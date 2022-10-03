$(document).ready(function() {
    $('.btn_change_pass').click(function() {
        var flag = true;
        var pass = $('#old_password').val();
        var new_pass = $('#new_password').val();
        var new_repass = $('#rep_new_password').val();
        var flag_pass = false;
        var regex_pass = /^(?!.* )(?=.*\d)(?=.*[a-zA-Z]).{6,16}$/

        if ($('#old_password').val() == '') {
            $('.n_eror_pass').html('Không để trống mục này');
            flag = false;
        } else {
            $.ajax({
                url: '/Ajax/check_pass_ntd',
                type: "POST",
                dataType: "JSON",
                async: false,
                data: {
                    ntd_pass: pass,
                },
                success: function(data) {
                    console.log(data.length);
                    if (data.length > 0) {
                        $('.n_eror_pass').html('');
                    } else {
                        $('.n_eror_pass').html('Mật khẩu hiện tại chưa chính xác');
                        flag = false;
                    }
                }
            });
        }


        if (new_pass == '') {
            $('.n_eror_new_pass').html('Không để trống mục này');
            flag = false;
        } else if (new_pass == pass) {
            $('.n_eror_new_pass').html('Mật khẩu mới không được giống mật khẩu hiện tại');
            flag = false;
        } else if (regex_pass.test(new_pass) == false) {
            $('.n_eror_new_pass').html(' Mật khẩu  tối thiểu 6 ký tự gồm tối thiểu 1 chữ và 1 số, không chứa dấu cách');
            flag = false;
        } else {
            $('.n_eror_new_pass').html('');
        }

        //re-pass
        if (new_repass == '') {
            $('.n_eror_rep_new_pass').html('Không để trống mục này');
            flag = false;
        } else if (new_pass != new_repass) {
            $('.n_eror_rep_new_pass').html('Mật khẩu xác nhận chưa đúng.');
            flag = false;
        } else {
            $('.n_eror_rep_new_pass').html('');
        }

        if (flag == true) {
            var data = new FormData();
            data.append('n_pass', $('#old_password').val());
            data.append('n_new_pass', $('#new_password').val());
            data.append('n_new_repass', $('#rep_new_password').val());
            console.log(data);
            $.ajax({
                url: '/Ajax/doi_mat_khau_ntd',
                type: "POST",
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                data: data,
                success: function(data) {
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

    })
    $('.n_show_pwd').click(function() {
        if ($(this).children('.n_pwd_eye').attr('src') == '/images/n_icon_open_eye.svg') {
            $(this).children('.n_pwd_eye').attr('src', '/images/n_icon_close_eye.svg');
            $(this).prev('.pwd').attr('type', 'text');
        } else {
            $(this).children('.n_pwd_eye').attr('src', '/images/n_icon_open_eye.svg');
            $(this).prev('.pwd').attr('type', 'password');
        }
    });
});