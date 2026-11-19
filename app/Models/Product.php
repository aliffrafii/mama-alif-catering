<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id_product';
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'menu_options',
        'is_active',
    ];
    protected $casts = [
        'menu_options' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'category_id',
            'id_categories'
        );
    }
    public function orderItems()
    {
        return $this->hasMany(
            OrderItem::class,
            'product_id',
            'id_product'
        );
    }
}
