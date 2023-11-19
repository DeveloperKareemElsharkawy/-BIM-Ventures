<?php

namespace App\Http\Requests\API\Admin\Payments;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            'transaction_id' => 'required|exists:transactions,id',
            'created_by' => 'required|exists:admins,id',
            'amount' => 'required|numeric|min:0',
            'paid_date' => 'required|date',
            'details' => 'nullable|string|max:255',
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
            'created_by' => auth('admin')->user()->id,
        ]);

    }
}
