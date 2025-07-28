<?php

namespace Src\Client\reseñas\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReseñaModel extends Model
{
    use HasFactory;

    protected $table = 'reseñas';

    // Corregido: Alineado con las columnas de tu .sql
    protected $fillable = [
        'cliente_usuario_id',
        'reseñable_type',
        'reseñable_id',
        'calificacion',
        'comentario',
        'aprobada',
        'fecha_reseña',
    ];
    
    protected $casts = [
        'aprobada' => 'boolean',
        'fecha_reseña' => 'datetime',
    ];

    /**
     * Get the parent reseñable model (servicio, sucursal, etc.).
     */
    public function reseñable()
    {
        return $this->morphTo();
    }
}