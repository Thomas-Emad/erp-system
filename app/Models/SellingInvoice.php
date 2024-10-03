<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellingInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'customer_id',
        'total_price',
        'shipping_price'
    ];
}
