<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Src\Client\usuarios\infrastructure\Persistence\Eloquent\UsuarioModel;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Apagamos la revisión de llaves foráneas para poder usar truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. Vaciamos la tabla de usuarios
        DB::table('usuarios')->truncate();

        // 3. Volvemos a encender la revisión
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 4. Seeder de usuarios con datos del archivo SQL
        $usuarios = [
            [
                'id' => 1,
                'nombre' => 'Carlos',
                'email' => 'cr972431@gmail.com',
                // Este hash corresponde a la contraseña proporcionada en el dump SQL
                'password' => '$2y$10$89u.F41mF90.w7q/g900..',
                'telefono' => '3213595990',
                'rol' => 'ADMIN',
                'activo' => true,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'nombre' => 'Armando Casas',
                'email' => 'daniel@gmail',
                'password' => '$2a$10$qhwhIHVKR1nalbxPSk58Eudo21KVEuzGKGmT5BHozj63/Fvh2mDQe',
                'telefono' => null,
                'rol' => 'USER',
                'activo' => true,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'nombre' => 'Carlos Rodriguez',
                'email' => 'cj@gmail',
                'password' => '$2a$10$n99gCmZNYVoZ5nsmDaY.aOiXWcNPDHIxPuPu6nTCJTYMAEAF/PAsG',
                'telefono' => '3213595991',
                'rol' => 'ADMIN',
                'activo' => true,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 4,
                'nombre' => 'julio jaramillo',
                'email' => 'jaramillo@gmail',
                'password' => '$2a$10$D0/B224GEzdFTeB9nEWkJu9o',
                'telefono' => null,
                'rol' => 'PERSONAL',
                'activo' => true,
                'created_at' => '2025-07-28 09:22:15',
                'updated_at' => '2025-07-28 09:22:15',
            ],
        ];

        DB::table('usuarios')->insert($usuarios);
    }
}
