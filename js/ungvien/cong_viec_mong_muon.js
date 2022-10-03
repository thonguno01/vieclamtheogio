$(document).ready(function() {
    $('#n_city').select2({
        width: '100%',
        placeholder: "Chọn tối đa 3 tỉnh thành",
        maximumSelectionLength: 3,
    });

    $('#n_city').change(function() {
        $.ajax({
            url: "/Ajax/getDistrict",
            type: 'GET',
            dataType: "json",
            data: {
                cit_id: $("#n_city").val(),
            }
        });
    });


    $('#n_lcv').select2({
        width: '100%',
        placeholder: "Chọn tối đa 5 loại công việc",
        maximumSelectionLength: 5,
    });
    $('#n_htlv').select2({
        width: '100%',
        placeholder: "Chọn hình thức làm việc",
    });
    $('#n_lhlv').select2({
        width: '100%',
        placeholder: "Chọn loại hình làm việc",
    });
    $('#n_ht_luong').select2({
        width: '100%',
        placeholder: "Chọn loại hình làm việc",
    });
    $('#n_httl').select2({
        width: '100%',
        placeholder: "Chọn loại hình làm việc",
    });

    // đổ dl ca làm
    var list_calam = $('#n_calam').data('value');
    if (parseInt(list_calam) == -1) {
        checkbox_click('.checkbox_boder[time=none]');
    } else {
        list_calam = list_calam.toString().split(",");
        // console.log(list_calam);
        $('.n_tdow').each(function() {
            // console.log($.inArray($(this).attr('value'),list_calam));
            if ($.inArray($(this).attr('value'), list_calam) >= 0) {
                n_tdow_click(this);
            }
        });
    }
    // end đổ dl ca làm

    $('.n_tdow').click(function() {
        n_tdow_click(this);
    });
    $('.checkbox_boder').click(function() {
        checkbox_click(this);
    });
    $('#n_ht_luong').change(function() {
        if ($(this).val() == 1) {
            $('.n_cvmm_luong_3').addClass('hide');
            $('.n_cvmm_luong_1').show();
            $('.n_cvmm_luong_1').prop('disabled', false);
            $('#n_httl').prop('disabled', false);
        } else if ($(this).val() == 3) {
            $('.n_cvmm_luong_3').addClass('hide');
            $('.n_cvmm_luong_1').show();
            $('.n_cvmm_luong_1').prop('disabled', true);
            $('#n_httl').prop('disabled', true);
        } else if ($(this).val() == 2) {
            $('.n_cvmm_luong_3').removeClass('hide');
            $('.n_cvmm_luong_1').hide();
            $('#n_httl').prop('disabled', false);
        }
    });
    $('.n_ttcb_update').click(function() {
        var time = $('.n_enable').length;
        var flag = true;
        // ca làm 
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

        // loại công việc
        var lcv = $('#n_lcv').val();
        if (lcv == '') {
            $('.n_lcv_error').html('Không để trống mục này');
            flag = false;
        } else {
            $('.n_lcv_error').html('');
        }
        // công việc cụ thể
        var cvct = $('.n_cvct').val().trim();
        if (cvct == '') {
            $('.n_cvct_error').html('Không để trống mục này');
            flag = false;
        } else if (checkAllkitu(cvct) == true) {
            $('.n_cvct_error').html('Công việc cụ thể không được nhập tất cả là ký tự đặc biệt');
            flag = false;
        } else {
            $('.n_cvct_error').html('');
        }
        // hình thức làm việc
        var htlv = $('#n_htlv').val();
        if (htlv == '' || htlv == 0) {
            $('.n_htlv_error').html('Không để trống mục này');
            flag = false;
        } else {
            $('.n_htlv_error').html('');
        }
        // nơi làm việc mong muốn
        var nlvmm = $('#n_city').val();
        if (nlvmm == '') {
            $('.n_nlvmm_error').html('Không để trống mục này');
            flag = false;
        } else {
            $('.n_nlvmm_error').html('');
        }
        // loại hình làm việc
        var lhlv = $('#n_lhlv').val();
        if (lhlv == '' || lhlv == 0) {
            $('.n_lhlv_error').html('Không để trống mục này');
            flag = false;
        } else {
            $('.n_lhlv_error').html('');
        }
        // hình thức lương -> mức lương
        var htl = $('#n_ht_luong').val();
        var luong_2 = '';
        if (htl == 1) {
            if ($('.n_cvmm_luong_1').val() == '') {
                $('.n_htl_error').html('Không để trống mục này');
                flag = false;
            } else if ($('.n_cvmm_luong_1').val() <= 0) {
                $('.n_htl_error').html('Mức lương phải lớn hơn 0');
                flag = false;
            } else {
                $('.n_htl_error').html('');
                luong_2 = $('.n_cvmm_luong_1').val();
            }
        } else if (htl == 2) {
            var min = ($('.n_luong_min').val());
            var max = ($('.n_luong_max').val());
            console.log(min + ' ' + max);
            if (min == '' || max == '') {
                $('.n_htl_error').html('Không để trống mục này');
                flag = false;
            } else if (parseInt(min) <= 0 || parseInt(max) <= 0) {
                $('.n_htl_error').html('Mức lương phải lớn hơn 0');
                flag = false;
            } else if (parseInt(min) >= parseInt(max)) {
                $('.n_htl_error').html('Mức lương sau phải lớn hơn mức lương trước.');
                flag = false;
            } else {
                $('.n_htl_error').html('');
                luong_2 = parseInt(min) + '-' + parseInt(max);
            }
        } else if (htl == 3) {
            luong_2 = 0;
        } else {
            $('.n_htl_error').html('Không để trống mục này');
            flag = false;
        }

        if (flag == true) {
            var data = new FormData();
            data.append('n_lcv', $('#n_lcv').val());
            data.append('n_cvct', $('.n_cvct').val());
            data.append('n_htlv', $('#n_htlv').val());
            data.append('n_lhlv', $('#n_lhlv').val());
            data.append('n_city', $('#n_city').val());
            data.append('n_ht_luong', $('#n_ht_luong').val());
            data.append('n_luong', luong_2);
            data.append('n_httl', $('#n_httl').val());
            data.append('ca_lam', ca_lam);
            console.log(data);
            $.ajax({
                url: '/Ajax/cong_viec_mong_muon',
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
            });
        }
    });
});

function checkbox_click(ele) {
    $(ele).children('.checkbox_checked').toggle();
    var time = $(ele).attr('time');
    if ($(ele).children('.checkbox_checked').css('display') == 'block') {
        if (time == 'mo') {
            $('.n_mo').addClass('n_tdow_pick');
        } else if (time == 'no') {
            $('.n_no').addClass('n_tdow_pick');
        } else if (time == 'ni') {
            $('.n_ni').addClass('n_tdow_pick');
        } else {
            $('.n_tdow').addClass('n_enable');
            $('.n_ndow').addClass('n_enable');
            $('.n_tdow_pick').click();
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
}

function n_tdow_click(ele) {
    $(ele).toggleClass('n_tdow_pick');
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