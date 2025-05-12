<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EspecialidadPersonal extends Pivot
{
    use HasFactory;

    protected $table = 'especialidad_personal';

    protected $fillable = [
        'especialidad_id',
        'personal_id',
    ];

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }
}