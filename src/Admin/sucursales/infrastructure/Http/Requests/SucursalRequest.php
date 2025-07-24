<?php

namespace Src\Admin\sucursales\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Admin\sucursales\domain\Entities\Sucursal;

class SucursalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'imagen_path' => 'nullable|string|max:255',
            'telefono_contacto' => 'nullable|string|max:25',
            'email_contacto' => 'nullable|email|max:255',
            'link_maps' => 'nullable|string|max:512',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'activo' => 'required|boolean',
        ];
    }

    public function toEntity(): Sucursal
    {
        return new Sucursal(
            null,
            $this->nombre,
            $this->imagen_path,
            $this->telefono_contacto,
            $this->email_contacto,
            $this->link_maps,
            $this->latitud,
            $this->longitud,
            $this->activo
        );
    }
}
