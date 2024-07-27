<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'deadline',
        'reward',
        'rival',
        'status',
        'manager_id'
    ];

    public function employees() {
        return $this->belongsToMany(User::class);
    }
}
