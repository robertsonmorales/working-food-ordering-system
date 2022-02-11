@extends('layouts.auth')

@section('content')
<div class="container" style="height: 100vh;">
    <div class="row justify-content-center align-items-center py-5">
        <div class="col-md-7">
            <div class="card p-4">
                <h4>
                	<a href="{{ route('home') }}"><i data-feather="arrow-left-circle"></i></a>
                	<span class="ms-2">{{ __('Order Summary') }}</span>
                </h4>

                <hr class="divider"></hr>

                <div class="card-body">
                    <form method="POST" 
                    	action="{{ route('process.order') }}" 
                    	class="w-100">
                        @csrf

                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col"></th>
                              <th scope="col">Menu</th>
                              <th scope="col">Price</th>
                              <!-- <th scope="col">Tax</th> -->
                            </tr>
                          </thead>	
                          <tbody>
                          	@foreach($order_list as $k => $item)
                            <tr>
                              <td scope="row">
                              	<img src="{{ $item->menus->menu_img }}" width="50" height="50">
                              </td>
                              <td>{{ $item->menus->menu_name }}</td>
                              <td>{{ "₱ ".number_format($item->price, 2) }}</td>
                            </tr>
                            @endforeach
                          </tbody>
                          <thead>
                          	<tr>
                              <td scope="row" colspan="2">Subtotal</td>
                              <td>{{ $calculation['subtotal'] }}</td>
                            </tr>
                            <tr>
                              <td scope="row" colspan="2">Tax</td>
                              <td>{{ $calculation['tax'] }}</td>
                            </tr>
                            <tr>
                              <td scope="row" colspan="2">Coupon</td>
                              <td class="text-danger">{{ $calculation['coupon'] }} (-)</td>
                            </tr>
                            <tr>
                              <td class="font-weight-600" scope="row" colspan="2">Total</td>
                              <td class="font-weight-600">{{ $calculation['total'] }}</td>
                            </tr>
                          </thead>
                        </table>

                        <div class="py-2"></div>

                        <div class="flex-center-end">
                            <input type="hidden" name="order_id" value="{{ $order_id }}">
                            <button type="submit" 
                            	class="btn btn-primary w-25">{{ __('Place Order') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection