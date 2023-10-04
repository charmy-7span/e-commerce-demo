<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\orderService;
use App\Http\Requests\Orders\Store;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\Update;
use App\Http\Resources\Order\Resource;
use App\Http\Resources\Order\Collection;

class OrderController extends Controller
{
    private $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService;
    }

    public function index(Request $request)
    {
        $orders = $this->orderService->collection($request);

        return new Collection($orders);
    }

    public function store(Store $request)
    {
        $order = $this->orderService->store($request->all());

        return $this->success(new Resource($order));
    }

    public function show(Order $order)
    {
        $order = $this->orderService->resource($order->id);

        return $this->success(new Resource($order));
    }

    public function update(Update $request, Order $order)
    {
        $order = $this->orderService->update($request->validated(), $order->id);

        return $order;
    }

    public function destroy(Order $order)
    {
        $order = $this->orderService->destroy($order->id);

        return $order;
    }
}
