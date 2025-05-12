<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promociones', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 255);
            $table->text('descripcion')->nullable();
            $table->string('tipo_descuento', 50)->comment('Ej: PORCENTAJE, MONTO_FIJO');
            $table->decimal('valor_descuento', 10, 2);
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin')->nullable();
            $table->unsignedInteger('usos_maximos_total')->nullable();
            $table->unsignedInteger('usos_maximos_por_cliente')->nullable()->default(1);
            $table->unsignedInteger('usos_actuales')->default(0);
            $table->boolean('activo')->default(true);
            $table->boolean('aplica_a_todos_productos')->default(false);
            $table->boolean('aplica_a_todos_servicios')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promociones');
    }
};