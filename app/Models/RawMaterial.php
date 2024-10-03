<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'description',
    'price',
    'quantity',
    'price_installment'
  ];

  public function productss()
  {
    return $this->belongsToMany(Product::class);
  }

  public function machines()
  {
    return $this->belongsToMany(Machine::class);
  }

  public function factories()
  {
    return $this->belongsToMany(Factory::class);
  }
}
