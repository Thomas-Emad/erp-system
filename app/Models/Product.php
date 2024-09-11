<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'description',
    'selling_price',
    'cost_price',
    'profit',
    'quantity',
    'image',
    'machine_id',
    'price_installment'
  ];

  public function machine()
  {
    return $this->belongsTo(Machine::class);
  }

  public function stores()
  {
    return $this->belongsToMany(Store::class);
  }

  public function raw_materials()
  {
    return $this->belongsToMany(RawMaterial::class);
  }
}
