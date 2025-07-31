<?php

namespace Src\Admin\personal\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// ¡Importante! Importa el Factory.
use Database\Factories\PersonalModelFactory;

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

    /**
     * Le dice a Laravel qué Factory usar para este modelo.
     */
    protected static function newFactory()
    {
        return PersonalModelFactory::new();
    }
}