<?php

namespace Src\Admin\personal\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'usuario_id' => 'required|integer|exists:usuarios,id|unique:personal,usuario_id',
            'sucursal_asignada_id' => 'nullable|integer|exists:sucursales,id',
            'tipo_personal' => 'required|string|max:50',
            'numero_empleado' => 'nullable|string|max:50|unique:personal,numero_empleado',
            'fecha_contratacion' => 'nullable|date',
            'activo_en_empresa' => 'sometimes|boolean',
        ];
    }
}