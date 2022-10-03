function loadFile(event) {
    // var loadFile = function(event) {
    var preview_logo = document.getElementById('preview_logo');
    var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/jfif", "image/PNG"];
    var file_data = $('#up_photo').prop('files')[0];
    if (file_data != undefined) {
        var type = file_data.type;
        var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/jfif", "image/PNG"];
        if (type == match[0] || type == match[1] || type == match[2] || type == match[3] || type == match[4] || type == match[5]) {
            if (file_data.size <= 8000000) {
                preview_logo.src = URL.createObjectURL(event.target.files[0]);
            } else {
                alert('Bạn chỉ được upload file dưới 8MB');
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
    $('#n_city').select2({
        width: '100%',
        placeholder: "Chọn tỉnh / thành phố",
    });
    $('#n_qh').select2({
        width: '100%',
        placeholder: "Chọn quận / huyện",
    });

    $('#n_city').change(function() {
        $.ajax({
            url: "/Ajax/getDistrict",
            type: 'GET',
            dataType: "json",
            data: {
                cit_id: $("#n_city").val(),
            },
            success: function(result) {
                if (result.length >= 0) {
                    var i = 0;
                    var html = "<option value=''>Chọn quận huyện</option>";

                    for (i = 0; i < result.length; i++) {
                        html += `<option value="` + result[i].cit_id + `">` + result[i].cit_name + `</option>`;
                    }
                    $('#n_qh').html(html);
                }
            },
            error: function(request, status, error) {
                var val = request.responseText.replace('gi', '');
                val = JSON.parse(val);
                var html = "<option value=''>Chọn quận huyện</option>";
                for (i = 0; i < val.length; i++) {
                    html = html + '<option value="' + val[i].cit_id + '">' + val[i].cit_name + '</option>';
                }
                $('#district').html(html);
            }
        });
    });

    $('.n_show_pwd').click(function() {
        if ($(this).children('.n_pwd_eye').attr('src') == '/images/n_icon_open_eye.svg') {
            $(this).children('.n_pwd_eye').attr('src', '/images/n_icon_close_eye.svg');
            $(this).parents('.dky_ntd_info').children('.pwd_ntd').attr('type', 'text');
        } else {
            $(this).children('.n_pwd_eye').attr('src', '/images/n_icon_open_eye.svg');
            $(this).parents('.dky_ntd_info').children('.pwd_ntd').attr('type', 'password');
        }
    });


    $('.submit_form_ntd').click(function(e) {
        e.preventDefault();
        var regex_email = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var regex_number = /((84|\+84|0)+([0-9]{9,14})\$)/g;
        var flag = true;
        // validate tên
        var flag_name = false;
        var name = $('#ntd_name').val().trim();
        if (name == '') {
            $('.n_eror_name').html('Không để trống mục này.');
            flag = false;
            $("#ntd_name").parents('.dky_ntd_info')[0].scrollIntoView();
        } else if (checkkitu(name) == true) {
            $('.n_eror_name').html('Tên doanh nghiệp/Người tuyển dụng chỉ chứa 1 số ký tự đặc biệt :  *  ( ) .  \' - & .');
            flag = false;
            $("#ntd_name").parents('.dky_ntd_info')[0].scrollIntoView();
        } else {
            $.ajax({
                url: '/Ajax/alias_ntd',
                type: "POST",
                dataType: "JSON",
                async: false,
                data: {
                    ntd_name: name,
                },
                success: function(data) {
                    if (data.length > 0) {
                        $('.n_eror_name').html('Tên đã tồn tại.');
                        $("#ntd_name").parents('.dky_ntd_info')[0].scrollIntoView();
                        flag_name = false;
                    } else {
                        $('.n_eror_name').html('');
                        flag_name = true;
                    }
                }
            });
        }
        // validate địa chỉ
        if ($('#ntd_address').val().trim() == '') {
            $('.n_eror_address').html('Không để trống mục này.');
            flag = false;
            $("#ntd_address").parents('.dky_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_address').html('');
        }

        // validate qh
        if ($('#n_qh').val() == '' || $('#n_qh').val() == 0) {
            $('.n_eror_qh').html('Không để trống mục này.');
            flag = false;
            $("#n_qh").parents('.dky_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_qh').html('');
        }

        // validate city
        if ($('#n_city').val() == '' || $('#n_city').val() == 0) {
            $('.n_eror_city').html('Không để trống mục này.');
            flag = false;
            $("#n_city").parents('.dky_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_city').html('');
        }

        //re-pass
        if ($('#ntd_repass').val() == '') {
            $('.n_eror_repass').html('Không để trống mục này');
            flag = false;
            $("#ntd_repass").parents('.dky_ntd_info')[0].scrollIntoView();
        } else if ($('#ntd_repass').val() != $('#ntd_password').val()) {
            $('.n_eror_repass').html('Mật khẩu xác nhận chưa đúng.');
            flag = false;
            $("#ntd_repass").parents('.dky_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_repass').html('');
        }

        //password
        var regex_pass = /^(?!.* )(?=.*\d)(?=.*[a-zA-Z]).{6,16}$/;
        if ($('#ntd_password').val() == '') {
            $('.n_eror_pass').html('Không để trống mục này');
            flag = false;
            $("#ntd_password").parents('.dky_ntd_info')[0].scrollIntoView();
        } else if (regex_pass.test($('#ntd_password').val()) == false) {
            $('.n_eror_pass').html(' Mật khẩu  tối thiểu 6 ký tự gồm tối thiểu 1 chữ và 1 số, không chứa dấu cách');
            flag = false;
            $("#ntd_password").parents('.dky_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_pass').html('');
        }

        var flag_phone = true;
        var regex_tel = /^((84|\+84|0)+[0-9]{9,14})$/g;
        //validate sđt
        if ($('#ntd_number').val() == '') {
            $('.n_eror_number').html('Không để trống mục này');
            flag_phone = false;
            $("#ntd_number").parents('.dky_ntd_info')[0].scrollIntoView();
        } else if (regex_tel.test($('#ntd_number').val()) == false) {
            $('.n_eror_number').html('Bạn chưa nhập đúng định dạng số điện thoại.');
            flag = false;
            $("#ntd_number").parents('.n_dky_uv_col')[0].scrollIntoView();
        } else {
            $('.n_eror_number').html('');
        }

        // validate email
        var email = $('#ntd_email').val();
        var flag_mail = false;
        if (email == '') {
            $('.n_eror_email').html('Không để trống mục này.');
            flag = false;
            $("#ntd_email").parents('.dky_ntd_info')[0].scrollIntoView();
        } else if (regex_email.test(email) == false) {
            $('.n_eror_email').html('Bạn chưa nhập đúng địch dạng email.');
            flag = false;
            $("#ntd_email").parents('.dky_ntd_info')[0].scrollIntoView();
        } else {
            $.ajax({
                url: '/Ajax/email_ntd',
                type: "POST",
                dataType: "JSON",
                async: false,
                data: {
                    email: email,
                },
                success: function(data) {
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
        // console.log($('#up_photo')[0].files[0]);
        if (flag == true && flag_mail == true && flag_name == true && flag_phone == true) {
            var data = new FormData;
            data.append('ntd_email', $('#ntd_email').val());
            data.append('ntd_number', $('#ntd_number').val());
            data.append('ntd_password', $('#ntd_password').val());
            data.append('n_city', $('#n_city').val());
            data.append('n_qh', $('#n_qh').val());
            data.append('ntd_address', $('#ntd_address').val());
            data.append('ntd_name', $('#ntd_name').val());
            data.append('avatar', $('#up_photo')[0].files[0]);

            $.ajax({
                url: '/Ajax/dang_ky_ntd',
                type: "POST",
                dataType: "JSON",
                async: false,
                contentType: false,
                cache: false,
                processData: false,
                data: data,
                success: function(data) {
                    console.log(data);
                    if (data.kq == true) {
                        window.location = '/gui-mail-xac-thuc-tai-khoan-nha-tuyen-dung';
                    }
                }
            });
        } else if (flag_mail == true || flag_phone == true) {
            var data = new FormData;
            data.append('ntd_company', $('#ntd_name').val());
            data.append('ntd_phone', $('#ntd_number').val());
            data.append('ntd_email', $('#ntd_email').val());
            $.ajax({
                url: '/Ajax/ntd_loi',
                type: "POST",
                dataType: "JSON",
                async: false,
                contentType: false,
                cache: false,
                processData: false,
                data: data,
                beforeSend: function() {
                    console.log('????/');

                },
                success: function(data) {
                    console.log('????/1');

                },
                error: function(xhr) {
                    console.log(xh);

                },
            })
        }

    });

    $("#ntd_email").blur(function() {
        var regex_email = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        let email = $("#ntd_email").val();
        $.ajax({
            url: '/Ajax/email_ntd',
            type: "POST",
            dataType: "JSON",
            async: false,
            data: {
                email: email,
            },
            success: function(data) {
                if (data.length > 0) {
                    $('.n_eror_email').html('Email đã tồn tại.');
                    flag_mail = false;
                } else if (regex_email.test(email) == false) {
                    $('.n_eror_email').html('Bạn chưa nhập đúng địch dạng email.');
                    flag_mail = false;
                } else {
                    $('.n_eror_email').html('');
                    flag_mail = true;
                }
            }
        });
    });
})


function checkkitu(str) {
    let regex = /[<>{}\"\-/|;:+~!?@#$%^=\\_]/;
    return regex.test(str);
}