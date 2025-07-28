<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    public function run()
    {
        DB::table('productos')->truncate();
        DB::table('productos')->insert([
            ['id' => 1, 'nombre' => 'Bálsamo Clásico de Crecimiento de Barba y Bigote 5% Minoxidil - 2oz|60ml Biotina + Queratina & Vitaminas', 'descripcion' => '5% Minoxidil: Estimula el crecimiento, fortalece el vello y mejora la densidad. Biotina, Queratina y Vitaminas: Para mayor efectividad en cada aplicación. Crema Ligera y de Rápida Absorción : Para piel Mixta o Sensible. Aplicación Fácil : Aplicar como una crema facial. Recomendación de Uso : Se sugiere aplicar dos veces al día durante 90 días para obtener los mejores resultados en el crecimiento y densidad de la barba.', 'precio' => 29.35, 'stock' => 200, 'sku' => 'PROD001C', 'categoria_id' => 9, 'activo' => 1],
            // ... (añade todos los productos)
        ]);
    }
}