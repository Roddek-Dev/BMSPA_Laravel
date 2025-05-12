<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promocion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PromocionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promociones = Promocion::all();
        return response()->json($promociones);
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
            'descuento' => 'required|numeric',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'activo' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $promocion = Promocion::create($validator->validated());
        return response()->json($promocion, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $promocion = Promocion::find($id);
        if (!$promocion) {
            return response()->json(["message" => 'Promoción no encontrada'], 404);
        }
        return response()->json($promocion);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promocion $promocion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $promocion = Promocion::find($id);
        if (!$promocion) {
            return response()->json(["message" => 'Promoción no encontrada'], 404);
        }
        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'descripcion' => 'nullable|string',
            'descuento' => 'numeric',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date|after_or_equal:fecha_inicio',
            'activo' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $promocion->update($validator->validated());
        return response()->json($promocion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $promocion = Promocion::find($id);
        if (!$promocion) {
            return response()->json(['message' => 'Promoción no encontrada'], 404);
        }
        $promocion->delete();
        return response()->json(['message' => 'Promoción eliminada con éxito']);
    }
}
