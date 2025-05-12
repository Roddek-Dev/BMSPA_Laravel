<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reseña;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReseñaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reseñas = Reseña::all();
        return response()->json($reseñas);
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
            'servicio_id' => 'required|exists:servicios,id',
            'comentario' => 'nullable|string',
            'calificacion' => 'required|integer|min:1|max:5',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $reseña = Reseña::create($validator->validated());
        return response()->json($reseña, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $reseña = Reseña::find($id);
        if (!$reseña) {
            return response()->json(["message" => 'Reseña no encontrada'], 404);
        }
        return response()->json($reseña);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resena $resena)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $reseña = Reseña::find($id);
        if (!$reseña) {
            return response()->json(["message" => 'Reseña no encontrada'], 404);
        }
        $validator = Validator::make($request->all(), [
            'usuario_id' => 'exists:usuarios,id',
            'servicio_id' => 'exists:servicios,id',
            'comentario' => 'nullable|string',
            'calificacion' => 'integer|min:1|max:5',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $reseña->update($validator->validated());
        return response()->json($reseña);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reseña = Reseña::find($id);
        if (!$reseña) {
            return response()->json(['message' => 'Reseña no encontrada'], 404);
        }
        $reseña->delete();
        return response()->json(['message' => 'Reseña eliminada con éxito']);
    }
}
