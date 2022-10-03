$(document).ready(function() {

    $('.btn_up_post').click(function() {

        var id_user = $('#new_user').val();
        var flag = true;
        //quyền lợi được hưởng
        if ($('#ntd_qldh').val() == '') {
            $('.n_eror_qldh').html('Không để trống mục này');
            $('#ntd_qldh').focus();
            flag = false;
            $("#ntd_qldh").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_qldh').html('');

        }
        //Yêu cầu công việc
        if ($('#ntd_yccv').val() == '') {
            $('.n_eror_yccv').html('Không để trống mục này');
            $('#ntd_yccv').focus();
            flag = false;
            $("#ntd_yccv").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_yccv').html('');

        }
        //Mô tả
        if ($('#ntd_mtcv').val() == '') {
            $('.n_eror_mtcv').html('Không để trống mục này');
            $('#ntd_mtcv').focus();
            flag = false;
            $("#ntd_mtcv").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_mtcv').html('');

        }
        // ----------
        //địa chỉ
        var city_work = $('#n_city').val();
        var qh_work = $('#n_qh').val();
        var address_work = $('#n_dcct').val();
        var new_at_com = '';
        if (!$("#n_noi_lam_viec").is(":checked")) {
            if ($('#n_city').val() == 0 || $('#n_qh').val() == '' || $('#n_dcct').val() == '') {
                $('.n_eror_dcct').html('Không để trống mục này.');
                flag = false;
            } else {
                $('.n_eror_dcct').html('');
                city_work = $('#n_city').val();
                qh_work = $('#n_qh').val();
                address_work = $('#n_dcct').val();
                new_at_com = 0;
            }
        } else {
            $('.n_eror_dcct').html('');
            new_at_com = qh_work + '.' + city_work;
        }

        //Số tiền
        var money_input = '';

        if ($('#n_salary_level').val() == 1) {
            if ($('#ntd_salary_money').val() == '') {
                $('.n_eror_salary_level').html('Không để trống mục này.');
                flag = false;
            } else if ($('#ntd_salary_money').val() <= 0) {
                $('.n_eror_salary_level').html('Mức lương phải lớn hơn 0');
                flag = false;
            } else {
                money_input = $('#ntd_salary_money').val();
                $('.n_eror_salary_level').html('');
                flag = true;
            }
        } else if ($('#n_salary_level').val() == 2) {
            var min = parseInt($('#ntd_salary_money_uocluong').val());
            var max = parseInt($('#ntd_salary_money_uocluong2').val());
            if (min == '' || max == '') {
                $('.n_eror_salary_level').html('Không để trống mục này.');
                flag = false;
            } else if (min <= 0 || max <= 0) {
                $('.n_eror_salary_level').html('Mức lương phải lớn hơn 0');
                flag = false;
            } else if (min > max) {
                $('.n_eror_salary_level').html('Mức lương sau phải lớn hơn mức lương trước.');
                flag = false;
            } else {
                $('.n_eror_salary_level').html('');
                flag = true;
                money_input = min + '-' + max;;

            }
        } else if ($('#n_salary_level').val() == 3) {
            $('.n_eror_salary_level').html('');
            money_input = 0;
        }

        // Kinh nghiệm làm việc
        if ($('#n_exp_work').val() == '' || $('#n_exp_work').val() == 0) {
            $('.n_eror_exp_work').html('Không để trống mục này.');
            flag = false;
            $("#n_exp_work").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_exp_work').html('');
        }
        //Yêu cầu độ tuổi
        if ($('#ntd_age').val() == '') {
            $('.n_eror_age').html('Không để trống mục này');
            flag = false;
            $("#ntd_age").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_age').html('');
        }

        //Chi tiết công việc
        var b_qh = $('#n_qh').val();
        var new_id = $('#new_id').val();
        var chi_tiet = $('#ntd_chi_tiet').val();
        var flag_chi_tiet = false;
        if (cat_des > 0 || chi_tiet != 0 || chi_tiet != undefined) {
            if (chi_tiet == '') {
                $('.n_eror_chi_tiet').html('Không để trống mục này');
                $('#ntd_chi_tiet').focus();
                flag = false;
                $("#ntd_chi_tiet").parents('.dtin_ntd_info')[0].scrollIntoView();
            } else {
                $.ajax({
                    url: '/admin/Submit_form/chi_tiet_cong_viec_sua',
                    type: "POST",
                    dataType: "JSON",
                    async: false,
                    data: {
                        new_id: new_id,
                        new_chitiet: chi_tiet,
                        n_qh: b_qh,
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.length > 0) {
                            $('.n_eror_chi_tiet').html('Việc làm đã có tại địa chỉ này rồi.');
                            flag_chi_tiet = false;
                        } else {
                            $('.n_eror_chi_tiet').html('');
                            flag_chi_tiet = true;
                        }
                    }
                });
            }
        } else {
            $('.n_eror_chi_tiet').html('');
            flag_chi_tiet = true;
        }
        var type_cong_viec = $('#n_type_congviec').val();
        var flag_type_congviec = false;
        if (flag_chi_tiet == false) {
            flag = false;
        }


        // Loại công việc
        if (type_cong_viec == '' || type_cong_viec == 0) {
            $('.n_eror_type_congviec').html('Không để trống mục này.');
            flag = false;
            $("#n_type_congviec").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_type_congviec').html('');
        }
        //Tiêu đề tin tuyển dụng
        var tieude = $('#ntd_tieude').val();
        var new_id = $('#new_id').val();
        var flag_tieude = false;
        if (tieude == '') {
            $('.n_eror_tieude').html('Không để trống mục này');
            $('#ntd_tieude').focus();
            flag_tieude = false;
            $("#ntd_tieude").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $.ajax({
                url: '/admin/Submit_form/tieu_de_alias_sua',
                type: "POST",
                dataType: "JSON",
                async: false,
                data: {
                    new_id: new_id,
                    new_title: tieude,
                },
                success: function(data) {
                    if (data.length > 0) {
                        $('.n_eror_tieude').html('Tiêu đề không được trùng');
                        $('#ntd_tieude').focus();
                        flag_tieude = false;
                    } else {
                        $('.n_eror_tieude').html('');
                        flag_tieude = true;
                    }
                }
            });
        }
        if (flag_tieude == false) {
            flag = false;
        }
        // Loại hình làm việc
        if ($('#n_type_working').val() == '') {
            $('.n_eror_type_working').html('Không để trống mục này.');
            flag = false;
            $("#n_type_working").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_type_working').html('');
        }

        //Hình thức làm việc
        if ($('#n_way_working').val() == '') {
            $('.n_eror_way_working').html('Không để trống mục này.');
            flag = false;
            $("#n_way_working").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_way_working').html('');
        }

        //Hạn nộp
        if ($('#ntd_date').val() == '') {
            $('.n_eror_date').html('Không để trống mục này.');
            flag = false;
            $("#ntd_date").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_date').html('');
        }





        //ca làm
        var gio_lam_from = [];
        var gio_lam_to = [];
        var ngay_lam_viec = [];
        var flag_ca = true;
        var time = $('.n_tdow_pick').length;

        if (!$("#n_time_lam_viec").is(":checked")) {
            var no_ca_lam = 1;
            $('.n_detail_ca_lam_total').find('.n_tdow_pick');
            var check_calendar = $('.n_detail_ca_lam_total').find('.n_tdow_pick');
            if (check_calendar.length == 0) {
                $('.n_eror_lichLV').text('Bạn chưa chọn ngày làm việc');
                flag = false;
            } else {
                new_t2 = dayWork('new_t2 ');
                new_t3 = dayWork('new_t3 ');
                new_t4 = dayWork('new_t4 ');
                new_t5 = dayWork('new_t5 ');
                new_t6 = dayWork('new_t6 ');
                new_t7 = dayWork('new_t7 ');
                new_cn = dayWork('new_cn ');
                $('.n_gio_lam1').each(function(index, ele) {
                    var fr = $(ele).children('.n_gio_lam').children('.n_gio_lam_from').val();
                    var to = $(ele).children('.n_gio_lam').children('.n_gio_lam_to').val();

                    if (fr == '' || to == '') {
                        flag_ca = false;
                    } else {
                        if (fr >= to) {
                            alert('Thời gian của ca làm việc không hợp lệ');
                            flag = false;
                        }
                        gio_lam_from.push(fr);
                        gio_lam_to.push(to);
                    }
                });
                if (flag_ca == false) {
                    $('.n_eror_lichLV').html('Bạn chưa chọn ca làm việc');
                    flag = false;
                } else {
                    $('.n_eror_lichLV').html('');
                }
            }

        } else {
            var no_ca_lam = 0;
            gio_lam_from = '';
            gio_lam_to = '';
            ngay_lam_viec = '';
            new_t2 = new_t3 = new_t4 = new_t5 = new_t6 = new_t7 = new_cn = '';
            $('.n_eror_calam').html('');
        }
        if (flag == true) {
            var data = new FormData;
            data.append('new_id', new_id);
            data.append('n_type_congviec', type_cong_viec);
            data.append('id_user', id_user);
            data.append('ntd_tieude', tieude);
            data.append('chi_tiet_cv', chi_tiet);
            data.append('ntd_age', $('#ntd_age').val());
            data.append('n_sex', $('#n_sex').val());
            data.append('n_level', $('#n_level').val());
            data.append('n_hoc_van', $('#n_hoc_van').val());
            data.append('n_exp_work', $('#n_exp_work').val());
            data.append('n_way_pay', $('#n_way_pay').val());
            data.append('n_type_working', $('#n_type_working').val());
            data.append('n_way_working', $('#n_way_working').val());
            data.append('ntd_date', $('#ntd_date').val());
            data.append('luong1', $('#n_salary_level').val());
            data.append('muc_luong', money_input);
            data.append('luong3', $('#n_salary_time').val());
            data.append('city_work', city_work);
            data.append('qh_work', qh_work);
            data.append('address_work', address_work);
            data.append('new_at_com', new_at_com);
            data.append('no_ca_lam', no_ca_lam);
            data.append('gio_lam', gio_lam_from);
            data.append('gio_ve', gio_lam_to);
            data.append('ngay_lam_viec', ngay_lam_viec);
            data.append('ntd_mtcv', $('#ntd_mtcv').val());
            data.append('ntd_yccv', $('#ntd_yccv').val());
            data.append('ntd_qldh', $('#ntd_qldh').val());
            data.append('t2', new_t2);
            data.append('t3', new_t3);
            data.append('t4', new_t4);
            data.append('t5', new_t5);
            data.append('t6', new_t6);
            data.append('t7', new_t7);
            data.append('cn', new_cn);
            $.ajax({
                url: '/admin/Submit_form/edit_new',
                type: "POST",
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                data: data,
                success: function(data) {
                    if (data.kq == true) {
                        window.location.href = '/admin/new_list';
                    } else {
                        alert('Cập nhật thất bại.');
                    }
                }
            })
        }
    });


    $('#n_city').select2({
        width: '100%',
        placeholder: "Chọn tỉnh / thành phố",
    });
    $('#n_qh').select2({
        width: '100%',
        placeholder: "Chọn quận / huyện",
    });

    $('#n_city').val($('#n_city').val()).trigger('change');
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

    $('#n_type_congviec').select2({
        width: '100%',
        placeholder: "Chọn loại công việc",
    });

    var cat_des = 0;
    $('#n_type_congviec').change(function() {
        var type_cong_viec = $('#n_type_congviec').val();
        $.ajax({
            url: "/Ajax/getJob",
            type: 'GET',
            dataType: "json",
            data: {
                cat_id: type_cong_viec,
            },
            success: function(result) {
                if (result.length >= 0) {
                    cat_des = result.length;
                    var i = 0;
                    var html = "<option value=''>Chọn chi tiết công việc</option>";

                    for (i = 0; i < result.length; i++) {
                        html += `<option value="` + result[i].tag_id + `">` + result[i].tag_name + `</option>`;
                    }
                    $('#ntd_chi_tiet').html(html);
                }
            },
            error: function(request, status, error) {
                var val = request.responseText.replace('gi', '');
                val = JSON.parse(val);
                var html = "<option value=''>Chọn chi tiết công việc</option>";
                for (i = 0; i < val.length; i++) {
                    html = html + '<option value="' + val[i].tag_id + '">' + val[i].tag_name + '</option>';
                }
                $('#district').html(html);
            }
        });
    });

    $('#n_level').select2({
        width: '100%',
        placeholder: "Tất cả",
    });

    $('#n_exp_work').select2({
        width: '100%',
        placeholder: "Chọn mức kinh nghiệm làm việc",
    });

    $('#n_type_working').select2({
        width: '100%',
        placeholder: "Chọn loại hình làm việc",
    });

    $('#n_sex').select2({
        width: '100%',
        placeholder: "Không yêu cầu",
    });

    $('#ntd_chi_tiet').select2({
        width: '100%',
        placeholder: "Chọn chi tiết công việc",
    });

    $('#n_hoc_van').select2({
        width: '100%',
        placeholder: "Tất cả",
    });

    $('#n_way_pay').select2({
        width: '100%',
        placeholder: "Tất cả",
    });

    $('#n_way_working').select2({
        width: '100%',
        placeholder: "Chọn hình thức làm việc",
    });


    $("#n_noi_lam_viec").click(function() {
        if ($('#n_city').attr('disabled') == undefined) {
            $('#n_city').prop('disabled', true);
            $('#n_qh').prop('disabled', true);
            $('#n_dcct').prop('disabled', true);
        } else {
            $('#n_city').prop('disabled', false);
            $('#n_qh').prop('disabled', false);
            $('#n_dcct').prop('disabled', false);

        }
    })


    // var list_calam =$('')

    //Time làm việc
    $("#n_time_lam_viec").click(function() {
        if ($('.n_gio_lam_from').attr('disabled') == undefined) {
            $('.n_gio_lam_from').prop('disabled', true);
            $('.n_gio_lam_to').prop('disabled', true);
        } else {
            $('.n_gio_lam_from').prop('disabled', false);
            $('.n_gio_lam_to').prop('disabled', false);

        }
    })


    //Ca làm việc 

    $('.n_tdow').click(function() {
        $(this).toggleClass('n_tdow_pick');
        var vl_lich = $(this).attr('value');
        if (vl_lich == 0) {
            $(this).attr('value', 1);
        } else if (vl_lich == 1) {
            $(this).attr('value', 0)
        }
    })

    // Button thêm ca

    var flag = 1;
    $("#them_ca_lam").click(function() {
        if (!$("#n_time_lam_viec").is(":checked")) {
            var t = $('.n_detail_ca_lam').length;
            flag++;
            if (t < 5)
                $(".n_detail_ca_lam_total").append(
                    `<div id="a" class="n_gio_lam1 pt-3 pb-4">
                <p class="n_text_label">Ca ` + flag + `</p>
                <div class="n_dtin_ntd_input n_gio_lam">
                    <label class="form-label label_gio_lam">Từ</label>
                    <input type="time" class="form-control n_gio_lam_from" >
                </div>
                <div class="n_dtin_ntd_input n_gio_lam">
                    <label class="form-label label_gio_lam">Đến</label>
                    <input type="time" class="form-control n_gio_lam_to" >
                </div>
                <div class="xoa_ca_lam" onclick="xoa_ca_lam(this)">
                    <h2 id="xoa_ca_lam"><img src="/images/carbon_delete.png" alt=""></h2>
                </div>
            </div>
            <div class="n_detail_ca_lam">
                <div class="n_dow n_mon">
                    <p class="n_tdow n_mo new_t2" onClick="ngay_lam_viec(this)" id="new_t2" value="0">Thứ 2</p>
                </div>
                <div class="n_dow n_tue"> 
                    <p class="n_tdow n_mo new_t3" onClick="ngay_lam_viec(this)" id="new_t3" value="0">Thứ 3</p>  
                </div>
                <div class="n_dow n_wen">
                    <p class="n_tdow n_mo new_t4" onClick="ngay_lam_viec(this)" id="new_t4" value="0">Thứ 4</p>
                </div>
                <div class="n_dow n_thu">
                    <p class="n_tdow n_mo new_t5" onClick="ngay_lam_viec(this)" id="new_t5" value="0">Thứ 5</p> 
                </div> 
                <div class="n_dow n_fri"> 
                    <p class="n_tdow n_mo new_t6" onClick="ngay_lam_viec(this) " id="new_t6" value="0">Thứ 6</p> 
                </div> 
                <div class="n_dow n_sat"> 
                    <p class="n_tdow n_mo new_t7" onClick="ngay_lam_viec(this)" id="new_t7" value="0">Thứ 7</p>  
                </div> 
                <div class="n_dow n_sun"> 
                    <p class="n_tdow n_mo new_cn" onClick="ngay_lam_viec(this)" id="new_cn" value="0">Chủ Nhật</p> 
                </div>
            </div>`);
        }
    });

});

