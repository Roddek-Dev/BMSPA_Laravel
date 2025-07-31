<?php

namespace Src\Admin\categorias\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// ¡IMPORTANTE! Importa el Factory que creaste en el paso anterior.
use Database\Factories\CategoriaModelFactory;

class CategoriaModel extends Model
{
    use HasFactory;

    // ... (tu código fillable y casts se queda igual) ...
    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo_categoria',
        'icono_clave',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Create a new factory instance for the model.
     * Esto le dice a Laravel qué Factory usar.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CategoriaModelFactory::new();
    }
}