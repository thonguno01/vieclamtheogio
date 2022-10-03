$(document).ready(function() {

    $('.btn_up_post').click(function() {
        //Tiêu đề tin tuyển dụng

        var tieude = $('#ntd_tieude').val();
        var flag_tieude = false;
        let arrCheck = ['tuyen-gap', 'luong-cao', 'hot', 'can-gap'];

        if (tieude == '') {
            $('.n_eror_tieude').html('Không để trống mục này');
            flag = false;
            $("#ntd_tieude").parents('.dtin_ntd_info')[0].scrollIntoView();

        } else if (checkkitu(tieude) == true) {
            $('.n_eror_tieude').html('Tin không được chứa ký tự đặc biệt trừ:  ( ) .  ,  -');
            flag = false;
            $("#ntd_tieude").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {

            $.ajax({
                url: 'Ajax/tieu_de_alias',
                type: "POST",
                dataType: "JSON",
                async: false,
                data: {
                    new_title: tieude,
                },
                success: function(data) {
                    if (data.length > 0) {
                        $('.n_eror_tieude').html('Tiêu đề không được trùng');
                        flag_tieude = false;
                    } else {
                        $('.n_eror_tieude').html('');
                        flag_tieude = true;
                    }
                }
            });
        }
        var type_cong_viec = $('#n_type_congviec').val();
        var flag_type_congviec = false;
        var flag = true;
        var chi_tiet = $('#ntd_chi_tiet').val();
        var flag_chi_tiet = false;
        if (tieude != '') {
            for (let i = 0; i < arrCheck.length; i++) {
                if (ChangeToSlug(tieude).indexOf(arrCheck[i]) != -1) {
                    $('.n_eror_tieude').html('Tiêu đề tin tuyển dụng KHÔNG chứa các nội dung như: Tuyển gấp, hot, cần gấp, lương cao');
                    flag = false;
                }
            }
        }
        // Loại công việc
        if (type_cong_viec == '' || type_cong_viec == 0) {
            $('.n_eror_type_congviec').html('Không để trống mục này.');
            flag_type_congviec = false;
            $("#n_type_congviec").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_type_congviec').html('');
            flag_type_congviec = true;

        }

        //Chi tiết công việc 
        var b_qh = $('#n_qh').val();
        if (cat_des > 0) {
            if (chi_tiet == '') {
                $('.n_eror_chi_tiet').html('Không để trống mục này');
                flag = false;
                $("#ntd_chi_tiet").parents('.dtin_ntd_info')[0].scrollIntoView();
            } else {
                $.ajax({
                    url: 'Ajax/chi_tiet_cong_viec',
                    type: "POST",
                    dataType: "JSON",
                    async: false,
                    data: {
                        new_chitiet: chi_tiet,
                        n_qh: b_qh,
                    },
                    success: function(data) {
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
        if (flag_chi_tiet == false) {
            flag = false;
        }
        if ($('#n_sex').val() == '' || $('#n_sex').val() == 0) {
            $('.n_eror_sex').html('Không để trống mục này');
            flag = false;
            $("#n_sex").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_sex').html('');
        }
        if ($('#n_level').val() == '' || $('#n_level').val() == 0) {
            $('.n_eror_level').html('Không để trống mục này');
            flag = false;
            $("#n_level").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_level').html('');
        }
        if ($('#n_hoc_van').val() == '' || $('#n_hoc_van').val() == 0) {
            $('.n_eror_hoc_van').html('Không để trống mục này');
            flag = false;
            $("#n_hoc_van").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_hoc_van').html('');
        }
        if ($('#n_way_pay').val() == '' || $('#n_way_pay').val() == 0) {
            $('.n_eror_way_pay').html('Không để trống mục này');
            flag = false;
            $("#n_way_pay").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_way_pay').html('');
        }

        //Yêu cầu độ tuổi
        if ($('#ntd_age').val() == '') {
            $('.n_eror_age').html('Không để trống mục này');
            flag = false;
            $("#ntd_age").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_age').html('');
        }

        // Kinh nghiệm làm việc
        if ($('#n_exp_work').val() == '' || $('#n_exp_work').val() == 0) {
            $('.n_eror_exp_work').html('Không để trống mục này.');
            flag = false;
            $("#n_exp_work").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_exp_work').html('');
        }

        // Loại hình làm việc
        if ($('#n_type_working').val() == '' || $('#n_type_working').val() == 0) {
            $('.n_eror_type_working').html('Không để trống mục này.');
            flag = false;
            $("#n_type_working").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_type_working').html('');
        }

        //Hình thức làm việc
        if ($('#n_way_working').val() == '' || $('#n_way_working').val() == 0) {
            $('.n_eror_way_working').html('Không để trống mục này.');
            flag = false;
            $("#n_way_working").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_way_working').html('');
        }


        // if (someday > today)
        //     text = “Ngày hôm nay là trước ngày 14 tháng 1 năm 2100.”;
        // else
        //     text = “Ngày hôm nay là sau ngày 14 tháng 1 năm 2100.”;
        //Hạn nộp
        if ($('#ntd_date').val() == '') {
            $('.n_eror_date').html('Không để trống mục này.');
            flag = false;
            $("#ntd_date").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            let d = new Date($('#ntd_date').val());
            day = d.getDate();
            month = d.getMonth();
            year = d.getFullYear();
            let today = new Date();
            if (Number(today.getDate()) > Number(day) && Number(today.getMonth()) >= Number(month) && Number(today.getFullYear()) >= Number(year)) {
                $('.n_eror_date').html('Hạn nộp hồ sơ phải lớn hơn này hôm nay');
                // console.log('Hạn nộp hồ sơ phải lớn hơn này hôm nay');
                flag = false;
            } else {
                $('.n_eror_date').html('');
            }
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
            var min = $('#ntd_salary_money_uocluong').val();
            var max = $('#ntd_salary_money_uocluong2').val();
            if (min == '' || max == '') {
                $('.n_eror_salary_level').html('Không để trống mục này.');
                flag = false;
            } else if (min <= 0 || max <= 0) {
                $('.n_eror_salary_level').html('Mức lương phải lớn hơn 0');
                flag = false;
            } else if (min >= max) {
                $('.n_eror_salary_level').html('Mức lương sau phải lớn hơn mức lương trước.');
                flag = false;
            } else {
                $('.n_eror_salary_level').html('');
                flag = true;
                money_input = min + '-' + max;

            }
        } else if ($('#n_salary_level').val() == 3) {
            $('.n_eror_salary_level').html('');
            money_input = 0;
        }


        //địa chỉ
        var city_work = $('#n_city').val();
        var qh_work = $('#n_qh').val();
        var address_work = $('#n_dcct').val().trim();
        var new_at_com = '';
        if (!$("#n_noi_lam_viec").is(":checked")) {
            if ($('#n_city').val() == 0 || $('#n_qh').val() == '' || $('#n_dcct').val().trim() == '') {
                $('.n_eror_dcct').html('Không để trống mục này.');
                flag = false;
            } else if (checkAllkitu(address_work) == true) {
                $('.n_eror_dcct').html('Địa chỉ cụ thể không được nhập toàn bộ kí tự đặc biệt .');
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

        //ca làm 
        var gio_lam_from = [];
        var gio_lam_to = [];
        var ngay_lam_viec = [];
        var calam = 0;

        var new_t2 = [];
        var new_t3 = [];
        var new_t4 = [];
        var new_t5 = [];
        var new_t6 = [];
        var new_t7 = [];
        var new_cn = [];
        var flag_ca = 0;
        var time = $('.n_tdow_pick').length;
        if (!$("#n_time_lam_viec").is(":checked")) {
            $('.n_gio_lam1').each(function(index, ele) {
                var fr = $(ele).children('.n_gio_lam').children('.n_gio_lam_from').val();
                var to = $(ele).children('.n_gio_lam').children('.n_gio_lam_to').val();

                if (fr == '' || to == '') {
                    flag_ca = 1;
                } else if (fr > to) {
                    flag_ca = 2;
                } else if (fr == to) {
                    flag_ca = 4;
                } else {
                    flag_ca = 0;
                    gio_lam_from.push(fr);
                    gio_lam_to.push(to);
                }
            });

            $('.n_detail_ca_lam').each(function(index, ele) {
                var ngay_trong_ca = $(ele).find('.n_tdow_pick');
                if (ngay_trong_ca.length == 0) {
                    flag_ca = 3;
                }
            });
            if (flag_ca == 1 || flag_ca == 3) {
                $('.n_eror_calam').html('Lịch không được để trống.');
                flag = false;
            } else if (flag_ca == 2) {
                $('.n_eror_calam').html('Thời gian bắt đầu phải bé hơn thời gian kết thúc.');
                flag = false;
            } else if (flag_ca == 4) {
                $('.n_eror_calam').html('Thời gian bắt đầu không được bằng thời gian kết thúc.');
                flag = false;
            } else {
                $('.n_eror_calam').html('');
            }
            calam = 1;
        } else {
            calam = 0;
            gio_lam_from = 0;
            gio_lam_to = 0;
            ngay_lam_viec = 0;
            $('.n_eror_calam').html('');
        }
        var t2 = getCalendar('new_t2', new_t2);
        var t3 = getCalendar('new_t3', new_t3);
        var t4 = getCalendar('new_t4', new_t4);
        var t5 = getCalendar('new_t5', new_t5);
        var t6 = getCalendar('new_t6', new_t6);
        var t7 = getCalendar('new_t7', new_t7);
        var cn = getCalendar('new_cn', new_cn);

        //Mô tả 
        let regexOnlyKiTu = /[^(\d+\w +\s)/$]/;
        let mtcv_val = $('#ntd_mtcv').val().trim();
        let yccv_val = $('#ntd_yccv').val().trim();
        let qldh_val = $('#ntd_qldh').val().trim();
        if ($('#ntd_mtcv').val().trim() == '') {
            $('.n_eror_mtcv').html('Không để trống mục này hoặc không được nhập toàn dấu cách  ');
            flag = false;
            $("#ntd_mtcv").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else if (checkAllkitu(mtcv_val) == true) {
            $('.n_eror_mtcv').html('Mô tả công việc không chứa tất cả các ký tự đặc biệt ');
            flag = false;
            $("#ntd_mtcv").parents('.dtin_ntd_info')[0].scrollIntoView();

        } else {
            $('.n_eror_mtcv').html('');
        }
        //Yêu cầu công việc 
        if ($('#ntd_yccv').val().trim() == '') {
            $('.n_eror_yccv').html('Không để trống mục này hoặc không được nhập toàn dấu cách');
            flag = false;
            $("#ntd_yccv").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else if (checkAllkitu($('#ntd_yccv').val().trim()) == true) {
            $('.n_eror_yccv').html('Yêu cầu công việc không chứa tất cả các ký tự đặc biệt ');
            flag = false;
            $("#ntd_yccv").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_yccv').html('');
        }
        //quyền lợi được hưởng
        if ($('#ntd_qldh').val().trim() == '') {
            $('.n_eror_qldh').html('Không để trống mục này hoặc không được nhập toàn dấu cách');
            flag = false;
            $("#ntd_qldh").parents('.dtin_ntd_info')[0].scrollIntoView();
        } else {
            $('.n_eror_qldh').html('');

        }
        // nếu 2 cái đầu khách rỗng 
        if (mtcv_val != '' && yccv_val != '') {
            if (mtcv_val == yccv_val) {
                $('.n_eror_yccv').html('Yêu cầu công việc không được trùng mô tả công việc ');
                flag = false;
                $("#ntd_yccv").parents('.dtin_ntd_info')[0].scrollIntoView();
            } else {
                $('.n_eror_yccv').html('');
            }
        }
        if (yccv_val != '' && qldh_val != '') {
            if (yccv_val == qldh_val) {
                $('.n_eror_qldh').html('Quyền lợi được hưởng không được trùng với yêu cầu công việc ');
                flag = false;
                $("#ntd_qldh").parents('.dtin_ntd_info')[0].scrollIntoView();
            } else {
                $('.n_eror_qldh').html('');
            }
        }
        if (mtcv_val != '' && qldh_val != '') {
            if (mtcv_val == qldh_val) {
                $('.n_eror_qldh').html('Quyền lợi được hưởng không được trùng với mô tả công việc ');
                flag = false;
                $("#ntd_qldh").parents('.dtin_ntd_info')[0].scrollIntoView();
            } else {
                $('.n_eror_qldh').html('');
            }
        }
        // nếu 3 cái khách rỗng 
        if (mtcv_val != '' && yccv_val != '' && qldh_val != '') {
            if (mtcv_val == yccv_val) {
                $('.n_eror_yccv').html('Yêu cầu công việc không được trùng mô tả công việc ');
                flag = false;
            } else if (mtcv_val == qldh_val) {
                $('.n_eror_qldh').html('Quyền lợi được hưởng không được trùng với mô tả công việc ');
                flag = false;
            } else if (yccv_val == qldh_val) {
                $('.n_eror_qldh').html('Quyền lợi được hưởng không được trùng với yêu cầu công việc  ');
                flag = false;
            } else {
                $('.n_eror_yccv').html('');
            }
        }
        if (checkAllkitu($('#ntd_qldh').val().trim()) == true) {
            $('.n_eror_qldh').html('Quyền lợi được hưởng không chứa tất cả các ký tự đặc biệt ');
            flag = false;
            $("#ntd_qldh").parents('.dtin_ntd_info')[0].scrollIntoView();

        } else if (checkAllkitu($('#ntd_yccv').val().trim()) == true) {
            $('.n_eror_yccv').html('Yêu cầu công việc không chứa tất cả các ký tự đặc biệt ');
            flag = false;
            $("#ntd_yccv").parents('.dtin_ntd_info')[0].scrollIntoView();
        }
        if (flag == true && flag_tieude == true && flag_type_congviec == true) {
            var data = new FormData;
            data.append('n_type_congviec', type_cong_viec);
            data.append('ntd_tieude', tieude);
            data.append('chi_tiet_cv', chi_tiet);
            data.append('ntd_age', $('#ntd_age').val());
            data.append('n_sex', $('#n_sex').val());
            data.append('n_level', $('#n_level').val());
            data.append('n_hoc_van', $('n_hoc_van').val());
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
            data.append('ngay_lam_viec', ngay_lam_viec);
            data.append('ntd_mtcv', $('#ntd_mtcv').val());
            data.append('ntd_yccv', $('#ntd_yccv').val());
            data.append('ntd_qldh', $('#ntd_qldh').val());

            data.append('calam', calam);
            data.append('gio_lam', gio_lam_from);
            data.append('gio_ve', gio_lam_to);
            data.append('new_t2', t2);
            data.append('new_t3', t3);
            data.append('new_t4', t4);
            data.append('new_t5', t5);
            data.append('new_t6', t6);
            data.append('new_t7', t7);
            data.append('new_cn', cn);
            $.ajax({
                url: '/Ajax/dang_tin_moi',
                type: "POST",
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                data: data,
                success: function(data) {
                    console.log(data);
                    if (data.kq == true) {
                        $('.up_success').show();
                        $('.btn_stay').click(function() {
                            $('.up_success').hide();
                        });
                        $('.btn_home').click(function() {
                            window.location = '/tin-da-dang';
                        });
                    } else {
                        if (data.type == 2) {
                            alert("Bạn đã đăng 24 tin trong ngày hôm này.");
                        } else if (data.type == 1) {
                            alert("Bạn vừa mới đăng tin, đợi 10 phút sau để đăng tin tiếp.");
                        }
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
                    if (result.length == 0) {
                        $('#ntd_chi_tiet').prop('disabled', 'disabled');
                    } else {
                        $('#ntd_chi_tiet').prop('disabled', '');
                    }
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
            reset_stt_ca();
        }

    });

});

function reset_stt_ca() {
    $('.n_gio_lam1').each(function(index) {
        $(this).children('.n_text_label').html('Ca ' + (index + 1));
    });
}

function xoa_ca_lam(e) {
    $(e).parent('.n_gio_lam1').next().remove();
    $(e).parent('.n_gio_lam1').remove();
    reset_stt_ca();
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

function getCalendar(class_lich, array) {
    if (!$("#n_time_lam_viec").is(":checked")) {
        $('.' + class_lich).each(function() {
            val = $(this).attr('value');
            array.push(val);
        });
    } else {
        array = ['0'];
    }

    return array.toString();
}



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

function checkkitu(str) {
    let regex = /[<>{}\"\-/|;:+~!?@#$%^=\\_]/;
    return regex.test(str);
}