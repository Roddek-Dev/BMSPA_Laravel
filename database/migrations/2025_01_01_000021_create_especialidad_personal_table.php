<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('especialidad_personal', function (Blueprint $table) {
            $table->foreignId('especialidad_id')->constrained('especialidades')->onDelete('cascade');
            $table->foreignId('personal_id')->constrained('personal')->onDelete('cascade');
            $table->timestamps();

            $table->primary(['especialidad_id', 'personal_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('especialidad_personal');
    }
};