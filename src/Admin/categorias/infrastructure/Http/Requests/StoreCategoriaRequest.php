<?php

namespace Src\Admin\categorias\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100|unique:categorias,nombre',
            'descripcion' => 'nullable|string',
            'tipo_categoria' => 'required|string|in:PRODUCTO,SERVICIO',
            'icono_clave' => 'nullable|string|max:50',
            'activo' => 'sometimes|boolean',
        ];
    }
}