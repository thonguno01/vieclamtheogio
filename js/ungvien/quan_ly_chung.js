$(document).ready(function() {
    // thông tin cơ bản
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

    $('#n_ttcb_update').click(function() {
        var tel = $('.n_tel').val();
        var addr = $('.n_addr').val().trim();
        var qh = $('#n_qh').val();
        var city = $('#n_city').val();
        var dob = $('.n_dob').val();
        var sex = $('input[name=n_sex]:checked').val();
        var name = $('.n_name').val().trim();
        var regex_email = localStorage.getItem("regex_email");
        var regex_tel = /^((84|\+84|0)+[0-9]{9,14})$/g;
        var flag = true;
        // sdt
        if (tel == '') {
            $('.n_tel_error').html('Không để trống mục này');
            $('.n_tel').parent()[0].scrollIntoView();
            flag = false;
        } else if (regex_tel.test(tel) == false) {
            $('.n_tel_error').html('Bạn chưa nhập đúng địch dạng số điện thoại');
            $('.n_tel').parent()[0].scrollIntoView();
            flag = false;
        } else {
            $('.n_tel_error').html('');
        }
        // dia chi
        if (addr == '') {
            $('.n_addr_error').html('Không để trống mục này');
            $('.n_addr').parent()[0].scrollIntoView();
            flag = false;
        } else {
            $('.n_addr_error').html('');
        }
        // qh
        if (qh < 0 || qh == '') {
            $('.n_qh_error').html('Không để trống mục này');
            $('#n_qh').parent()[0].scrollIntoView();
            flag = false;
        } else {
            $('.n_qh_error').html('');
        }
        // city
        if (city < 0 || city == '') {
            $('.n_city_error').html('Không để trống mục này');
            $('#n_city').parent()[0].scrollIntoView();
            flag = false;
        } else {
            $('.n_city_error').html('');
        }
        // dob
        if (dob == '') {
            $('.n_dob_error').html('Không để trống mục này');
            $('.n_dob').parent()[0].scrollIntoView();
            flag = false;
        } else {
            let d = new Date($('.n_dob').val());
            day = d.getDate();
            month = d.getMonth();
            year = d.getFullYear();
            let today = new Date();
            if (Number(today.getDate()) < Number(day) && Number(today.getMonth()) <= Number(month) && Number(today.getFullYear()) <= Number(year)) {
                $('.n_dob_error').html('Ngày sinh không được lớn hơn này hôm nay');
                flag = false;
            } else {
                $('.n_dob_error').html('');
            }
        }
        // sex
        if (sex == undefined) {
            $('.n_sex_error').html('Không để trống mục này');
            $('.n_sex').parents('.n_ttcb_radio')[0].scrollIntoView();
            flag = false;
        } else {
            $('.n_sex_error').html('');
        }
        // name
        if (name == '') {
            $('.n_name_error').html('Không để trống mục này');
            $('.n_name').parent()[0].scrollIntoView();
            flag = false;
        } else if (checkkitu(name) == true) {
            $('.n_name_error').html('Tên công ty không được chứa  ký tự đặc biệt');
            $('.n_name').parent()[0].scrollIntoView();
            flag = false;
        } else {
            $('.n_name_error').html('');
        }

        var file_data = $('#up_photo').prop('files')[0];
        var mary = $('input[name=n_mary]:checked').val(); // ko bat buoc
        if (mary == undefined) {
            mary = 0;
        }

        if (flag == true) {
            var data = new FormData();
            data.append('avatar', file_data);
            data.append('n_email', $('#n_email').val());
            data.append('n_name', $('.n_name').val());
            data.append('n_sex', sex);
            data.append('n_mary', mary);
            data.append('n_dob', $('.n_dob').val());
            data.append('n_city', $('#n_city').val());
            data.append('n_qh', $('#n_qh').val());
            data.append('n_addr', $('.n_addr').val());
            data.append('n_tel', $('.n_tel').val());
            console.log(data);
            $.ajax({
                url: '/Ajax/thong_tin_co_ban',
                type: "POST",
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                data: data,
                success: function(data) {
                    console.log(data);
                    if (data.kq == true) {
                        window.location.reload();
                    }
                }
            })
        };
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
            if (file_data.size <= 8000000) {
                preview_logo.src = URL.createObjectURL(event.target.files[0]);
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

function checkkitu(str) {
    let regex = /[<>{}\"\'\-/|;:.,+~!?@#$%^=&*\\_)(]/;
    return regex.test(str);
}

$('.n_name').blur(() => {
    let text = '';
    let name = $(' .n_name').val().trim().toString().split(" ");
    let length = name.length;
    for (let i = 0; i < length; i++) {
        text += name[i].charAt(0).toUpperCase() + name[i].slice(1) + ' ';
    }
    $('.n_name').val(text);

})