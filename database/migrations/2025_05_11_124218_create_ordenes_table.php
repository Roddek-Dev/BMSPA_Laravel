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
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_usuario_id')->constrained('usuarios')->onDelete('restrict');
            $table->string('numero_orden', 50)->unique();
            $table->dateTime('fecha_orden')->useCurrent();
            $table->dateTime('fecha_recibida')->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('descuento_total', 10, 2)->default(0.00);
            $table->decimal('impuestos_total', 10, 2)->default(0.00);
            $table->decimal('total_orden', 10, 2);
            $table->string('estado_orden', 50)->default('PENDIENTE_PAGO')->comment('Ej: PENDIENTE_PAGO, PAGADA, EN_PROCESO, ENVIADA, ENTREGADA, CANCELADA');
            $table->text('notas_orden')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};