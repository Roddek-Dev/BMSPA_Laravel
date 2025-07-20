<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('imagen_path', 255)->nullable();
            $table->string('telefono', 25)->nullable()->unique();
            $table->string('rol', 50)->default('CLIENTE')->comment('Ej: CLIENTE, EMPLEADO. Si es EMPLEADO, tiene un registro en la tabla `personal`');
            $table->boolean('activo')->default(true); // Añade esta línea
            $table->foreignId('musica_preferencia_navegacion_id')->nullable()->constrained('musica_preferencias_navegacion')->onDelete('set null');
            $table->foreignId('sucursal_preferida_id')->nullable()->constrained('sucursales')->onDelete('set null')->comment('Sucursal preferida por el usuario para visualización rápida');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    
    public function down(): void
    {   
        Schema::dropIfExists('usuarios');
    }
};