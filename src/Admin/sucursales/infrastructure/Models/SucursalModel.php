<?php

// OJO: Asumo que este es el namespace. ¡Cámbialo si es diferente!
namespace Src\Admin\sucursales\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// ¡Importante! Importa el Factory que acabamos de crear.
use Database\Factories\SucursalModelFactory;

class SucursalModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sucursales';

    // Asegúrate de que estos campos coincidan con tu tabla
    protected $fillable = [
        'nombre',
        'telefono_contacto',
        'email_contacto',
        'link_maps',
        'latitud',
        'longitud',
    ];

    protected $casts = [
        'latitud' => 'decimal:7',
        'longitud' => 'decimal:7',
    ];

    /**
     * Le dice a Laravel qué Factory usar para este modelo.
     */
    protected static function newFactory()
    {
        return SucursalModelFactory::new();
    }
}