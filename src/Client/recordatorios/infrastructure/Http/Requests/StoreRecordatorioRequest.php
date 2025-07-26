<?php

namespace Src\Client\recordatorios\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// ASEGÚRATE DE QUE LA CLASE SE LLAME StoreRecordatorioRequest
class StoreRecordatorioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        // Obtenemos el ID del usuario autenticado que está haciendo la petición.
        $authUserId = $this->user()->id;

        return [
            // El usuario_id debe ser el del propio usuario autenticado.
            'usuario_id' => [
                'required',
                'integer',
                Rule::in([$authUserId])
            ],
            
            // El agendamiento_id debe existir, no estar borrado, y pertenecer al usuario autenticado.
            'agendamiento_id' => [
                'nullable',
                'integer',
                Rule::exists('agendamientos', 'id')->where(function ($query) use ($authUserId) {
                    $query->where('cliente_usuario_id', $authUserId)->whereNull('deleted_at');
                })
            ],
            
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_hora_recordatorio' => 'required|date_format:Y-m-d H:i:s',
            'canal_notificacion' => 'sometimes|string|in:EMAIL,SMS,PUSH_NOTIFICATION',
            'enviado' => 'sometimes|boolean',
            'fecha_envio' => 'nullable|date_format:Y-m-d H:i:s',
            'activo' => 'sometimes|boolean',
            'fijado' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'usuario_id.in' => 'No puedes crear recordatorios para otro usuario.',
            'agendamiento_id.exists' => 'El agendamiento especificado no existe o no te pertenece.',
        ];
    }
}