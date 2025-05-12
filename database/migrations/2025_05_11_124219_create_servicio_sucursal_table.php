<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicio_sucursal', function (Blueprint $table) {
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade');
            $table->foreignId('sucursal_id')->constrained('sucursales')->onDelete('cascade');
            $table->decimal('precio_en_sucursal', 10, 2)->nullable()->comment('Precio específico del servicio en esta sucursal, si difiere del base del servicio');
            $table->boolean('esta_disponible')->default(true)->comment('Si el servicio está actualmente activo/ofreciéndose en esta sucursal');
            $table->timestamps();

            $table->primary(['servicio_id', 'sucursal_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servicio_sucursal');
    }
};