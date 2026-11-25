<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Peticione;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PeticioneController extends Controller
{
    //


    public function index()
    {
        $peticiones = Peticione::with(['user', 'categoria'])->paginate(8);
        $categorias = Categoria::all();

        $misPeticiones = Auth::check()
            ? Peticione::with('categoria')->where('user_id', Auth::id())->get()
            : collect();

        return view('peticiones.index', compact('peticiones', 'categorias', 'misPeticiones'));
    }

    public function show($id)
    {
        $peticione = Peticione::findOrFail($id);
        return view('peticiones.show',compact('peticione'));
    }

    public function listMine(Request $request)
    {
        try {
            $user_id = Auth::user()->id;
            $peticiones = Peticione::where('user_id', $user_id)->get();
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return view('peticiones.index', compact('peticiones'));
    }

    public function store(Request $request)
    {
        $peticione = new Peticione();

        $validator = Validator::make(request()->all(), [
            'titulo' => 'required|string|max:25',
            'descripcion' => 'required|string|max:255',
            'destinatario' => 'required|string|max:25',
            'firmantes' => 'required|integer',
            'estado' => 'required|in:aceptada,pendiente',
            'categoria_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $input = $request->all();

        $peticione->titulo = $request->input('titulo');
        $peticione->descripcion = $request->input('descripcion');
        $peticione->destinatario = $request->input('destinatario');
        $peticione->firmantes = $request->input('firmantes');
        $peticione->estado = $request->input('estado');

        $categoria = Categoria::findOrFail($input['categoria_id']);


        $user_id = 1;
        $user = User::findOrFail($user_id);

        $peticione->user()->associate($user);
        $peticione->categoria()->associate($categoria);
        $peticione->save();


        return response()->json(['message' => 'Peticion Creada', 'data' => $peticione], 200);
    }

    public function firmar($id, $user_id)
    {
        $peticione = Peticione::findOrFail($id);
        $user = User::findOrFail($user_id);
        $userFirmantes = $peticione->firmantes()->get();
        foreach ($userFirmantes as $userFirman) {
            if ($userFirman->user_id == $user_id) {
                return response()->json(['message' => 'El usuario ya ha firmado esta peticion', 'data' => $peticione], 409);
            }
        }
        $peticione->firmantes()->attach($user);
        $peticione->firmantes = $peticione->firmantes + 1;
        $peticione->save();
        return response()->json(['message' => 'Peticion Firmada', 'data' => $peticione], 200);
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
        $peticione = Peticione::findOrFail($id);
        $validator = Validator::make(request()->all(), [
            'titulo' => 'required|string|max:25',
            'descripcion' => 'required|string|max:255',
            'destinatario' => 'required|string|max:25',
            'categoria_id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $peticione->titulo = $request->input('titulo');
        $peticione->descripcion = $request->input('descripcion');
        $peticione->destinatario = $request->input('destinatario');
        $peticione->categoria_id = $request->input('categoria_id');

        $res = $peticione->update();
        if ($res) {
            return response()->json(['message' => 'Peticion actualizada', 'data' => $peticione], 200);
        } else {
            return response()->json(['message' => 'Peticion no actualizada', 'data' => $peticione], 400);
        }
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
