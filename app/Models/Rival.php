<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rival extends Model
{
    use HasFactory;

    protected $fillable = [
        'rival_value',
        'reason_of_rival',
        'employee_id'
    ];

    public function employee() {
        return $this->belongsTo(User::class);
    }
}
