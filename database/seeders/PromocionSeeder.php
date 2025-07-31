<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Src\Admin\promociones\infrastructure\Models\PromocionModel;

class PromocionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Desactivar revisión de llaves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. Vaciamos la tabla para no duplicar datos en cada ejecución
        PromocionModel::truncate();

        // 3. Reactivar revisión
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 4. Seeder de promociones con datos del archivo SQL
        $promociones = [
            [
                'id' => 1,
                'nombre' => '2x1 Masaje Relajante',
                'descripcion' => 'Aprovecha esta promoción especial y ven con un acompañante para disfrutar de un masaje relajante 2x1. Válido hasta el 31 de Agosto.',
                'fecha_inicio' => '2025-07-26 00:00:00',
                'fecha_fin' => '2025-08-31 23:59:59',
                'tipo_descuento' => 'PORCENTAJE',
                'valor_descuento' => 50.00,
                'codigo' => 'MR-2X1-2025',
                'activo' => true,
                'usos_maximos_total' => 100,
                'usos_maximos_por_cliente' => 1,
                'usos_actuales' => 0,
                'aplica_a_todos_productos' => false,
                'aplica_a_todos_servicios' => false,
                'created_at' => '2025-07-26 04:27:44',
                'updated_at' => '2025-07-26 04:27:44'
            ],
            [
                'id' => 2,
                'nombre' => 'Combo Barbería',
                'descripcion' => 'Corte de cabello + arreglo de barba por un precio especial. Válido solo en el mes de agosto.',
                'fecha_inicio' => '2025-08-01 00:00:00',
                'fecha_fin' => '2025-08-31 23:59:59',
                'tipo_descuento' => 'PORCENTAJE',
                'valor_descuento' => 15.00,
                'codigo' => 'BARBER-COMBO-AGO',
                'activo' => false,
                'usos_maximos_total' => 50,
                'usos_maximos_por_cliente' => 1,
                'usos_actuales' => 0,
                'aplica_a_todos_productos' => false,
                'aplica_a_todos_servicios' => false,
                'created_at' => '2025-07-26 04:27:44',
                'updated_at' => '2025-07-26 04:27:44'
            ]
        ];

        DB::table('promociones')->insert($promociones);
    }
}
