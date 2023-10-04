<?php

namespace App\Services;

use App\Models\UserAddress;

class AddressService
{
    private $addressObj;

    public function __construct()
    {
        $this->addressObj = new UserAddress;
    }

    public function collection($inputs)
    {
        $addresses = $this->addressObj->query();

        if (!empty($inputs['include'])) {
            $addresses->with($inputs['include']);
        }

        return (isset($inputs['limit']) && $inputs['limit'] == '-1') ? $addresses->get() : $addresses->paginate($inputs['limit']);
    }

    public function store($inputs)
    {
        $address = $this->addressObj->create([
            'user_id' => auth()->user()->id,
            'country_id' => $inputs['country_id'],
            'state_id' => $inputs['state_id'],
            'city_id' => $inputs['city_id'],
            'pin_code' => $inputs['pin_code'],
            'address_line1' => $inputs['address_line1'],
            'address_line2' => $inputs['address_line2']
        ]);

        return $address;
    }

    public function resource(int $id)
    {
        $address = $this->addressObj->findOrFail($id);

        return $address;
    }

    public function edit(array $inputs, int $id)
    {
        $this->resource($id)->update([
            'user_id' => auth()->user()->id,
            'country_id' => $inputs['country_id'],
            'state_id' => $inputs['state_id'],
            'city_id' => $inputs['city_id'],
            'pin_code' => $inputs['pin_code'],
            'address_line1' => $inputs['address_line1'],
            'address_line2' => $inputs['address_line2']
        ]);

        $data['message'] = 'Address detail updated successfully';

        return $data;
    }

    public function destroy(int $id)
    {
        $this->resource($id)->delete();

        $data['message'] = 'Address deleted successfully';

        return $data;
    }
}
