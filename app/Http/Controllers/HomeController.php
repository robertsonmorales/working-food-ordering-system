<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{MenuCategories, Menu, OrderList, Order, Coupon};

class HomeController extends Controller
{
    protected $categories, $menus, $order_list, $coupon;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MenuCategories $categories, Menu $menus, OrderList $order_list, Order $order, Coupon $coupon)
    {
        $this->middleware('auth');

        $this->menu = $menus;
        $this->category = $categories;
        $this->order = $order;
        $this->order_list = $order_list;
        $this->coupon = $coupon;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = $this->category->limitFields()
            ->active()
            ->latest()
            ->get();

        $menu = $this->menu->limitFields()
            ->active()
            ->latest()
            ->get();

        $order = $this->order->latest()->first();

        $ol = $this->order_list;
        $order_list = $ol->latest()->get();

        $subtotal = $ol->subtotal($order->id);
        $tax = $ol->getOrder($order->id)->get();
        $ans = [];

        foreach ($tax as $key => $value) {
            $ans[] = $value->price * $value->tax;
        }

        $new_tax = array_sum($ans);

        if($order->has_coupon_code != null){
            $coupon = @$this->coupon->getCode($order->has_coupon_code)->first();
            $coupon_discount = ($coupon->percentage / 100) * $subtotal;
        }else{
            $coupon_discount = 0;
        }

        return view('index', [
            'categories' => $categories,
            'menu' => $menu,
            'has_coupon' => is_null($order->has_coupon_code) ? 0 : 1,
            'order_id' => $order->id,
            'order_list' => $order_list,

            'subtotal' => $this->formatNumber($subtotal),
            'tax' => $this->formatNumber($new_tax),
            'coupon' => $this->formatNumber($coupon_discount),
            'total' => $this->formatNumber($subtotal - $coupon_discount),
        ]);
    }
}
