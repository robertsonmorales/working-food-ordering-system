// Tab Select
$('.nav-category').on('click', function(){
    let cat_id = $(this).attr('id');

    // * select active category tab
    $('.nav-category').each(function(index, value){
        let that = $(this);

        if(that.attr('id') == cat_id){
            that.addClass('active');
        }else{
            that.removeClass('active');
        }
    });

    // * filter menu records
    $('.btn-card').each(function(index, value){
        let that = $(this);
        
        if(that.data('category') == cat_id){
            that.show(200);
        }else if(cat_id == undefined){
            that.show(200);
            that.removeAttr('style');
        }else {
            that.hide(100);
        }
    });
});

// Search menu
$('#search').on('keyup', function() {
    let search = $(this).val().toLowerCase();

    $('.btn-card .name').filter(function(){
        let parentElement = $(this).parent().parent().parent();
        let filter = $(this).text().toLowerCase().indexOf(search) > -1;

        // if(filter){
        //     $('#no-result').addClass('d-none');
        // }else{
        //     $('#no-result').removeClass('d-none');
        // }

        parentElement.toggle(filter);
    });
});

// SELECT MENU
$('.btn-card').click(function() {
    let data_id = $(this).attr('data-menu-id');

    addOrderMenu(data_id);
});
// ENDS HERE

// REMOVE MENU
$('.btn-remove').click(function(){
    let id = $(this).attr('data-id');

    removeOrderMenu(id);
});
// ENDS HERE

// RESET ORDERED MENU
$('.btn-reset').click(function(){
    if(confirm('Reset all menu from Order?')){
        axios({
            method: 'post',
            url: '/reset_order',
            data: {
                _token: token,
                order_id: $('#order-id').val()
            }
        }).then((res) => {
            // console.log(res);

            if(res.data.status == 200){
                $('.menu-list .card').remove();
                $('.menu-is-empty').show(100);
                $('.btn-reset').addClass('d-none');

                triggerCalculations(res.data);
                countOrders();
            }
        }).catch(error => console.log(error));
    }
});
// ENDS HERE

// Coupon application
$('.btn-coupon').click(function() {
    if($(this).attr('data-coupon') == 0){ // No Coupon Applied
        $('#modal').addClass('flexbox-center');
        $('#modal .modal-content').addClass('show');
    }else{
        let order_id = $('#order-id').val();
        
        if(confirm('Are you sure to remove Coupon?')){
            requestCoupon('post', '/apply_coupon', {
                _token: token,
                order_id: order_id,
                status: 'remove', // add or remove
            });
        }
    }
});

// Modal for coupon
$('.btn-claim').click(function(){
    let coupon = $('#coupod_code').val();
    let order_id = $('#order-id').val();

    requestCoupon('post', '/apply_coupon', {
        _token: token,
        coupon_code: coupon,
        order_id: order_id,
        status: 'add'
    });
});

// CLOSE MODAL
$('.btn-close').click(() => {
    $('#modal').removeClass('flexbox-center');
    $('#modal .modal-content').removeClass('show'); 
});

$('.btn-order-close').click(() => {
    $('#order-modal').removeClass('flexbox-center');
    $('#order-modal .modal-content').removeClass('show'); 
});
// ENDS HERE

function requestCoupon(method, url, params){
    axios({
        method: method,
        url: url,
        data: params
    }).then((res) => {
        
        if(res.data.status == 200){

            if(res.data.hasOwnProperty('coupon') 
                && res.data.hasOwnProperty('total')){

                $('#coupon').html(res.data.coupon);
                $('#total').html(res.data.total);
                $('#coupon-text').html(res.data.button_text);

                if(res.data.button_text == 'Remove Coupon'){
                    $('.btn-coupon').attr('data-coupon', 1);
                }else{
                    $('.btn-coupon').attr('data-coupon', 0);
                }

            }

            alert(res.data.message);

            if($('#modal').hasClass('flexbox-center')){
                $('#modal').removeClass('flexbox-center');
            }
        }

        if(res.data.status == 400){
            alert(res.data.message);
        }
    }).catch(res => console.log(res));
}

function addOrderMenu(id){
    let url = '/add_order';

    axios({
        method: 'post',
        url: url,
        data: {
            _token: token,
            id: id
        }
    }).then((res) => {
        // console.log(res);
        
        if(res.data.status == 200){
            $('.menu-is-empty').hide(100);
            $('.menu-list').prepend(res.data.html);
            $('#order-id').val(res.data.order_id);
            $('.order-no').html('Order #' + res.data.order_no);

            if($('#orders').hasClass('d-none') 
                && $('#app').hasClass('no-order')
                && $('#menu-list').hasClass('has-order')){
                $('#orders').removeClass('d-none');
                $('#app').removeClass('no-order');
                $('#menu-list').removeClass('has-order');
            }

            triggerCalculations(res.data);
            countOrders();
        }
    }).catch((error) => {
        console.log(error);
    });
}

function addOrder(id){
    addOrderMenu(id)
}

function removeOrderMenu(id){
    let url = '/remove_order_menu';

    axios({
        method: 'post',
        url: url,
        data: {
            _token: token,
            id: id
        }
    }).then((res) => {
        let card_length = $('.order-card').length;

        if(res.data.status == 200){
            for(let i = 0; i < $('.order-card').length; i++){
                let data_id = $('.order-card')[i].getAttribute('data-id');
                if(data_id == id){
                    $('.order-card')[i].remove();
                }
            }

            if(card_length <= 1){
                $('.menu-is-empty').show(100);
            }

            triggerCalculations(res.data);
            countOrders();
        }
    });
}

function removeOrder(id){
    removeOrderMenu(id);
}

function triggerCalculations(data){
    $('#subtotal').html(data.subtotal);
    $('#tax').html(data.tax);
    $('#coupon').html("(-) " + data.coupon);
    $('#total').html(data.total);
}

function countOrders(){
    let count_list = $('.menu-list .card').length;
    $('#btn-save').attr('disabled', false);

    if(count_list >= 1) {
        if($('.btn-coupon').hasClass('d-none')){
            $('.btn-coupon').removeClass('d-none');
        }
    }else{
        $('#btn-save').attr('disabled', true);
        $('.btn-coupon').addClass('d-none');
    }

    if(count_list >= 2){
        if($('.btn-reset').hasClass('d-none')){
            $('.btn-reset').removeClass('d-none');
            
        }
    } else{
        $('.btn-reset').addClass('d-none');
    }
}

setInterval(() => {
    var date = document.getElementById('datetime');
    var get_date = new Date();
    
    date.innerHTML = get_date.toLocaleTimeString();
}, 1000);