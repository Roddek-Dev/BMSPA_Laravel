<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Admin\personal\infrastructure\Models\PersonalModel;
use Src\Client\usuarios\infrastructure\Persistence\Eloquent\UsuarioModel; 
use Src\Admin\sucursales\infrastructure\Models\SucursalModel; 

class PersonalModelFactory extends Factory
{
    protected $model = PersonalModel::class;

    public function definition(): array
    {
        return [
            // Creamos un usuario nuevo para asociarlo a este personal
            'usuario_id' => UsuarioModel::factory(),
            // Puedes ajustar la lógica si ya tienes sucursales creadas
            'sucursal_asignada_id' => SucursalModel::factory(),  
            'tipo_personal' => $this->faker->randomElement(['Estilista', 'Recepcionista', 'Gerente']),
            'numero_empleado' => $this->faker->unique()->numerify('EMP-#####'),
            'fecha_contratacion' => $this->faker->date(),
            'activo_en_empresa' => true,
        ];
    }
}