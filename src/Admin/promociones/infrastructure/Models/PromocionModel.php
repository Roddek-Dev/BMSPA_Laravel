<?php

namespace Src\Admin\promociones\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromocionModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'promociones';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'tipo_descuento',
        'valor_descuento',
        'fecha_inicio',
        'fecha_fin',
        'usos_maximos_total',
        'usos_maximos_por_cliente',
        'usos_actuales',
        'activo',
        'aplica_a_todos_productos',
        'aplica_a_todos_servicios',
    ];

    protected $casts = [
        'valor_descuento' => 'float',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'usos_maximos_total' => 'integer',
        'usos_maximos_por_cliente' => 'integer',
        'usos_actuales' => 'integer',
        'activo' => 'boolean',
        'aplica_a_todos_productos' => 'boolean',
        'aplica_a_todos_servicios' => 'boolean',
    ];

     /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */

    protected static function newFactory()
    {
        // Le indica a Laravel que use este Factory específico
        return \Src\Admin\promociones\infrastructure\Factories\PromocionModelFactory::new();    
    }
}