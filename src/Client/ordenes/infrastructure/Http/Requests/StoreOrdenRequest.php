<?php

namespace Src\Client\ordenes\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrdenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'notas_orden' => 'nullable|string',
            'detalles' => 'required|array|min:1',
            // Valida que cada item en el array de detalles tenga un producto_id y una cantidad
            'detalles.*.producto_id' => 'required|integer|exists:productos,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
        ];
    }
}