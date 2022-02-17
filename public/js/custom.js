'use strict';

const token = $('meta[name=csrf-token]').attr('content');

$(document).ready(function(){
    let path = window.location.pathname;
    let pathname = path.split('/').reverse()[0];
    // console.log(pathname);

    let navs = $('.btn-nav-item');
    for (let i = 0; i < navs.length; i++) {
        if(navs[i].getAttribute('data-nav') == pathname){
            navs[i].classList.add('active');
        }else{
            navs[i].classList.remove('active');
        }
    }

    // LOGOUT USER
    $('.btn-logout').click(function(){
        if(confirm('Are you sure you want to logout?')){
            $('#logout-form').submit();
        }
    });
    // ENDS HERE
});