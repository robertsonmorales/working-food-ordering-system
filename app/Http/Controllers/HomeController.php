<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;

use App\Models\{MenuCategories, Menu, OrderList, Order, Coupon, Transaction};

class HomeController extends Controller
{
    protected $categories, $menus, $order_list, $coupon, $trans;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct(MenuCategories $categories, Menu $menus, OrderList $order_list, Order $order, Coupon $coupon, Transaction $trans)
    {
        $this->middleware('auth');

        $this->menu = $menus;
        $this->category = $categories;
        $this->order = $order;
        $this->order_list = $order_list;
        $this->coupon = $coupon;
        $this->trans = $trans;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function menu()
    {
        // Session::forget('calculations');
        // Session::forget('order');

        $categories = $this->category->limitFields()->active()->latest()->get();
        $menu = $this->menu->limitFields()->active()->latest()->get();
        $calc = [];

        $check_order = $this->order->where('user_id', Auth::id())->latest()->first();
        if(empty($check_order)){ // no order history of user
            $has_order = false;
            $order_list = [];
        }else{ // has order history of user
            $has_order = true;

            $order = Session::get('order');
            $calc = $this->getCalculations($order);
            $ol = $this->order_list;
            $order_list = $ol->getOrder($order->id)->latest()->get();
        }
        
        $params = array_merge([
            'categories' => @$categories,
            'menu' => @$menu,
            'has_order' => $has_order,
            'has_coupon' => @is_null($order->has_coupon_code) ? 0 : 1, // 0 = null; 1 = has_code
            'order_id' => @$order->id,
            'order_list' => @$order_list
        ], @$calc);

        return view('pages.menu', $params);
    }

    // * ADD ORDER MENU
    public function addOrder(Request $request){
        $menu_id = $request->get('id');
        $menu_details = $this->menu->limitFields()->find($menu_id);

        // checks order history
        $check_orders = $this->order->limitFields()
            ->where('user_id', Auth::id())
            ->latest()
            ->first();

        if(empty($check_orders)){
            $order = $this->order->create([
                'user_id' => Auth::id(),
                'order_no' => 1,
                'has_coupon_code' => null,
                'status' => 1
            ]);
        }else{
            $order = $check_orders;
        }

        Session::put('order', $order);

        $insert_order = $this->order_list->create(array(
            'price' => $menu_details->price,
            'tax' => $menu_details->tax,
            'orders_id' => $order->id,
            'menu_id' => $menu_id
        ));

        $times = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';

        $contentHTML = '<div class="card row mx-1 order-card" data-id="'.$insert_order->id.'">
            <img src="'.$menu_details->menu_img.'" alt="'.$menu_details->menu_name.'" width="80" height="70" class="card-img col-3">
            <div class="card-details col-7">
                <div class="text-muted">'.$menu_details->menu_name.'</div>
                <h5 data-tax="'.$menu_details->tax.'">₱'.number_format($menu_details->price, 2).'</h5>
            </div>
            <div class="card-actions col-2">
                <button class="btn btn-remove"
                    onclick="removeOrder('.$insert_order->id.')"
                    data-id="'.$insert_order->id.'">
                    <span>'.$times.'</span>
                </button>
            </div>
        </div>';

        return $this->msgs(200, 'Added Successfully', 
            array_merge(
                $this->getCalculations($order), [
                    'html' => $contentHTML, 
                    'order_id' => $order->id,
                    'order_no' => $order->order_no
                ]
            )
        );
    }

    // * REMOVE ORDER MENU
    public function removeOrderMenu(Request $request){
        $id = $request->get('id');
        $data = $this->order_list->findOrFail($id);
        $data->delete();

        $order = $this->order->find($data->orders_id);

        return $this->msgs(200, 'Order Removed Successfully', array_merge($this->getCalculations($order), []));
    }

    // * RESET ORDER MENU
    public function resetOrder(Request $request){
        $order_id = $request->get('order_id');
        $order = $this->order->find($order_id);
        $list = $this->order_list->getOrder($order_id)->get();

        foreach ($list as $key => $value) {
            $find_order = $this->order_list->find($value->id);
            $find_order->delete();
        }

        $count_orders_list = $this->order_list->getOrder($order_id)->count();
        if($count_orders_list == 0){
            return $this->msgs(200, 'Reset Successfully', array_merge(
                $this->getCalculations($order), []
            ));
        }else{
            return $this->msgs(400, 'Failed to reset all menu from order');
        }
    }

    // * APPLY COUPON
    public function applyCoupon(Request $request){
        // return $request->all();
        $order_id = $request->get('order_id');
        $status = $request->get('status');

        if($status == 'remove'){ // remove coupon
            $update = $this->order->find($order_id);
            $update->update([
                'has_coupon_code' => null
            ]);

            if($update){
                Session::put('order', $update);

                return $this->msgs(200, 'Coupon Remove Successfully', 
                    array_merge(
                        $this->getCalculations($update),
                        ['button_text' => 'Add Coupon']
                    )
                );
            }
        }else if($status == 'add'){
            $code = strtoupper($request->get('coupon_code'));
            $verify_coupon = $this->coupon->getCode($code)->first();

            if(empty($verify_coupon)){
                return $this->msgs(400, "Invalid Coupon Code");
            }else{
                $update = $this->order->find($order_id);
                $update->update([
                    'has_coupon_code' => $code
                ]);

                if($update){
                    Session::put('order', $update);

                    $subt = $this->order_list->subtotal($order_id);
                    $coupon = ($verify_coupon->percentage / 100) * $subt;

                    return $this->msgs(200, 'Coupon Added Successfully', array_merge(
                            $this->getCalculations($update),
                            ['button_text' => 'Remove Coupon']
                        ) 
                    );
                }else{
                    return $this->msgs(400, "Failed to apply coupon");
                }
            }
        }
    }

    // * SEARCH MENU
    public function searchMenu(Request $request){
        $data = $request->get('search');

        $menu = $this->menu->limitFields()->searchFor($data)->latest()->get();
        $htmlContent = "";

        foreach ($menu as $key => $value) {
            $htmlContent .= '<button class="card btn-card btn-card-'.$value['id'].'"
                data-category="'.$value['menu_category_id'].'"
                data-menu-id="'.$value['id'].'"
                onclick="addOrder('.$value['id'].')">
                <img class="img-fluid mb-2" 
                    src="'.$value['menu_img'].'" 
                    alt="'.$value['menu_name'].'">
                <div class="card-body">
                    <p class="card-text">
                        <span class="name">'.$value['menu_name'].'</span>
                        <span class="price">'.$this->formatNumber($value['price']).'</span></p>
                </div>
            </button>';
        }
        
        return response()->json($htmlContent);
    }

    // * ORDER SUMMARY VIEW
    public function orderSummary(Request $request){
        $order_id = $request->input('order_id');
        $order = $this->order->find($order_id);

        if(empty($order)){
            abort(404);
        }else{
            $order_list = $this->order_list->limitFields()->getOrder($order_id)->get();
            $calc = $this->getCalculations($order);

            return view('pages.order_summary', [
                'order_id' => $order_id,
                'calculation' => $calc,
                'order_list' => $order_list
            ]);
        }
    }

    // * PROCESS ORDER 
    public function processOrder(Request $request){
        $order_id = $request->has('order_id');
        if($order_id){
            $calc = Session::get('calculations');
            $calc['status'] = 1;

            $save_trans = $this->trans->create($calc);

            if($save_trans){
                $order = $this->order->create([
                    'user_id' => Auth::id(),
                    'order_no' => ($this->order->find($calc['order_id'])->order_no + 1),
                    'has_coupon_code' => null,
                    'status' => 1
                ]);

                Session::forget('calculations');
                Session::put('order', $order);

                return redirect()
                    ->route('home')
                    ->with('message', 'Order have been successfully saved and is now pending.');
            }else{
                abort(400);
            }
        }else{
            abort(400);
        }
    }
}
