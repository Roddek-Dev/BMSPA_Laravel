<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->text('descripcion')->nullable();
            $table->string('imagen_path', 255)->nullable();
            $table->decimal('precio_base', 10, 2);
            $table->unsignedInteger('duracion_minutos');
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->onDelete('set null');
            $table->foreignId('especialidad_requerida_id')->nullable()->constrained('especialidades')->onDelete('set null')->comment('Si el servicio requiere una especialización específica del personal');
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};