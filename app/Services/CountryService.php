<?php

namespace App\Services;

use App\Helpers\MediaUploaderHelper;
use App\Models\Country;
use App\Traits\ApiResponser;
use App\Traits\BaseModel;

class countryService
{
    use BaseModel;
    private $countryObj;
    public function __construct()
    {
        $this->countryObj = new Country;
    }

    public function collection($inputs)
    {
        $countries = $this->countryObj->query();
        // $inputs['limit'] = isset($inputs['limit']) ? $inputs['limit'] : config('site.pagination.limit');

        if (!empty($inputs['include'])) {
            $countries = $countries->with($inputs['include']);
        }

        return (isset($inputs['limit']) && $inputs['limit'] == '-1') ? $countries->get() : $countries->paginate($inputs['limit']);
   }

    public function store($inputs)
    {
        $country = $this->countryObj->create($inputs);

        return $country;
    }

    public function resource(int $id)
    {
        $country = $this->countryObj->findOrFail($id);

        return $country;
    }

    public function edit(array $inputs, int $id)
    {
        $this->resource($id)->update($inputs);

        $data['message'] = 'Country detail updated successfully';

        return $data;
    }

    public function destroy(int $id)
    {
        $this->resource($id)->delete();

        $data['message'] = 'Country deleted successfully';

        return $data;
    }
}
