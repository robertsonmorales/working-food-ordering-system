<aside id="orders" 
    class="{{ ($has_order) ? '' : 'd-none' }}">

    @php $count_orders = ($order_list == 0) ? 0 : count($order_list); @endphp
    <div class="sticky-header">
        <div class="header">
            <h4 class="order-no">Order #{{ $order_id }}</h4>
        </div>

        <div class="actions">
            <button class="btn btn-primary-outline btn-coupon {{ ($count_orders == 0) ? 'd-none' : '' }}" 
                data-coupon="{{ $has_coupon }}">
                <span class="me-2">
                    <i data-feather="file-text"></i>
                </span>
                <span id="coupon-text">{{ $has_coupon == 0 ? 'Add' : 'Remove' }} Coupon</span>
            </button>
            <button class="btn btn-danger-outline btn-reset {{ ($count_orders < 2) ? 'd-none' : '' }}">
                <span class="me-2"><i data-feather="x"></i></span>
                <span>Clear Order</span>
            </button>
        </div>

        <hr class="divider">
    </div>

    <div class="menu-list">
        @if($count_orders != 0)
        @foreach($order_list as $item)
        <div class="card row mx-1 order-card"
            data-id="{{ $item->id }}">
            <img src="{{ $item->menus->menu_img }}" 
                alt="{{ $item->menus->menu_name }}"
                width="80"
                height="70"
                class="card-img col-3">
            
            <div class="card-details col-7">
                <div class="text-muted">{{ $item->menus->menu_name }}</div>
                <h5>₱{{ number_format($item->menus->price, 2) }}</h5>
            </div>

            <!-- <div class="order-qty">
                <button class="btn btn-light btn-minus">
                    <span><i data-feather="minus"></i></span>
                </button>

                <input type="text" 
                    value="1" 
                    class="form-control qty" 
                    readonly>

                <button class="btn btn-light btn-plus">
                    <span><i data-feather="plus"></i></span>
                </button>
            </div> -->

            <div class="card-actions col-2">
                <button class="btn btn-remove" 
                    data-id="{{ $item->id }}">
                    <span><i data-feather="x"></i></span>
                </button>
            </div>
        </div>
        @endforeach
        @endif

        <div class="menu-is-empty" style="display: {{ ($count_orders != 0) ? 'none;' : '' }}">
            <div class="mb-2"><i data-feather="meh"></i></div>
            <h3>No Orders Yet.</h3>
        </div>
    </div>

    <div class="transactions">
        <hr class="divider">

        <div class="transaction-breakdown">
            <div class="breakdown">
                <span>Subtotal</span>
                <span id="subtotal">{{ @$subtotal }}</span>
            </div>

            <div class="breakdown">
                <span>Tax</span>
                <span id="tax">{{ @$tax }}</span>
            </div>

            <div class="breakdown">
                <span>Coupon</span>
                <span id="coupon" class="text-danger">(-) {{ @$coupon }}</span>
            </div>

            <div class="breakdown">
                <h4>Total</h4>
                <span id="total">{{ @$total }}</span>
            </div>

            <form class="transaction-action" 
                method="POST" 
                action="{{ route('order.summary') }}">
                @csrf
                <input type="hidden" 
                    name="order_id" 
                    id="order-id" 
                    value="{{ $order_id }}">
                <button type="submit" 
                    class="btn btn-primary w-100" 
                    id="btn-save" {{ ($count_orders <= 0) ? 'disabled' : '' }}>
                    <span>Checkout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
