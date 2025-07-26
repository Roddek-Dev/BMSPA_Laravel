<?php

namespace Src\Admin\personal\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonalModel extends Model
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
        'activo_en_empresa' => 'boolean',
        'fecha_contratacion' => 'date',
    ];
}