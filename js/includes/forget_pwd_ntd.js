$('.btn_save_change').click(function() {
    var regex_email = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var flag = true
    var email = $('#send_email').val();
    if ($('#send_email').val() == '') {
        $('.n_eror_email').html('Không để trống mục này.');
        flag = false;
        $("#send_email").parents('.dky_ntd_info')[0].scrollIntoView();
    } else if (regex_email.test($('#send_email').val()) == false) {
        $('.n_eror_email').html('Bạn chưa nhập đúng định dạng email.');
        flag = false;
        $("#send_email").parents('.dky_ntd_info')[0].scrollIntoView();
    } else {
        $.ajax({
            url: '/Ajax/email_ntd',
            type: "POST",
            dataType: "JSON",
            data: {
                email: email,
            },
            success: function(data) {
                console.log(data.length);
                if (data.length == 0) {
                    $('.n_eror_email').html('Email không tồn tại');
                } else {
                    $('.n_eror_email').html('');
                    var data = new FormData();
                    data.append('send_email', $('#send_email').val());
                    console.log(data);
                    $.ajax({
                        url: '/Ajax/email_reset_pass_ntd',
                        type: "POST",
                        dataType: "JSON",
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: data,
                        success: function(data) {
                            console.log(data);
                            if (data.kq == true) {
                                window.location = '/gui-email-quen-mat-khau-nha-tuyen-dung';
                            }
                        }
                    });
                }
            }
        });
    }
})
$(document).ready(function() {
    $('#restorePass').ajaxForm(function() {});
});