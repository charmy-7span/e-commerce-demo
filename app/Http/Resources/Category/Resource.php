<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Product\Resource as ProductResource;
use App\Models\Product;
use App\Traits\ResourceFilterable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    use ResourceFilterable;

    protected $model = 'Category';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product' => ProductResource::collection($this->whenLoaded('products')),
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
