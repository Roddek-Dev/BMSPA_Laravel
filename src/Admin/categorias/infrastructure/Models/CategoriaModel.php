<?php

namespace Src\Admin\categorias\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaModel extends Model
{
    use HasFactory;

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
}