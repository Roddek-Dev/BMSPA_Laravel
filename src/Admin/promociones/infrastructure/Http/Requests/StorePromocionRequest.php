<?php

namespace Src\Admin\promociones\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePromocionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => 'required|string|max:50|unique:promociones,codigo',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo_descuento' => 'required|string|in:PORCENTAJE,MONTO_FIJO',
            'valor_descuento' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date_format:Y-m-d H:i:s',
            'fecha_fin' => 'nullable|date_format:Y-m-d H:i:s|after:fecha_inicio',
            'usos_maximos_total' => 'nullable|integer|min:0',
            'usos_maximos_por_cliente' => 'nullable|integer|min:1',
            'activo' => 'sometimes|boolean',
            'aplica_a_todos_productos' => 'sometimes|boolean',
            'aplica_a_todos_servicios' => 'sometimes|boolean',
        ];
    }
}