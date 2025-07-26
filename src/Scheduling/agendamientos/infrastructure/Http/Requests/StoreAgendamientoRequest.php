<?php

namespace Src\Scheduling\agendamientos\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgendamientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente_usuario_id' => 'required|integer|exists:usuarios,id',
            'personal_id' => 'nullable|integer|exists:personal,id',
            'servicio_id' => 'required|integer|exists:servicios,id',
            'sucursal_id' => 'required|integer|exists:sucursales,id',
            'fecha_hora_inicio' => 'required|date_format:Y-m-d H:i:s',
            'fecha_hora_fin' => 'required|date_format:Y-m-d H:i:s|after:fecha_hora_inicio',
            'precio_final' => 'required|numeric|min:0',
            'estado' => 'sometimes|string|max:50|in:PROGRAMADA,CONFIRMADA,CANCELADA_CLIENTE,CANCELADA_PERSONAL,COMPLETADA,NO_ASISTIO',
            'notas_cliente' => 'nullable|string',
            'notas_internas' => 'nullable|string',
        ];
    }
}