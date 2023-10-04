<?php

namespace App\Models;

use App\Traits\ApiResponser;
use App\Traits\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory, ApiResponser, BaseModel;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'total'
    ];

    public $queryable = [
        'id'
    ];

    protected $relationship = [
        'product' => [
            'model' => 'App\\Models\\Product'
        ],
        'order' => [
            'model' => 'App\\Models\\Order'
        ]
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
