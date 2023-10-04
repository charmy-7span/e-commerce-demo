<?php

namespace App\Services;

use App\Helpers\MediaUploaderHelper;
use App\Models\State;
use App\Traits\ApiResponser;
use App\Traits\BaseModel;
use Spatie\QueryBuilder\QueryBuilder;

class StateService
{
    use BaseModel;
    private $stateObj;
    public function __construct()
    {
        $this->stateObj =  QueryBuilder::for(State::class);
        // $this->stateObj =  new State;
    }

    public function collection($inputs)
    {
        $states = $this->stateObj;
        // $inputs['limit'] = isset($inputs['limit']) ? $inputs['limit'] : config('site.pagination.limit');

        if (!empty($inputs['include'])) {
            // $states = $states->with($inputs['include']);
            $states =  $states->allowedIncludes($inputs['include']);
        }

        return (isset($inputs['limit']) && $inputs['limit'] == '-1') ? $states->get() : $states->paginate($inputs['limit']);
    }

    public function store($inputs)
    {
        $state = $this->stateObj->create($inputs);

        return $state;
    }

    public function resource(int $id)
    {
        $state = $this->stateObj->findOrFail($id);

        return $state;
    }

    public function edit(array $inputs, int $id)
    {
        $this->resource($id)->update($inputs);

        $data['message'] = 'State detail updated successfully';

        return $data;
    }

    public function destroy(int $id)
    {
        $this->resource($id)->delete();

        $data['message'] = 'State deleted successfully';

        return $data;
    }
}
