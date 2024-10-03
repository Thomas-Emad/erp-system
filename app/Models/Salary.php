<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salary extends Model
{
  use HasFactory;

  protected $fillable = [
    'owner_id',
    'employee_id',
    'amount',
    'attachment',
    'description',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'employee_id', 'id');
  }
}
