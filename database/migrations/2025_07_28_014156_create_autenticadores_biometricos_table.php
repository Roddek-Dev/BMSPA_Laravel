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
        Schema::create('autenticadores_biometricos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->string('dispositivo_nombre')->comment('Ej: iPhone de Juan');
            $table->text('credencial_id')->comment('ID único de la credencial biométrica');
            $table->text('public_key')->comment('Clave pública para verificar la autenticación');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autenticadores_biometricos');
    }
};