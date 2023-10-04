<?php

namespace App\Models;

use App\Traits\ApiResponser;
use App\Traits\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory, ApiResponser, BaseModel;

    protected $fillable = [
        'name'
    ];

    public $queryable = [
        'id'
    ];

    public function states()
    {
        return $this->hasMany(State::class);
    }
}
