$(document).ready(function() {
    $('.stt_uv_apply').change(function() {
        var stt_ut = $(this).val();
        var id_ut = $(this).attr('data-idUt');
        $.ajax({
            url: '/Ajax/update_stt_apply',
            type: "POST",
            dataType: "JSON",
            data: {
                stt_ut: stt_ut,
                id_ut: id_ut,
            },
            success: function(data) {
                console.log(data);
            }
        });
    });
    $(".filter_uv_ut_stt").change(function() {
        var tt_sort = $(this).val();
        url = "/ung-vien-ung-tuyen";
        if (tt_sort >= 0) url = url + "?stt=" + tt_sort;
        window.location.href = url;
    });
});