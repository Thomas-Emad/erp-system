<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyingReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_price',
        'buying_invoice_id'
    ];
}
