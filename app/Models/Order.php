<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_cost',
        'status',
        'time',
        'store_id',
        'factory_id'
    ];

    public function factory() {
        return $this->belongsTo(Factory::class);
    }

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function order_products() {
        return $this->hasMany(OrderProduct::class);
    }
}
