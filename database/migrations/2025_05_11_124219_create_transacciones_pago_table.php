<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transacciones_pago', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_id')->nullable()->constrained('ordenes')->onDelete('set null');
            $table->foreignId('agendamiento_id')->nullable()->constrained('agendamientos')->onDelete('set null');
            $table->foreignId('cliente_usuario_id')->constrained('usuarios')->onDelete('restrict');
            $table->decimal('monto', 10, 2);
            $table->string('moneda', 10)->default('MXN');
            $table->string('metodo_pago', 100);
            $table->string('id_transaccion_pasarela', 255)->nullable()->unique();
            $table->string('estado_pago', 50)->comment('Ej: PENDIENTE, COMPLETADO, FALLIDO, REEMBOLSADO');
            $table->dateTime('fecha_transaccion')->useCurrent();
            $table->json('datos_pasarela_request')->nullable();
            $table->json('datos_pasarela_response')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transacciones_pago');
    }
};