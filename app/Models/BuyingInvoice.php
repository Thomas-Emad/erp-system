<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyingInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'total_price',
        'shipping_price',
        'supplier_id',
        'factory_id'        
    ];

    public function factory() {
        return $this->belongsTo(Factory::class);
    }
}
