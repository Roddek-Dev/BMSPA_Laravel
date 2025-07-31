<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Deshabilitar temporalmente las verificaciones de clave foránea
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // 2. Truncar la tabla para eliminar datos existentes
        DB::table('sucursales')->truncate();
        
        // 3. Habilitar nuevamente las verificaciones de clave foránea
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // 4. Insertar los datos de las sucursales
        DB::table('sucursales')->insert([
            ['id' => 1, 'nombre' => 'BarberMusicSpa San Luis Potosí', 'telefono_contacto' => '4441021114', 'email_contacto' => 'sanluis.sucursal1@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/abcdefg', 'latitud' => 22.1558000, 'longitud' => -101.0189000, 'activo' => 1],
            ['id' => 2, 'nombre' => 'BarberMusicSpa Coatzacoalcos', 'telefono_contacto' => '9212104867', 'email_contacto' => 'coatzacoalcos.sucursal2@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/hijklmn', 'latitud' => 18.1367000, 'longitud' => -94.4697000, 'activo' => 1],
            ['id' => 3, 'nombre' => 'BarberMusicSpa Villahermosa', 'telefono_contacto' => '9934120021', 'email_contacto' => 'villahermosa.sucursal3@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/opqrstu', 'latitud' => 17.9947000, 'longitud' => -92.9304000, 'activo' => 1],
            ['id' => 4, 'nombre' => 'MusicSpa Mérida', 'telefono_contacto' => '9995188579', 'email_contacto' => 'merida.sucursal4@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/vwxyz12', 'latitud' => 21.0184000, 'longitud' => -89.5828000, 'activo' => 1],
            ['id' => 5, 'nombre' => 'BarberMusicSpa Ciudad del Carmen', 'telefono_contacto' => '9386886061', 'email_contacto' => 'ciudaddelcarmen.sucursal5@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/3456789', 'latitud' => 18.6366000, 'longitud' => -91.8219000, 'activo' => 1],
            ['id' => 6, 'nombre' => 'BarberMusicSpa Villahermosa II', 'telefono_contacto' => '9212104867', 'email_contacto' => 'villahermosa2.sucursal6@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/123abcd', 'latitud' => 17.9866000, 'longitud' => -92.9329000, 'activo' => 1],
            ['id' => 7, 'nombre' => 'MusicSpa Villahermosa III', 'telefono_contacto' => '9934120021', 'email_contacto' => 'villahermosa3.sucursal7@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/efghijk', 'latitud' => 17.9947000, 'longitud' => -92.9304000, 'activo' => 1],
            ['id' => 8, 'nombre' => 'BarberMusicSpa Cancún', 'telefono_contacto' => '9981234567', 'email_contacto' => 'cancun.sucursal8@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/lmnopq', 'latitud' => 21.1619000, 'longitud' => -86.8515000, 'activo' => 1],
            ['id' => 9, 'nombre' => 'BarberMusicSpa Guadalajara', 'telefono_contacto' => '3331234567', 'email_contacto' => 'guadalajara.sucursal9@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/rstuvw', 'latitud' => 20.6736000, 'longitud' => -103.3440000, 'activo' => 1],
            ['id' => 10, 'nombre' => 'BarberMusicSpa Monterrey', 'telefono_contacto' => '8181234567', 'email_contacto' => 'monterrey.sucursal10@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/xyzw12', 'latitud' => 25.6866000, 'longitud' => -100.3161000, 'activo' => 1],
            ['id' => 11, 'nombre' => 'BarberMusicSpa Puebla', 'telefono_contacto' => '2221234567', 'email_contacto' => 'puebla.sucursal11@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/345678', 'latitud' => 19.0414000, 'longitud' => -98.2063000, 'activo' => 1],
            ['id' => 12, 'nombre' => 'BarberMusicSpa Querétaro', 'telefono_contacto' => '4421234567', 'email_contacto' => 'queretaro.sucursal12@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/901234', 'latitud' => 20.5925000, 'longitud' => -100.3929000, 'activo' => 1],
            ['id' => 13, 'nombre' => 'BarberMusicSpa Tijuana', 'telefono_contacto' => '6641234567', 'email_contacto' => 'tijuana.sucursal13@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/567890', 'latitud' => 32.5149000, 'longitud' => -117.0382000, 'activo' => 1],
            ['id' => 14, 'nombre' => 'BarberMusicSpa Chihuahua', 'telefono_contacto' => '6141234567', 'email_contacto' => 'chihuahua.sucursal14@gmail.com', 'link_maps' => 'https://maps.app.goo.gl/abcde', 'latitud' => 28.6329000, 'longitud' => -106.0691000, 'activo' => 1],
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
