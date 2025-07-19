<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sucursal extends Model
{
    use HasFactory, SoftDeletes;

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
     * Obtiene todas las direcciones asociadas a esta sucursal.
     */
    public function direcciones()
    {
        return $this->morphMany(Direccion::class, 'direccionable');
    }
}