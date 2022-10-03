$(document).ready(function () {
    $('.unsave_uv').click(function(){
        var id_save = $(this).attr('data-idsave');
        var id_uv = $(this).attr('data-iduv');
        $('.warning_background').show();
        ele = this;
        $('.yes_unsave_uv').click(function(){
            save_uv(id_uv);
            $(ele).parents('tr').remove();
            $('.warning_background').hide();
        });
    });
});