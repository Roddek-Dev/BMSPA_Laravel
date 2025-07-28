<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromocionSeeder extends Seeder
{
    public function run()
    {
        DB::table('promociones')->truncate();
        DB::table('promociones')->insert([
            ['id' => 1, 'codigo' => 'BUENFINOFICIAL', 'nombre' => 'El Buen Fin BarberMusicSpa', 'descripcion' => 'Aprovecha grandes descuentos en servicios y productos seleccionados durante El Buen Fin.', 'tipo_descuento' => 'Porcentaje', 'valor_descuento' => 0.25, 'fecha_inicio' => '2025-11-14 00:00:00', 'fecha_fin' => '2025-11-20 00:00:00', 'usos_maximos_total' => 1000, 'usos_maximos_por_cliente' => 1, 'activo' => 1, 'aplica_a_todos_productos' => 1, 'aplica_a_todos_servicios' => 1],
            ['id' => 2, 'codigo' => 'REGALANAVIDAD', 'nombre' => 'Celebración Navideña BarberMusicSpa', 'descripcion' => 'Regala y regálate bienestar con nuestros paquetes especiales de Navidad y Año Nuevo.', 'tipo_descuento' => 'Cantidad Fija', 'valor_descuento' => 10.00, 'fecha_inicio' => '2025-12-01 00:00:00', 'fecha_fin' => '2025-12-31 00:00:00', 'usos_maximos_total' => 500, 'usos_maximos_por_cliente' => null, 'activo' => 1, 'aplica_a_todos_productos' => 0, 'aplica_a_todos_servicios' => 1],
            ['id' => 3, 'codigo' => 'AMORYESTILO', 'nombre' => 'Promoción Amor y Amistad', 'descripcion' => 'Sorprende a tu pareja con un paquete de spa para dos o un servicio exclusivo.', 'tipo_descuento' => 'Porcentaje', 'valor_descuento' => 0.20, 'fecha_inicio' => '2026-02-10 00:00:00', 'fecha_fin' => '2026-02-16 00:00:00', 'usos_maximos_total' => 200, 'usos_maximos_por_cliente' => 1, 'activo' => 1, 'aplica_a_todos_productos' => 0, 'aplica_a_todos_servicios' => 1],
            // ... (añade el resto de promociones)
        ]);
    }
}