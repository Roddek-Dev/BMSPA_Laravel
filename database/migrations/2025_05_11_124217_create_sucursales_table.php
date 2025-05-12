<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sucursales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('imagen_path', 255)->nullable();
            $table->string('direccion_calle', 255);
            $table->string('direccion_numero_exterior', 50);
            $table->string('direccion_numero_interior', 50)->nullable();
            $table->string('direccion_colonia', 100);
            $table->string('direccion_codigo_postal', 10);
            $table->string('direccion_municipio_alcaldia', 100);
            $table->string('direccion_ciudad', 100)->nullable();
            $table->string('direccion_estado', 100);
            $table->string('telefono_contacto', 25)->nullable();
            $table->string('email_contacto', 255)->nullable()->unique();
            $table->string('link_maps', 512)->nullable();
            $table->decimal('latitud', 10, 7)->nullable();
            $table->decimal('longitud', 10, 7)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sucursales');
    }
};