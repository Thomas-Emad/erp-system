<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellingInvoiceProduct extends Model
{
  use HasFactory;

  protected $fillable = [
    'price',
    'quantity',
    'store_id',
    'product_id',
    'selling_invoice_id'
  ];

  public function store()
  {
    return $this->belongsTo(Store::class);
  }

  public function selling_invoice()
  {
    return $this->belongsTo(SellingInvoice::class);
  }

  public function product(): BelongsTo
  {
    return $this->belongsTo(Product::class);
  }
}
