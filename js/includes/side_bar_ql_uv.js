$(document).ready(function () {
    $('.n_qlhs').click(function(){
        $(this).next().toggleClass('hide');
        $(this).children('.n_drop_down_icon_at').toggleClass('n_drop_down');
        $(this).children('.n_drop_down_icon').toggleClass('n_drop_down');
    });
    $('.n_side_bar_btn_mobi').click(function(){
        $(this).toggleClass('n_close');
        $('.n_side_bar_bottom').toggleClass('menu_mobile');
    });
});