$(document).ready(function() {
    $('#n_city').select2({
        width: '100%',
        placeholder: "Chọn tỉnh / thành phố",
    });
    $('#n_qh').select2({
        width: '100%',
        placeholder: "Chọn quận / huyện",
    });
    $('#n_cate').select2({
        width: 'inherit',
        placeholder: "Chọn tối đa 5 loại công việc ",
        maximumSelectionLength: 5,
    });
    $('#n_city_hope').select2({
        width: 'inherit',
        placeholder: "Chọn tối đa 3 nơi làm việc mong muốn",
        maximumSelectionLength: 3,
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



    $('#n_city_hope').change(function() {
        $.ajax({
            url: "/Ajax/getDistrict",
            type: 'GET',
            dataType: "json",
            data: {
                cit_id: $("#n_city_hope").val(),
            },
        });
    });



    $('.n_show_pwd').click(function() {
        if ($(this).children('.n_pwd_eye').attr('src') == '/images/n_icon_open_eye.svg') {
            $(this).children('.n_pwd_eye').attr('src', '/images/n_icon_close_eye.svg');
            $(this).parents('.n_dky_uv_col').children('.n_dky_uv_input').attr('type', 'text');
        } else {
            $(this).children('.n_pwd_eye').attr('src', '/images/n_icon_open_eye.svg');
            $(this).parents('.n_dky_uv_col').children('.n_dky_uv_input').attr('type', 'password');
        }
    });
    $('.n_tdow').click(function() {
        if (!$(this).hasClass('n_enable')) {
            $(this).toggleClass('n_tdow_pick');
            var mo = $('.n_mo.n_tdow_pick').length;
            var no = $('.n_no.n_tdow_pick').length;
            var ni = $('.n_ni.n_tdow_pick').length;
            if (mo == 7) {
                $('.checkbox_boder[time="mo"]').children('.checkbox_checked').show();
            } else {
                $('.checkbox_boder[time="mo"]').children('.checkbox_checked').hide();
            }
            if (no == 7) {
                $('.checkbox_boder[time="no"]').children('.checkbox_checked').show();
            } else {
                $('.checkbox_boder[time="no"]').children('.checkbox_checked').hide();
            }
            if (ni == 7) {
                $('.checkbox_boder[time="ni"]').children('.checkbox_checked').show();
            } else {
                $('.checkbox_boder[time="ni"]').children('.checkbox_checked').hide();
            }
        }
    });
    $('.checkbox_boder').click(function() {
        $(this).children('.checkbox_checked').toggle();
        var time = $(this).attr('time');
        if ($(this).children('.checkbox_checked').css('display') == 'block') {
            if (time == 'mo') {
                $('.n_mo').addClass('n_tdow_pick');
            } else if (time == 'no') {
                $('.n_no').addClass('n_tdow_pick');
            } else if (time == 'ni') {
                $('.n_ni').addClass('n_tdow_pick');
            } else {
                $('.n_tdow').addClass('n_enable');
                $('.n_ndow').addClass('n_enable');
            }
        } else {
            if (time == 'mo') {
                $('.n_mo').removeClass('n_tdow_pick');
            } else if (time == 'no') {
                $('.n_no').removeClass('n_tdow_pick');
            } else if (time == 'ni') {
                $('.n_ni').removeClass('n_tdow_pick');
            } else {
                $('.n_ndow').removeClass('n_enable');
                $('.n_tdow').removeClass('n_enable');
            }
        }
    });
    $('.n_dky_uv_btn').click(function() {
        // validate ca làm
        var status = $('input[name=status]:checked').val();
        var time = $('.n_enable').length;
        var regex_email = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var regex_tel = /^([0-9]{9,15})$/g;
        var flag = true;
        if (time == 0) {
            // ko chọn ca làm linh hoạt theo ntd
            var time = $('.n_tdow_pick').length;
            if (time > 0) {
                var ca_lam = [];
                $('.n_tdow_pick').each(function() {
                    ca_lam.push($(this).attr('value'));
                });
                $('.n_eror_ca_lam').html('');
            } else {
                $('.n_eror_ca_lam').html('Không để trống mục này.');
                flag = false;
            }
        } else {
            // ko chọn ca làm linh hoạt theo ntd
            ca_lam = -1;
            $('.n_eror_ca_lam').html('');
        }
        // validate tên
        if ($('#n_dky_name').val() == '') {
            $('.n_eror_name').html('Không để trống mục này.');
            flag = false;
            $("#n_dky_name").parents('.n_dky_uv_col')[0].scrollIntoView();
        } else {
            $('.n_eror_name').html('');
        }
        // validate email
        var email = $('#n_dky_email').val();
        var flag_email = false;
        if (email == '') {
            $('.n_eror_email').html('Không để trống mục này.');
            flag = false;
            $("#n_dky_email").parents('.n_dky_uv_col')[0].scrollIntoView();
        } else if (regex_email.test(email) == false) {
            $('.n_eror_email').html('Bạn chưa nhập đúng địch dạng email.');
            flag = false;
            $("#n_dky_email").parents('.n_dky_uv_col')[0].scrollIntoView();
        } else {
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
                    if (data.length > 0) {
                        $('.n_eror_email').html(data);
                        flag_email = false;
                    } else {
                        $('.n_eror_email').html(data);
                        flag_email = true;
                    }
                }
            });
        }

        // validate mật khẩu
        if ($('#n_dky_pwd').val() == '') {
            $('.n_eror_pwd').html('Không để trống mục này.');
            flag = false;
            $("#n_dky_pwd").parents('.n_dky_uv_col')[0].scrollIntoView();
        } else {
            $('.n_eror_pwd').html('');
        }
        // validate mật khẩu nhập lại
        if ($('#n_dky_re_pwd').val() == '') {
            $('.n_eror_re_pwd').html('Không để trống mục này.');
            flag = false;
            $("#n_dky_re_pwd").parents('.n_dky_uv_col')[0].scrollIntoView();
        } else if ($('#n_dky_re_pwd').val() != $('#n_dky_pwd').val()) {
            $('.n_eror_re_pwd').html('Mật khẩu xác nhận chưa đúng.');
            flag = false;
            $("#n_dky_re_pwd").parents('.n_dky_uv_col')[0].scrollIntoView();
        } else {
            $('.n_eror_re_pwd').html('');
        }
        // validate city
        if ($('#n_city').val() == '' || $('#n_city').val() == 0) {
            $('.n_eror_city').html('Không để trống mục này.');
            flag = false;
            $("#n_city").parents('.n_dky_uv_col')[0].scrollIntoView();
        } else {
            $('.n_eror_city').html('');
        }
        // validate qh
        if ($('#n_qh').val() == '' || $('#n_qh').val() == 0) {
            $('.n_eror_qh').html('Không để trống mục này.');
            flag = false;
            $("#n_qh").parents('.n_dky_uv_col')[0].scrollIntoView();
        } else {
            $('.n_eror_qh').html('');
        }
        // validate địa chỉ
        if ($('#n_addr').val() == '') {
            $('.n_eror_addr').html('Không để trống mục này.');
            flag = false;
            $("#n_addr").parents('.n_dky_uv_col')[0].scrollIntoView();
        } else {
            $('.n_eror_addr').html('');
        }
        // validate cate
        if ($('#n_cate').val() == '') {
            $('.n_eror_cate').html('Không để trống mục này.');
            flag = false;
            $("#n_cate").parents('.n_dky_uv_col')[0].scrollIntoView();
        } else {
            $('.n_eror_cate').html('');
        }
        // validate công việc
        if ($('#n_cv').val() == '') {
            $('.n_eror_cv').html('Không để trống mục này.');
            flag = false;
            $("#n_cv").parents('.n_dky_uv_col')[0].scrollIntoView();
        } else {
            $('.n_eror_cv').html('');
        }
        // validate city hope
        if ($('#n_city_hope').val() == '') {
            $('.n_eror_city_hope').html('Không để trống mục này.');
            flag = false;
            $("#n_city_hope").parents('.n_dky_uv_col')[0].scrollIntoView();
        } else {
            $('.n_eror_city_hope').html('');
        }
        // validate phone
        if ($('#n_tel').val() == '') {
            $('.n_eror_tel').html('Không để trống mục này.');
            flag = false;
            $("#n_tel").parents('.n_dky_uv_col')[0].scrollIntoView();
        } else if (regex_tel.test($('#n_tel').val()) == false) {
            $('.n_eror_tel').html('Bạn chưa nhập đúng định dạng số điện thoại.');
            flag = false;
            $("#n_tel").parents('.n_dky_uv_col')[0].scrollIntoView();
        } else {
            $('.n_eror_tel').html('');
        }

        //validate trạng thái tài khoản
        if (status == undefined) {
            $('.n_status_error').html('Không để trống mục này');
            flag = false;
        } else {
            $('.n_status_error').html('');
        }
        // đăng ký
        // console.log(flag);
        // console.log(flag_email);

        var file_data = $('#up_photo')[0].files[0];
        // console.log(file_data);
        if (flag == true && flag_email == true) {
            var data = new FormData();
            data.append('avatar', file_data);
            data.append('n_dky_name', $('#n_dky_name').val());
            data.append('n_dky_email', $('#n_dky_email').val());
            data.append('n_dky_pwd', $('#n_dky_pwd').val());
            data.append('n_city', $('#n_city').val());
            data.append('n_qh', $('#n_qh').val());
            data.append('n_addr', $('#n_addr').val());
            data.append('n_cate', $('#n_cate').val());
            data.append('n_cv', $('#n_cv').val());
            data.append('n_city_hope', $('#n_city_hope').val());
            data.append('n_tel', $('#n_tel').val());
            data.append('ca_lam', ca_lam);
            data.append('status', status);
            console.log(data);
            $.ajax({
                url: '/admin/Submit_form/candidate_add',
                type: "POST",
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                data: data,
                success: function(data) {
                    console.log(data);
                    if (data.kq == true) {
                        window.location.href = '/admin/candidate/list';
                    }
                }
            })
        }
    });
});

function loadFile(event) {
    // var loadFile = function(event) {
    var preview_logo = document.getElementById('preview_logo');
    var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/jfif", "image/PNG"];
    var file_data = $('#up_photo').prop('files')[0];
    if (file_data != undefined) {
        var type = file_data.type;
        var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/jfif", "image/PNG"];
        if (type == match[0] || type == match[1] || type == match[2] || type == match[3] || type == match[4] || type == match[5]) {
            preview_logo.src = URL.createObjectURL(event.target.files[0]);
        } else {
            alert('Bạn chỉ được upload file ảnh');
            return false;
        }
    }
    // };
}