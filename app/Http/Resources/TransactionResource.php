<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    $clientType = match ($this->client_type) {
      'customer' => $this->customer,
      'supplier' => $this->supplier,
      'employee' => $this->user,
      default => null,
    };

    return [
      'id' => $this->id,
      'owner' => [
        'id' => $this->user->id,
        'name' => $this->user->name
      ],
      'client' => [
        'id' => $this->client_id,
        'name' => $clientType?->name
      ],
      'client_type' => $this->client_type,
      'title' => $this->title,
      'description' => $this->description,
      'amount' => $this->amount,
      'transaction_type' => $this->transaction_type,
      'transaction_category' => $this->transaction_category,
      'attachment' => $this->attachment,
      'created_at' => $this->created_at,
    ];
  }
}
