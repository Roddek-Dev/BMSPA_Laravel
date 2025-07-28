<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgendamientoSeeder extends Seeder
{
    public function run()
    {
        DB::table('agendamientos')->truncate();
        DB::table('agendamientos')->insert([
            ['id' => 1, 'cliente_usuario_id' => 1, 'personal_id' => 1, 'servicio_id' => 17, 'sucursal_id' => 15, 'fecha_hora_inicio' => '2025-07-28 10:00:00', 'fecha_hora_fin' => '2025-07-28 10:45:00', 'precio_final' => 25.00, 'estado' => 'Confirmado', 'notas_cliente' => 'Primera vez, emocionado.'],
            ['id' => 2, 'cliente_usuario_id' => 2, 'personal_id' => 2, 'servicio_id' => 8, 'sucursal_id' => 15, 'fecha_hora_inicio' => '2025-07-28 11:00:00', 'fecha_hora_fin' => '2025-07-28 12:00:00', 'precio_final' => 70.00, 'estado' => 'Confirmado', 'notas_internas' => 'Cliente habitual de radiofrecuencia.'],
            // ... (añade todos los agendamientos)
        ]);
    }
}