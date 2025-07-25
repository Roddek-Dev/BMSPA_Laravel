<?php

namespace Src\Catalog\productos\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
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
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100|unique:productos,sku',
            'categoria_id' => 'nullable|integer|exists:categorias,id',
            'activo' => 'sometimes|boolean',
        ];
    }
}