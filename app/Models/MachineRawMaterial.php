<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineRawMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'machine_id',
        'raw_material_id'
    ];
}
