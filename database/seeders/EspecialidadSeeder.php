<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspecialidadSeeder extends Seeder
{
    public function run()
    {
        DB::table('especialidades')->truncate();
        DB::table('especialidades')->insert([
            ['id' => 1, 'nombre' => 'Cosmiatra / Terapeuta en Estética Avanzada', 'descripcion' => 'Profesional especializado en tratamientos faciales de alta tecnología, corporales avanzados, despigmentación y eliminación de tatuajes.', 'icono_clave' => 'icono_estetica_avanzada', 'activo' => 1],
            ['id' => 2, 'nombre' => 'Masajista / Terapeuta Corporal', 'descripcion' => 'Profesional encargado de maderoterapia y masajes relajantes.', 'icono_clave' => 'icono_masajista', 'activo' => 1],
            ['id' => 3, 'nombre' => 'Barbero / Estilista Masculino', 'descripcion' => 'Especialista en arreglo y diseño de barba, cortes de cabello masculinos y perfilado de cejas para hombres.', 'icono_clave' => 'icono_barbero', 'activo' => 1],
            ['id' => 4, 'nombre' => 'Estilista / Colorista', 'descripcion' => 'Profesional de cabello que realiza coloraciones, cortes generales (masculinos y femeninos), y tratamientos capilares.', 'icono_clave' => 'icono_estilista', 'activo' => 1],
            ['id' => 5, 'nombre' => 'Técnico en Depilación Láser', 'descripcion' => 'Profesional certificado para la operación de equipos de depilación láser SHR.', 'icono_clave' => 'icono_depilacion_laser', 'activo' => 1],
            ['id' => 6, 'nombre' => 'Diseñador de Cejas / Micropigmentador', 'descripcion' => 'Especialista en diseño y delineado de cejas y posiblemente otras técnicas de micropigmentación.', 'icono_clave' => 'icono_cejas_micropigmentacion', 'activo' => 1],
        ]);
    }
}