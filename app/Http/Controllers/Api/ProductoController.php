<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();
        return response()->json($productos);
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
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'activo' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $producto = Producto::create($validator->validated());
        return response()->json($producto, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $producto = Producto::find($id);
        if (!$producto) {
            return response()->json(["message" => 'Producto no encontrado'], 404);
        }
        return response()->json($producto);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);
        if (!$producto) {
            return response()->json(["message" => 'Producto no encontrado'], 404);
        }
        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'numeric',
            'stock' => 'integer',
            'activo' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $producto->update($validator->validated());
        return response()->json($producto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);
        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
        $producto->delete();
        return response()->json(['message' => 'Producto eliminado con éxito']);
    }
}
