<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recordatorio extends Model
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
        'fecha_hora_recordatorio' => 'datetime',
        'enviado' => 'boolean',
        'fecha_envio' => 'datetime',
        'activo' => 'boolean',
        'fijado' => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function agendamiento()
    {
        return $this->belongsTo(Agendamiento::class);
    }
}