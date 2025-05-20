<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('musica_preferencias_navegacion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_opcion', 100)->unique();
            $table->text('descripcion')->nullable();
            $table->string('stream_url_ejemplo', 512)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('musica_preferencias_navegacion');
    }
};