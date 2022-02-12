'use strict';

let token = $('meta[name=csrf-token]').attr('content');

$(document).ready(function(){
    // let path = window.location.pathname;
    // let pathname = path.split('/').reverse()[0];

    // let navs = $('.btn-nav-item');
    // for (let i = 0; i < navs.length; i++) {
    //     if(navs[i].getAttribute('data-nav') == pathname){
    //         navs[i].classList.add('active');
    //     }else{
    //         navs[i].classList.remove('active');
    //     }
    // }

    // Tab Select
    $('.nav-category').click(function(){
        let cat_id = $(this).attr('id');

        for(let a = 0; a < $('.nav-category').length; a++){
            if($('.nav-category')[a].getAttribute('id') != cat_id){
                $('.nav-category')[a].classList.remove('active');
            }else{
                $(this).addClass('active');
            }
        }

        for(let i = 0; i < $('.btn-card').length; i++){
            if($('.btn-card')[i].getAttribute('data-category') != cat_id){
                $('.btn-card')[i].style.display = 'none';
            }else{
                $('.btn-card')[i].style.display = 'flex';
            }
        }
    });

    // Reset Tab
    $('.nav-category.category-all').click(function(){
        $('.btn-card').removeAttr('style');
    });

    // Search menu
    $('#search').keyup(function() {
        $('#menu-list').empty();

        $('#loader').removeClass('d-none');
        $('#no-result').addClass('d-none');

        let search = $(this).val().toLowerCase();

        axios({
            method:'get',
            url: '/search_menu?search='+search,
            params: {
                _token: token,
            },
        }).then((res) => {
            if(res.data.length == 0){
                $('#loader').addClass('d-none');
                $('#no-result').removeClass('d-none');
            }else{
                $('#loader').addClass('d-none');
                $('#no-result').addClass('d-none');

                $('#menu-list').html(res.data);
            }
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

    // LOGOUT USER
    $('.btn-logout').click(function(){
        if(confirm('Are you sure you want to logout?')){
            $('#logout-form').submit();
        }
    });
    // ENDS HERE
});

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
        console.log(res);
        
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