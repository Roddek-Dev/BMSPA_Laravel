<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        DB::table('categorias')->truncate();
        DB::table('categorias')->insert([
            ['id' => 1, 'nombre' => 'Estética Corporal Avanzada', 'descripcion' => 'Remodelación y reafirmación corporal no invasiva.', 'tipo_categoria' => 'Servicio', 'icono_clave' => 'icono_estetica_corporal', 'activo' => 1],
            ['id' => 2, 'nombre' => 'Tratamientos Faciales Avanzados', 'descripcion' => 'Limpieza profunda, rejuvenecimiento y corrección facial.', 'tipo_categoria' => 'Servicio', 'icono_clave' => 'icono_facial_avanzado', 'activo' => 1],
            ['id' => 3, 'nombre' => 'Terapias Manuales y Masajes', 'descripcion' => 'Masajes de relajación y terapias corporales manuales.', 'tipo_categoria' => 'Servicio', 'icono_clave' => 'icono_masajes', 'activo' => 1],
            ['id' => 4, 'nombre' => 'Servicios de Barbería', 'descripcion' => 'Cortes y arreglo de barba/bigote para caballeros.', 'tipo_categoria' => 'Servicio', 'icono_clave' => 'icono_barberia', 'activo' => 1],
            ['id' => 5, 'nombre' => 'Cuidado y Estilismo Capilar', 'descripcion' => 'Coloración, cortes y tratamientos para el cabello.', 'tipo_categoria' => 'Servicio', 'icono_clave' => 'icono_estilismo_capilar', 'activo' => 1],
            ['id' => 6, 'nombre' => 'Depilación Láser', 'descripcion' => 'Eliminación permanente del vello con láser SHR.', 'tipo_categoria' => 'Servicio', 'icono_clave' => 'icono_depilacion_laser', 'activo' => 1],
            ['id' => 7, 'nombre' => 'Servicios de Cejas y Mirada', 'descripcion' => 'Diseño y perfilado de cejas, embellecimiento de la mirada.', 'tipo_categoria' => 'Servicio', 'icono_clave' => 'icono_cejas_mirada', 'activo' => 1],
            ['id' => 8, 'nombre' => 'Eliminación de Tatuajes', 'descripcion' => 'Procedimientos para remover tatuajes.', 'tipo_categoria' => 'Servicio', 'icono_clave' => 'icono_eliminacion_tatuajes', 'activo' => 1],
            ['id' => 9, 'nombre' => 'Productos Crecimiento Capilar', 'descripcion' => 'Productos para estimular el crecimiento del cabello.', 'tipo_categoria' => 'Producto', 'icono_clave' => 'icono_prod_crecimiento', 'activo' => 1],
            ['id' => 10, 'nombre' => 'Productos para el Cabello', 'descripcion' => 'Champús, acondicionadores y tratamientos generales para el cabello.', 'tipo_categoria' => 'Producto', 'icono_clave' => 'icono_prod_cabello', 'activo' => 1],
            ['id' => 11, 'nombre' => 'Productos para la Barba', 'descripcion' => 'Aceites, bálsamos y ceras para el cuidado de la barba.', 'tipo_categoria' => 'Producto', 'icono_clave' => 'icono_prod_barba', 'activo' => 1],
            ['id' => 12, 'nombre' => 'Productos de Afeitado', 'descripcion' => 'Cremas, geles y accesorios para un afeitado perfecto.', 'tipo_categoria' => 'Producto', 'icono_clave' => 'icono_prod_afeitado', 'activo' => 1],
            ['id' => 13, 'nombre' => 'Productos para la Piel', 'descripcion' => 'Limpiadores, hidratantes y tratamientos para la piel.', 'tipo_categoria' => 'Producto', 'icono_clave' => 'icono_prod_piel', 'activo' => 1],
            ['id' => 14, 'nombre' => 'Kits de Productos', 'descripcion' => 'Paquetes combinados de productos para diferentes necesidades.', 'tipo_categoria' => 'Producto', 'icono_clave' => 'icono_prod_kits', 'activo' => 1],
            ['id' => 15, 'nombre' => 'Productos Rebalance', 'descripcion' => 'Línea de productos para reequilibrar o restaurar.', 'tipo_categoria' => 'Producto', 'icono_clave' => 'icono_prod_rebalance', 'activo' => 1],
        ]);
    }
}