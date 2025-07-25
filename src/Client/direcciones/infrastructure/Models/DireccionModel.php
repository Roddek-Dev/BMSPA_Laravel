<?php

namespace Src\Client\direcciones\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DireccionModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'direcciones';

    protected $fillable = [
        'direccionable_id',
        'direccionable_type',
        'direccion',
        'colonia',
        'codigo_postal',
        'ciudad',
        'estado',
        'referencias',
        'es_predeterminada',
    ];

    protected $casts = [
        'es_predeterminada' => 'boolean',
    ];

    public function direccionable()
    {
        return $this->morphTo();
    }
}