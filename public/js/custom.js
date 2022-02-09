'use strict';

let token = $('meta[name=csrf-token]').attr('content');

$(document).ready(function(){
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
            url: 'api/search_menu?search='+search,
            params: {
                _token: token,
            },
        }).then((res) => {
            console.log(res.data.length);

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

    // Coupon application
    $('.btn-coupon').click(function() {
        if($(this).attr('data-coupon') == 0){ // No Coupon Applied
            $('#modal').addClass('flexbox-center');
            $('#modal .modal-content').addClass('show');
        }else{
            let o_id = $(this).attr('data-order-id');
            if(confirm('Are you sure to remove Coupon?')){
                httpRequest('post', 'api/apply_coupon', {
                    _token: token,
                    oid: o_id,
                    status: 'remove', // add or remove
                });
            }
        }
    });

    // Modal for coupon
    $('.btn-claim').click(function(){
        let coupon = $('#coupod_code').val();
        let oid = $('.btn-coupon').attr('data-order-id');

        httpRequest('post', 'api/apply_coupon', {
            _token: token,
            coupon_code: coupon,
            oid: oid,
            status: 'add'
        });
    });

    $('.btn-close').click(() => {
        $('#modal').removeClass('flexbox-center');
       $('#modal .modal-content').removeClass('show'); 
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

    function httpRequest(method, url, params, config=""){
        axios({
            method: 'post',
            url: 'api/apply_coupon',
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
        });
    }
});

function addOrderMenu(id){
    let url = 'api/add_order';

    axios({
        method: 'post',
        url: url,
        data: {
            _token: token,
            id: id
        }
    }).then((res) => {
        if(res.data.status == 200){
            $('.menu-is-empty').hide(100);
            $('.menu-list').prepend(res.data.html);

            $('#subtotal').html(res.data.subtotal);
            $('#tax').html(res.data.tax);
            $('#coupon').html("(-) " + res.data.coupon);
            $('#total').html(res.data.total);
        }
    }).catch((error) => {
        console.log(error);
    });
}

function addOrder(id){
    addOrderMenu(id)
}

function removeOrderMenu(id){
    let url = 'api/remove_order_menu';

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


            $('#subtotal').html(res.data.subtotal);
            $('#tax').html(res.data.tax);
            $('#coupon').html("(-) " + res.data.coupon);
            $('#total').html(res.data.total);
        }
    });
}

function removeOrder(id){
    removeOrderMenu(id);
}

setInterval(() => {
    var date = document.getElementById('datetime');
    var get_date = new Date();
    
    date.innerHTML = get_date.toLocaleTimeString();
}, 1000);