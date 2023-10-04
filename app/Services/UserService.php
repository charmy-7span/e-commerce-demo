<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    private $userObj;

    public function __construct()
    {
        $this->userObj = new User;
    }

    public function collection($inputs)
    {
        $users = $this->userObj->query();

        if (!empty($inputs['include']))
        {
            $users->with($inputs['include']);
        }

        return (isset($inputs['limit']) && $inputs['limit'] == '-1') ? $users->get() : $users->paginate($inputs['limit']);
    }

    public function resource($id, $inputs = null)
    {
        $user = $this->userObj->findOrFail($id);

        return $user;
    }

    public function update(array $inputs, int $id)
    {
        $this->resource($id)->update($inputs);

        $data['message'] = "User Profile Updated Successfully";

        return $data;
    }

    public function destroy(int $id)
    {
        $this->resource($id)->delete();

        $data['message'] = 'User deleted successfully';

        return $data;
    }
}
