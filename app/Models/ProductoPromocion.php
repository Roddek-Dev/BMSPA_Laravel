<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductoPromocion extends Pivot
{
    use HasFactory;

    protected $table = 'producto_promocion';

    protected $fillable = [
        'promocion_id',
        'producto_id',
    ];

    public function promocion()
    {
        return $this->belongsTo(Promocion::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}