<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sucursales = Sucursal::all();
        return response()->json($sucursales);
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
            'direccion' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'activo' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $sucursal = Sucursal::create($validator->validated());
        return response()->json($sucursal, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sucursal = Sucursal::find($id);
        if (!$sucursal) {
            return response()->json(["message" => 'Sucursal no encontrada'], 404);
        }
        return response()->json($sucursal);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sucursal $sucursal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $sucursal = Sucursal::find($id);
        if (!$sucursal) {
            return response()->json(["message" => 'Sucursal no encontrada'], 404);
        }
        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'direccion' => 'string|max:255',
            'telefono' => 'nullable|string|max:20',
            'activo' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $sucursal->update($validator->validated());
        return response()->json($sucursal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sucursal = Sucursal::find($id);
        if (!$sucursal) {
            return response()->json(['message' => 'Sucursal no encontrada'], 404);
        }
        $sucursal->delete();
        return response()->json(['message' => 'Sucursal eliminada con éxito']);
    }
}
