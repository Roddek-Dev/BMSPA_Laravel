<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Desactivamos la revisión de llaves foráneas para una inserción masiva segura.
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call([
            // Tablas Maestras (sin dependencias)
            CategoriaSeeder::class,
            EspecialidadSeeder::class,
            MusicaPreferenciaNavegacionSeeder::class,
            SucursalSeeder::class,
            PromocionSeeder::class,

            // Tablas con dependencias básicas
            UsuarioSeeder::class,
            PersonalSeeder::class,
            ServicioSeeder::class,
            ProductoSeeder::class,

            // Tablas transaccionales y de relación
            AgendamientoSeeder::class,
            OrdenSeeder::class,
            DetalleOrdenSeeder::class,
            DireccionSeeder::class,
            EspecialidadPersonalSeeder::class,
            HorarioSucursalSeeder::class,
            ExcepcionHorarioSucursalSeeder::class,
            ProductoPromocionSeeder::class,
            PromocionServicioSeeder::class,
            RecordatorioSeeder::class,
            ReseñaSeeder::class,
            ServicioPersonalSeeder::class,
            ServicioSucursalSeeder::class,
            TransaccionPagoSeeder::class,
        ]);
        
        // Reactivamos la revisión de llaves foráneas.
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}