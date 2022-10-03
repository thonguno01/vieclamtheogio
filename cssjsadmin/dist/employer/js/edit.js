function upFile(event) {
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

    $('.btn_update_thong_tin').click(function() {

        //khai báo
        var regex_number = /((84|\+84|0)+(9|8|7|5|3)+([0-9]{8})\b)/;

        var flag = true;

        //validate tên
        if ($('#ntd_name').val() == '') {
            $('.n_eror_name').html('Không để trống mục này');
            flag = false;
            $("#ntd_name").parents('.thong_tin_info')[0].scrollIntoView();
        } else {
            $('.n_eror_name').html('');
        }

        // validate city
        if ($('#n_city').val() == '' || $('#n_city').val() == 0) {
            $('.n_eror_city').html('Không để trống mục này.');
            flag = false;
            $("#n_city").parents('.thong_tin_info')[0].scrollIntoView();
        } else {
            $('.n_eror_city').html('');
        }

        // validate qh
        if ($('#n_qh').val() == '' || $('#n_qh').val() == 0) {
            $('.n_eror_qh').html('Không để trống mục này.');
            flag = false;
            $("#n_qh").parents('.thong_tin_info')[0].scrollIntoView();
        } else {
            $('.n_eror_qh').html('');
        }

        //validate địa chỉ
        if ($('#ntd_dia_chi').val() == '') {
            $('.n_eror_address').html('Không để trống mục này.');
            flag = false;
            $("#ntd_dia_chi").parents('.dcct_form')[0].scrollIntoView();
        } else {
            $('.n_eror_address').html('');
        }


        //validate số điện thoại
        if ($('#ntd_tel').val() == '') {
            $('.n_eror_tel').html('Không để trống mục này');
            flag = false;
            $("#ntd_tel").parents('.thong_tin_info')[0].scrollIntoView()
        } else {
            if (regex_number.test($('#ntd_tel').val()) == false) {
                $('.n_eror_tel').html('Bạn chưa nhập đúng định dạng số điện thoại.');
                flag = false;
                $("#ntd_tel").parents('.thong_tin_info')[0].scrollIntoView();
            } else {
                $('.n_eror_tel').html('');

            }
        }

        //phương thức liên lạc
        var zalo = $('#n_zalo').val();
        var sky = $('#n_skype').val();

        if (zalo == '' && sky == '') {
            $('.n_eror_ptlh').html('Vui lòng điền 1 trong 2');
        } else {
            if (zalo != "") {
                console.log(regex_number.test(zalo));
                console.log(regex_number.test(zalo));
                if (regex_number.test(zalo) == false) {
                    $('.n_eror_ptlh').html('Bạn chưa nhập đúng định dạng số điện thoại.');

                } else {
                    $('.n_eror_ptlh').html('');
                }
            } else {
                if (regex_number.test(sky) == false) {
                    $('.n_eror_ptlh').html('Bạn chưa nhập đúng định dạng số điện thoại.');

                } else {
                    $('.n_eror_ptlh').html('');
                }
            }
        }

        var status = $('input[name=status]:checked').val();

        if (flag == true) {
            var data = new FormData();

            data.append('ntd_company', $('#ntd_name').val());
            data.append('ntd_phone', $('#ntd_tel').val());
            data.append('ntd_city', $('#n_city').val());
            data.append('ntd_qh', $('#n_qh').val());
            data.append('ntd_masothue', $('#ntd_mst').val());
            data.append('ntd_address', $('#ntd_dia_chi').val());
            data.append('id_employer', $('.id_employer').val());
            data.append('status', status);
            console.log(data);
            $.ajax({
                url: '/admin/Submit_form/employer_edit',
                type: "POST",
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                data: data,
                success: function(data) {
                    console.log(data);
                    if (data.kq == true) {
                        window.location.href = '/admin/employer/list '
                    }
                }
            })
        };


    });
});