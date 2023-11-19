<?php

namespace App\Http\Resources\API\Admin\Transactions;

use App\Http\Resources\API\Admin\Profile\AdminProfileResource;
use App\Http\Resources\API\Customer\Profile\CustomerProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'amount' => (float)$this->amount,
            'due_date' => $this->due_date,
            'vat_percentage' => (float)$this->vat_percentage,
            'is_vat_inclusive' => (boolean)$this->is_vat_inclusive,
            'status' => $this->status,
            'payments' => PaymentsResource::collection($this->payments),
            'customer' => new CustomerProfileResource($this->customer),
            'created_by' => new AdminProfileResource($this->admin),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
