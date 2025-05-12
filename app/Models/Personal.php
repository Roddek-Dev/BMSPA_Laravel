<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'personal';

    protected $fillable = [
        'usuario_id',
        'sucursal_asignada_id',
        'tipo_personal',
        'numero_empleado',
        'fecha_contratacion',
        'activo_en_empresa',
    ];

    protected $casts = [
        'fecha_contratacion' => 'date',
        'activo_en_empresa' => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function sucursalAsignada()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_asignada_id');
    }

    public function agendamientos()
    {
        return $this->hasMany(Agendamiento::class);
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'servicio_personal');
    }

    public function reseñas()
    {
        return $this->morphMany(Reseña::class, 'reseñable');
    }
}