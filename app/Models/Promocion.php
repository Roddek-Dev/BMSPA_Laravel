<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promocion extends Model
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
        'valor_descuento' => 'decimal:2',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'activo' => 'boolean',
        'aplica_a_todos_productos' => 'boolean',
        'aplica_a_todos_servicios' => 'boolean',
    ];

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'promocion_servicio');
    }
}