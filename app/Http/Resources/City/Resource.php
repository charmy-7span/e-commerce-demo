<?php

namespace App\Http\Resources\City;

use App\Http\Resources\Category\Resource as CategoryResource;
use App\Http\Resources\State\Resource as StateResource;
use App\Traits\ResourceFilterable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    use ResourceFilterable;

    protected $model = 'City';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'state_id' => $this->state_id,
            'state' => new StateResource($this->whenLoaded('state')),
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
