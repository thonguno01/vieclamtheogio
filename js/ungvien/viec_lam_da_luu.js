$(document).ready(function () {
    $('.unsave_new').click(function(){
        var id_save = $(this).attr('data-idsave');
        var id_new = $(this).attr('data-new');
        var id_ntd = $(this).attr('data-idntd');
        $('.warning_background').show();
        ele = this;
        $('.yes_unsave_uv').click(function(){
            save_new(id_ntd,id_new);
            $(ele).parents('tr').remove();
            $('.warning_background').hide();
        });
    });
});