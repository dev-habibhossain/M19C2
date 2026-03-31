<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'sku',
        'name',
        'description',
        'price',
        'stock',
        'active',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function movements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
