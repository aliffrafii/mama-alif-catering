<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $primaryKey = 'id_cart';
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'selected_menus',
    ];

    protected $casts = [
        // Cast ini yang bikin selected_menus otomatis JSON↔array
        // Jangan pernah json_encode() manual sebelum assign ke model ini
        'selected_menus' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id_user'
        );
    }

    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'product_id',
            'id_product'
        );
    }
}
