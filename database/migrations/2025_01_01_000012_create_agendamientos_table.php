<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendamientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('personal_id')->nullable()->constrained('personal')->onDelete('set null')->comment('Personal que realizará el servicio');
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('restrict');
            $table->foreignId('sucursal_id')->constrained('sucursales')->onDelete('restrict')->comment('Sucursal donde se agenda el servicio');
            $table->dateTime('fecha_hora_inicio');
            $table->dateTime('fecha_hora_fin');
            $table->decimal('precio_final', 10, 2);
            $table->string('estado', 50)->default('PROGRAMADA')->comment('Ej: PROGRAMADA, CONFIRMADA, CANCELADA_CLIENTE, CANCELADA_PERSONAL, COMPLETADA, NO_ASISTIO');
            $table->text('notas_cliente')->nullable();
            $table->text('notas_internas')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendamientos');
    }
};