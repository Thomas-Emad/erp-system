<?php

namespace App\Http\Resources\Installment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstallmentSupplierResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    $this->resource->load('materials', 'supplier', 'payments');

    return [
      'installment' => [
        'start_installment'   => $this->start,
        'end_installment'     => $this->end,
        'total_installment'   => $this->total_installment,
        'installment_amount'  => $this->installment_amount,
        'type_of_duration'    => $this->duration,
        'count_installment'   => ceil($this->total_installment / $this->installment_amount),
        'paid_installment'    => $this->payments()->where('status', 'paid')->sum('amount'),
        'unpaid_installment'  => $this->payments()->where('status', 'unpaid')->sum('amount') - $this->credit_balance,
        'next_payment'        => $this->payments()->where('status', 'unpaid')->get()->first()->date ?? '~~',
        'status'              => $this->status,
        'credit_balance'      => $this->credit_balance,
      ],
      'materials' => InstallmentProductResource::collection($this->materials),
      'payments' => InstallmentPaymentResource::collection($this->payments),
      'supplier' => new \App\Http\Resources\ClientResource($this->supplier),
    ];
  }
}
