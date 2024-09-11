<?php

namespace App\Http\Resources\Installment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstallmentPaymentResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'amount' => $this->amount,
      'date' => $this->date,
      'status' => $this->status,
      'attachment' => $this->attachment
    ];
  }
}
