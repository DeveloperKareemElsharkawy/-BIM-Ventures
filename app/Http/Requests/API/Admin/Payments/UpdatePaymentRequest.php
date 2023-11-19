<?php

namespace App\Http\Requests\API\Admin\Payments;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
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
            'payment_id' => 'required|exists:payments,id',
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
            'payment_id' => $this->route('payment_id'),
        ]);
    }
}
