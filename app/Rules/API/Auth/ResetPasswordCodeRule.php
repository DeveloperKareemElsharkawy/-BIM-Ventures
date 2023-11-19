<?php

namespace App\Rules\API\Auth;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class ResetPasswordCodeRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($type, $username)
    {
        $this->type = $type;
        $this->username = $username;
    }


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $user = User::query()->where($this->type, request()['username'])->first();

        if (!$user) {
            return false;
        }
        return \DB::table('password_resets')->where('email', $user->email)->value('code') == $value;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('message.auth.forget_password.wrong_code');
    }
}
