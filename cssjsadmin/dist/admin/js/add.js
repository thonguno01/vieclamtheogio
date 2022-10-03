function loadFile(event) {
    // var loadFile = function(event) {
    var preview_logo = document.getElementById('preview_logo');
    var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/jfif", "image/PNG"];
    var file_data = $('#up_photo').prop('files')[0];
    if (file_data != undefined) {
        var type = file_data.type;
        var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/jfif", "image/PNG"];
        if (type == match[0] || type == match[1] || type == match[2] || type == match[3] || type == match[4] || type == match[5]) {
            if (file_data.size <= 2097152) {
                preview_logo.src = URL.createObjectURL(event.target.files[0]);
            } else {
                alert('Bạn chỉ được upload file dưới 2MB');
                return false;
            }
        } else {
            alert('Bạn chỉ được upload file ảnh');
            return false;
        }
    }
    // };
}
$(document).ready(function() {
    $('.add_new').click(function() {
        var regex_email = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var regex_number = /((84|\+84|0)+([0-9]{9,14})\b)/;
        var flag = true;
        var username = $('.username_admin').val();

        //validate username
        if (username == '') {
            $('.n_eror_name').html('Không để trống mục này.');
            flag = false;
        } else {
            $.ajax({
                url: '/admin/Submit_form/username_admin',
                type: "POST",
                dataType: "JSON",
                async: false,
                data: {
                    username_admin: username,
                },
                success: function(data) {
                    console.log(data.length);
                    if (data.length > 0) {
                        $('.n_eror_username').html('Username đã tồn tại.');
                        flag_name = false;
                    } else {
                        $('.n_eror_username').html('');
                        flag_name = true;
                    }
                }
            });
        }

        //validate name
        if ($('.name_admin').val() == '') {
            $('.n_eror_name').html('Không để trống mục này.');
            flag = false;
        } else {
            $('.n_eror_name').html('');
        }

        //validate email
        var email = $('.email_admin').val();
        var flag_mail = false;
        if (email == '') {
            $('.n_eror_email').html('Không để trống mục này.');
            flag = false;
        } else if (regex_email.test(email) == false) {
            $('.n_eror_email').html('Bạn chưa nhập đúng địch dạng email.');
            flag = false;
        } else {
            $.ajax({
                url: '/admin/Submit_form/email_admin',
                type: "POST",
                dataType: "JSON",
                async: false,
                data: {
                    email_admin: email,
                },
                success: function(data) {
                    console.log(data.length);
                    if (data.length > 0) {
                        $('.n_eror_email').html('Email đã tồn tại.');
                        flag_mail = false;
                    } else {
                        $('.n_eror_email').html('');
                        flag_mail = true;
                    }
                }
            });
        }


        //password
        if ($('.pass_admin').val() == '') {
            $('.n_eror_pass').html('Không để trống mục này');
            flag = false;
        } else {
            $('.n_eror_pass').html('');
        }
        //re_pass
        if ($('.re_pass_admin').val() == '') {
            $('.n_eror_repass').html('Không để trống mục này');
            flag = false;
        } else if ($('.re_pass_admin').val() != $('.pass_admin').val()) {
            $('.n_eror_rep_pass').html('Mật khẩu xác nhận chưa đúng.');
            flag = false;
        } else {
            $('.n_eror_rep_pass').html('');
        }

        //validate sđt
        if ($('.phone_admin').val() == '') {
            $('.n_eror_phone').html('Không để trống mục này');
            flag = false;
        } else if (regex_number.test($('.phone_admin').val()) == false) {
            $('.n_eror_phone').html('Bạn chưa nhập đúng định dạng số điện thoại.');
            flag = false;
        } else {
            $('.n_eror_phone').html('');
        }

        if (flag == true && flag_mail == true) {
            var data = new FormData;
            data.append('avatar', $('#up_photo')[0].files[0]);
            data.append('name', $('.name_admin').val());
            data.append('username_admin', username);
            data.append('password', $('.pass_admin').val());
            data.append('email_admin', email);
            data.append('phone', $('.phone_admin').val());
            $.ajax({
                url: '/admin/Submit_form/add_admin',
                type: "POST",
                dataType: "JSON",
                async: false,
                contentType: false,
                cache: false,
                processData: false,
                data: data,
                success: function(data) {
                    alert(data.msg);
                    if (data.kq == true) {
                        window.location.href = '/admin/list_admin';
                    }
                }
            });
        }
    })
})