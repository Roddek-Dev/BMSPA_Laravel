<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
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
        'activo' => 'boolean',
        'precio' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}