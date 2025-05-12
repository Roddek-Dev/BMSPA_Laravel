<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = Servicio::all();
        return response()->json($servicios);
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
            'activo' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $servicio = Servicio::create($validator->validated());
        return response()->json($servicio, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $servicio = Servicio::find($id);
        if (!$servicio) {
            return response()->json(["message" => 'Servicio no encontrado'], 404);
        }
        return response()->json($servicio);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Servicio $servicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $servicio = Servicio::find($id);
        if (!$servicio) {
            return response()->json(["message" => 'Servicio no encontrado'], 404);
        }
        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'numeric',
            'activo' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $servicio->update($validator->validated());
        return response()->json($servicio);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $servicio = Servicio::find($id);
        if (!$servicio) {
            return response()->json(['message' => 'Servicio no encontrado'], 404);
        }
        $servicio->delete();
        return response()->json(['message' => 'Servicio eliminado con éxito']);
    }
}
