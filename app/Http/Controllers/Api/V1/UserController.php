<?php

namespace App\Http\Controllers\Api\V1;

use App\Data\UserData;
use App\Traits\ApiResponser;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Update;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiResponser;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function me()
    {
        $user = $this->userService->resource(Auth::id());

        return $this->resource($user);
    }

    public function update(Update $request)
    {
        $user = $this->userService->update($request->validated(), auth()->user()->id);

        return $user;
    }
}
