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
        Schema::table('sucursales', function (Blueprint $table) {
            // Agregar columnas faltantes
            $table->string('telefono_contacto')->nullable()->after('nombre');
            $table->string('email_contacto')->nullable()->after('telefono_contacto');
            $table->text('link_maps')->nullable()->after('email_contacto');
            $table->decimal('latitud', 10, 7)->nullable()->after('link_maps');
            $table->decimal('longitud', 10, 7)->nullable()->after('latitud');
            $table->boolean('activo')->default(true)->after('longitud');
            
            // Eliminar columnas obsoletas si existen
            $table->dropColumn(['direccion', 'telefono', 'activa']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sucursales', function (Blueprint $table) {
            // Revertir cambios
            $table->string('direccion')->nullable()->after('nombre');
            $table->string('telefono')->nullable()->after('direccion');
            $table->boolean('activa')->default(true)->after('telefono');
            
            // Eliminar columnas agregadas
            $table->dropColumn(['telefono_contacto', 'email_contacto', 'link_maps', 'latitud', 'longitud', 'activo']);
        });
    }
};
