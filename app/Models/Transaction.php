<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
  use HasFactory;

  protected $fillable = [
    'owner_id',
    'client_id',
    'client_type',
    'title',
    'description',
    'amount',
    'transaction_type',
    'transaction_category',
    'attachment',

  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
  public function customer(): BelongsTo
  {
    return $this->belongsTo(Customer::class);
  }
  public function supplier(): BelongsTo
  {
    return $this->belongsTo(Supplier::class);
  }
}
