<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
