$(document).ready(function() {
    $("#admin-login").validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            "username": {
                required: true,
            },
            "password": {
                required: true,
            },
        },
        messages: {
            "username": {
                required: "Bạn chưa nhập email",
            },
            "password": {
                required: "Bạn chưa nhập password",
            },
        },
        submitHandler: function() {
            var admin_user = $('.admin_user').val();
            var password = $('.admin_pass').val();
            var data = new FormData();
            data.append('admin_user', admin_user);
            data.append('password', password);
            $.ajax({
                url: '/admin/Submit_form/login',
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