<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recordatorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class RecordatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recordatorios = Recordatorio::all();
        return response()->json($recordatorios);
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
            'usuario_id' => 'required|exists:usuarios,id',
            'agendamiento_id' => 'required|exists:agendamientos,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_hora_recordatorio' => 'required|date',
            'canal_notificacion' => 'required|string|max:255',
            'enviado' => 'boolean',
            'fecha_envio' => 'nullable|date',
            'activo' => 'boolean',
            'fijado' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $recordatorio = Recordatorio::create($validator->validated());
        return response()->json($recordatorio, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $recordatorio = Recordatorio::find($id);
        if (!$recordatorio) {
            return response()->json(["message" => 'Recordatorio no encontrado'], 404);
        }
        return response()->json($recordatorio);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recordatorio $recordatorio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $recordatorio = Recordatorio::find($id);
        if (!$recordatorio) {
            return response()->json(["message" => 'Recordatorio no encontrado'], 404);
        }
        $validator = Validator::make($request->all(), [
            'usuario_id' => 'exists:usuarios,id',
            'agendamiento_id' => 'exists:agendamientos,id',
            'titulo' => 'string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_hora_recordatorio' => 'date',
            'canal_notificacion' => 'string|max:255',
            'enviado' => 'boolean',
            'fecha_envio' => 'nullable|date',
            'activo' => 'boolean',
            'fijado' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $recordatorio->update($validator->validated());
        return response()->json($recordatorio);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $recordatorio = Recordatorio::find($id);
        if (!$recordatorio) {
            return response()->json(['message' => 'Recordatorio no encontrado'], 404);
        }
        $recordatorio->delete();
        return response()->json(['message' => 'Recordatorio eliminado con éxito']);
    }
}
