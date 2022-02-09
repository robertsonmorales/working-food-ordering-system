<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';

    protected $fillable = [
        'code',
        'name',
        'percentage'
    ];

    public function scopeGetCode($query, $c){
        return $query->where('code', $c);
    }
}
