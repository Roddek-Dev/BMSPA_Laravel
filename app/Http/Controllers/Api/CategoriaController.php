<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();
        return response()->json($categorias);
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
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $categoria = Categoria::create($validator->validated());
        return response()->json($categoria, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categoria = Categoria::find($id);
        if (!$categoria) {
            return response()->json(["message" => 'Categoría no encontrada'], 404);
        }
        return response()->json($categoria);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $categoria = Categoria::find($id);
        if (!$categoria) {
            return response()->json(["message" => 'Categoría no encontrada'], 404);
        }
        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $categoria->update($validator->validated());
        return response()->json($categoria);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categoria = Categoria::find($id);
        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }
        $categoria->delete();
        return response()->json(['message' => 'Categoría eliminada con éxito']);
    }
}
