<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderList extends Model
{
    use HasFactory;

    protected $table = 'order_lists';

    protected $fillable = [
        'orders_id',
        'menu_id',
        'price',
        'tax'
    ];

    public function scopeGetOrder($query, $order_id){
        return $query->where('orders_id', $order_id);
    }

    public function scopeSubtotal($query, $order_id){
        return $query->where('orders_id', $order_id)->sum('price');
    }

    public function scopeTax($query, $order_id){
        return $query->where('orders_id', $order_id);
    }

    public function menus(){
        return $this->hasOne(Menu::class, 'id', 'menu_id');
    }
}
