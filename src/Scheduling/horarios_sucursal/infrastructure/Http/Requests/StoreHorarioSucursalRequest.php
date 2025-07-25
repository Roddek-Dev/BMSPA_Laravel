<?php

namespace Src\Scheduling\horarios_sucursal\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreHorarioSucursalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sucursal_id' => [
                'required',
                'integer',
                'exists:sucursales,id',
                Rule::unique('horarios_sucursal')->where(function ($query) {
                    return $query->where('dia_semana', $this->input('dia_semana'));
                })
            ],
            'dia_semana' => 'required|integer|between:0,6',
            'hora_apertura' => 'nullable|date_format:H:i',
            'hora_cierre' => 'nullable|date_format:H:i|after:hora_apertura',
            'esta_cerrado_regularmente' => 'sometimes|boolean',
        ];
    }
}