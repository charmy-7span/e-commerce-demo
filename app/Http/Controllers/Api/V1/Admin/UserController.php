<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Update;
use App\Http\Resources\User\Collection;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService;
    }

    public function index(Request $request)
    {
        $user = $this->userService->collection($request);

        return new Collection($user);
    }

    public function update(Update $request, User $user)
    {
        $user = $this->userService->update($request->validated(), $user->id);

        return $user;
    }

    public function destroy(User $user)
    {
        $user = $this->userService->destroy($user->id);

        return $user;
    }
}
