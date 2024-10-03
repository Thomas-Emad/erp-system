<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'is_damage'
    ];

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function raw_materials() {
        return $this->belongsToMany(RawMaterial::class);
    }

    public function factories() {
        return $this->belongsToMany(Factory::class);
    }
}
