<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PromocionServicio extends Pivot
{
    use HasFactory;

    protected $table = 'promocion_servicio';

    protected $fillable = [
        'promocion_id',
        'servicio_id',
    ];

    public function promocion()
    {
        return $this->belongsTo(Promocion::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}