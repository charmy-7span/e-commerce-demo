<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Data\Auth\ForgetPasswordData;
use App\Data\Auth\ResetPasswordData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login;
use App\Http\Requests\Auth\SignUp;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Login $request)
    {
        $data = $this->authService->login($request->all());

        return $data;
    }

    public function logout()
    {
        $data = $this->authService->logout();

        return $data;
    }
}
