<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineFactory extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'machine_id',
        'factory_id'
    ];
}
