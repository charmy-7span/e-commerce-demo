<?php

namespace App\Models;

use App\Traits\ApiResponser;
use App\Traits\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, ApiResponser, BaseModel;

    protected $fillable = [
        'user_id',
        'status',
        'total'
    ];

    public $queryable = [
        'id'
    ];

    protected $relationship = [
        'orderItems' => [
            'model' => 'App\\Models\\OrderItem'
        ]
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
