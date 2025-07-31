<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Src\Admin\categorias\infrastructure\Models\CategoriaModel;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Desactivar revisión de llaves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. Vaciar la tabla para no duplicar datos en cada ejecución
        CategoriaModel::truncate();

        // 3. Reactivar revisión
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 4. Seeder de categorías con datos del archivo SQL
        $categorias = [
            [
                'id' => 1,
                'nombre' => 'Estética Corporal Avanzada',
                'descripcion' => 'Remodelación y reafirmación corporal no invasiva.',
                'tipo_categoria' => 'Servicio',
                'icono_clave' => 'icono_estetica_corporal',
                'activo' => 1,
                'created_at' => '2025-07-25 19:21:18',
                'updated_at' => '2025-07-25 19:21:18'
            ],
            [
                'id' => 2,
                'nombre' => 'Tratamientos Faciales Avanzados',
                'descripcion' => 'Limpieza profunda, rejuvenecimiento y corrección facial.',
                'tipo_categoria' => 'Servicio',
                'icono_clave' => 'icono_facial_avanzado',
                'activo' => 1,
                'created_at' => '2025-07-25 19:21:18',
                'updated_at' => '2025-07-25 19:21:18'
            ],
            [
                'id' => 3,
                'nombre' => 'Terapias Manuales y Masajes',
                'descripcion' => 'Masajes de relajación y terapias corporales manuales.',
                'tipo_categoria' => 'Servicio',
                'icono_clave' => 'icono_masajes',
                'activo' => 1,
                'created_at' => '2025-07-25 19:21:18',
                'updated_at' => '2025-07-25 19:21:18'
            ],
            [
                'id' => 4,
                'nombre' => 'Servicios de Barbería',
                'descripcion' => 'Cortes y arreglo de barba/bigote para caballeros.',
                'tipo_categoria' => 'Servicio',
                'icono_clave' => 'icono_barberia',
                'activo' => 1,
                'created_at' => '2025-07-25 19:21:18',
                'updated_at' => '2025-07-25 19:21:18'
            ],
            [
                'id' => 5,
                'nombre' => 'Cuidado y Estilismo Capilar',
                'descripcion' => 'Coloración, cortes y tratamientos para el cabello.',
                'tipo_categoria' => 'Servicio',
                'icono_clave' => 'icono_estilismo_capilar',
                'activo' => 1,
                'created_at' => '2025-07-25 19:21:18',
                'updated_at' => '2025-07-25 19:21:18'
            ],
            [
                'id' => 6,
                'nombre' => 'Depilación Láser',
                'descripcion' => 'Eliminación permanente del vello con láser SHR.',
                'tipo_categoria' => 'Servicio',
                'icono_clave' => 'icono_depilacion_laser',
                'activo' => 1,
                'created_at' => '2025-07-25 19:21:18',
                'updated_at' => '2025-07-25 19:21:18'
            ],
            [
                'id' => 7,
                'nombre' => 'Servicios de Cejas y Mirada',
                'descripcion' => 'Diseño y perfilado de cejas, embellecimiento de la mirada.',
                'tipo_categoria' => 'Servicio',
                'icono_clave' => 'icono_cejas_mirada',
                'activo' => 1,
                'created_at' => '2025-07-25 19:21:18',
                'updated_at' => '2025-07-25 19:21:18'
            ],
            [
                'id' => 8,
                'nombre' => 'Eliminación de Tatuajes',
                'descripcion' => 'Procedimientos para remover tatuajes.',
                'tipo_categoria' => 'Servicio',
                'icono_clave' => 'icono_eliminacion_tatuajes',
                'activo' => 1,
                'created_at' => '2025-07-25 19:21:18',
                'updated_at' => '2025-07-25 19:21:18'
            ],
            [
                'id' => 9,
                'nombre' => 'Productos Crecimiento Capilar',
                'descripcion' => 'Productos para estimular el crecimiento del cabello.',
                'tipo_categoria' => 'Producto',
                'icono_clave' => 'icono_prod_crecimiento',
                'activo' => 1,
                'created_at' => '2025-07-25 19:21:18',
                'updated_at' => '2025-07-25 19:21:18'
            ],
            [
                'id' => 10,
                'nombre' => 'Productos para el Cabello',
                'descripcion' => 'Champús, acondicionadores y tratamientos generales para el cabello.',
                'tipo_categoria' => 'Producto',
                'icono_clave' => 'icono_prod_cabello',
                'activo' => 1,
                'created_at' => '2025-07-25 19:21:18',
                'updated_at' => '2025-07-25 19:21:18'
            ],
        ];

        DB::table('categorias')->insert($categorias);
    }
}
