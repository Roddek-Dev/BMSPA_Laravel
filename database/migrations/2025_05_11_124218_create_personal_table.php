<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->unique()->constrained('usuarios')->onDelete('cascade')->comment('Relación One-to-One con usuarios');
            $table->foreignId('sucursal_asignada_id')->nullable()->constrained('sucursales')->onDelete('set null')->comment('Sucursal principal. NULL para ADMIN_GENERAL');
            $table->string('tipo_personal', 50)->comment('Ej: ADMIN_GENERAL, ADMIN_SUCURSAL, BARBERO, ESTILISTA, MASAJISTA, RECEPCIONISTA');
            $table->string('numero_empleado', 50)->nullable()->unique();
            $table->date('fecha_contratacion')->nullable();
            $table->boolean('activo_en_empresa')->default(true)->comment('Si el empleado está actualmente activo en la empresa');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal');
    }
};