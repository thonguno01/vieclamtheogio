$(document).ready(function() {
    $("#admin_change_pass").validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            "password_old": {
                required: true,
                remote: {
                    url: '/admin/Submit_form/admin_check_pass',
                    type: 'post',
                }
            },
            "password": {
                required: true,
            },
            "password_confirmation": {
                equalTo: "#password",
            },
        },
        messages: {
            "password_old": {
                required: "Bạn chưa nhập mật khẩu cũ",
                remote: " Mật khẩu cũ chưa chính xác"
            },
            "password": {
                required: "Bạn chưa nhập password",
            },
            "password_confirmation": {
                equalTo: "Mật khẩu xác nhận chưa đúng",
            },

        },
        submitHandler: function() {
            var password = $('#password').val();
            var data = new FormData();
            data.append('password', password);
            $.ajax({
                url: '/admin/Submit_form/admin_change_pass',
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
                    // alert(response.status);
                    window.location = '/admin/home';
                },
                error: function(xhr) {
                    alert('Thất bại');

                }
            });
            return false;
        }
    });
})