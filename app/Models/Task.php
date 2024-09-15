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
        'delivered_time',
        'manager_id'
    ];

    public function employees() {
        return $this->belongsToMany(User::class, 'employee_task', 'employee_id', 'task_id');
    }

    public function manager() {
        return $this->belongsTo(User::class);
    } 
}
