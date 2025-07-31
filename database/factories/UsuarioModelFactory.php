<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
// ¡Asegúrate de usar el namespace correcto para tu UsuarioModel!
use Src\Client\usuarios\infrastructure\Persistence\Eloquent\UsuarioModel;

class UsuarioModelFactory extends Factory
{
    /**
     * El nombre del modelo correspondiente del factory.
     *
     * @var string
     */
    protected $model = UsuarioModel::class;

    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // Contraseña por defecto
            'telefono' => $this->faker->phoneNumber(),
            'rol' => 'cliente',
            'activo' => true,
            'imagen_path' => null,
            'email_verified_at' => now(),
        ];
    }
}