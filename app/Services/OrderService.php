<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderService
{
    private $orderObj;

    public function __construct()
    {
        $this->orderObj = new Order;
    }

    public function collection($inputs)
    {
        $orders = $this->orderObj->query();

        if (!empty($inputs['include'])) {
            $orders->with($inputs['include']);
        }

        return (isset($inputs['limit']) && $inputs['limit'] == '-1') ? $orders->get() : $orders->paginate($inputs['limit']);
    }

    public function store($inputs)
    {
        $order = $this->orderObj->create([
            'user_id' => auth()->user()->id
        ]);
        $total = 0;
        foreach ($inputs['products'] as $product) {
            $orderItem = new OrderItem();
            $products = Product::whereId($product['id'])->first();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $product['id'];
            $orderItem->quantity = $product['quantity'];
            $orderItem->price = $products->price;
            $orderItem->total = $products->price * $product['quantity'];
            $orderItem->save();

            $total += $orderItem['quantity'] * $orderItem['price'];
        }
        $order['total'] = $total;
        $order->save();

        // dd($order->orderItems);
        // $orders = $this->orderObj->query();
        // dd($order->id);
        $order =  $this->resource($order->id, $inputs);

        return $order;
    }

    public function resource(int $id, $inputs = null)
    {
        $order = $this->orderObj->query();

        if (!empty($inputs['include'])) {
            $order->with($inputs['include']);
        }

        return $order = $order->findOrFail($id);
    }

    public function update(array $inputs, int $id)
    {
        $this->resource($id)->update($inputs);

        $data['message'] = 'Order detail updated successfully';

        return $data;
    }

    public function destroy(int $id)
    {
        $this->resource($id)->delete();

        $data['message'] = 'Order deleted successfully';

        return $data;
    }
}
