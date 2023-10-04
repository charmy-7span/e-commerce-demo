<?php

namespace App\Http\Resources\State;

use App\Http\Resources\Category\Resource as CategoryResource;
use App\Http\Resources\City\Resource as CityResource;
use App\Http\Resources\Country\Resource as CountryResource;
use App\Traits\ResourceFilterable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    use ResourceFilterable;

    protected $model = 'State';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'country_id' => $this->country_id,
            'country' => new CountryResource($this->whenLoaded('country')),
            'city' => CityResource::collection($this->whenLoaded('cities')),
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
