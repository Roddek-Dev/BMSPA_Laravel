<?php

namespace Src\Catalog\productos\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ProductoModelFactory;

class ProductoModel extends Model
{
    use HasFactory;

    protected $table = 'productos';

    // --- ¡CORRECCIÓN AQUÍ! ---
    // Asegúrate de que los nombres aquí coincidan 100% con tu tabla.
    // Asumo que el campo se llama 'precio', si no, ponle el nombre correcto.
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio', // Cambiado de 'precio_unitario' a 'precio'
        'stock',
        'categoria_id',
        'proveedor',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'precio' => 'float', // Cambiado de 'precio_unitario' a 'precio'
        'stock' => 'integer',
    ];

    protected static function newFactory()
    {
        return ProductoModelFactory::new();
    }
}