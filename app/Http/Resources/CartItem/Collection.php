<?php

namespace App\Http\Resources\CartItem;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class Collection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */

    public $collects = 'App\Http\Resources\CartItem\Resource';

    public function toArray($request)
{
        return $this->collection;
    }
}
