<?php

namespace Src\Admin\promociones\infrastructure\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Admin\promociones\infrastructure\Models\PromocionModel;

class PromocionModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PromocionModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // Usa los campos exactos que están en tu modelo PromocionModel
            'codigo' => $this->faker->unique()->word,
            'nombre' => $this->faker->sentence(3),
            'descripcion' => $this->faker->paragraph,
            'tipo_descuento' => $this->faker->randomElement(['porcentaje', 'fijo']),
            'valor_descuento' => $this->faker->randomFloat(2, 5, 50),
            'fecha_inicio' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'fecha_fin' => $this->faker->dateTimeBetween('now', '+1 month'),
            'usos_maximos_total' => $this->faker->numberBetween(10, 100),
            'usos_maximos_por_cliente' => $this->faker->numberBetween(1, 5),
            'usos_actuales' => 0,
            'activo' => $this->faker->boolean(80),
            'aplica_a_todos_productos' => $this->faker->boolean(),
            'aplica_a_todos_servicios' => $this->faker->boolean(),
        ];
    }
}