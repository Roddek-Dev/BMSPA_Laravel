<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ordenes = Orden::all();
        return response()->json($ordenes);
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
            'total' => 'required|numeric',
            'estado' => 'nullable|string|max:50',
            'fecha' => 'required|date',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $orden = Orden::create($validator->validated());
        return response()->json($orden, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $orden = Orden::find($id);
        if (!$orden) {
            return response()->json(["message" => 'Orden no encontrada'], 404);
        }
        return response()->json($orden);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orden $orden)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $orden = Orden::find($id);
        if (!$orden) {
            return response()->json(["message" => 'Orden no encontrada'], 404);
        }
        $validator = Validator::make($request->all(), [
            'usuario_id' => 'exists:usuarios,id',
            'total' => 'numeric',
            'estado' => 'nullable|string|max:50',
            'fecha' => 'date',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $orden->update($validator->validated());
        return response()->json($orden);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $orden = Orden::find($id);
        if (!$orden) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }
        $orden->delete();
        return response()->json(['message' => 'Orden eliminada con éxito']);
    }
}
