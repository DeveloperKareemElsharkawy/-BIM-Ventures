<?php

namespace App\Http\Controllers\API\Customer\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Customer\Auth\ResetPasswordRequest;
use App\Http\Resources\API\Customer\Profile\CustomerProfileResource;
use App\Models\User;

class ResetPasswordController extends BaseController
{
    public function setNewPassword(ResetPasswordRequest $request)
    {
        $user = User::query()->where($request['type'], $request['username'])->first();

        if (!$user) {
            return $this->respondError("user not found");
        }

        $user->update(['password' => $request['password']]);

        \DB::table('password_resets')->where('email', $user->email)->delete();

        return $this->respondData([
            'user' => new CustomerProfileResource($user),
            'token' =>  $user->createToken(config('app.name'))->plainTextToken
        ], 'password has been reset successful');
    }
}
