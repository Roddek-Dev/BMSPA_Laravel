<?php

namespace Src\Client\reseñas\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReseñaRequest extends FormRequest
{
    public function authorize(): bool
    {
        // En una implementación real, deberías verificar que el usuario
        // es el dueño de la reseña que intenta actualizar.
        return true;
    }

    public function rules(): array
    {
        return [
            'calificacion' => 'sometimes|required|integer|min:1|max:5',
            'comentario' => 'nullable|string',
        ];
    }
}