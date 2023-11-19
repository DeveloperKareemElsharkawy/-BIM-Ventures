<?php

namespace App\Http\Requests\API\Admin\Transactions;

use App\Enums\TransactionStatusEnum;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'created_by' => 'required|exists:admins,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'vat_percentage' => 'required|numeric|min:0|max:100',
            'is_vat_inclusive' => 'required|boolean',
            'status' => 'required|in:' . implode(',', [
                    TransactionStatusEnum::PAID,
                    TransactionStatusEnum::OUTSTANDING,
                    TransactionStatusEnum::OVERDUE,
                ]),
        ];
    }

    public function TransactionStatus(): string
    {
        $dueDate = Carbon::createFromFormat('Y-m-d', $this->input('due_date'));
        if ($dueDate->isPast()) {
            return TransactionStatusEnum::OVERDUE;
        } else {
            return TransactionStatusEnum::OUTSTANDING;
        }
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
            'status' => $this->TransactionStatus()
        ]);

    }
}
