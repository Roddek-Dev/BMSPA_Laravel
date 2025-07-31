<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Admin\categorias\infrastructure\Models\CategoriaModel;

class CategoriaModelFactory extends Factory
{
    protected $model = CategoriaModel::class;

    public function definition(): array
    {
        return [
            // --- ¡LA SOLUCIÓN DEFINITIVA! ---
            // En lugar de una palabra corta, usamos un nombre de compañía único.
            // Es imposible que esto se repita en 50 intentos.
            'nombre' => $this->faker->unique()->company,

            'descripcion' => $this->faker->sentence,
            'tipo_categoria' => $this->faker->randomElement(['Producto', 'Servicio']),
            'icono_clave' => 'fa-solid fa-star',
            'activo' => true,
        ];
    }
}