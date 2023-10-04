<?php

namespace App\Services;

use App\Models\wishListItem;

class WishListItemService
{
    private $wishListItemObj;

    public function __construct()
    {
        $this->wishListItemObj = new WishlistItem;
    }

    public function collection($inputs)
    {
        $wishListItems = $this->wishListItemObj->query();

        if (!empty($inputs['include'])) {
            $wishListItems->with($inputs['include']);
        }

        return (isset($inputs['limit']) && $inputs['limit'] == '-1') ? $wishListItems->get() : $wishListItems->paginate($inputs['limit']);
    }

    public function store($inputs)
    {
        $wishListItem = $this->wishListItemObj->create([
            'user_id' => auth()->user()->id,
            'product_id' => $inputs['product_id'],
        ]);

        return $wishListItem;
    }

    public function resource(int $id)
    {
        $wishListItem = $this->wishListItemObj->findOrFail($id);

        return $wishListItem;
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
