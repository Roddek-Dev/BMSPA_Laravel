<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonalSeeder extends Seeder
{
    public function run()
    {
        DB::table('personal')->truncate();
        DB::table('personal')->insert([
            ['id' => 1, 'usuario_id' => 1, 'sucursal_asignada_id' => 15, 'tipo_personal' => 'Barbero / Estilista Masculino', 'numero_empleado' => 'EMP001SLP', 'fecha_contratacion' => '2023-01-15', 'activo_en_empresa' => 1],
            ['id' => 2, 'usuario_id' => 2, 'sucursal_asignada_id' => 15, 'tipo_personal' => 'Cosmiatra / Terapeuta en Estética Avanzada', 'numero_empleado' => 'EMP002SLP', 'fecha_contratacion' => '2024-03-20', 'activo_en_empresa' => 1],
            ['id' => 3, 'usuario_id' => 3, 'sucursal_asignada_id' => 15, 'tipo_personal' => 'Masajista / Terapeuta Corporal', 'numero_empleado' => 'EMP003SLP', 'fecha_contratacion' => '2022-06-01', 'activo_en_empresa' => 1],
            // ... (añade el resto del personal)
        ]);
    }
}