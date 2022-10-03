$('.btn_save_change').click(function() {
    flag = true;
    var regex_pass = /^(?!.* )(?=.*\d)(?=.*[a-zA-Z]).{6,16}$/;
    //password
    if ($('#new_password').val() == '') {
        $('.n_eror_pass').html('Không để trống mục này');
        flag = false;
        $("#new_password").parents('.new_password')[0].scrollIntoView();
    } else if (regex_pass.test($('#new_password').val()) == false) {
        $('.n_eror_pass').html('Mật khẩu  tối thiểu 6 ký tự gồm tối thiểu 1 chữ và 1 số, không chứa dấu cách');
        flag = false;
        $("#new_password").parents('.new_password')[0].scrollIntoView();
    } else {
        $('.n_eror_pass').html('');
    }

    //re-pass
    if ($('#rep_new_password').val() == '') {
        $('.n_eror_new_pass').html('Không để trống mục này');
        flag = false;
        $("#rep_new_password").parents('.new_password')[0].scrollIntoView();
    } else if ($('#rep_new_password').val() != $('#new_password').val()) {
        $('.n_eror_new_pass').html('Mật khẩu xác nhận chưa đúng.');
        flag = false;
        $("#rep_new_password").parents('.new_password')[0].scrollIntoView();
    } else {
        $('.n_eror_new_pass').html('');
    }
    if (flag == true) {
        var id = $('#id_email').attr('data-id');
        var type = $('#id_email').attr('data-type');
        var data = new FormData();
        data.append('new_password', $('#new_password').val());
        data.append('id', id);
        data.append('type', type);
        $.ajax({
            url: '/Ajax/change_pass',
            type: "POST",
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            data: data,
            success: function(data) {
                console.log(data);
                if (data.kq == true) {
                    window.location = '/doi-mat-khau-thanh-cong';
                } else {
                    alert(data.msg);
                }
            }
        })
    }

})
$(document).ready(function() {
    $('#changePass').ajaxForm(function() {});
});