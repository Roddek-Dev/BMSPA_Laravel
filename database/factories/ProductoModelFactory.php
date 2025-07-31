<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Catalog\productos\infrastructure\Models\ProductoModel;
use Src\Admin\categorias\infrastructure\Models\CategoriaModel;

class ProductoModelFactory extends Factory
{
    protected $model = ProductoModel::class;

    public function definition(): array
    {
        return [
            'nombre' => 'Producto ' . $this->faker->unique()->word,
            'descripcion' => $this->faker->sentence,
            
            // --- ¡LA CORRECCIÓN FINAL! ---
            // Cambiamos 'precio_unitario' por 'precio' para que coincida con la tabla.
            'precio' => $this->faker->randomFloat(2, 5000, 100000),

            'stock' => $this->faker->numberBetween(0, 100),
            'categoria_id' => CategoriaModel::inRandomOrder()->first()->id,
            'activo' => true,
        ];
    }
}