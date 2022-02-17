<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'has_coupon_code',
        'order_no',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeLimitFields($query){
        return $query->select(array_merge($this->fillable, ['id']));
    }

    public function transaction(){
        return $this->hasOne(Transaction::class, 'order_id');
    }
}
