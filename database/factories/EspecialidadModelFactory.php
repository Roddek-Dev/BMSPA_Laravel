<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Admin\especialidades\infrastructure\Models\EspecialidadModel;

class EspecialidadModelFactory extends Factory
{
    protected $model = EspecialidadModel::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->jobTitle,
            'descripcion' => $this->faker->sentence,
            // ¡LA CORRECCIÓN FINAL!
            'activo' => true, // Cambiado de 'activa' a 'activo'
        ];
    }
}