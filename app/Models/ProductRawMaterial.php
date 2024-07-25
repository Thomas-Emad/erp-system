<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRawMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity_of_raw_material',
        'product_id',
        'raw_material_id'
    ];
}
