<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\City;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Services\cityService;
use App\Http\Controllers\Controller;
use App\Http\Requests\cities\Upsert;
use App\Http\Resources\city\Resource;
use App\Http\Resources\city\Collection;

class CityController extends Controller
{
    use ApiResponser;

    protected $cityService;

    public function __construct()
    {
        $this->cityService = new CityService;
    }

    public function index(Request $request)
    {
        $cities = $this->cityService->collection($request);

        return new Collection($cities);
    }

    public function store(Upsert $request)
    {
        $city = $this->cityService->store($request->all());

        return $this->success(new Resource($city));
    }

    public function show(City $city)
    {
        $city = $this->cityService->resource($city->id);

        return $this->success(new Resource($city));
    }

    public function update(Upsert $request, City $city)
    {
        $city = $this->cityService->edit($request->validated(), $city->id);

        return $city;
    }

    public function destroy(City $city)
    {
        $city = $this->cityService->destroy($city->id);

        return $city;
    }
}
