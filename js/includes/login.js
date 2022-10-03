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
$(document).ready(function() {
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
            var regex_email = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var flag = true;
            var email = $('#email').val();
            var pass = $('#pass').val();
            var type = $('.type_login').val();
            var data = new FormData();
            data.append('email', email);
            data.append('pass', pass);
            data.append('type', type);
            if (regex_email.test(email) == false) {
                $('#email-error-container').html('Bạn chưa nhập đúng địch dạng email.');
                flag = false;
            }
            if (flag == true) {

                $.ajax({
                    url: '/login',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    data: data,
                    beforeSend: function() {
                        $('#response').html("<img src='/images/loading.gif'/>");
                    },
                    success: function(response) {
                        if (response.status == 1) {
                            window.location = '/quan-ly-chung-ntd';
                        } else if (response.status === false) {
                            alert(response.message);
                        } else if (response.status == 0) {
                            alert(response.message);
                            $.ajax({
                                url: '/Ajax/re_send_email_ntd',
                                type: "POST",
                                dataType: "JSON",
                                async: false,
                                data: {},
                                success: function(res) {

                                }
                            });
                            window.location = '/gui-mail-xac-thuc-tai-khoan-nha-tuyen-dung';
                        }
                    },
                    error: function(xhr) {
                        alert('Thất bại');

                    }
                });
            } else {
                alert('Thông tin tài khoản và mật khẩu quý khách không đúng! Vui lòng nhập lại email và password')
            }
            return false;
        }
    });
})