function show_pass(e) {
    var input = $(e).parent().find('input');

    if (input.attr('type') == 'password') {
        $(e).attr('src', '/images/icon_see_pass.svg');
        input.attr('type', 'text');
    } else {
        $(e).attr('src', '/images/n_icon_open_eye.svg');
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
                        window.location = '/quan-ly-chung-ung-vien';
                    } else if (response.status === false) {
                        alert(response.message);
                    } else if (response.status == 0) {
                        $.ajax({
                            url: '/Ajax/re_send_email_uv',
                            type: "POST",
                            dataType: "JSON",
                            async: false,
                            data: {
                                n_dky_email: email,
                            },
                            success: function(res) {

                            }

                        })
                        window.location = '/gui-mail-xac-thuc-tai-khoan-ung-vien';
                    }
                },
                error: function(xhr) {
                    alert('Thất bại');

                }
            });
            return false;
        }
    });
})