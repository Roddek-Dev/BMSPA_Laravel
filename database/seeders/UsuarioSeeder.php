<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        DB::table('usuarios')->truncate();
        DB::table('usuarios')->insert([
            ['id' => 1, 'nombre' => 'Ana García', 'email' => 'anagarcia123@gmail.com', 'password' => Hash::make('passwordAna1'), 'telefono' => '5512345678', 'rol' => 'CLIENTE', 'activo' => 1, 'musica_preferencia_navegacion_id' => 2, 'sucursal_preferida_id' => 15],
            ['id' => 2, 'nombre' => 'Carlos Martínez', 'email' => 'carlosmrtz45@hotmail.com', 'password' => Hash::make('passwordCar2'), 'telefono' => '3321098765', 'rol' => 'CLIENTE', 'activo' => 1, 'musica_preferencia_navegacion_id' => 3, 'sucursal_preferida_id' => 16],
            ['id' => 3, 'nombre' => 'Sofía López', 'email' => 'sofialpz789@gmail.com', 'password' => Hash::make('passwordSof3'), 'telefono' => '9987654321', 'rol' => 'CLIENTE', 'activo' => 1, 'musica_preferencia_navegacion_id' => 5, 'sucursal_preferida_id' => 18],
            // ... (añade el resto de usuarios, hasheando sus contraseñas)
        ]);
    }
}