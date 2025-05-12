<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sucursal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sucursales';

    protected $fillable = [
        'nombre',
        'imagen_path',
        'direccion_calle',
        'direccion_numero_exterior',
        'direccion_numero_interior',
        'direccion_colonia',
        'direccion_codigo_postal',
        'direccion_municipio_alcaldia',
        'direccion_ciudad',
        'direccion_estado',
        'telefono_contacto',
        'email_contacto',
        'link_maps',
        'latitud',
        'longitud',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'latitud' => 'decimal:7',
        'longitud' => 'decimal:7',
    ];

    public function horarios()
    {
        return $this->hasMany(HorarioSucursal::class);
    }
}