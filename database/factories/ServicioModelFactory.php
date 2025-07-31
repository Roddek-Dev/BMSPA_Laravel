<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Catalog\servicios\infrastructure\Models\ServicioModel;
use Src\Admin\categorias\infrastructure\Models\CategoriaModel;

class ServicioModelFactory extends Factory
{
    protected $model = ServicioModel::class;

    public function definition(): array
    {
        return [
            'nombre' => 'Servicio de ' . $this->faker->jobTitle,
            'descripcion' => $this->faker->sentence,
            
            // --- ¡AQUÍ ESTÁ LA CORRECCIÓN FINAL! ---
            // Añadimos los dos campos que la tabla SÍ tiene.
            'precio_base' => $this->faker->randomFloat(2, 40000, 200000), 
            'duracion_minutos' => $this->faker->randomElement([30, 45, 60, 90]),

            'categoria_id' => CategoriaModel::factory(),
            'activo' => true,
        ];
    }
}