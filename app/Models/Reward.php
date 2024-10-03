<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'reward_value',
        'reason_for_reward',
        'employee_id'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class);
    }
}
