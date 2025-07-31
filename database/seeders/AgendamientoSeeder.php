<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Src\Scheduling\agendamientos\infrastructure\Models\AgendamientoModel;

class AgendamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Desactivamos la revisión de llaves foráneas para poder usar truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. Vaciamos la tabla para no duplicar datos en cada ejecución
        AgendamientoModel::truncate();

        // 3. Volvemos a activar la revisión
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 4. Seeder de agendamientos
        $agendamientos = [
            [
                'id' => 1,
                'estado' => 'PROGRAMADA',
                'fecha_hora_inicio' => '2025-03-31 13:34:00',
                'fecha_hora_fin' => '2025-03-31 14:34:00',
                'servicio_id' => 5,
                'sucursal_id' => 1,
                'cliente_usuario_id' => 4,
                'personal_id' => null,
                'precio_final' => 50.00,
                'notas_cliente' => 'feo ese hpt servicio',
                'notas_internas' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'estado' => 'PROGRAMADA',
                'fecha_hora_inicio' => '2025-04-06 22:16:00',
                'fecha_hora_fin' => '2025-04-06 23:16:00',
                'servicio_id' => 5,
                'sucursal_id' => 1,
                'cliente_usuario_id' => 4,
                'personal_id' => null,
                'precio_final' => 50.00,
                'notas_cliente' => 'hola xd',
                'notas_internas' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'estado' => 'PROGRAMADA',
                'fecha_hora_inicio' => '2025-04-19 22:49:00',
                'fecha_hora_fin' => '2025-04-19 23:49:00',
                'servicio_id' => 5,
                'sucursal_id' => 1,
                'cliente_usuario_id' => 4,
                'personal_id' => null,
                'precio_final' => 50.00,
                'notas_cliente' => 'ncncnbc',
                'notas_internas' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'estado' => 'PROGRAMADA',
                'fecha_hora_inicio' => '2025-04-07 11:10:00',
                'fecha_hora_fin' => '2025-04-07 12:10:00',
                'servicio_id' => 5,
                'sucursal_id' => 3,
                'cliente_usuario_id' => 4,
                'personal_id' => null,
                'precio_final' => 50.00,
                'notas_cliente' => 'egtdhhdfhdfhfdhdgdghdghhghdg',
                'notas_internas' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'estado' => 'PROGRAMADA',
                'fecha_hora_inicio' => '2025-04-10 09:30:00',
                'fecha_hora_fin' => '2025-04-10 10:30:00',
                'servicio_id' => 5,
                'sucursal_id' => 2,
                'cliente_usuario_id' => 4,
                'personal_id' => null,
                'precio_final' => 50.00,
                'notas_cliente' => 'ejemplo',
                'notas_internas' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('agendamientos')->insert($agendamientos);
    }
}