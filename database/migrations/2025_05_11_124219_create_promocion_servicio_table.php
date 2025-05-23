<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promocion_servicio', function (Blueprint $table) {
            $table->foreignId('promocion_id')->constrained('promociones')->onDelete('cascade');
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade');
            $table->timestamps();

            $table->primary(['promocion_id', 'servicio_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promocion_servicio');
    }
};