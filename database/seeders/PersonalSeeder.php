<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Src\Admin\personal\infrastructure\Models\PersonalModel;

class PersonalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Apagamos la revisión de llaves foráneas para poder usar truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. Vaciamos la tabla para no duplicar datos en cada ejecución
        PersonalModel::truncate();

        // 3. Volvemos a prender
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 4. Creamos los datos de prueba
        // Nota: Los datos básicos (nombre, teléfono) vienen de la tabla usuarios
        // Aquí solo configuramos la información específica del empleado
        $personal = [
            [
                'id' => 1,
                'usuario_id' => 4, // julio jaramillo (PERSONAL)
                'sucursal_asignada_id' => 1,
                'tipo_personal' => 'BARBERO',
                'numero_empleado' => 'EMP001',
                'fecha_contratacion' => '2024-01-15',
                'activo_en_empresa' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'usuario_id' => 1, // Carlos (ADMIN)
                'sucursal_asignada_id' => null, // ADMIN_GENERAL no tiene sucursal específica
                'tipo_personal' => 'ADMIN_GENERAL',
                'numero_empleado' => 'EMP002',
                'fecha_contratacion' => '2023-06-01',
                'activo_en_empresa' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'usuario_id' => 3, // Carlos Rodriguez (ADMIN)
                'sucursal_asignada_id' => 2,
                'tipo_personal' => 'ADMIN_SUCURSAL',
                'numero_empleado' => 'EMP003',
                'fecha_contratacion' => '2024-03-10',
                'activo_en_empresa' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('personal')->insert($personal);
    }
}
