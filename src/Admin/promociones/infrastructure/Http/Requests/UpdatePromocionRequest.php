<?php

namespace Src\Admin\promociones\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePromocionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $promocionId = $this->route('promocione'); // Laravel usa el singular del resource name

        return [
            'codigo' => ['sometimes', 'required', 'string', 'max:50', Rule::unique('promociones')->ignore($promocionId)],
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo_descuento' => 'sometimes|required|string|in:PORCENTAJE,MONTO_FIJO',
            'valor_descuento' => 'sometimes|required|numeric|min:0',
            'fecha_inicio' => 'sometimes|required|date_format:Y-m-d H:i:s',
            'fecha_fin' => 'nullable|date_format:Y-m-d H:i:s|after:fecha_inicio',
            'usos_maximos_total' => 'nullable|integer|min:0',
            'usos_maximos_por_cliente' => 'nullable|integer|min:1',
            'activo' => 'sometimes|boolean',
            'aplica_a_todos_productos' => 'sometimes|boolean',
            'aplica_a_todos_servicios' => 'sometimes|boolean',
        ];
    }
}