<?php

// Esta es la ruta correcta que nos dio el error.
namespace Src\Catalog\servicios\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// ¡Importante! Importa el Factory que vamos a crear.
use Database\Factories\ServicioModelFactory;

class ServicioModel extends Model
{
    use HasFactory;

    protected $table = 'servicios';

    // Asegúrate de que los campos coincidan con tu tabla
    protected $fillable = [
        'nombre',
        'descripcion',
        'duracion_estimada',
        'precio',
        'categoria_id',
        'activo',
    ];

    /**
     * Le dice a Laravel qué Factory usar.
     */
    protected static function newFactory()
    {
        return ServicioModelFactory::new();
    }
}