$(document).ready(function() {
    $('#n_vt').select2({
        width: '100%',
        placeholder: "Chọn chức danh / vị trí",
    });
    $('.n_btn_add').click(function() {
        refresh();
        add_exp();
    });

    $('.n_ttcb_update').click(function() {
        if ($('.n_id_update').val() == 0) {
            add_exp();
        } else {
            update_exp($(this).data('update'));
        }
    });
});

function update_exp(ele) {
    if (validate() == true) {
        var name = $('.n_name').val().trim();
        var vt = $('#n_vt option:selected').text();
        var vt_id = $('#n_vt').val();
        var start = $('.n_date_start').val();
        start = new Date(start);
        var from = '';
        if (start.getDate() < 10) {
            from = from + '0' + start.getDate() + '/';
        } else {
            from = from + start.getDate() + '/';
        }
        if (start.getMonth() < 9) {
            from = from + '0' + (start.getMonth() + 1) + '/';
        } else {
            from = from + (start.getMonth() + 1) + '/';
        }
        from = from + start.getFullYear();
        var end = $('.n_date_end').val();
        var to = '';
        end = new Date(end);
        if (end.getDate() < 10) {
            to = to + '0' + end.getDate() + '/';
        } else {
            to = to + end.getDate() + '/';
        }
        if (end.getMonth() < 9) {
            to = to + '0' + (end.getMonth() + 1) + '/';
        } else {
            to = to + (end.getMonth() + 1) + '/';
        }
        to = to + end.getFullYear();
        var mota = $('.n_knlv_mota').val();

        var data = new FormData;
        data.append('n_name', $('.n_name').val());
        data.append('vt_id', $('#n_vt').val());
        data.append('start', $('.n_date_start').val());
        data.append('end', $('.n_date_end').val());
        data.append('mota', $('.n_knlv_mota').val());
        data.append('id_knlv', $('.n_id_update').val());

        $.ajax({
            url: '/Ajax/kinh_nghiem_lam_viec',
            type: "POST",
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            data: data,
            success: function(data) {
                console.log(data);
            }
        })

        $(ele).parents('.n_knlv_row_content').find('.n_knlv_kn_ides').html(mota);
        $(ele).parents('.n_knlv_row_content').find('.n_name_txt').html(name);
        $(ele).parents('.n_knlv_row_content').find('.n_vt_txt').html(vt);
        $(ele).parents('.n_knlv_row_content').find('.n_vt_txt').data('id', vt_id);
        $(ele).parents('.n_knlv_row_content').find('.n_from_txt').html(from);
        $(ele).parents('.n_knlv_row_content').find('.n_to_txt').html(to);
        refresh();
    }
}

function edit_exp(ele) {
    $('.n_id_update').val($(ele).parents('.n_knlv_row_content').data("id"));
    $('.n_knlv_mota').val($(ele).parents('.n_knlv_row_content').find('.n_knlv_kn_ides').html());
    $('.n_name').val($(ele).parents('.n_knlv_row_content').find('.n_name_txt').html());

    var vt_id = $(ele).parents('.n_knlv_row_content').find('.n_vt_txt').data('id');
    $('#n_vt').select2().val(vt_id).trigger("change");

    var from = $(ele).parents('.n_knlv_row_content').find('.n_from_txt').html();
    from = from.split("/");
    from = from[2] + '-' + from[1] + '-' + from[0];
    $('.n_date_start').val(from);
    var to = $(ele).parents('.n_knlv_row_content').find('.n_to_txt').html();
    to = to.split("/");
    to = to[2] + '-' + to[1] + '-' + to[0];
    $('.n_date_end').val(to);

    $('.n_ttcb_update').data('update', ele);
}

function del_exp(ele) {
    $('.warning_background').show();
    $('.btn_yes').click(function() {
        $(ele).parents('.n_ttcb_row').remove();
        $('.warning_background').hide();
        var data = new FormData;
        data.append('id_knlv', $(ele).attr("data-id"));

        $.ajax({
            url: '/Ajax/xoa_kng',
            type: "POST",
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            data: data,
            success: function(data) {
                console.log(data);

            }
        });
    });
}

function refresh() {
    $('.n_id_update').val('');
    $('.n_knlv_mota').val('');
    $('.n_name').val('');
    $('#n_vt').select2().val('').trigger("change");
    $('.n_date_start').val('');
    $('.n_date_end').val('');
    $('.n_ttcb_update').data('update', '');
}

