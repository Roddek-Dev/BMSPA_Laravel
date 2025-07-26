<?php

namespace Src\Client\recordatorios\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordatorioModel extends Model
{
    use HasFactory;

    protected $table = 'recordatorios';

    protected $fillable = [
        'usuario_id',
        'agendamiento_id',
        'titulo',
        'descripcion',
        'fecha_hora_recordatorio',
        'canal_notificacion',
        'enviado',
        'fecha_envio',
        'activo',
        'fijado',
    ];

    protected $casts = [
        'enviado' => 'boolean',
        'activo' => 'boolean',
        'fijado' => 'boolean',
        'fecha_hora_recordatorio' => 'datetime',
        'fecha_envio' => 'datetime',
    ];
}