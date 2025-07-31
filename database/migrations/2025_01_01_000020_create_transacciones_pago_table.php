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
        Schema::create('transacciones_pago', function (Blueprint $table) {
            $table->id();
            // La transacción ahora solo se relaciona con órdenes de productos
            $table->foreignId('orden_id')->constrained('ordenes')->onDelete('cascade');
            $table->foreignId('cliente_usuario_id')->constrained('usuarios');
            
            $table->decimal('monto', 10, 2);
            $table->string('moneda', 10)->default('MXN');
            $table->string('metodo_pago', 100)->comment('Ej: paypal, mercadopago');
            $table->string('id_transaccion_pasarela')->unique()->nullable();
            $table->string('estado_pago', 50)->comment('Ej: PENDIENTE, COMPLETADO, FALLIDO, REEMBOLSADO');
            $table->dateTime('fecha_transaccion')->useCurrent();
            
            $table->json('datos_pasarela_request')->nullable();
            $table->json('datos_pasarela_response')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacciones_pago');
    }
};