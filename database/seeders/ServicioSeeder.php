<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioSeeder extends Seeder
{
    public function run()
    {
        // Deshabilitar temporalmente las verificaciones de clave foránea
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        DB::table('servicios')->truncate();
        
        // Habilitar nuevamente las verificaciones de clave foránea
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        DB::table('servicios')->insert([
            ['id' => 1, 'nombre' => 'SculpSure', 'descripcion' => 'Reducción de grasa localizada no invasiva mediante tecnología láser.', 'precio_base' => 150.00, 'duracion_minutos' => 45, 'categoria_id' => 2, 'especialidad_requerida_id' => 1, 'activo' => 1],
            ['id' => 2, 'nombre' => 'Lipo sin Cirugía', 'descripcion' => 'Tratamiento no invasivo para la eliminación de depósitos de grasa.', 'precio_base' => 120.00, 'duracion_minutos' => 60, 'categoria_id' => 2, 'especialidad_requerida_id' => 1, 'activo' => 1],
            ['id' => 3, 'nombre' => 'Radiofrecuencia Corporal', 'descripcion' => 'Tratamiento que utiliza ondas electromagnéticas para combatir la flacidez y celulitis.', 'precio_base' => 100.00, 'duracion_minutos' => 50, 'categoria_id' => 2, 'especialidad_requerida_id' => 1, 'activo' => 1],
            ['id' => 4, 'nombre' => 'Microdermoabrasión', 'descripcion' => 'Exfoliación profunda para mejorar la textura de la piel y reducir manchas.', 'precio_base' => 80.00, 'duracion_minutos' => 30, 'categoria_id' => 1, 'especialidad_requerida_id' => 2, 'activo' => 1],
            ['id' => 5, 'nombre' => 'Tinte y Corte', 'descripcion' => 'Servicio completo de coloración y corte de cabello para hombre.', 'precio_base' => 80.00, 'duracion_minutos' => 90, 'categoria_id' => 3, 'especialidad_requerida_id' => 3, 'activo' => 1],
            ['id' => 6, 'nombre' => 'Barba Clásica', 'descripcion' => 'Arreglo de barba con navaja, toallas calientes y productos de alta calidad.', 'precio_base' => 30.00, 'duracion_minutos' => 30, 'categoria_id' => 3, 'especialidad_requerida_id' => 3, 'activo' => 1],
            ['id' => 7, 'nombre' => 'Manicure Spa', 'descripcion' => 'Cuidado completo de uñas y piel de las manos con masajes y exfoliación.', 'precio_base' => 40.00, 'duracion_minutos' => 45, 'categoria_id' => 4, 'especialidad_requerida_id' => 4, 'activo' => 1],
            ['id' => 8, 'nombre' => 'Pedicure Spa', 'descripcion' => 'Relajante tratamiento para pies con exfoliación, hidratación y masajes.', 'precio_base' => 50.00, 'duracion_minutos' => 60, 'categoria_id' => 4, 'especialidad_requerida_id' => 4, 'activo' => 1],
            ['id' => 9, 'nombre' => 'Masaje Descontracturante', 'descripcion' => 'Masaje terapéutico para aliviar tensiones musculares y nudos.', 'precio_base' => 75.00, 'duracion_minutos' => 60, 'categoria_id' => 5, 'especialidad_requerida_id' => 5, 'activo' => 1],
            ['id' => 10, 'nombre' => 'Masaje Relajante', 'descripcion' => 'Masaje de cuerpo completo con aceites esenciales para reducir el estrés.', 'precio_base' => 70.00, 'duracion_minutos' => 60, 'categoria_id' => 5, 'especialidad_requerida_id' => 5, 'activo' => 1],
            ['id' => 11, 'nombre' => 'Limpieza Facial Profunda', 'descripcion' => 'Tratamiento para limpiar poros, eliminar impurezas y revitalizar la piel del rostro.', 'precio_base' => 65.00, 'duracion_minutos' => 60, 'categoria_id' => 1, 'especialidad_requerida_id' => 2, 'activo' => 1],
            ['id' => 12, 'nombre' => 'Maquillaje para Eventos', 'descripcion' => 'Maquillaje profesional para ocasiones especiales con productos de alta gama.', 'precio_base' => 90.00, 'duracion_minutos' => 90, 'categoria_id' => 1, 'especialidad_requerida_id' => 2, 'activo' => 1],
        ]);
    }
}
