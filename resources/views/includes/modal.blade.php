<div class="modal" id="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h4>Add Coupon</h4>
      <span class="btn-close"></span>
    </div>
    <div class="modal-body">
      <p>Input Coupon Code</p>
      <div class="group-box">
        <span class="icon"><i data-feather="search"></i></span>
        <input type="text" name="coupod_code" id="coupod_code" class="form-control" placeholder="Ex: Go2018" autocomplete="off">
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary btn-claim">Claim</button>
    </div>
  </div>
</div>

@empty(!session()->get('message'))
<div class="modal flexbox-center" id="order-modal">
  <div class="modal-content show">
    <div class="modal-header">
      <h4>Order</h4>
      <span class="btn-close"></span>
    </div>
    <div class="modal-body">
      <p>{{ session()->get('message') }}</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary btn-order-close">Close</button>
    </div>
  </div>
</div>
@endempty