function add_exp() {
    if (validate() == true) {
        var name = $('.n_name').val();
        var vt = $('#n_vt option:selected').text();
        var vt_id = $('#n_vt').val();
        var start = $('.n_date_start').val();
        start = new Date(start);
        var from = '';
        if (start.getDate() < 10) {
            from = from + '0' + start.getDate() + '/';
        } else {
            from = from + start.getDate() + '/';
        }
        if (start.getMonth() < 9) {
            from = from + '0' + (start.getMonth() + 1) + '/';
        } else {
            from = from + (start.getMonth() + 1) + '/';
        }
        from = from + start.getFullYear();
        var end = $('.n_date_end').val();
        var to = '';
        end = new Date(end);
        if (end.getDate() < 10) {
            to = to + '0' + end.getDate() + '/';
        } else {
            to = to + end.getDate() + '/';
        }
        if (end.getMonth() < 9) {
            to = to + '0' + (end.getMonth() + 1) + '/';
        } else {
            to = to + (end.getMonth() + 1) + '/';
        }
        to = to + end.getFullYear();
        var mota = $('.n_knlv_mota').val();
        var s = '<div class="n_ttcb_row"><div class="n_ttcb_row_left n_knlv_row_content" data-id=1><img class="n_knlv_kn_ava" src="/images/n_knlv_avata.svg"><div class="n_knlv_kn_text"><p class="n_knlv_kn_txt"><span class="n_knlv_kn_title">Tên công ty:</span> <span class="n_knlv_kn_txt n_name_txt">' + name + '</span></p><p class="n_knlv_kn_txt"><span class="n_knlv_kn_title">Chức danh / Vị trí:</span> <span class="n_knlv_kn_txt n_vt_txt" data-id="' + vt_id + '">' + vt + '</span></p><p class="n_knlv_kn_txt"><span class="n_knlv_kn_title">Thời gian:</span> <span class="n_knlv_kn_itxt">Từ</span> <span class="n_knlv_kn_txt n_from_txt">' + from + '</span> <span class="n_knlv_kn_itxt">đến</span> <span class="n_knlv_kn_txt n_to_txt">' + to + '</span></p><p class="n_knlv_kn_txt"><span class="n_knlv_kn_title">Mô tả:</span> <span class="n_knlv_kn_ides">' + mota + '</span></p></div><button class="n_knlv_kn_func n_btn_edit" onclick="edit_exp(this)"><img src="/images/n_icon_pen.svg"></button><button class="n_knlv_kn_func n_btn_del" onclick="del_exp(this)"><img src="/images/n_icon_del.svg"></button></div></div>';
        $('.n_list_exp').append(s);

        var data = new FormData;
        data.append('n_name', $('.n_name').val());
        data.append('vt_id', $('#n_vt').val());
        data.append('start', $('.n_date_start').val());
        data.append('end', $('.n_date_end').val());
        data.append('mota', $('.n_knlv_mota').val());
        data.append('id_knlv', '0');

        $.ajax({
                url: '/Ajax/kinh_nghiem_lam_viec',
                type: "POST",
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                data: data,
                success: function(data) {
                    console.log(data);
                }
            })
            // xóa gtri ở các ô input
        refresh();
    }
}

function validate() {
    var flag = true;

    var name = $('.n_name').val().trim();
    if (name == '') {
        $('.n_name_error').html('Bạn chưa nhập tên công ty');
        flag = false;
    } else if (checkkitu(name) == true) {
        $('.n_name_error').html(' Tên công ty không được chứa ký tự đặc biệt trừ:  ( ) .  ,  - ');
        flag = false;

    } else {
        $('.n_name_error').html('');
    }
    var vt = $('#n_vt').val();
    if (vt == '') {
        $('.n_vt_error').html('Không để trống mục này');
        flag = false;
    } else {
        $('.n_vt_error').html('');
    }
    var start = $('.n_date_start').val();
    var end = $('.n_date_end').val();
    if (start == '') {
        $('.n_date_start_error').html('Không để trống mục này');
        flag = false;
    } else if (validateDay(new Date(start), new Date()) == true) {
        $('.n_date_start_error').html('Chọn ngày bắt đầu nhỏ hơn ngày hiện tại');
        flag = false;
    } else {
        $('.n_date_start_error').html('');
    }

    if (end == '') {
        $('.n_date_end_error').html('Không để trống mục này');
        flag = false;
    } else {
        $('.n_date_end_error').html('');
    }
    if ($('.n_knlv_mota').val().length != 0) {
        if ($('.n_knlv_mota').val().trim() == '') {
            $('.n_n_knlv_mota_error').html('Bạn chưa nhập thông tin');
            flag = false;
        } else {
            $('.n_n_knlv_mota_error').html('');

        }
    } else {
        $('.n_n_knlv_mota_error').html('');
    }
    let checkday = validateDay(new Date(start), new Date(end));
    if (checkday == true) {
        $('.n_date_start_error').html('Chọn ngày bắt đầu nhỏ hơn ngày kết thúc ');
        $('.n_date_end_error').html('Chọn ngày kết thúc lớn hơn ngày bắt đầu ');
        flag = false;
    }
    console.log(checkday);
    return flag;
}

function checkkitu(str) {
    let regex = /[<>{}\"\'/|;:+~!?@#$%^=&*\\_]/;
    return regex.test(str);
}