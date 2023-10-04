<?php

namespace App\Http\Resources\OrderItem;

use App\Http\Resources\Product\Resource as ProductResource;
use App\Models\Product;
use App\Traits\ResourceFilterable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    use ResourceFilterable;

    protected $model = 'OrderItem';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd(3);
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            //    'Order' => ProductResource::collection($this->whenLoaded('products')),
            'total' => $this->total
        ];
    }
}
