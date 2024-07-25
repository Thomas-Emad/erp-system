<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactoryRawMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'raw_material_id',
        'factory_id'
    ];
}
