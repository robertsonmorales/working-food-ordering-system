<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'order_id',
        'subtotal',
        'tax',
        'coupon',
        'total',
        'status'
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
}
