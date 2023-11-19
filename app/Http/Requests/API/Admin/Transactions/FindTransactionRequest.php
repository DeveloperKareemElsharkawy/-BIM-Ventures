<?php

namespace App\Http\Requests\API\Admin\Transactions;

use App\Enums\TransactionStatusEnum;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class FindTransactionRequest extends FormRequest
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
            'transaction_id' => $this->route('transaction_id'),
        ]);

    }
}
