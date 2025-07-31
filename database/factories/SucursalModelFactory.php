<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
// OJO: Asumo que este es el namespace. ¡Si no es, corrígelo!
use Src\Admin\sucursales\infrastructure\Models\SucursalModel;

class SucursalModelFactory extends Factory
{
    protected $model = SucursalModel::class;

    public function definition(): array
    {
        return [
            'nombre' => 'Sucursal ' . $this->faker->city,
            'telefono_contacto' => $this->faker->phoneNumber,
            'email_contacto' => $this->faker->email,
            'link_maps' => $this->faker->url,
            'latitud' => $this->faker->latitude,
            'longitud' => $this->faker->longitude,
            'activo' => $this->faker->boolean(80), // 80% de probabilidad de estar activo
        ];
    }
}