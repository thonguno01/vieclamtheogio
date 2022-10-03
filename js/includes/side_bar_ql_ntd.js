$(document).ready(function () {
    $('.n_qlhsut').click(function(){
        $(this).next().toggleClass('hide');
        $(this).children('.n_drop_down_icon').toggleClass('n_drop_down');
        $(this).children('.n_drop_down_icon_at').toggleClass('n_drop_down');
    });
    $('.n_qltk_ntd').click(function(){
        $(this).next().toggleClass('hide');
        $(this).children('.n_drop_down_icon').toggleClass('n_drop_down');
        $(this).children('.n_drop_down_icon_at').toggleClass('n_drop_down');
    });
    $('.n_side_bar_btn_mobi').click(function(){
        $(this).toggleClass('n_close');
        $('.body_menu_ntd').toggleClass('menu_mobile');
    });
});

