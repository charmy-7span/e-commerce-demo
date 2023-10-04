<?php

namespace App\Http\Resources\State;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class Collection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public $collects = 'App\Http\Resources\State\Resource';

    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
