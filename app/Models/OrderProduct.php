<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'cost',
        'quantity',
        'product_id',
        'order_id'
    ];
    
    public function order() {
        return $this->belongsTo(Order::class);
    }
}
