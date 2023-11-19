<?php

namespace App\Http\Requests\API\Admin\Payments;

use App\Enums\TransactionStatusEnum;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class FindPaymentRequest extends FormRequest
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
