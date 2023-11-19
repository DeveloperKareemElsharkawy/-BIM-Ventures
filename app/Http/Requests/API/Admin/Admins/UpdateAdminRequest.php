<?php

namespace App\Http\Requests\API\Admin\Admins;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
            'admin_id' => 'required|exists:admins,id',
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20|unique:admins,mobile,' . $this->input('admin_id'),
            'email' => 'required|string|email|max:255|unique:admins,email,' . $this->input('admin_id'),
            'password' => 'required|string|min:8',
        ];
    }


    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'admin_id' => $this->route('admin_id'),
        ]);
    }
}
