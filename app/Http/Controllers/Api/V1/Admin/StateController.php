<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\states\Store;
use App\Http\Requests\states\Upsert;
use App\Http\Resources\State\Collection;
use App\Http\Resources\State\Resource;
use App\Models\State;
use App\Services\stateService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class StateController extends Controller
{
    use ApiResponser;

    protected $stateService;

    public function __construct()
    {
        $this->stateService = new StateService;
    }

    public function index(Request $request)
    {
        $states = $this->stateService->collection($request);

        return new Collection($states);
    }

    public function store(Store $request)
    {
        $states = $this->stateService->store($request->all());

        return $this->success(new Resource($states));
    }

    public function show(State $state)
    {
        $states = $this->stateService->resource($state->id);

        return $this->success(new Resource($states));
    }

    public function update(Upsert $request, State $state)
    {
        $state = $this->stateService->edit($request->validated(), $state->id);

        return $state;
    }

    public function destroy(State $state)
    {
        $state = $this->stateService->destroy($state->id);

        return $state;
    }
}
