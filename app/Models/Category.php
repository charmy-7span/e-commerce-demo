<?php

namespace App\Models;

use App\Traits\ApiResponser;
use App\Traits\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Plank\Mediable\Mediable;

class Category extends Model
{
    use HasFactory, ApiResponser, BaseModel, Mediable;

    protected $fillable = [
        'name',
        'description'
    ];

    public $queryable = [
        'id'
    ];

    protected $relationship = [
        'products' => [
            'model' => 'App\\Models\\Product'
        ]
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
