<?php

namespace Src\Admin\sucursales\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SucursalModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sucursales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'imagen_path',
        'telefono_contacto',
        'email_contacto',
        'link_maps',
        'latitud',
        'longitud',
        'activo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activo' => 'boolean',
        'latitud' => 'float',
        'longitud' => 'float',
    ];
}
