<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6',
            'telefono' => 'nullable|string|max:20',
            'rol' => 'nullable|string|max:50',
            'activo' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $data = $validator->validated();
        $data['password'] = bcrypt($data['password']);
        $usuario = Usuario::create($data);
        return response()->json($usuario, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(["message" => 'Usuario no encontrado'], 404);
        }
        return response()->json($usuario);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(["message" => 'Usuario no encontrado'], 404);
        }
        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'email' => 'email|unique:usuarios,email,' . $id,
            'password' => 'nullable|string|min:6',
            'telefono' => 'nullable|string|max:20',
            'rol' => 'nullable|string|max:50',
            'activo' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $data = $validator->validated();
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $usuario->update($data);
        return response()->json($usuario);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        $usuario->delete();
        return response()->json(['message' => 'Usuario eliminado con éxito']);
    }
}
