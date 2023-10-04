<?php

namespace App\Services;

use App\Helpers\MediaUploaderHelper;
use App\Models\City;
use App\Traits\ApiResponser;
use App\Traits\BaseModel;

class CityService
{
    use BaseModel;
    private $cityObj;

    public function __construct()
    {
        $this->cityObj = new City;
    }

    public function collection($inputs)
    {
        $cities = $this->cityObj->query();

        if (!empty($inputs['include']))
        {
            $cities = $cities->with($inputs['include']);
        }

        return (isset($inputs['limit']) && $inputs['limit'] == '-1') ? $cities->get() : $cities->paginate($inputs['limit']);
   }

    public function store($inputs)
    {
        $city = $this->cityObj->create($inputs);

        return $city;
    }

    public function resource(int $id)
    {
        $city = $this->cityObj->findOrFail($id);

        return $city;
    }

    public function edit(array $inputs, int $id)
    {
        $this->resource($id)->update($inputs);

        $data['message'] = 'City detail updated successfully';

        return $data;
    }

    public function destroy(int $id)
    {
        $this->resource($id)->delete();

        $data['message'] = 'City deleted successfully';

        return $data;
    }
}
