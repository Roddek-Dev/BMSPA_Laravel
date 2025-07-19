<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id();
            // Campos para la relación polimórfica
            $table->unsignedBigInteger('direccionable_id');
            $table->string('direccionable_type');

            // --- CAMPOS DE DIRECCIÓN UNIFICADOS ---
            $table->string('direccion', 255);
            $table->string('colonia', 100);
            $table->string('codigo_postal', 10);
            $table->string('ciudad', 100);
            $table->string('estado', 100);
            $table->text('referencias')->nullable()->comment('Referencias adicionales para la ubicación');
            
            // Opcional: Para saber si es la dirección principal de un usuario o sucursal
            $table->boolean('es_predeterminada')->default(false);

            $table->timestamps();
            $table->softDeletes();
            
            // Índice para mejorar la búsqueda polimórfica
            $table->index(['direccionable_id', 'direccionable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};