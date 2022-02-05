<aside class="py-4" id="orders">
    <div class="header">
        <h4>Order</h4>
    </div>

    <div class="actions">
        <button class="btn btn-primary-outline btn-coupon">
            <span class="me-2">
                <i data-feather="file-text"></i>
            </span>
            <span>Add Coupon</span>
        </button>
        <button class="btn btn-danger-outline btn-reset">
            <span class="me-2">
                <i data-feather="x"></i>
            </span>
            <span>Reset Order</span>
        </button>
    </div>

    <div class="menu-list">
        <div class="card">
            <img src="https://media-cldnry.s-nbcnews.com/image/upload/newscms/2020_27/1586837/hotdogs-te-main-200702.jpg" 
                alt="Hotdog"
                width="80"
                height="70"
                class="card-img">
            
            <div class="card-details">
                <div class="text-muted">Hotdog</div>
                <h5>₱75.00</h5>
            </div>

            <div class="order-qty">
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
            </div>

            <div class="card-actions">
                <button class="btn btn-remove">
                    <span><i data-feather="x"></i></span>
                </button>
            </div>
        </div>
        <div class="card">
            <img src="https://cdn.shopify.com/s/files/1/2141/9909/products/Coke_Zero_330mL_1024x.png?v=1591901397" 
                alt="Coke"
                width="80"
                height="70"
                class="card-img">
            
            <div class="card-details">
                <div class="text-muted">Coke</div>
                <h5>₱18.00</h5>
            </div>

            <div class="order-qty">
                <button class="btn btn-light btn-minus">
                    <span><i data-feather="minus"></i></span>
                </button>

                <input type="text" 
                    value="2" 
                    class="form-control qty" 
                    readonly>

                <button class="btn btn-light btn-plus">
                    <span><i data-feather="plus"></i></span>
                </button>
            </div>

            <div class="card-actions">
                <button class="btn btn-remove">
                    <span><i data-feather="x"></i></span>
                </button>
            </div>
        </div>
        <div class="card">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTGGe_44E31zA2w0PQoM1GY5k9kih5kbBiY0AjiJOYqghC1N0wo4WpB-VeS3I7s-10vnRk&usqp=CAU" 
                alt="Pork Combo"
                width="80"
                height="70"
                class="card-img">
            
            <div class="card-details">
                <div class="text-muted">Pork Combo</div>
                <h5>₱110.00</h5>
            </div>

            <div class="order-qty">
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
            </div>

            <div class="card-actions">
                <button class="btn btn-remove">
                    <span><i data-feather="x"></i></span>
                </button>
            </div>
        </div>
    </div>

    <hr class="divider">

    <div class="transactions">
        <div class="transaction-breakdown">
            <div class="breakdown">
                <span>Subtotal</span>
                <span>₱100.00</span>
            </div>

            <div class="breakdown">
                <span>Tax</span>
                <span>₱100.00</span>
            </div>

            <div class="breakdown">
                <span>Coupon</span>
                <span>₱100.00</span>
            </div>

            <div class="breakdown">
                <h4>Total</h4>
                <span>₱100.00</span>
            </div>

            <div class="transaction-action">
                <button class="btn btn-primary w-100">Save Order</button>
            </div>
        </div>
    </div>
</aside>