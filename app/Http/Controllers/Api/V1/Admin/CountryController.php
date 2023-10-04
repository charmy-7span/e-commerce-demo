<?php

namespace App\Http\Controllers\Api\V1\Admin;


use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Services\CountryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\countries\Store;
use App\Http\Requests\countries\Upsert;
use App\Http\Resources\Country\Resource;
use App\Http\Resources\Country\Collection;
use App\Models\Country;

class CountryController extends Controller
{
    use ApiResponser;

    protected $countryService;

    public function __construct()
    {
        $this->countryService = new CountryService;
    }

    public function index(Request $request)
    {
        $countries = $this->countryService->collection($request);

        return new Collection($countries);
    }

    public function store(Store $request)
    {
        $country = $this->countryService->store($request->all());

        return $this->success(new Resource($country));
    }

    public function show(Country $country)
    {
        $country = $this->countryService->resource($country->id);

        return $this->success(new Resource($country));
    }

    public function update(Upsert $request, Country $country)
    {
        $country = $this->countryService->edit($request->validated(), $country->id);

        return $country;
    }

    public function destroy(Country $country)
    {
        $country = $this->countryService->destroy($country->id);

        return $country;
    }
}