function xoa_ca_lam(e) {
    $(e).parent('.n_gio_lam1').next().remove();
    $(e).parent('.n_gio_lam1').remove();
}

function ngay_lam_viec(b) {
    $(b).toggleClass('n_tdow_pick');
    var vl_lich = $(b).attr('value');
    if (vl_lich == 0) {
        $(b).attr('value', 1);
    } else if (vl_lich == 1) {
        $(b).attr('value', 0)
    }
}

$(document).on('click', '.myCheckbox', function() {
    var target = $(this).data('target');
    if ($(this).is(':checked')) {
        $('.' + target).addClass('disabled').css('pointerEvents', 'none');
        $('.n_tdow_pick').removeClass('n_tdow_pick');
    } else {
        $('.' + target).removeClass('disabled').css('pointerEvents', 'auto');
    }
});




function showDiv(select) {
    if (select.value == 2) {
        document.getElementById('salary_hidden').style.display = "flex";
        document.getElementById('input_salary').style.display = "none";
    } else {
        document.getElementById('salary_hidden').style.display = "none";
        document.getElementById('input_salary').style.display = "block";
    }
    if (select.value == 3) {
        $('#ntd_salary_money').prop('disabled', true);
        $('#n_salary_time').prop('disabled', true);
    } else {
        $('#ntd_salary_money').prop('disabled', false);
        $('#n_salary_time').prop('disabled', false);
    }
}
//ngay lam viec
function dayWork(classDay) {
    var array = [];
    $('.' + classDay).each(function() {
        array.push($(this).attr('value'));
    });
    return array;
}