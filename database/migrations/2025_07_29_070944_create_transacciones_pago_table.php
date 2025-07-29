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
            $table->unsignedBigInteger('orden_id');
            $table->string('mercadopago_payment_id');
            $table->string('mercadopago_preference_id');
            $table->string('payment_method_id');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3);
            $table->string('status');
            $table->string('status_detail')->nullable();
            $table->timestamp('fecha_transaccion');
            $table->timestamps();

            // Índices
            $table->index('orden_id');
            $table->index('mercadopago_payment_id');
            $table->index('mercadopago_preference_id');

            // Claves foráneas
            $table->foreign('orden_id')->references('id')->on('ordenes')->onDelete('cascade');
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
