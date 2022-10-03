$(document).ready(function() {
    $('.n_dmk_btn').click(function() {
        var flag = true;
        var pass = $('.n_pass').val();
        var new_pass = $('.n_new_pass').val();
        var new_repass = $('.n_new_repass').val();
        var flag_pass = false;
        var regex_pass = /^(?!.* )(?=.*\d)(?=.*[a-zA-Z]).{6,16}$/;

        if (pass == '') {
            $('.n_pass_error').html('Không để trống mục mày');
            flag = false;
        } else {
            $.ajax({
                url: '/Ajax/check_old_pass',
                type: "POST",
                dataType: "JSON",
                async: false,
                data: {
                    uv_pass: pass,
                },
                success: function(data) {
                    console.log(data.length);
                    if (data.length > 0) {
                        $('.n_pass_error').html('');
                    } else {
                        $('.n_pass_error').html('Mật khẩu hiện tại chưa chính xác');
                        flag = false;
                    }
                }
            });
        }

        if (new_pass == '') {
            $('.n_new_pass_error').html('Không để trống mục mày');
            flag = false;
        } else if (new_pass == pass) {
            $('.n_new_pass_error').html('Mật khẩu mới không được giống mật khẩu hiện tại');
            flag = false;
        } else if (regex_pass.test(new_pass) == false) {
            $('.n_new_pass_error').html(' Mật khẩu  tối thiểu 6 ký tự gồm tối thiểu 1 chữ và 1 số, không chứa dấu cách');
            flag = false;
        } else {
            $('.n_new_pass_error').html('');
        }

        if (new_repass == '') {
            $('.n_new_repass_error').html('Không để trống mục mày');
            flag = false;
        } else if (new_pass != new_repass) {
            $('.n_new_repass_error').html('Mật khẩu xác nhận không đúng');
            flag = false;
        } else {
            $('.n_new_repass_error').html('');
        }

        if (flag == true) {
            var data = new FormData();
            data.append('n_pass', $('.n_pass').val());
            data.append('n_new_pass', $('.n_new_pass').val());
            data.append('n_new_repass', $('.n_new_repass').val());
            console.log(data);
            $.ajax({
                url: '/Ajax/doi_mat_khau_ung_vien',
                type: "POST",
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                data: data,
                success: function(data) {
                    console.log(data);
                    if (data.kq == true) {
                        $('.changepass_success').show();
                        $('.btn_stay').click(function() {
                            window.location.reload();
                        });
                        $('.btn_home').click(function() {
                            window.location = '/';
                        });
                    }
                }
            })


        }

    });
    $('.n_show_pwd').click(function() {
        if ($(this).children('.n_pwd_eye').attr('src') == '/images/n_icon_open_eye.svg') {
            $(this).children('.n_pwd_eye').attr('src', '/images/n_icon_close_eye.svg');
            $(this).prev('.n_dkm_input').attr('type', 'text');
        } else {
            $(this).children('.n_pwd_eye').attr('src', '/images/n_icon_open_eye.svg');
            $(this).prev('.n_dkm_input').attr('type', 'password');
        }
    });
});