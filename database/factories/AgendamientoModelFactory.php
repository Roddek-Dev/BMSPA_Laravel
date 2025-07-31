<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
// Importa todos los modelos que vas a necesitar
use Src\Scheduling\agendamientos\infrastructure\Models\AgendamientoModel;
use Src\Admin\personal\infrastructure\Models\PersonalModel; // <-- ¡Ajusta esta ruta a tu modelo Personal!
use Src\Catalog\servicios\infrastructure\Models\ServicioModel; // <-- ¡Ajusta esta ruta a tu modelo Servicio!
use Src\Admin\sucursales\infrastructure\Models\SucursalModel;// <-- ¡Ajusta esta ruta a tu modelo Sucursal!
use Src\Client\usuarios\infrastructure\Persistence\Eloquent\UsuarioModel;       // <-- ¡Ajusta esta ruta a tu modelo Usuario!


class AgendamientoModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AgendamientoModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // En lugar de un ID fijo, le pedimos al factory que cree un registro
            // y nos devuelva su ID.
            'cliente_usuario_id' => UsuarioModel::factory(),
            'personal_id' => PersonalModel::factory(),
            'servicio_id'        => ServicioModel::factory(),
            'sucursal_id'        => SucursalModel::factory(),

            // El resto de los datos se queda igual
            'fecha_hora_inicio' => $this->faker->dateTimeBetween('now', '+1 month'),
            'fecha_hora_fin' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'precio_final' => $this->faker->randomFloat(2, 20, 300),
            'estado' => $this->faker->randomElement(['pendiente', 'confirmado', 'cancelado']),
            'notas_cliente' => $this->faker->sentence(),
            'notas_internas' => $this->faker->optional()->sentence(),
        ];
    }
}