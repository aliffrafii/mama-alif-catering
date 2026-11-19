<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $primaryKey = 'id_order_item';
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'selected_menus',
        'notes',
    ];

    protected $casts = [
        'selected_menus' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'product_id',
            'id_product'
        );
    }

    public function order()
    {
        return $this->belongsTo(
            Order::class,
            'order_id',
            'id_order'
        );
    }
}
