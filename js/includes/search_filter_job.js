$(document).ready(function() {
    //autocomplete tag 
    autocomplete_tag = localStorage.getItem("list_tag").split(",");
    autocomplete(document.getElementById("findkeyjob"), autocomplete_tag, "autocomplete_tag");
    console.log(autocomplete_tag);
    $('#n_city').select2({
        width: '150px',
        placeholder: "Tất cả tỉnh thành",
        dropdownParent: $('#city_lq'),
        closeOnSelect: false,
    });
    $('#n_cate').select2({
        width: '170px',
        placeholder: "Chọn ngành nghề",
        dropdownParent: $('.drop_cate'),
        closeOnSelect: false,
    });
    $('#n_httl').select2({
        width: '100%',
        placeholder: "Tất cả",
    });
    $('#n_hv').select2({
        width: '100%',
        placeholder: "Tất cả",
    });
    $('#n_gt').select2({
        width: '100%',
        placeholder: "Tất cả",
    });
    $('#n_cb').select2({
        width: '100%',
        placeholder: "Tất cả",
    });
    $('#n_knlv').select2({
        width: '100%',
        placeholder: "Tất cả",
    });
    $('#n_lhlv').select2({
        width: '100%',
        placeholder: "Tất cả",
    });
    $('#n_htlv').select2({
        width: '100%',
        placeholder: "Tất cả",
    });
    // btn bộ lọc
    $('.n_filter_btn').click(function() {
        if ($(document).width() > 600) {
            $('.n_filter_opt').toggleClass('n_flex');
        } else {
            $('.n_modal_filter_mobile').addClass('show');
        }
    });
    // btn đóng bộ lọc mobile
    $('.n_close_filter').click(function() {
        $('.n_modal_filter_mobile').removeClass('show');
    });
    // chọn option @ bộ lọc mobile
    $('.n_option').click(function() {
        $(this).parent('.n_filter_option_div').data('value', $(this).data('value'));
        $(this).parent().children('div').removeClass('n_option_select');
        $(this).toggleClass('n_option_select');
    });
    // btn thiết lập lại @ lọc mobile
    $('.n_del_filter').click(function() {
        $('.n_option').removeClass('n_option_select');
        $('.n_filter_option_div').each(function() {
            $(this).data('value', 0);
        });
    });
    // btn lọc
    $('.n_filter').click(function() {
        tim_kiem($('#n_city').val());
    });
    // đóng popup tt/qh
    $('.n_close_city_box').click(function() {
        $('.city_district').removeClass('n_open_city_box');
    });
    $('#n_cate').next().children('.selection').children('.select2-selection.select2-selection--single').click(function() {
        $('.city_district').removeClass('n_open_city_box');
    });
    $('#findkeyjob').focus(function() {
        $('.city_district').removeClass('n_open_city_box');
    });
    // mở popup tt/qh
    $('#select2-n_city-container').parent('.select2-selection--single').click(function() {
        $('.city_district').addClass('n_open_city_box');
    });
    // đổ ds quận huyện @ popup tt/qh
    $('#n_city').change(function() {
        $.ajax({
            url: "/Ajax/getDistrict",
            type: 'GET',
            dataType: "json",
            data: {
                cit_id: $("#n_city").val(),
            },
            success: function(result) {
                if (result.length > 0) {
                    var i = 0;
                    var html = "";
                    for (i = 0; i < result.length; i++) {
                        html += `<div class='district_col_txt' onclick='district_click(` + result[i].cit_id + `)'>` + result[i].cit_name + `</div>`;
                    }
                    $('.city_box_right_content').html(html);
                    $('#district').children('.city_box_right_txt').html('Quận huyện');
                } else {
                    var html = '<div class="district_col"><div class="district_col_title" onclick="city_click(1)">Hà Nội</div><div class="district_col_txt" onclick="district_click(72)">Hai Bà Trưng</div><div class="district_col_txt" onclick="district_click(70)">Cầu Giấy</div><div class="district_col_txt" onclick="district_click(78)">Nam Từ Liêm</div><div class="district_col_txt" onclick="district_click(69)">Long Biên</div><div class="district_col_txt" onclick="district_click(74)">Thanh Xuân</div><div class="district_col_txt" onclick="district_click()">Hoàng Mai</div></div><div class="district_col"><div class="district_col_title" onclick="city_click(45)">Hồ Chí Minh</div><div class="district_col_txt" onclick="district_click(636)">Huyện Bình Chánh</div><div class="district_col_txt" onclick="district_click(638)">Huyện Cần Giờ</div><div class="district_col_txt" onclick="district_click(615)">Quận 1</div><div class="district_col_txt" onclick="district_click(624)">Quận 2</div><div class="district_col_txt" onclick="district_click(629)">Quận 5</div><div class="district_col_txt" onclick="district_click(626)">Quận 10</div></div><div class="district_col"><div class="district_col_title" onclick="city_click(26)">Đà Nẵng</div><div class="district_col_txt" onclick="district_click(427)">Huyện Cẩm Lệ</div><div class="district_col_txt" onclick="district_click(424)">Huyện Hải Châu</div><div class="district_col_txt" onclick="district_click(428)">Huyện Hòa Vang</div><div class="district_col_txt" onclick="district_click(422)">Quận Liên Chiểu</div><div class="district_col_txt" onclick="district_click(426)">Quận Ngũ Hành Sơn</div><div class="district_col_txt" onclick="district_click(423)">Quận Thanh Khê</div></div>';
                    $('.city_box_right_content').html(html);
                    $('#district').children('.city_box_right_txt').html('Địa điểm nổi bật');
                }
            },
            error: function(request, status, error) {}
        });
    });
    // đổ dl tỉnh thành lên thanh search => tạo change event để quận huyện chạy theo
    $('#n_city').val($('#n_city').val()).trigger('change');
    // btn tìm kiếm
    $('.n_tim_kiem').click(function() {
        tim_kiem($('#n_city').val());
    });
});

