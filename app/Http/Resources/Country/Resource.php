<?php

namespace App\Http\Resources\Country;

use App\Http\Resources\State\Resource as StateResource;
use App\Models\State;
use App\Traits\ResourceFilterable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    use ResourceFilterable;

    protected $model = 'Country';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'state' => StateResource::collection($this->whenLoaded('states')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
