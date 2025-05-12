<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ServicioPersonal extends Pivot
{
    use HasFactory;

    protected $table = 'servicio_personal';

    protected $fillable = [
        'servicio_id',
        'personal_id',
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }
}