function city_click(cit_id) {
    $('#n_city').val(cit_id).trigger('change');
}

function district_click(qh_id) {
    tim_kiem(qh_id);
}

function tim_kiem(cit_id) {
    var findkey = $('.n_key').val();
    var nn_id = $('#n_cate').val();
    if ($(document).width() > 600) {
        var httl = $('#n_httl').val();
        var hv = $('#n_hv').val();
        var gt = $('#n_gt').val();
        var cb = $('#n_cb').val();
        var knlv = $('#n_knlv').val();
        var lhlv = $('#n_lhlv').val();
        var htlv = $('#n_htlv').val();
    } else {
        var httl = $('.n_httl').data('value');
        var hv = $('.n_hv').data('value');
        var gt = $('.n_gt').data('value');
        var cb = $('.n_cb').data('value');
        var knlv = $('.n_knlv').data('value');
        var lhlv = $('.n_lhlv').data('value');
        var htlv = $('.n_htlv').data('value');
    }

    $.ajax({
        url: "/Ajax/search_job",
        type: 'POST',
        dataType: "json",
        data: {
            findkey: findkey,
            httl: httl,
            hv: hv,
            gt: gt,
            cb: cb,
            knlv: knlv,
            lhlv: lhlv,
            htlv: htlv,
            nn_id: nn_id,
            cit_id: cit_id,
        },
        success: function(url) {
            console.log(url['url']);
            if (url['url'] != '') {
                window.location = url['url'];
            }
        },
        error: function() {}
    });
}

function autocomplete(inp, arr, append) {
    var currentFocus;
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;
        closeAllLists();
        if (!val) { return false; }
        currentFocus = -1;
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        document.getElementById(append).appendChild(a);
        for (i = 0; i < arr.length; i++) {
            for (j = 0; j < arr[i].length; j++) {
                if (arr[i].substr(j, val.length).toUpperCase() == val.toUpperCase()) {
                    b = document.createElement("DIV");
                    b.setAttribute("class", "tag_s_item");
                    b.innerHTML = arr[i];
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    b.addEventListener("click", function(e) {
                        inp.value = this.getElementsByTagName("input")[0].value;
                        closeAllLists();
                        document.getElementById('box_search_key').style.display = "none";
                        open_box('box_search_city');
                    });
                    a.appendChild(b);
                    break;
                }
            }
        }
    });
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");

        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            currentFocus++;
            addActive(x);
        } else if (e.keyCode == 38) {
            currentFocus--;
            addActive(x);
        } else if (e.keyCode == 13) {
            // e.preventDefault();
            $('#btn_search').click();
            console.log(x);
            if (currentFocus > -1) {
                if (x) x[currentFocus].click();
            }
        }
    });

    function addActive(x) {
        if (!x) return false;
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        x[currentFocus].classList.add("autocomplete-active");
        inp.value = x[currentFocus].textContent;
    }

    function removeActive(x) {
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }

    function closeAllLists(elmnt) {
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    document.addEventListener("click", function(e) {
        closeAllLists(e.target);
    });
}