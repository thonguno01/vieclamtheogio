// var regex_email= /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
// var regex_tel = /^([0-9]{9,15})$/g;
localStorage.setItem("regex_email", /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/);
localStorage.setItem("regex_tel", /((84|\+84|0)+(9|8|7|5|3)+([0-9]{8})\b)/);
$(document).ready(function() {
    $(".avatar").click(function(e) {
        e.preventDefault();
        $(".dropdown_notify").hide();
        $(".dropdown_avatar").toggle();
    });
    $(".bell_img").click(function(e) {
            e.preventDefault();
            $(".dropdown_avatar").hide();
            $(".dropdown_notify").toggle();
        })
        // $(".dropdown_avatar").(function (e) { 
        //     e.preventDefault();
        //     $(".dropdown_avatar").hide();
        // });
    $(".btn_menu_responsive").click(function(e) {
        e.preventDefault();
        $(".menu_responsive").slideDown();
    })
    $(".close_menu_response").click(function(e) {
        e.preventDefault();
        $(".menu_responsive").slideUp();
    });

    $('.v-footer-ontop').click(function() {
        $("html").animate({ scrollTop: 0 }, "easy");
    });
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) $(".v-footer-ontop").fadeIn();
        else $(".v-footer-ontop").fadeOut();
    });
    $('.n_hd_btn_log_out').click(function() {
        $('.log_out_background').show();
        $('.btn_log_out').click(function() {
            window.location = '/logout';
        });
        $('.btn_no_log_out').click(function() {
            $('.log_out_background').hide();
        });
    });
    $('.btn_close_log_out').click(function() {
        $('.log_out_background').hide();
    });
    $('.delete_notify').click(function() {
        var r = confirm('Bạn chắc chắn muốn xóa tất cả thông báo?');
        if (r == true) {
            $.ajax({
                url: '/Ajax/del_all_notify',
                type: "POST",
                dataType: "JSON",
                data: {},
                success: function(data) {}
            });
            $('.dropdown_notify_item').remove();
            $('.dropdown_notify_list').html('Bạn không có thông báo.');
            $('.notify .number_red').html('0');
        }
    });
});

function save_uv(id_uv) {
    $.ajax({
        url: '/Ajax/save_uv',
        type: "POST",
        dataType: "JSON",
        data: {
            id_uv: id_uv
        },
        success: function(data) {}
    });
}

function save_new(id_ntd, id_new) {
    $.ajax({
        url: '/Ajax/save_new',
        type: "POST",
        dataType: "JSON",
        data: {
            id_ntd: id_ntd,
            id_new: id_new
        },
        success: function(data) {}
    });
}

function lammoi_hsuv(id_uv) {
    $.ajax({
        url: '/Ajax/lammoi_hsuv',
        type: "POST",
        dataType: "Json",
        data: {
            id_uv: id_uv,
        },
        success: function(data) {
            if (data.kq == true) {
                window.location.reload();
            } else {
                alert("Bạn đã hết lượt làm mới trong tháng này.")
            }
        }
    })
}

function ntd_found_uv(id_uv) {
    $.ajax({
        url: '/Ajax/ntd_found_uv',
        type: "POST",
        dataType: "Json",
        data: {
            id_uv: id_uv,
        },
        success: function(data) {}
    })
}

function del_ung_vien_tu_diem_loc(id_uv, id_ntd) {
    $.ajax({
        url: '/Ajax/ntd_del_uvtdl',
        type: "POST",
        dataType: "Json",
        data: {
            id_uv: id_uv,
            id_ntd: id_ntd,
        },
        success: function(data) {}
    })
}

function ChangeToSlug(string) {
    var string;
    slug = string.toLowerCase();

    //Đổi ký tự có dấu thành không dấu
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    //Xóa các ký tự đặt biệt
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    //Đổi khoảng trắng thành ký tự gạch ngang
    slug = slug.replace(/ /gi, "-");
    //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
    //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    //Xóa các ký tự gạch ngang ở đầu và cuối
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    //In slug ra textbox có id “slug”
    return slug;
}

function checkAllkitu(str) {
    let regex = /(^[^a-zA-Z0-9]*$)/;
    return regex.test(str);
}

//1 bawts dau 2 : hien tai
function validateDay(time1, time2) {
    let d = time1;
    day = d.getDate();
    month = d.getMonth();
    year = d.getFullYear();
    let today = time2;
    day2 = today.getDate();
    month2 = today.getMonth();
    year2 = today.getFullYear();
    //so sánh với ngày hiện tại 
    if (year < year2) {
        return false;
    } else if (year >= year2) {
        if (month < month2) {
            return false;
        } else if (month >= month2) {
            if (day < day2) {
                return false;
            } else if (day > day2) {
                return true;
            }
        }
    }
}