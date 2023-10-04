<?php

namespace App\Models;

use App\Traits\ApiResponser;
use App\Traits\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;

class Product extends Model
{
    use HasFactory, ApiResponser, BaseModel, Mediable;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'quantity'
    ];

    public $queryable = [
        'id'
    ];

    protected $relationship = [
        'category' => [
            'model' => 'App\\Models\\Category'
        ]
    ];

    protected $scopedFilters = [
        'category_id', 'search'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeCategoryId($query, $id)
    {
        return  $query->whereHas('category', function ($qq) use ($id) {
            $qq->where('category_id', $id);
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('product.name', 'like', '%' . $search . '%');
    }
}
