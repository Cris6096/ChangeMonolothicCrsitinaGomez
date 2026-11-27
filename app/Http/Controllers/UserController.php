<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 400);
        }
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        return response()->json(['message'=>'User Created','data'=>$user],200);
    }
    public function show(User $user)
    {
        return response()->json(['message'=>'','data'=>$user],200);
    }

    public function index(User $user)
    {
        $user = User::all();
        return response()->json(['message'=>'','data'=>$user],200);
    }

    public function listPeticiones($id){
        $user = User::findOrFail($id);
        $peticiones = $user->peticiones()->get();
        return response()->json(['message' => 'Peticiones de Usuarios Encontrados', 'data' => $peticiones], 202);
    }

    public function peticionesFirmadas(Request $request)
    {
        try {
            $id = Auth::id();
            $usuario = User::findOrFail($id);
            $peticiones = $usuario->firmas()->with(['user', 'categoria', 'files'])->paginate(8);
            $categorias = Categoria::all();
            $titulo = 'Peticiones que has firmado';
        } catch (\Exception $exception) {
            return redirect()->route('peticiones.index')->with('error', $exception->getMessage());
        }

        return view('peticiones.index', compact('peticiones', 'categorias', 'titulo'));
    }



}
