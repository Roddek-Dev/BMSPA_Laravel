<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agendamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class AgendamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agendamientos = Agendamiento::all();
        return response()->json($agendamientos);
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
            // Ajusta las reglas según tus columnas reales
            'usuario_id' => 'required|exists:usuarios,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_hora' => 'required|date',
            'estado' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $agendamiento = Agendamiento::create($validator->validated());

        return response()->json($agendamiento, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $agendamiento = Agendamiento::find($id);
        if (!$agendamiento) {
            return response()->json(["message" => 'Agendamiento no encontrado'], 404);
        }
        return response()->json($agendamiento);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agendamiento $agendamiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $agendamiento = Agendamiento::find($id);
        if (!$agendamiento) {
            return response()->json(["message" => 'Agendamiento no encontrado'], 404);
        }
        $validator = Validator::make($request->all(), [
            'usuario_id' => 'exists:usuarios,id',
            'titulo' => 'string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_hora' => 'date',
            'estado' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $agendamiento->update($validator->validated());
        return response()->json($agendamiento);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $agendamiento = Agendamiento::find($id);
        if (!$agendamiento) {
            return response()->json(['message' => 'Agendamiento no encontrado'], 404);
        }
        $agendamiento->delete();
        return response()->json(['message' => 'Agendamiento eliminado con éxito']);
    }
}
