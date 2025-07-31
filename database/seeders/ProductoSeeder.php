<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Src\Catalog\productos\infrastructure\Models\ProductoModel;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Apagamos la revisión de llaves foráneas para poder usar truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. Vaciamos la tabla para no duplicar datos en cada ejecución
        ProductoModel::truncate();

        // 3. Volvemos a encender la revisión
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 4. Creamos los datos de prueba
        $productos = [
            [
                'id' => 1,
                'sku' => 'PROD001',
                'nombre' => 'Pomada Base Agua Mel Bros Co. 4oz',
                'descripcion' => 'Pomada de fijación media con base de agua y fácil de lavar.',
                'stock' => 150,
                'precio' => 25.50,
                'categoria_id' => 10, // Productos para el Cabello
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'sku' => 'PROD002',
                'nombre' => 'Aceite para Barba Mel Bros Co.',
                'descripcion' => 'Aceite hidratante y suavizante para el cuidado de la barba.',
                'stock' => 200,
                'precio' => 18.75,
                'categoria_id' => 4, // Servicios de Barbería
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'sku' => 'PROD003',
                'nombre' => 'Tónico Facial Limpiador',
                'descripcion' => 'Tónico para limpieza profunda de la piel, apto para todo tipo de cutis.',
                'stock' => 100,
                'precio' => 15.00,
                'categoria_id' => 2, // Tratamientos Faciales Avanzados
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'sku' => 'PROD004',
                'nombre' => 'Reelance Shampoo Hombre 120ml',
                'descripcion' => 'Shampoo que neutraliza el pH del cuero cabelludo y estimula el crecimiento del cabello.',
                'stock' => 75,
                'precio' => 23.53,
                'categoria_id' => 9, // Productos Crecimiento Capilar
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'sku' => 'PROD005',
                'nombre' => 'Cera para Bigote Estilismo Profesional',
                'descripcion' => 'Cera de alta fijación para dar forma y estilo al bigote.',
                'stock' => 50,
                'precio' => 12.99,
                'categoria_id' => 4, // Servicios de Barbería
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('productos')->insert($productos);
    }
}
