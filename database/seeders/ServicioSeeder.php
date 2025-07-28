<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioSeeder extends Seeder
{
    public function run()
    {
        DB::table('servicios')->truncate();
        DB::table('servicios')->insert([
            ['id' => 1, 'nombre' => 'SculpSure', 'descripcion' => 'Reducción de grasa localizada no invasiva mediante tecnología láser.', 'precio_base' => 150.00, 'duracion_minutos' => 45, 'categoria_id' => 2, 'especialidad_requerida_id' => 1, 'activo' => 1],
            ['id' => 2, 'nombre' => 'Lipo sin Cirugía', 'descripcion' => 'Tratamiento no invasivo para la eliminación de depósitos de grasa.', 'precio_base' => 120.00, 'duracion_minutos' => 60, 'categoria_id' => 2, 'especialidad_requerida_id' => 1, 'activo' => 1],
            // ... (añade todos los servicios)
        ]);
    }
}