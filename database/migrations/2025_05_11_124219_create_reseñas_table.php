<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reseñas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->tinyInteger('calificacion')->unsigned()->comment('1 a 5 estrellas');
            $table->text('comentario')->nullable();
            $table->unsignedBigInteger('reseñable_id')->comment('ID del modelo reseñado');
            $table->string('reseñable_type', 255)->comment('Namespace del modelo reseñado, ej: App\\Models\\Servicio, App\\Models\\Producto, App\\Models\\Personal');
            $table->boolean('aprobada')->default(true);
            $table->dateTime('fecha_reseña')->useCurrent();
            $table->timestamps();

            $table->index(['reseñable_id', 'reseñable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reseñas');
    }
};