<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Especialidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EspecialidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $especialidades = Especialidad::all();
        return response()->json($especialidades);
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
        $especialidad = Especialidad::create($validator->validated());
        return response()->json($especialidad, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $especialidad = Especialidad::find($id);
        if (!$especialidad) {
            return response()->json(["message" => 'Especialidad no encontrada'], 404);
        }
        return response()->json($especialidad);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Especialidad $especialidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $especialidad = Especialidad::find($id);
        if (!$especialidad) {
            return response()->json(["message" => 'Especialidad no encontrada'], 404);
        }
        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $especialidad->update($validator->validated());
        return response()->json($especialidad);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $especialidad = Especialidad::find($id);
        if (!$especialidad) {
            return response()->json(['message' => 'Especialidad no encontrada'], 404);
        }
        $especialidad->delete();
        return response()->json(['message' => 'Especialidad eliminada con éxito']);
    }
}
