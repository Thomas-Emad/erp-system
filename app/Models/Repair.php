<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'what_has_been_fixed',
        'problem_reason',
        'date',
        'machine_id'
    ];
}
