<?php

namespace App\Services;

use App\Http\Resources\User\Resource;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Support\Arr;
use App\Jobs\ForgetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthService
{
    private $userObj;

    private $userOtpObj;

    private $userOtpService;

    public function __construct(User $userObj)
    {
        $this->userObj = $userObj;
        $this->userOtpObj = new UserOtp();
        $this->userOtpService = new UserOtpService($this->userOtpObj);
    }

    public function signup($inputs)
    {
        $user = $this->userObj->create(Arr::only($inputs, ['first_name', 'last_name', 'email', 'mobile_number', 'password']));

        $user->assignRole('customer');

        return $user;
    }

    public function login($inputs)
    {
        $user = $this->userObj->whereEmail($inputs['email'])->first();

        if ($user == null) {
            $data['errors']['user'][] = 'User not found!';
            return $data;
        }

        if (!Hash::check($inputs['password'], $user->password)) {
            $data['errors']['user'] = 'Please enter correct password!';
            return $data;
        }

        return $this->generateToken($user);
    }

    public function generateToken($user)
    {
        $data = [
            'user' => ($user),
            'token' => $user->createToken(config('app.name'))->plainTextToken,
        ];

        return $data;
    }

    public function forgetPassword($inputs)
    {
        $user = $this->userObj->where('email', $inputs['email'])->first();
        if ($user == null) {
            $data['errors']['email'][] = __('message.emailNotExist');

            return $data;
        }
        $this->userOtpObj->where('user_id', $user['id'])->where('otp_for', 'forget_password')->delete();

        $otp = mt_rand(1000, 9999);
        $this->userOtpService->store(['otp' => $otp, 'user_id' => $user->id, 'otp_for' => 'forget_password']);

        ForgetPasswordMail::dispatch($user, $otp);
        $data['message'] = __('message.forgetPasswordEmailSuccess');

        return $data;
    }

    public function resetPassword($inputs)
    {
        $user = $this->userObj->where('email', $inputs['email'])->first();
        if ($user == null) {
            $data['errors']['email'][] = __('message.emailNotExist');

            return $data;
        }

        $userOtp = $this->userOtpObj->where('user_id', $user['id'])->where('otp', $inputs['otp'])->where('otp_for', 'forget_password')->first();
        if ($userOtp == null) {
            $data['errors']['otp'][] = __('message.invalidOtp');

            return $data;
        }
        $expirationTime = config('site.otpExpirationTimeInMinutes');
        $expirationDate = Carbon::parse($userOtp['created_at'])->addMinutes($expirationTime)->format('Y-m-d H:i:s');

        if ($userOtp['used_at'] != null || date('Y-m-d h:i:s') > $expirationDate) {
            $data['errors']['otp'][] = __('message.invalidOtp');

            return $data;
        }
        $this->userOtpService->update($userOtp['id'], ['used_at' => date('Y-m-d h:i:s')]);
        $user->password = $inputs['password'];
        $user->save();
        $data['message'] = __('message.passwordChangeSuccess');

        return $data;
    }

    public function logout()
    {
        $user = $this->userObj->whereId(Auth::id());

        if (empty($user)) {
            $data['error']['user'] = "Something went wrong";
        }
        Auth::user()->tokens()->delete();

        $data['message'] = "Logout Successfully";
        return $data;
    }

    public function changePassword($request)
    {
        $user = Auth::user();

        // dd( $user->password);
        if (!Hash::check($request['old_password'], $user['password'])) {
            $data['message'] = "Incorrect old password";

            return $data;
        }

        $user->password = Hash::make($request['new_password']);

        $user->save();

        return $user;
    }
}
