const $ = require('jquery');

$('.btn-coupon').click(() => {
    $('#modal').addClass('flexbox-center');
    $('#modal .modal-content').addClass('show');  
});

$('.btn-close').click(() => {
    $('#modal').removeClass('flexbox-center');
   $('#modal .modal-content').removeClass('show'); 
});



setInterval(() => {
    var date = document.getElementById('datetime');
    var get_date = new Date();
    
    date.innerHTML = get_date.toLocaleTimeString();
}, 1000);