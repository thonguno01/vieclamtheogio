$('.btn_save_change').click(function() {
    var regex_email = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var flag = true
    var flag_email = false;
    var email = $('#send_email').val();
    // validate email
    if ($('#send_email').val() == '') {
        $('.n_eror_email').html('Không để trống mục này.');
        flag = false;
        $("#send_email").parents('.dky_ntd_info')[0].scrollIntoView();
    } else if (regex_email.test($('#send_email').val()) == false) {
        $('.n_eror_email').html('Bạn chưa nhập đúng định dạng email.');
        flag = false;
        $("#send_email").parents('.dky_ntd_info')[0].scrollIntoView();
    } else {
        console.log(email);
        $.ajax({
            url: '/Ajax/email_uv',
            type: "POST",
            dataType: "JSON",
            async: false,
            data: {
                n_dky_email: email,
            },
            success: function(data) {
                console.log(data.length);
                if (data.length == 0) {
                    $('.n_eror_email').html('Email không tồn tại');
                    flag_email = false
                } else {
                    $('.n_eror_email').html('');
                    flag_email = true;

                }
            }
        });
    }

    if (flag == true && flag_email == true) {
        var id = $('#id_email').attr('data-id');
        var data = new FormData();
        data.append('send_email', $('#send_email').val());
        data.append('uv_id', id);
        console.log(data);
        $.ajax({
            url: '/Ajax/email_reset_pass_uv',
            type: "POST",
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            data: data,
            success: function(data) {
                console.log(data);
                if (data.kq == true) {
                    window.location = '/gui-email-quen-mat-khau-ung-vien';
                }
            }
        });
    }
})
$(document).ready(function() {
    $('#restorePass').ajaxForm(function() {});
});