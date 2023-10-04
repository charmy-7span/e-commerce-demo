<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\wishListItem;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\WishListItemService;
use App\Http\Requests\WishListItems\Upsert;
use App\Http\Resources\WishListItem\Collection;
use App\Http\Resources\WishListItem\Resource;

class WishListItemController extends Controller
{
    use ApiResponser;

    private $wishListItemService;

    public function __construct()
    {
        $this->wishListItemService = new WishListItemService;
    }

    public function index(Request $request)
    {
        $wishListItems = $this->wishListItemService->collection($request);

        return new Collection($wishListItems);
    }

    public function store(Upsert $request)
    {
        $wishListItem = $this->wishListItemService->store($request->all());

        return $this->success(new Resource($wishListItem));
    }

    public function update(Upsert $request, wishListItem $wishListItem)
    {
        $wishListItem = $this->wishListItemService->edit($request->validated(), $wishListItem->id);

        return $wishListItem;
    }

    public function destroy(wishListItem $wishListItem)
    {
        $wishListItem = $this->wishListItemService->destroy($wishListItem->id);

        return $wishListItem;
    }
}
