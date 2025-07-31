<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicio_personal', function (Blueprint $table) {
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade');
            $table->foreignId('personal_id')->constrained('personal')->onDelete('cascade');
            $table->timestamps();

            $table->primary(['servicio_id', 'personal_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servicio_personal');
    }
};