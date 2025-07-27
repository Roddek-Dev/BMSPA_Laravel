<?php

namespace Src\Client\ordenes\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrdenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Generalmente, solo el estado de una orden se actualiza por un admin,
        // pero aquí permitimos más campos por flexibilidad.
        return [
            'estado_orden' => 'sometimes|string|in:PENDIENTE_PAGO,PAGADA,EN_PROCESO,ENVIADA,ENTREGADA,CANCELADA',
            'notas_orden' => 'nullable|string',
        ];
    }
}