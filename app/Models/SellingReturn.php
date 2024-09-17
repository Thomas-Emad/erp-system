<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellingReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_price',
        'selling_invoice_id'
    ];
}
