<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reseñas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->unsignedTinyInteger('calificacion')->comment('1 a 5 estrellas');
            $table->text('comentario')->nullable();
            
            // Columna para el ID del modelo reseñado (Servicio, Producto, Sucursal, etc.)
            $table->unsignedBigInteger('reseñable_id');
            // Columna para el namespace del modelo
            $table->string('reseñable_type');

            $table->boolean('aprobada')->default(false)->comment('Se cambia a true tras la moderación del admin');
            $table->dateTime('fecha_reseña')->useCurrent();
            $table->timestamps();

            // Índice para la relación polimórfica
            $table->index(['reseñable_id', 'reseñable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseñas');
    }
};