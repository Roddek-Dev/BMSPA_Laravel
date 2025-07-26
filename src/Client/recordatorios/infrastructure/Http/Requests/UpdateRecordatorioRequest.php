<?php

namespace Src\Client\recordatorios\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// ASEGÚRATE DE QUE LA CLASE SE LLAME UpdateRecordatorioRequest
class UpdateRecordatorioRequest extends FormRequest
{
    public function authorize(): bool
    {
        // En un caso real, deberías verificar que el recordatorio que se intenta actualizar
        // pertenece al usuario autenticado.
        return true;
    }

    public function rules(): array
    {
        return [
            // Aquí puedes mantener las reglas de actualización que ya tenías
            'titulo' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_hora_recordatorio' => 'sometimes|required|date_format:Y-m-d H:i:s',
            'canal_notificacion' => 'sometimes|string|in:EMAIL,SMS,PUSH_NOTIFICATION',
            'enviado' => 'sometimes|boolean',
            'fecha_envio' => 'nullable|date_format:Y-m-d H:i:s',
            'activo' => 'sometimes|boolean',
            'fijado' => 'sometimes|boolean',
        ];
    }
}