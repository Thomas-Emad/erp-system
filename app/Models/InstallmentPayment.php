<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstallmentPayment extends Model
{
  use HasFactory;

  protected $fillable = [
    "installment_id",
    "amount",
    "attachment",
    'status',
    'date',
    'type',
  ];

  public function installment(): BelongsTo
  {
    return $this->belongsTo(Installment::class);
  }
}
