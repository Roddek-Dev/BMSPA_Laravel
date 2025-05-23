<?php

declare(strict_types=1);

namespace Src\Client\usuarios\infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Importar la clase base Authenticatable
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
// Asegúrate que tu clase herede de Authenticatable e implemente JWTSubject si es necesario
class UsuarioModel extends Authenticatable implements JWTSubject
{
    use HasFactory; // Puedes mantener esto si usas factories con este modelo

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'telefono',
        'rol',
        'activo',
        'imagen_path',
        'musica_preferencia_navegacion_id',
        'sucursal_preferida_id'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'musica_preferencia_navegacion_id' => 'integer',
        'sucursal_preferida_id' => 'integer'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Devuelve la clave primaria del modelo
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return []; // Puedes añadir claims personalizados aquí si los necesitas
    }
}