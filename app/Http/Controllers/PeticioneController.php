<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Peticione;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\File;
use Illuminate\Support\Facades\DB;

class PeticioneController extends Controller
{


    public function index()
    {
        $peticiones = Peticione::with(['user', 'categoria', 'files'])->paginate(8);
        $categorias = Categoria::all();

        return view('peticiones.index', compact('peticiones', 'categorias'));
    }

    public function show($id)
    {
        $peticione = Peticione::with(['user', 'categoria', 'files'])->findOrFail($id);

        $yaFirmada = Auth::check()
            && Auth::user()->firmas()->wherePivot('peticione_id', $peticione->id)->exists();

        $otras = Peticione::with(['user', 'files'])
            ->where('id', '!=', $peticione->id)
            ->take(4)
            ->get();

        return view('peticiones.show', compact('peticione', 'yaFirmada', 'otras'));
    }

    public function listMine(Request $request)
    {
        try {
            $user_id = Auth::user()->id;
            $peticiones = Peticione::with(['categoria', 'files'])->where('user_id', $user_id)->get();
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return view('peticiones.mine', compact('peticiones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'       => 'required|max:255',
            'descripcion'  => 'required',
            'destinatario' => 'required',
            'categoria_id' => 'required|exists:categorias,id',
            'file' => 'required|image|max:5120',
        ]);

        try {
            $input = $request->all();
            $categoria = Categoria::findOrFail($input['categoria_id']);
            $user = Auth::user();

            $peticione = new Peticione();
            $peticione->titulo = $request->input('titulo');
            $peticione->descripcion = $request->input('descripcion');
            $peticione->destinatario = $request->input('destinatario');
            $peticione->firmantes = 0;
            $peticione->estado = 'pendiente';

            $peticione->user()->associate($user);
            $peticione->categoria()->associate($categoria);
            $peticione->save();
            $res_file = $this->fileUpload($request, $peticione->id);

            if (!$res_file) {
                DB::rollBack();
                return back()->with('error', 'Error subida del archivo')->withInput();
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage())->withInput();
        }

        return redirect()->route('peticiones.mine')->with('success', 'Petición creada correctamente.');
    }


    public function fileUpload(Request $req, $peticione_id = null)
    {
        $file = $req->file('file');
        if (!$file) {
            return false;
        }

        $filename = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('peticiones', $filename, 'public'); // storage/app/public/peticiones

        $fileModel = new File;
        $fileModel->peticione_id = $peticione_id;
        $fileModel->name = $filename;
        $fileModel->file_path = $filePath;

        return $fileModel->save();
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('peticiones.edit-add', compact('categorias'));
    }

    public function firmar($id)
    {
        try {
            $peticione = Peticione::findOrFail($id);
            $user = Auth::user();

            $res = $user->firmas()->syncWithoutDetaching([$peticione->id]);

            if (empty($res['attached'])) {
                return back()->with('error', 'Ya has firmado esta petición.');
            }

            $peticione->increment('firmantes');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return back()->with('success', 'Petición firmada correctamente.');
    }


    public function edit($id)
    {
        $peticione = Peticione::with('files')->findOrFail($id);

        if ($peticione->user_id != Auth::id()) {
            abort(403, 'No puedes editar una petición que no es tuya.');
        }

        $categorias = Categoria::all();

        return view('peticiones.edit-add', compact('peticione', 'categorias'));
    }




    public function verCategoria($id)
    {
        $peticione = Peticione::findOrFail($id);
        $categoria = $peticione->categoria()->get();
        return response()->json(['message' => 'Categoria encontrada', 'data' => $peticione, $categoria], 200);
    }

    public function verFirmantes($id)
    {
        $peticione = Peticione::findOrFail($id);
        $user = $peticione->firmantes()->get();
        return response()->json(['message' => 'Firmantes encontrados', 'data' => $peticione->firmantes, $user], 200);
    }

    public function updateEstado(Request $request, $id)
    {
        $peticione = Peticione::findOrFail($id);
        $validator = Validator::make(request()->all(), [
            'estado' => 'required|in:aceptada,pendiente',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $peticione->estado = $request->input('estado');
        $peticione->save();
        return response()->json(['message' => 'Peticion actualizada', 'data' => $peticione], 200);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $peticione = Peticione::with('files')->findOrFail($id);

        if ($peticione->user_id != Auth::id()) {
            abort(403, 'No puedes editar una petición que no es tuya.');
        }

        $request->validate([
            'titulo'       => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'destinatario' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'file'         => 'nullable|image|max:5120', // al editar, la imagen es opcional
        ]);

        $rutasAntiguas = [];

        DB::beginTransaction();
        try {
            $peticione->titulo = $request->input('titulo');
            $peticione->descripcion = $request->input('descripcion');
            $peticione->destinatario = $request->input('destinatario');
            $peticione->categoria_id = $input['categoria_id'];

            $res = $peticione->update();
            if (!$res) {
                DB::rollBack();
                return back()->with('error', 'Petición no actualizada')->withInput();
            }

            // Si sube una imagen nueva, sustituye a la anterior
            if ($request->hasFile('file')) {
                $archivosAntiguos = $peticione->files;

                $res_file = $this->fileUpload($request, $peticione->id);
                if (!$res_file) {
                    DB::rollBack();
                    return back()->with('error', 'Error subiendo el archivo')->withInput();
                }

                foreach ($archivosAntiguos as $archivo) {
                    $rutasAntiguas[] = $archivo->file_path;
                    $archivo->delete();
                }
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage())->withInput();
        }

        // El archivo antiguo se borra del disco solo cuando todo se ha guardado bien
        foreach ($rutasAntiguas as $ruta) {
            Storage::disk('public')->delete($ruta);
        }

        return redirect()->route('peticiones.mine')->with('success', 'Petición actualizada correctamente.');
    }

    public function destroy($id)
    {
        $peticione = Peticione::findOrFail($id);
        if ($peticione->firmantes > 0) {
            return response()->json(['message' => 'Error peticion firmada no se puede borrar'], 409);
        }
        $peticione->delete();
        return response()->json(['message' => 'Peticion eliminada', 'data' => $peticione], 200);

    }
}
