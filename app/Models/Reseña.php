<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reseña extends Model
{
    use HasFactory;

    protected $table = 'reseñas';

    protected $fillable = [
        'cliente_usuario_id',
        'calificacion',
        'comentario',
        'reseñable_id',
        'reseñable_type',
        'aprobada',
        'fecha_reseña',
    ];

    protected $casts = [
        'calificacion' => 'integer',
        'aprobada' => 'boolean',
        'fecha_reseña' => 'datetime',
    ];

    public function cliente()
    {
        return $this->belongsTo(Usuario::class, 'cliente_usuario_id');
    }

    public function reseñable()
    {
        return $this->morphTo();
    }
}