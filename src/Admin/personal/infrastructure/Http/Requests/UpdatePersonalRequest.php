<?php

namespace Src\Admin\personal\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePersonalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $personalId = $this->route('personal');

        return [
            'usuario_id' => ['sometimes', 'required', 'integer', 'exists:usuarios,id', Rule::unique('personal')->ignore($personalId)],
            'sucursal_asignada_id' => 'nullable|integer|exists:sucursales,id',
            'tipo_personal' => 'sometimes|required|string|max:50',
            'numero_empleado' => ['nullable', 'string', 'max:50', Rule::unique('personal')->ignore($personalId)],
            'fecha_contratacion' => 'nullable|date',
            'activo_en_empresa' => 'sometimes|boolean',
        ];
    }
}