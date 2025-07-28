<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SucursalSeeder extends Seeder
{
    public function run()
    {
        DB::table('sucursales')->truncate();
        DB::table('sucursales')->insert([
            ['id' => 15, 'nombre' => 'BarberMusicSpa San Luis Potosí (Plaza San Luis)', 'telefono_contacto' => '4441021114', 'email_contacto' => 'barbermusicspa.plazasanluis@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/59MadN6Ji22s3R677', 'latitud' => 22.1558000, 'longitud' => -101.0189000, 'activo' => 1],
            ['id' => 16, 'nombre' => 'BarberMusicSpa Coatzacoalcos (Plaza Forum)', 'telefono_contacto' => '9212104867', 'email_contacto' => 'barbermusicspa.plazaforum@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/1CHfFnaRmSVDyuqW6', 'latitud' => 18.1367000, 'longitud' => -94.4697000, 'activo' => 1],
            ['id' => 17, 'nombre' => 'BarberMusicSpa Villahermosa (Plaza Altabrisa)', 'telefono_contacto' => '9934120021', 'email_contacto' => 'barbermusicspa.altabrisavillahermosa@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/pTBbYJXVJXyo9ZSJ8', 'latitud' => 17.9947000, 'longitud' => -92.9304000, 'activo' => 1],
            ['id' => 18, 'nombre' => 'MusicSpaVillahermosa Mérida (Plaza Altabrisa)', 'telefono_contacto' => '9995188579', 'email_contacto' => 'musicspavillahermosa.altabrisamerida@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/zJ9SuGr6wbxug7En9', 'latitud' => 21.0184000, 'longitud' => -89.5828000, 'activo' => 1],
            ['id' => 19, 'nombre' => 'BarberMusicSpa Ciudad del Carmen (Plaza Zentralia)', 'telefono_contacto' => '9386886061', 'email_contacto' => 'barbermusicspa.plazazentralia@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/ai2KZKCc3Wx2kkrh8', 'latitud' => 18.6366000, 'longitud' => -91.8219000, 'activo' => 1],
            ['id' => 20, 'nombre' => 'BarberMusicSpa Villahermosa II (Plaza Las Americas)', 'telefono_contacto' => '9212104867', 'email_contacto' => 'barbermusicspa.plazalasamericas@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/nyGbqHxUZt9zyDaM9', 'latitud' => 17.9866000, 'longitud' => -92.9329000, 'activo' => 1],
            ['id' => 21, 'nombre' => 'MusicSpaVillahermosa Villahermosa III (Plaza Altabrisa)', 'telefono_contacto' => '9934120021', 'email_contacto' => 'musicspavillahermosa.altabrisavillahermosa3@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/R5GS9YzMc1zSgtFK9', 'latitud' => 17.9947000, 'longitud' => -92.9304000, 'activo' => 1],
        ]);
    }
}