<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Admin\Payments\FindPaymentRequest;
use App\Http\Requests\API\Admin\Payments\StorePaymentRequest;
use App\Http\Requests\API\Admin\Payments\UpdatePaymentRequest;
use App\Http\Resources\API\Admin\Transactions\PaymentsResource;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;

class  PaymentsController extends BaseController
{
    /**
     * List Payments
     *
     * @return JsonResponse
     */
    public function index($transactionId)
    {
        $payments = Payment::query()->where('transaction_id', $transactionId)->paginate(10);

        return $this->respondWithPagination(PaymentsResource::collection($payments));
    }

    /**
     * @param FindPaymentRequest $request
     * @param $paymentId
     * @return JsonResponse
     */
    public function show(FindPaymentRequest $request, $paymentId)
    {
        $payment = Payment::query()->find($paymentId);

        return $this->respondData(new PaymentsResource($payment));
    }

    /**
     * @param StorePaymentRequest $request
     * @return JsonResponse
     */
    public function store(StorePaymentRequest $request)
    {
        $payment = Payment::query()->create($request->validated());

        return $this->respondData(new PaymentsResource($payment), 'created successfully');
    }


    /**
     * @param UpdatePaymentRequest $request
     * @param int $paymentId
     * @return JsonResponse
     */
    public function update(UpdatePaymentRequest $request, int $paymentId)
    {
        $payment = Payment::query()->where('id', $paymentId)->first();

        $payment->update($request->validated());

        return $this->respondData(new PaymentsResource($payment), 'updated successfully');
    }


    /**
     * @param FindPaymentRequest $request
     * @param int $paymentId
     * @return JsonResponse
     */
    public function destroy(FindPaymentRequest $request, int $paymentId)
    {
        $payment = Payment::query()->where('id', $paymentId)->first();

        $payment->delete();

        return $this->respondData(new PaymentsResource($payment), 'Deleted successfully');
    }
}
