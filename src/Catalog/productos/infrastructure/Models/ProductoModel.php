<?php

namespace Src\Catalog\productos\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductoModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen_path',
        'precio',
        'stock',
        'sku',
        'categoria_id',
        'activo',
    ];

    protected $casts = [
        'precio' => 'float',
        'stock' => 'integer',
        'activo' => 'boolean',
        'categoria_id' => 'integer'
    ];
}