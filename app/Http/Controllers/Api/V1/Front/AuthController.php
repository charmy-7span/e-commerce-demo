<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Data\UserData;
use App\Data\Auth\LoginData;
use App\Traits\ApiResponser;
use App\Data\Auth\SignUpData;
use App\Services\AuthService;
use App\Data\Auth\ResetPasswordData;
use App\Http\Controllers\Controller;
use App\Data\Auth\ForgetPasswordData;
use App\Http\Requests\Auth\ChangePassword;
use App\Http\Requests\Auth\Login;
use App\Http\Requests\Auth\SignUp;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponser;

    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function signUp(SignUp $request)
    {
        $user = $this->authService->signup($request->all());


        $data = [
            'user' => UserData::from($user),
            'token' => $user->createToken(config('app.name'))->plainTextToken,
        ];

        return $this->success($data, 200);
    }

    public function login(Login $request)
    {
        $user = $this->authService->login($request->all());

        return $this->success($user, 200);
    }

    public function forgetPassword(ForgetPasswordData $request)
    {
        $data = $this->authService->forgetPassword($request->all());

        return isset($data['errors']) ? $this->error($data) : $this->success($data, 200);
    }

    public function resetPassword(ResetPasswordData $request)
    {
        $data = $this->authService->resetPassword($request->all());

        return isset($data['errors']) ? $this->error($data) : $this->success($data, 200);
    }

    public function changePassword(ChangePassword $request)
    {
        $data = $this->authService->changePassword($request->all());

        // dd($data);
        return isset($data['errors']) ? $this->error($data) : $this->success($data, 200);
    }

    public function logout()
    {
        $data = $this->authService->logout();

        return $data;
    }
}
