<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\{Order, OrderList, User, Menu, Coupon};

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user, $order, $order_list, $menu, $coupon;
    public function __construct(User $user, OrderList $order_list, Order $order, Menu $menu, Coupon $coupon){
        $this->user = $user;
        $this->order = $order;
        $this->order_list = $order_list;
        $this->menu = $menu;
        $this->coupon = $coupon;
    }

    public function formatNumber($int){
        return "₱ ".number_format($int, 2);
    }

    public function getCalculations($order){
        $calc = $this->order_list->getOrder($order->id);
        $subtotal = $calc->sum('price');

        $ans = [];
        foreach ($calc->get() as $key => $value) {
            $ans[] = $value->price * $value->tax;
        }

        $tax = array_sum($ans);

        $total_discount = "";
        if(!is_null($order->has_coupon_code)){
            $coupon = $this->coupon->where('code', $order->has_coupon_code)->first();

            $total_discount = ($coupon->percentage / 100) * $subtotal;
            $total = $subtotal - $total_discount;
        }else{
            $total_discount = $subtotal;
            $total = $total_discount;
        }

        return array(
            'subtotal' => $this->formatNumber($subtotal),
            'tax' => $this->formatNumber($tax),
            'coupon' => is_null($order->has_coupon_code) ? '0.00' : $this->formatNumber($total_discount),
            'total' => $this->formatNumber($total)
        );
    }
}
