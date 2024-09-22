<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Installment extends Model
{
  use HasFactory;

  protected $fillable = [
    "client_id",
    "total_installment",
    'shipping_price',
    'installment_amount',
    "duration",
    "start",
    "end",
    "attachment",
    "credit_balance",
    "status",
    'type',
  ];

  public function materials(): BelongsToMany
  {
    return $this->belongsToMany(RawMaterial::class, "installment_products", "installment_id", "product_id")->select(['raw_materials.id', 'raw_materials.name', 'raw_materials.price_installment', 'raw_materials.quantity as quantityProduct', 'installment_products.quantity as quantityInstallment']);
  }
  public function products()
  {
    return $this->belongsToMany(Product::class, "installment_products", "installment_id", "product_id")->select(['products.id', 'products.name', 'products.price_installment', 'products.quantity as quantityProduct', 'installment_products.quantity as quantityInstallment']);
  }

  public function payments(): HasMany
  {
    return $this->hasMany(InstallmentPayment::class, 'installment_id', 'id');
  }

  public function supplier(): BelongsTo
  {
    return $this->belongsTo(Supplier::class, 'client_id', 'id');
  }
  public function customer(): BelongsTo
  {
    return $this->belongsTo(Customer::class, 'client_id', 'id');
  }
}
