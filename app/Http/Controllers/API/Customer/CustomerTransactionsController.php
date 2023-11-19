<?php

namespace App\Http\Controllers\API\Customer;

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

class  CustomerTransactionsController extends BaseController
{
    /**
     * List Transactions
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $transactions = Transaction::query()->where('user_id',auth('customer')->user()->id)->paginate(10);

        return $this->respondWithPagination(TransactionsResource::collection($transactions));
    }


}
