<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique();
            $table->text('descripcion')->nullable();
            $table->string('tipo_categoria', 50)->comment('Ej: PRODUCTO, SERVICIO');
            $table->string('icono_clave', 50)->nullable()->comment('Clave para mapear a un icono en el frontend');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};