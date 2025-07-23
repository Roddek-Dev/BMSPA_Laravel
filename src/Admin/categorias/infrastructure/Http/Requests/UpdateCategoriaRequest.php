<?php

namespace Src\Admin\categorias\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoriaId = $this->route('categoria');
        return [
            'nombre' => ['sometimes', 'required', 'string', 'max:100', Rule::unique('categorias')->ignore($categoriaId)],
            'descripcion' => 'nullable|string',
            'tipo_categoria' => 'sometimes|required|string|in:PRODUCTO,SERVICIO',
            'icono_clave' => 'nullable|string|max:50',
            'activo' => 'sometimes|boolean',
        ];
    }
}