<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyingInvoiceRawMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'price',
        'raw_material_id',
        'buying_invoice_id'
    ];

    public function buying_invoice() {
        return $this->belongsTo(BuyingInvoice::class);
    }
}
