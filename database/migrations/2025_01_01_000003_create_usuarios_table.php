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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('imagen_path')->nullable();
            $table->string('telefono', 25)->unique()->nullable();
            $table->string('rol', 50)->default('CLIENTE');
            $table->boolean('activo')->default(true);
            $table->unsignedBigInteger('musica_preferencia_navegacion_id')->nullable();
            $table->unsignedBigInteger('sucursal_preferida_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('musica_preferencia_navegacion_id')->references('id')->on('musica_preferencias_navegacion')->onDelete('set null');
            $table->foreign('sucursal_preferida_id')->references('id')->on('sucursales')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};