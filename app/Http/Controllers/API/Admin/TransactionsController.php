<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Admin\Transactions\FindTransactionRequest;
use App\Http\Requests\API\Admin\Transactions\StoreTransactionRequest;
use App\Http\Requests\API\Admin\Transactions\UpdateTransactionRequest;
use App\Http\Resources\API\Admin\Transactions\TransactionsResource;
use App\Http\Resources\API\Customer\Profile\CustomerProfileResource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class  TransactionsController extends BaseController
{
    /**
     * List Transactions
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $transactions = Transaction::query()->paginate(10);

        return $this->respondWithPagination(TransactionsResource::collection($transactions));
    }

    /**
     * Return User List
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function usersList(Request $request)
    {
        $users = User::query()->paginate(10);

        return $this->respondWithPagination(CustomerProfileResource::collection($users));
    }

    /**
     * @param FindTransactionRequest $request
     * @param $transactionId
     * @return JsonResponse
     */
    public function show(FindTransactionRequest $request, $transactionId)
    {
        $transaction = Transaction::query()->find($transactionId);

        return $this->respondData(new TransactionsResource($transaction));
    }

    /**
     * @param StoreTransactionRequest $request
     * @return JsonResponse
     */
    public function store(StoreTransactionRequest $request)
    {
        $transaction = Transaction::query()->create($request->validated());

        return $this->respondData(new TransactionsResource($transaction), 'created successfully');
    }


    /**
     * @param UpdateTransactionRequest $request
     * @param int $transactionId
     * @return JsonResponse
     */
    public function update(UpdateTransactionRequest $request, int $transactionId)
    {
        $transaction = Transaction::query()->where('id', $transactionId)->first();

        $transaction->update($request->validated());

        return $this->respondData(new TransactionsResource($transaction), 'Updated successfully');
    }


    /**
     * @param FindTransactionRequest $request
     * @param int $transactionId
     * @return JsonResponse
     */
    public function destroy(FindTransactionRequest $request, int $transactionId)
    {
        $transaction = Transaction::query()->where('id', $transactionId)->first();

        $transaction->delete();

        return $this->respondData(new TransactionsResource($transaction), 'Deleted successfully');
    }


    public function report(Request $request)
    {
        $transactions = Transaction::query()
            ->select(DB::raw('YEAR(transactions.due_date) as year, MONTH(transactions.due_date) as month'))
            ->selectRaw('SUM(CASE WHEN payments.id IS NOT NULL THEN payments.amount ELSE 0 END) as paid_amount')
            ->selectRaw('SUM(CASE WHEN payments.id IS NULL AND transactions.due_date >= CURDATE() THEN transactions.amount ELSE 0 END) as outstanding_amount')
            ->selectRaw('SUM(CASE WHEN payments.id IS NULL AND transactions.due_date < CURDATE() THEN transactions.amount ELSE 0 END) as overdue_amount')
            ->leftJoin('payments', 'transactions.id', '=', 'payments.transaction_id')
            ->when($request->has('start_date') && $request->has('end_date'), function ($query) use ($request) {
                return $query->whereBetween('transactions.due_date', [$request->input('start_date'), $request->input('end_date')]);
            })
            ->groupBy(DB::raw('YEAR(transactions.due_date), MONTH(transactions.due_date)'))->get();

        return $this->respondData($transactions, 'Report Generated successfully');
    }
}
