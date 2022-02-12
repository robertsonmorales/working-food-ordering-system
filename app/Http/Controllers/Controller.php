<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Session;
use App\Models\{MenuCategories, Order, OrderList, User, Menu, Coupon, Transaction};

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user, $order, $order_list, $menu, $categories, $coupon, $trans;
    public function __construct(User $user, OrderList $order_list, Order $order, Menu $menu, MenuCategories $categories, Coupon $coupon, Transaction $trans){
        $this->menu = $menu;
        $this->category = $categories;
        $this->user = $user;
        $this->order = $order;
        $this->order_list = $order_list;
        $this->coupon = $coupon;
        $this->trans = $trans;
    }

    public function formatNumber($int, $symbol=true){
        if($symbol){
            return "₱ ".number_format($int, 2);
        }else{
            return number_format($int, 2);
        }
    }

    public function getCalculations($order){
        if(!empty($order)){
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

            $set_coupon = is_null($order->has_coupon_code) ? '0.00' : $total_discount;
            
            $calculations = array(
                'order_id' => $order->id,
                'subtotal' => (float) $subtotal,
                'tax' => $tax,
                'coupon' => (float) $set_coupon,
                'total' => $total
            );

            $data = array(
                'subtotal' => $this->formatNumber($subtotal),
                'tax' => $this->formatNumber($tax),
                'coupon' => is_null($order->has_coupon_code) ? '₱ 0.00' : $this->formatNumber($total_discount),
                'total' => $this->formatNumber($total)
            );
        }else{
            $calculations = array(
                'order_id' => null,
                'subtotal' => 0,
                'tax' => 0,
                'coupon' => 0,
                'total' => 0,
            );

            $data = array(
                'subtotal' => '₱ 0.00',
                'tax' => '₱ 0.00',
                'coupon' => '₱ 0.00',
                'total' => '₱ 0.00',
            );
        }

        Session::put('calculations', $calculations);

        return $data;
    }

    public function msgs($status, $msg, $addons=[]){
        $params = array(
            'status' => $status,
            'message' => $msg
        );

        if(count($addons) > 0){
            $params = array_merge($params, $addons);
        }

        return response()->json($params);
    }
}
