<?php

namespace App\Http\Requests\API\Customer\User;

use App\Rules\API\User\OldPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => ['required','min:6',new OldPassword()],
            'password' => 'required|confirmed|min:6',
        ];
    }
}
