<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recordatorios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade')->comment('Usuario que recibe el recordatorio (cliente o personal)');
            $table->foreignId('agendamiento_id')->nullable()->constrained('agendamientos')->onDelete('cascade');
            $table->string('titulo', 255);
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha_hora_recordatorio');
            $table->string('canal_notificacion', 50)->default('EMAIL')->comment('Ej: EMAIL, SMS, PUSH_NOTIFICATION');
            $table->boolean('enviado')->default(false);
            $table->dateTime('fecha_envio')->nullable();
            $table->boolean('activo')->default(true);
            $table->boolean('fijado')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recordatorios');
    }
};