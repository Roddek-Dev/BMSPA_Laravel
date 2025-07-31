<?php

declare(strict_types=1);

namespace Src\Client\usuarios\infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
// ¡IMPORTANTE! Importa el Factory que corresponde a este modelo.
use Database\Factories\UsuarioModelFactory;

class UsuarioModel extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    // ... (tus fillable, hidden, casts se quedan igual)
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'telefono',
        'rol',
        'activo',
        'imagen_path',
    ];

    protected $hidden = [
        'password',
    ];
 
    protected $casts = [
        'activo' => 'boolean',
        'email_verified_at' => 'datetime',
    ];
    
    // ... (tus métodos JWT se quedan igual)
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email' => $this->email,
            'nombre' => $this->nombre,
            'rol' => $this->rol
        ];
    }

    /**
     * Create a new factory instance for the model.
     * Esto le dice a Laravel qué Factory usar para este modelo.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return UsuarioModelFactory::new();
    }
}