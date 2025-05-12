<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'servicios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen_path',
        'precio_base',
        'duracion_minutos',
        'categoria_id',
        'especialidad_requerida_id',
        'activo',
    ];

    protected $casts = [
        'precio_base' => 'decimal:2',
        'duracion_minutos' => 'integer',
        'activo' => 'boolean',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function especialidadRequerida()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_requerida_id');
    }

    public function agendamientos()
    {
        return $this->hasMany(Agendamiento::class);
    }

    public function personal()
    {
        return $this->belongsToMany(Personal::class, 'servicio_personal');
    }

     public function promociones()
    {
        return $this->belongsToMany(Promocion::class, 'promocion_servicio');
    }

    public function reseñas()
    {
        return $this->morphMany(Reseña::class, 'reseñable');
    }
}