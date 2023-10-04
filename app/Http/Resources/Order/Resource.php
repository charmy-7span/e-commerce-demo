<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\OrderItem\Resource as OrderItemResource;
use App\Http\Resources\Product\Resource as ProductResource;
use App\Models\OrderItem;
use App\Models\Product;
use App\Traits\ResourceFilterable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    use ResourceFilterable;

    protected $model = 'Order';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'status' => $this->status,
            'total' => $this->total
        ];
    }
}
