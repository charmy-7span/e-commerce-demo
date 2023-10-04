<?php

namespace App\Models;

use App\Traits\ApiResponser;
use App\Traits\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory, ApiResponser, BaseModel;

    protected $fillable = [
        'user_id',
        'city_id',
        'state_id',
        'country_id',
        'pin_code',
        'address_line1',
        'address_line2'
    ];

    public $queryable = [
        'id'
    ];
}
