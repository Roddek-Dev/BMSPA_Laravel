<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'imagen_path',
        'direccion',
        'telefono',
        'rol',
        'estado',
        'musica_preferencia_navegacion_id',
        'sucursal_preferida_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function musicaPreferenciaNavegacion()
    {
        return $this->belongsTo(MusicaPreferenciaNavegacion::class);
    }

    public function sucursalPreferida()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_preferida_id');
    }

    public function ordenes()
    {
        return $this->hasMany(Orden::class, 'cliente_usuario_id');
    }
}