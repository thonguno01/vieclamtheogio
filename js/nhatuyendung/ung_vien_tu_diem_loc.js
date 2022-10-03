$(document).ready(function() {
    $('.unsave_uv').click(function() {
        var id_ntd = $(this).attr('data-idntd');
        var id_uv = $(this).attr('data-iduv');
        $('.warning_background').show();
        ele = this;
        $('.yes_unsave_uv').click(function() {
            console.log(id_ntd + ' ' + id_uv);

            del_ung_vien_tu_diem_loc(id_uv, id_ntd);
            $(ele).parents('tr').remove();
            $('.warning_background').hide();
        });
    });
});