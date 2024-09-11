<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InstallmentProduct extends Model
{
  use HasFactory;

  protected $fillable = [
    "installment_id",
    "product_id",
    "price",
    "quantity"
  ];

  public function material(): HasOne
  {
    return $this->hasOne(RawMaterial::class, "id", "product_id");
  }
  public function product(): HasOne
  {
    return $this->hasOne(Product::class, "id", "product_id");
  }
}
