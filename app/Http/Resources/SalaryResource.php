<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalaryResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'user_id' => $this->user->id,
      'name' => $this->user->name,
      'email' => $this->user->email,
      'amount' => $this->amount,
      'description' => $this->description,
      'attachment' => $this->attachment,
      'date' => $this->created_at
    ];
  }
}
