<?php

namespace App\Http\Requests\API\Admin\Admins;

use Illuminate\Foundation\Http\FormRequest;

class FindAdminRequest extends FormRequest
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
