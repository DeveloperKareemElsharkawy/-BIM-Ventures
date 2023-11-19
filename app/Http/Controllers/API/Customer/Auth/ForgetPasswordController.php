<?php

namespace App\Http\Controllers\API\Customer\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Customer\Auth\SendResetCodeRequest;
use App\Models\User;
use App\Notifications\SendForgetPasswordCode;
use Illuminate\Support\Facades\DB;

class ForgetPasswordController extends BaseController
{
    public function sendResetCode(SendResetCodeRequest $request)
    {
        $user = User::query()->where($request['type'], $request['username'])->first();

        $reset_code = $this->generateResetCode();

        $passwordReset = DB::table('password_resets')
            ->updateOrInsert(
                [$request['type'] => $request['username']],
                ['code' => $reset_code, 'created_at' => now()]
            );

        if ($request['type'] == 'email') {
            $user->notify(new SendForgetPasswordCode($reset_code));
        } else {
            // TODO: Implement sending SMS via mobile provider
        }
        return $this->respondMessage('Reset Password Code has been sent successfully');
    }


    function generateResetCode()
    {
        return mt_rand(1000, 9999); // A 4-digit code for better readability and usability
    }

}
