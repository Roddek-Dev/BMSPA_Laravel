<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MusicaPreferenciaNavegacionSeeder extends Seeder
{
    public function run()
    {
        DB::table('musica_preferencias_navegacion')->truncate();
        DB::table('musica_preferencias_navegacion')->insert([
            ['id' => 1, 'nombre_opcion' => 'Música Electrónica', 'descripcion' => 'Género musical que utiliza instrumentos electrónicos y tecnología musical para producir sonidos, ideal para un ambiente moderno y energizante.', 'stream_url_ejemplo' => 'https://open.spotify.com/playlist/37i9dQZF1DX0FkEbt6HOwE', 'activo' => 1],
            ['id' => 2, 'nombre_opcion' => 'Música Pop', 'descripcion' => 'Género musical popular con melodías pegadizas y estructuras sencillas, ideal para un ambiente animado y familiar.', 'stream_url_ejemplo' => 'https://open.spotify.com/playlist/37i9dQZF1DXcBWIGoYBM5M', 'activo' => 1],
            ['id' => 3, 'nombre_opcion' => 'Rock Clásico', 'descripcion' => 'Género que abarca una amplia gama de estilos musicales evolucionados del rock and roll de los años 60-80, perfecto para un ambiente con carácter y nostalgia.', 'stream_url_ejemplo' => 'https://open.spotify.com/playlist/37i9dQZF1DXcBWIGoYBM5M', 'activo' => 1],
            ['id' => 4, 'nombre_opcion' => 'Indie Pop / Rock', 'descripcion' => 'Música alternativa con influencias de rock y pop, a menudo asociada con sellos discográficos independientes, para un ambiente fresco y relajado.', 'stream_url_ejemplo' => 'https://open.spotify.com/playlist/37i9dQZF1DX2L0iB2NEaK2', 'activo' => 1],
            ['id' => 5, 'nombre_opcion' => 'Jazz Suave', 'descripcion' => 'Un estilo de jazz relajante y melódico, ideal para ambientes tranquilos, sofisticados y que invitan a la calma.', 'stream_url_ejemplo' => 'https://open.spotify.com/playlist/37i9dQZF1DXbKgb5liG50K', 'activo' => 1],
            ['id' => 6, 'nombre_opcion' => 'Música Latina Pop', 'descripcion' => 'Géneros populares de habla hispana como reggaetón, pop latino y baladas, para un ambiente alegre y con ritmo.', 'stream_url_ejemplo' => 'https://open.spotify.com/playlist/37i9dQZF1DX2Nc3B7A90rp', 'activo' => 1],
            ['id' => 7, 'nombre_opcion' => 'R&B Suave', 'descripcion' => 'Ritmo y blues contemporáneo con melodías melancólicas y beats relajantes, perfecto para un ambiente íntimo y con estilo.', 'stream_url_ejemplo' => 'https://open.spotify.com/playlist/37i9dQZF1DXd2tK8sE7wwS', 'activo' => 1],
            ['id' => 8, 'nombre_opcion' => 'Lo-fi Beats', 'descripcion' => 'Un género de música electrónica con elementos de jazz, hip-hop y funk, caracterizado por su sonido relajado y atmosférico, ideal para concentración o relajación.', 'stream_url_ejemplo' => 'https://open.spotify.com/playlist/37i9dQZF1DXc8kgYqQLMfN', 'activo' => 1],
            ['id' => 9, 'nombre_opcion' => 'Clásica Relajante', 'descripcion' => 'Obras de música clásica seleccionadas por su efecto calmante y sereno, para un ambiente de máxima tranquilidad y elegancia.', 'stream_url_ejemplo' => 'https://open.spotify.com/playlist/37i9dQZF1DXdK7fA3p7y5W', 'activo' => 1],
        ]);
    }
}