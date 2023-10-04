<?php

namespace App\Models;

use App\Traits\ApiResponser;
use App\Traits\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory, ApiResponser, BaseModel;

    protected $fillable = [
        'state_id',
        'name'
    ];

    public $queryable = [
        'id'
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
