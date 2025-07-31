<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Src\Admin\especialidades\infrastructure\Models\EspecialidadModel;

class EspecialidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Apagamos la revisión de llaves foráneas para poder usar truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. Vaciamos la tabla para no duplicar datos en cada ejecución
        EspecialidadModel::truncate();

        // 3. La volvemos a prender
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 4. Creamos los datos de prueba
        $especialidades = [
            [
                'id' => 1,
                'nombre' => 'Barbería Clásica',
                'descripcion' => 'Cortes y afeitados tradicionales para caballero.',
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nombre' => 'Masajes Terapéuticos',
                'descripcion' => 'Técnicas de masaje para relajación y alivio de tensiones.',
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nombre' => 'Estética Facial',
                'descripcion' => 'Tratamientos de limpieza, hidratación y rejuvenecimiento facial.',
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'nombre' => 'Manicura y Pedicura',
                'descripcion' => 'Servicios de cuidado de manos y pies.',
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'nombre' => 'Depilación Láser',
                'descripcion' => 'Especialistas en procedimientos de depilación permanente.',
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'nombre' => 'Estilismo y Coloración',
                'descripcion' => 'Expertos en cortes modernos y aplicación de tintes.',
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'nombre' => 'Terapias Corporales',
                'descripcion' => 'Tratamientos corporales reductores y reafirmantes.',
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('especialidades')->insert($especialidades);
    }
}
