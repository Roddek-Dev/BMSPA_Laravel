<?php

namespace Src\Admin\especialidades\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EspecialidadRequest extends FormRequest
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
            'icono_clave' => 'nullable|string|max:50',
            'activo' => 'required|boolean',
        ];
    }
}
