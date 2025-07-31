<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('excepciones_horario_sucursal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sucursal_id')->constrained('sucursales')->onDelete('cascade');
            $table->date('fecha')->comment('Fecha específica de la excepción');
            $table->boolean('esta_cerrado')->default(true)->comment('Indica si la sucursal está cerrada en esta fecha específica');
            $table->time('hora_apertura')->nullable()->comment('Hora de apertura especial para esta fecha, si aplica y no está cerrada');
            $table->time('hora_cierre')->nullable()->comment('Hora de cierre especial para esta fecha, si aplica y no está cerrada');
            $table->string('descripcion', 255)->nullable()->comment('Motivo de la excepción, ej: Festivo Nacional, Mantenimiento');
            $table->timestamps();

            $table->index(['sucursal_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('excepciones_horario_sucursal');
    }
};