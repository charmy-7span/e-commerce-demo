<?php

namespace App\Models;

use App\Traits\ApiResponser;
use App\Traits\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory, ApiResponser, BaseModel;

    protected $fillable = [
        'country_id',
        'name'
    ];

    public $queryable = [
        'id'
    ];

    protected $relationship = [
        'country' => [
            'model' => 'App\\Models\\Country'
        ],
        'cities' => [
            'model' => 'App\\Models\\City'
        ]
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
