$(document).ready(function() {
    $('.ntd_xemtt_uv').click(function() {
        console.log($(this).data());

        if ($(this).data('iduser') == '') {
            var type = $('.type_login').val();
            if (type == 4) {
                $('.n_dn_title').html('BẠN CẦN ĐĂNG NHẬP NHÀ TUYỂN DỤNG ĐỂ THỰC HIỆN THAO TÁC');
            } else {
                $('.n_dn_title').html('BẠN CẦN ĐĂNG NHẬP ỨNG VIÊN ĐỂ THỰC HIỆN THAO TÁC');
            }
            $('.background_login').toggle();
        } else {
            if ($(this).data('check') == 2) {
                alert("Bạn đã xem thông tin ứng viên này rồi.");
            } else if ($(this).data('check') == 1) {
                if ($(this).data('point') > 0) {
                    var r = confirm("Bạn sẽ mất 1 điểm để xem thông tin ứng viên. Bạn chắc chắn muốn xem thông tin ứng viên!");
                    if (r == true) {
                        var id_uv = $(this).attr('data-iduv');
                        $.ajax({
                            url: '/Ajax/ntd_see_uv',
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                id_uv: id_uv,
                            },
                            success: function(data) {
                                console.log(data.uv_phone);
                                if (data.kq == true) {
                                    $('.n_phone').addClass('n_detail_uv_show_in4');
                                    $('.n_phone').html(data.uv_phone);
                                    $('.n_email').addClass('n_detail_uv_show_in4');
                                    $('.n_email').html(data.uv_email);
                                    $(this).attr('data-check', 2);
                                } else {
                                    alert("Bạn đã xem thông tin ứng viên này rồi.");
                                }
                            }
                        });
                    }
                } else {
                    alert("Bạn không đủ điểm để xem ứng viên");
                }
            }
        }
    });
});