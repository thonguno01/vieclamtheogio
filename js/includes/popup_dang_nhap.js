$(document).ready(function() {
    $('.n_btn_like').click(function() {
        if ($(this).data('iduser') == '') {
            var type = $('.type_login').val();
            if (type == 4) {
                $('.n_dn_title').html('BẠN CẦN ĐĂNG NHẬP NHÀ TUYỂN DỤNG ĐỂ THỰC HIỆN THAO TÁC');
            } else {
                $('.n_dn_title').html('BẠN CẦN ĐĂNG NHẬP ỨNG VIÊN ĐỂ THỰC HIỆN THAO TÁC');
            }
            $('.background_login').toggle();
        } else {
            $(this).parent('.n_job_func').find('.n_job_like').toggleClass('hide');
            $(this).parent('.n_job_func').find('.n_job_like_after').toggleClass('hide');
            $(this).parent('.n_job_func').find('.n_job_liked').toggleClass('hide');
            $(this).parent('.n_job_func').find('.n_job_liked_after').toggleClass('hide');
        }
    });
    $('.Group1000003744').click(function() {
        if ($(this).data('iduser') == '') {
            var type = $('.type_login').val();
            if (type == 4) {
                $('.n_dn_title').html('BẠN CẦN ĐĂNG NHẬP NHÀ TUYỂN DỤNG ĐỂ THỰC HIỆN THAO TÁC');
            } else {
                $('.n_dn_title').html('BẠN CẦN ĐĂNG NHẬP ỨNG VIÊN ĐỂ THỰC HIỆN THAO TÁC');
            }
            $('.background_login').toggle();
        } else {
            if ($(this).children('img').attr('src') == '/images/Group 1000003744.svg') {
                $(this).children('img').attr('src', '/images/Group 1000003745.svg');
            } else {
                $(this).children('img').attr('src', '/images/Group 1000003744.svg');
            }
        }
    });
    $('.btn-warning').click(function() {
        if ($(this).data('iduser') == '') {
            var type = $('.type_login').val();
            if (type == 4) {
                $('.n_dn_title').html('BẠN CẦN ĐĂNG NHẬP NHÀ TUYỂN DỤNG ĐỂ THỰC HIỆN THAO TÁC');
            } else {
                $('.n_dn_title').html('BẠN CẦN ĐĂNG NHẬP ỨNG VIÊN ĐỂ THỰC HIỆN THAO TÁC');
            }
            $('.background_login').toggle();
        } else {
            window.location = '/dang-tin';
        }
    });
    $('.btn_ttct').click(function() {
        var type = $('.type_login').val();
        if (type == 4) {
            $('.n_dn_title').html('BẠN CẦN ĐĂNG NHẬP NHÀ TUYỂN DỤNG ĐỂ THỰC HIỆN THAO TÁC');
        } else {
            $('.n_dn_title').html('BẠN CẦN ĐĂNG NHẬP ỨNG VIÊN ĐỂ THỰC HIỆN THAO TÁC');
        }
        $('.background_login').show();
    });
    $('.n_job_chat').click(function() {
        if ($(this).data('iduser') == '') {
            var type = $('.type_login').val();
            if (type == 4) {
                $('.n_dn_title').html('BẠN CẦN ĐĂNG NHẬP NHÀ TUYỂN DỤNG ĐỂ THỰC HIỆN THAO TÁC');
            } else {
                $('.n_dn_title').html('BẠN CẦN ĐĂNG NHẬP ỨNG VIÊN ĐỂ THỰC HIỆN THAO TÁC');
            }
            $('.background_login').toggle();
        }
    });
    $('.message_text').click(function() {
        if ($(this).data('iduser') == '') {
            var type = $('.type_login').val();
            if (type == 4) {
                $('.n_dn_title').html('BẠN CẦN ĐĂNG NHẬP NHÀ TUYỂN DỤNG ĐỂ THỰC HIỆN THAO TÁC');
            } else {
                $('.n_dn_title').html('BẠN CẦN ĐĂNG NHẬP ỨNG VIÊN ĐỂ THỰC HIỆN THAO TÁC');
            }
            $('.background_login').toggle();
        }
    });
    $('.n_btn_ut').click(function() {
        if ($(this).data('iduser') == '') {
            var type = $('.type_login').val();
            if (type == 4) {
                $('.n_dn_title').html('BẠN CẦN ĐĂNG NHẬP NHÀ TUYỂN DỤNG ĐỂ THỰC HIỆN THAO TÁC');
            } else {
                $('.n_dn_title').html('BẠN CẦN ĐĂNG NHẬP ỨNG VIÊN ĐỂ THỰC HIỆN THAO TÁC');
            }
            $('.background_login').toggle();
        } else {
            $('.btn_save_ut').data('ca', $(this).data('ca'));
            $('.popup_ung_tuyen_bg').toggle();
            if ($(this).data('ca') == 0) {
                $('.btn_save_ut').click();
                $('.btn_save_ut').hide();
            }
        }
    });
    $('.n_close_popup_dn').click(function() {
        $('.background_login').hide();
    });
    $(".form_login_page").validate({
        onclick: false,
        rules: {
            "email": {
                required: true,
                email: true,
            },
            "pass": {
                required: true,
            },
        },
        messages: {
            "email": {
                required: "Bạn chưa nhập email",
                email: "Email không đúng định dạng",
            },
            "pass": {
                required: "Bạn chưa nhập password",
            },
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "email") {
                $("#email-error-container").html(error);
            }
            if (element.attr("name") == "pass") {
                $("#pass-error-container").html(error);
            }
        },
        submitHandler: function() {
            var email = $('#email').val();
            var pass = $('#pass').val();
            var type = $('.type_login').val();
            var data = new FormData();
            data.append('email', email);
            data.append('pass', pass);
            data.append('type', type);
            $.ajax({
                url: '/login',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                data: data,
                beforeSend: function() {
                    $('#response').html("<img src='/images/loading.gif' />");
                },
                success: function(response) {
                    if (response.status == 1) {
                        window.location.reload();
                    } else {

                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert('Thất bại');
                }
            });
            return false;
        }
    });
});

function show_pass(e) {
    var input = $(e).parent().find('input');
    if (input.attr('type') == 'password') {
        $(e).attr('src', '/images/n_icon_open_eye.svg');
        input.attr('type', 'text');
    } else {
        $(e).attr('src', '/images/icon_see_pass.svg');
        input.attr('type', 'password');
    }
}