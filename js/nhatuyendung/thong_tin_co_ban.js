function loadFile(event) {
    // var loadFile = function(event) {
    var preview_logo1 = document.getElementById('preview_logo1');
    var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/jfif", "image/PNG"];
    var file_data = $('#up_photo1').prop('files')[0];
    if (file_data != undefined) {
        var type = file_data.type;
        var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/jfif", "image/PNG"];
        if (type == match[0] || type == match[1] || type == match[2] || type == match[3] || type == match[4] || type == match[5]) {
            if (file_data.size <= 8000000) {
                preview_logo1.src = URL.createObjectURL(event.target.files[0]);
            } else {
                check = false;
                alert('Bạn chỉ được upload file dưới 8MB');
            }
        } else {
            alert('Bạn chỉ được upload file ảnh');
            return false;
        }
    }
    // };
}
var check = true;

function upFile(event) {
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
                check = false;
                alert('Bạn chỉ được upload file dưới 8MB');
            }
        } else {
            check = false;
            alert('Bạn chỉ được upload file ảnh');
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
        var regex_number = /((84|\+84|0)+([0-9]{9,14})\b)/g;
        var regex_kitu = /[$&+:;=?@#|'<>^*%!]/g;
        var flag = true;

        //validate tên
        if ($('#ntd_name').val() == '') {
            $('.n_eror_name').html('Không để trống mục này');
            flag = false;
            $("#ntd_name").parents('.thong_tin_info')[0].scrollIntoView();
        } else if ($('#ntd_name').val().trim() == '') {
            $('.n_eror_name').html('Tên doanh nghiệp/Nhà tuyển dụng không được nhập toàn dấu cách.');
            flag = false;
            $("#ntd_name").parents('.thong_tin_info')[0].scrollIntoView();
        } else if (regex_kitu.test($('#ntd_name').val()) == true) {
            $('.n_eror_name').html('Tên doanh nghiệp/Nhà tuyển dụng không được chứa ký tự đặc biệt trừ:  ( ) .  ,  -');
            flag = false;
        } else {
            $.ajax({
                url: '/Ajax/alias_ntd',
                type: "POST",
                dataType: "JSON",
                async: false,
                data: {
                    ntd_name: $('#ntd_name').val(),
                },
                success: function(data) {
                    if (data.length > 0) {
                        $('.n_eror_name').html('Tên đã tồn tại.');
                        flag = false;
                    } else {
                        $('.n_eror_name').html('');
                        flag = true;
                    }
                }
            });
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
        if ($('#ntd_dia_chi').val().trim() == '') {
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
            } else if ($('#ntd_tel').val().length < 10 || $('#ntd_tel').val().length > 15) {
                $('.n_eror_tel').html('Bạn chưa nhập đúng định dạng số điện thoại.');
                flag = false;
                $("#ntd_tel").parents('.thong_tin_info')[0].scrollIntoView();

            } else if (isNumeric($('#ntd_tel').val()) == false) {
                $('.n_eror_tel').html('Bạn chưa nhập đúng định dạng số điện thoại.');
                flag = false;
                $("#ntd_tel").parents('.thong_tin_info')[0].scrollIntoView();

            } else {
                $('.n_eror_tel').html('');

            }
        }
        var regex_tel = /^((84|\+84|0)+[0-9]{9,14})$/g;
        //phương thức liên lạc
        var zalo = $('#n_zalo').val();
        var sky = $('#n_skype').val();

        if (zalo != "") {
            if (regex_tel.test(zalo) == false) {
                $('.n_eror_ptlh1').html('  Bạn chưa nhập đúng định dạng số điện thoại Zalo.');
                flag = false;
            } else if (zalo.length < 10 || zalo.length > 15) {
                $('.n_eror_ptlh1').html('  Bạn chưa nhập đúng định dạng số điện thoại Zalo.');
                flag = false;
            } else {
                $('.n_eror_ptlh1').html('');
            }
        }
        var regex_sky = /^((84|\+84|0)+[0-9]{9,14})$/g;
        if (sky != "") {
            if (sky.length < 10 || sky.length > 15) {
                $('.n_eror_ptlh2').html('Bạn chưa nhập đúng định dạng số điện thoại skype.');
                flag = false;
            } else if (regex_sky.test(sky) == false) {
                $('.n_eror_ptlh2').html('Bạn chưa nhập đúng định dạng số điện thoại Skyle.');
                flag = false;
            } else {
                $('.n_eror_ptlh2').html('');
            }
        }
        var file_background = $('#up_photo1').prop('files')[0];
        if (check == true) {

            var file_avatar = $('#up_photo').prop('files')[0];
        } else {
            var file_avatar = '';
        }
        var mst = $('#ntd_mst').val().trim();
        var regex_mst = /^\d+\.\d+$/;

        if (mst != '') {
            let chek = isNumeric(mst);

            if (mst.length != 10 && mst.length == 13) {

                if (chek == false) {
                    $('.n_eror_mst').html('Mã số thuế không nhập ký tự khác ký tự số.');
                    flag = false;
                } else {
                    $('.n_eror_mst').html('');
                }
            } else if (mst.length == 10 && mst.length != 13) {

                if (chek == false) {
                    $('.n_eror_mst').html('Mã số thuế không nhập ký tự khác ký tự số.');
                    flag = false;
                } else {
                    $('.n_eror_mst').html('');
                }
            } else {
                $('.n_eror_mst').html('Mã số thuế gồm 10 hoặc 13 kí tự số .');
                flag = false;
            }
        } else {
            $('.n_eror_mst').html('');
        }
        if (flag == true) {
            var data = new FormData();
            data.append('background', file_background);
            data.append('avatar', file_avatar);
            data.append('ntd_company', $('#ntd_name').val());
            data.append('ntd_email', $('#ntd_email').val());
            data.append('ntd_phone', $('#ntd_tel').val());
            data.append('ntd_city', $('#n_city').val());
            data.append('ntd_qh', $('#n_qh').val());
            data.append('ntd_masothue', $('#ntd_mst').val());
            data.append('ntd_address', $('#ntd_dia_chi').val());
            data.append('ntd_zalo', $('#n_zalo').val());
            data.append('ntd_skype', $('#n_skype').val());
            console.log(data);
            $.ajax({
                url: '/Ajax/thong_tin_co_ban_ntd',
                type: "POST",
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                data: data,
                success: function(data) {
                    console.log(data);
                    if (data.kq == true) {
                        alert("Cập nhật thành công.");
                        // window.location.reload();
                    }
                }
            })
        };


    });
});

function isNumeric(value) {
    return /^-?\d+$/.test(value);
}