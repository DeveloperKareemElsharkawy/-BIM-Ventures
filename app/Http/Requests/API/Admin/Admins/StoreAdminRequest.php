<?php

namespace App\Http\Requests\API\Admin\Admins;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20|unique:admins,mobile',
            'email' => 'required|string|email|max:255|unique:admins,email',
            'password' => 'required|string|min:8',
        ];
    }
}
