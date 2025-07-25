<?php

namespace Src\Client\direcciones\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDireccionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Se asume que la autorización se maneja en el middleware de la ruta
    }

    public function rules(): array
    {
        return [
            'direccion' => 'required|string|max:255',
            'colonia' => 'required|string|max:100',
            'codigo_postal' => 'required|string|max:10',
            'ciudad' => 'required|string|max:100',
            'estado' => 'required|string|max:100',
            'referencias' => 'nullable|string',
            'es_predeterminada' => 'sometimes|boolean',
        ];
    }
}