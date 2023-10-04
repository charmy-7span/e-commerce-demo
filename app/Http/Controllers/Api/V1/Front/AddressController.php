<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Models\UserAddress;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Services\AddressService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Addresses\Upsert;
use App\Http\Resources\Address\Resource;
use App\Http\Resources\Address\Collection;

class AddressController extends Controller
{
    use ApiResponser;

    private $addressService;

    public function __construct()
    {
        $this->addressService = new AddressService;
    }

    public function index(Request $request)
    {
        $addresses = $this->addressService->collection($request);

        return new Collection($addresses);
    }

    public function store(Upsert $request)
    {
        $address = $this->addressService->store($request->all());

        return $this->success(new Resource($address));
    }

    public function show(UserAddress $address)
    {
        $address = $this->addressService->resource($address->id);

        return $this->success(new Resource($address));
    }

    public function update(Upsert $request, UserAddress $address)
    {
        $address = $this->addressService->edit($request->validated(), $address->id);

        return $address;
    }

    public function destroy(UserAddress $address)
    {
        $address = $this->addressService->destroy($address->id);

        return $address;
    }
}
