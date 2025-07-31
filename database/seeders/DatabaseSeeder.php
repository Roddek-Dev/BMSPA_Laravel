<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llamamos al seeder de usuarios para que inserte los datos.
        $this->call([
            UsuarioSeeder::class,
            CategoriaSeeder::class,
            EspecialidadSeeder::class,
            ProductoSeeder::class,
            PromocionSeeder::class,
            ServicioSeeder::class,
            SucursalSeeder::class,
            PersonalSeeder::class,
            AgendamientoSeeder::class,
        ]);
    }
}