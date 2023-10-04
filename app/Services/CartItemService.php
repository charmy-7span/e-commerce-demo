<?php

namespace App\Services;

use App\Models\CartItem;

class CartItemService
{
    private $cartItemObj;

    public function __construct()
    {
        $this->cartItemObj = new CartItem;
    }

    public function collection($inputs)
    {
        $cartItems = $this->cartItemObj->query();

        if (!empty($inputs['include'])) {
            $cartItems->with($inputs['include']);
        }

        return (isset($inputs['limit']) && $inputs['limit'] == '-1') ? $cartItems->get() : $cartItems->paginate($inputs['limit']);
    }

    public function store($inputs)
    {
        $cartItem = $this->cartItemObj->create([
            'user_id' => auth()->user()->id,
            'product_id' => $inputs['product_id'],
            'quantity' => $inputs['quantity']
        ]);

        return $cartItem;
    }

    public function resource(int $id)
    {
        $cartItem = $this->cartItemObj->findOrFail($id);

        return $cartItem;
    }

    public function edit(array $inputs, int $id)
    {
        $this->resource($id)->update([
            'user_id' => auth()->user()->id,
            'product_id' => $inputs['product_id'],
            'quantity' => $inputs['quantity']
        ]);

        $data['message'] = 'Cart Item detail updated successfully';

        return $data;
    }

    public function destroy(int $id)
    {
        $this->resource($id)->delete();

        $data['message'] = 'Cart Item deleted successfully';

        return $data;
    }
}
