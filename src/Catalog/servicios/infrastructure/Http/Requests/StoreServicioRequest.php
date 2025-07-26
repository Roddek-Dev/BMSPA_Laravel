<?php

namespace Src\Catalog\servicios\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServicioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen_path' => 'nullable|string|max:255',
            'precio_base' => 'required|numeric|min:0',
            'duracion_minutos' => 'required|integer|min:0',
            'categoria_id' => 'nullable|integer|exists:categorias,id',
            'especialidad_requerida_id' => 'nullable|integer|exists:especialidades,id',
            'activo' => 'sometimes|boolean',
        ];
    }
}