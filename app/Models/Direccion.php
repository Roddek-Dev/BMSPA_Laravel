<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Direccion extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'direccionable_id',
        'direccionable_type',
        'direccion',
        'indicaciones',
        'colonia',
        'codigo_postal',
        'ciudad',
        'estado',
        'referencias',
        'es_predeterminada',
    ];

    /**
     * Obtiene el modelo padre al que pertenece esta dirección (puede ser una Sucursal, Orden, etc.).
     */
    public function direccionable()
    {
        return $this->morphTo();
    }
}