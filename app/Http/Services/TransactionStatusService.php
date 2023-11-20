<?php

namespace App\Http\Services;

use App\Enums\TransactionStatusEnum;
use App\Models\Transaction;
use App\Http\Resources\API\Admin\Transactions\TransactionsResource;
use Carbon\Carbon;

class TransactionStatusService
{
    public static function excute(Transaction $transaction): string
    {
        $payments = $transaction->payments()->pluck('amount')->toArray();

        $totalPaid = array_sum($payments);

        $dueDate = Carbon::createFromFormat('Y-m-d', $transaction->due_date);

        if ($dueDate->isPast()) {

            if ($transaction->amount > $totalPaid){
                return TransactionStatusEnum::OVERDUE;
            }else{
                return TransactionStatusEnum::PAID;
            }

        }else{
            return TransactionStatusEnum::OUTSTANDING;
        }
    }
}
