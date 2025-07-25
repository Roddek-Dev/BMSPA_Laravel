<?php

namespace Src\Catalog\productos\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productoId = $this->route('producto');
        return [
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen_path' => 'nullable|string|max:255',
            'precio' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'sku' => ['nullable', 'string', 'max:100', Rule::unique('productos')->ignore($productoId)],
            'categoria_id' => 'nullable|integer|exists:categorias,id',
            'activo' => 'sometimes|boolean',
        ];
    }
}