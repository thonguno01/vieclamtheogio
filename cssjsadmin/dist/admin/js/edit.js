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
    $('.add_update').click(function() {
        var regex_number = /((84|\+84|0)+(9|8|7|5|3)+([0-9]{8})\b)/;
        var flag = true;

        //validate name
        if ($('.name_admin').val() == '') {
            $('.n_eror_name').html('Không để trống mục này.');
            flag = false;
        } else {
            $('.n_eror_name').html('');
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

        if (flag == true) {
            var data = new FormData;
            data.append('name', $('.name_admin').val());
            data.append('password', $('.pass_admin').val());
            data.append('phone', $('.phone_admin').val());
            data.append('id_admin', $('.id_admin').val());
            $.ajax({
                url: '/admin/Submit_form/edit_admin',
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