<?php

namespace Src\Client\direcciones\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDireccionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Se asume que la autorización se maneja en el middleware de la ruta
    }

    public function rules(): array
    {
        return [
            'direccion' => 'sometimes|required|string|max:255',
            'colonia' => 'sometimes|required|string|max:100',
            'codigo_postal' => 'sometimes|required|string|max:10',
            'ciudad' => 'sometimes|required|string|max:100',
            'estado' => 'sometimes|required|string|max:100',
            'referencias' => 'nullable|string',
            'es_predeterminada' => 'sometimes|boolean',
        ];
    }
}