<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\CartItem;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Services\CartItemService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartItems\Upsert;
use App\Http\Resources\CartItem\Resource;
use App\Http\Resources\CartItem\Collection;

class CartItemController extends Controller
{
    use ApiResponser;

    private $cartItemService;

    public function __construct()
    {
        $this->cartItemService = new CartItemService;
    }

    public function index(Request $request)
    {
        $cartItems = $this->cartItemService->collection($request);

        return new Collection($cartItems);
    }

    public function store(Upsert $request)
    {
        $cartItem = $this->cartItemService->store($request->all());

        return $this->success(new Resource($cartItem));
    }

    public function update(Upsert $request, CartItem $cartItem)
    {
        $cartItem = $this->cartItemService->edit($request->validated(), $cartItem->id);

        return $cartItem;
    }

    public function destroy(CartItem $cartItem)
    {
        $cartItem = $this->cartItemService->destroy($cartItem->id);

        return $cartItem;
    }
}
