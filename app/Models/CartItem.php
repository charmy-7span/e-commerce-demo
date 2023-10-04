<?php

namespace App\Models;

use App\Traits\ApiResponser;
use App\Traits\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory, ApiResponser, BaseModel;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total'
    ];

    public $queryable = [
        'id'
    ];
}
