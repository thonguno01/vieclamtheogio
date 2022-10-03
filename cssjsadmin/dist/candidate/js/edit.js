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

    $.ajax({
        url: "/Ajax/getDistrict",
        type: 'GET',
        dataType: "json",
        data: {
            cit_id: $("#n_city").val(),
        },
        success: function(result) {
            if (result.length >= 0) {
                var qh = $("#n_qh").attr('qh_id');
                console.log(qh);
                var i = 0;
                var html = "<option value=''>Chọn quận huyện</option>";

                for (i = 0; i < result.length; i++) {
                    if (result[i].cit_id == qh) {
                        html += `<option selected value="` + result[i].cit_id + `">` + result[i].cit_name + `</option>`;
                    } else {
                        html += `<option value="` + result[i].cit_id + `">` + result[i].cit_name + `</option>`;
                    }
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


    $('.update_user_admin').click(function() {
        var name = $('#n_dky_name').val();
        var tel = $('#n_tel').val();
        var status = $('input[name=status]:checked').val();
        var regex_tel = /((84|\+84|0)+(9|8|7|5|3)+([0-9]{8})\b)/;
        var flag = true;
        //validate_phone
        if (tel == '') {
            $('.n_eror_tel').html('Không để trống mục này');
            flag = false;
        } else if (regex_tel.test(tel) == false) {
            $('.n_eror_tel').html('Bạn chưa nhập đúng định dạng số điện thoại');
            flag = false;
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

        // validate city
        if ($('#n_city').val() == '' || $('#n_city').val() == 0) {
            $('.n_eror_city').html('Không để trống mục này.');
            flag = false;
        } else {
            $('.n_eror_city').html('');
        }
        // validate qh
        if ($('#n_qh').val() == '' || $('#n_qh').val() == 0) {
            $('.n_eror_qh').html('Không để trống mục này.');
            flag = false;
        } else {
            $('.n_eror_qh').html('');
        }
        // validate địa chỉ
        if ($('#n_addr').val() == '') {
            $('.n_eror_addr').html('Không để trống mục này.');
            flag = false;
        } else {
            $('.n_eror_addr').html('');
        }
        // validate cate
        if ($('#n_cate').val() == '') {
            $('.n_eror_cate').html('Không để trống mục này.');
            flag = false;
        } else {
            $('.n_eror_cate').html('');
        }
        // validate công việc
        if ($('#n_cv').val() == '') {
            $('.n_eror_cv').html('Không để trống mục này.');
            flag = false;
        } else {
            $('.n_eror_cv').html('');
        }
        // validate city hope
        if ($('#n_city_hope').val() == '') {
            $('.n_eror_city_hope').html('Không để trống mục này.');
            flag = false;
        } else {
            $('.n_eror_city_hope').html('');
        }



        if (flag == true) {
            var data = new FormData();
            data.append('n_name', name);
            data.append('status', status);
            data.append('n_tel', tel);
            data.append('n_city', $('#n_city').val());
            data.append('n_qh', $('#n_qh').val());
            data.append('n_addr', $('#n_addr').val());
            data.append('n_cate', $('#n_cate').val());
            data.append('n_cv', $('#n_cv').val());
            data.append('n_city_hope', $('#n_city_hope').val());
            data.append('id_candidate', $('.id_candidate').val());
            data.append('time_avatar', $('.time_avatar').val())
            console.log(data);
            $.ajax({
                url: '/admin/Submit_form/candidate_edit',
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
        };

    })
})