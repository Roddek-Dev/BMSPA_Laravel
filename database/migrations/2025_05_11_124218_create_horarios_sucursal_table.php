<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios_sucursal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sucursal_id')->constrained('sucursales')->onDelete('cascade');
            $table->tinyInteger('dia_semana')->unsigned()->comment('0=Domingo, 1=Lunes,..., 6=Sábado');
            $table->time('hora_apertura')->nullable();
            $table->time('hora_cierre')->nullable();
            $table->boolean('esta_cerrado_regularmente')->default(false)->comment('Si este día de la semana la sucursal está normalmente cerrada, ej: Domingos');
            $table->timestamps();

            $table->unique(['sucursal_id', 'dia_semana']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios_sucursal');
    }
};