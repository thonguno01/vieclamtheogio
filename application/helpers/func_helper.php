<?php
function pagination($base_url, $total_row, $per_page)
{
    $CI = &get_instance();
    $CI->load->library("pagination");
    $config['base_url'] = $base_url;
    $config['total_rows'] = $total_row;
    $config['per_page'] = $per_page;
    $config["use_page_numbers"] = true;
    $config["reuse_query_string"] = true;
    $config["prefix"] = '/';
    // full tag pagination
    $config["full_tag_open"] = " <nav class='list_pagination' >
    <ul class='pagination'>";
    $config["full_tag_close"] = "</ul>
    </nav>";
    // first link
    $config["first_link"] = "&lt&lt";
    $config["first_tag_open"] = "<li class='page-item update-page-item n_next'>";
    $config["first_tag_close"] = "</li>";

    // last link
    $config["last_link"] = "&gt&gt";
    $config["last_tag_open"] = "<li class='page-item update-page-item n_next'>";
    $config["last_tag_close"] = "</li>";

    // next link
    $config["next_link"] = "&gt";
    $config["next_tag_open"] = "<li class='page-item update-page-item n_next'>";
    $config["next_tag_close"] = "</li>";

    // pre link
    $config["prev_link"] = "&lt";
    $config["prev_tag_open"] = "<li class='page-item update-page-item n_next'>";
    $config["prev_tag_close"] = "</li>";

    // cur link 
    $config["cur_tag_open"] = "<li class='page-item update-page-item active_pagin'><a class='page-link'>";
    $config["cur_tag_close"] = "</a></li>";
    $config['num_links'] = 1;

    $config["num_tag_open"] = "<li class='page-item update-page-item'>";
    $config["num_tag_close"] = "</li>";
    $config['attributes'] = array('class' => 'page-link');
    $CI->pagination->initialize($config);
}

function ci_pagination($url, $total_rows, $row_per_page)
{
    $pagination['base_url'] = $url;
    $pagination['total_rows'] = $total_rows;
    $pagination['per_page'] = $row_per_page;
    $pagination['page_query_string'] = true;
    $pagination['num_tag_open'] = '<button class="t_paginate_item">';
    $pagination['num_tag_close'] = '</button>';
    $pagination['first_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
    $pagination['first_tag_close'] = '</button>';
    $pagination['last_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
    $pagination['last_tag_close'] = '</button>';
    $pagination['next_tag_open'] = '<button class="t_paginate_item t_paginate_item_next">';
    $pagination['next_tag_close'] = '</button>';
    $pagination['prev_tag_open'] = '<button class="t_paginate_item t_paginate_item_prev">';
    $pagination['prev_tag_close'] = '</button>';
    $pagination['cur_tag_open'] = '<button class="t_paginate_item t_paginate_active">';
    $pagination['first_link'] = 'Đầu';
    $pagination['last_link'] = 'Cuối';
    $pagination['query_string_segment'] = 'page';
    $pagination['use_page_numbers'] = TRUE;
    return $pagination;
}
function vn_str_filter($title)
{
    $marTViet = array(
        "à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ",
        "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ",
        "ì", "í", "ị", "ỉ", "ĩ",
        "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ",
        "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
        "ỳ", "ý", "ỵ", "ỷ", "ỹ",
        "đ", "Đ", "'",
        "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
        "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
        "Ì", "Í", "Ị", "Ỉ", "Ĩ",
        "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
        "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
        "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
        "Đ", "Đ", "'"
    );
    $marKoDau = array(
        "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a",
        "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
        "i", "i", "i", "i", "i",
        "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o",
        "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
        "y", "y", "y", "y", "y",
        "d", "D", "",
        "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A",
        "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
        "I", "I", "I", "I", "I",
        "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O",
        "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
        "Y", "Y", "Y", "Y", "Y",
        "D", "D", "",
    );
    $title = str_replace($marTViet, $marKoDau, $title);
    $arr_str  = array("&lt;", "&gt;", "/", "\\", "&apos;", "&quot;", "&amp;", "lt;", "gt;", "apos;", "quot;", "amp;", "&lt", "&gt", "&apos", "&quot", "&amp", "&#34;", "&#39;", "&#38;", "&#60;", "&#62;");
    $title  = str_replace($arr_str, " ", $title);
    $title = preg_replace('/[^0-9a-zA-Z\s]+/', ' ', $title);

    $array = array(
        '    ' => ' ',
        '   ' => ' ',
        '  ' => ' ',
    );
    $title = trim(strtr($title, $array));
    $title = preg_replace('/\s+/', ' ', $title);
    $title  = str_replace(" ", "-", $title);
    $title  = urlencode($title);
    $array_apter = array("%0D%0A", "%", "&");
    $title  = str_replace($array_apter, "-", $title);
    $title  = strtolower($title);
    return $title;
}
// tỉnh thành
function all_city()
{
    $arrcity = [
        1 => 'Hà Nội',
        2 => 'Hải Phòng',
        3 => 'Bắc Giang',
        4 => 'Bắc Kạn',
        5 => 'Bắc Ninh',
        6 => 'Cao Bằng',
        7 => 'Điện Biên',
        8 => 'Hòa Bình',
        9 => 'Hải Dương',
        10 => 'Hà Giang',
        11 => 'Hà Nam',
        12 => 'Hưng Yên',
        13 => 'Lào Cai',
        14 => 'Lai Châu',
        15 => 'Lạng Sơn',
        16 => 'Ninh Bình',
        17 => 'Nam Định',
        18 => 'Phú Thọ',
        19 => 'Quảng Ninh',
        20 => 'Sơn La',
        21 => 'Thái Bình',
        22 => 'Thái Nguyên',
        23 => 'Tuyên Quang',
        24 => 'Vĩnh Phúc',
        25 => 'Yên Bái',
        26 => 'Đà Nẵng',
        27 => 'Thừa Thiên Huế',
        28 => 'Khánh Hòa',
        29 => 'Lâm Đồng',
        30 => 'Bình Định',
        31 => 'Bình Thuận',
        32 => 'Đắk Lắk',
        33 => 'Đắk Nông',
        34 => 'Gia Lai',
        35 => 'Hà Tĩnh',
        36 => 'Kon Tum',
        37 => 'Nghệ An',
        38 => 'Ninh Thuận',
        39 => 'Phú Yên',
        40 => 'Quảng Bình',
        41 => 'Quảng Nam',
        42 => 'Quảng Ngãi',
        43 => 'Quảng Trị',
        44 => 'Thanh Hóa',
        45 => 'Hồ Chí Minh',
        46 => 'Bình Dương',
        47 => 'Bà Rịa Vũng Tàu',
        48 => 'Cần Thơ',
        49 => 'An Giang',
        50 => 'Bạc Liêu',
        51 => 'Bình Phước',
        52 => 'Bến Tre',
        53 => 'Cà Mau',
        54 => 'Đồng Tháp',
        55 => 'Đồng Nai',
        56 => 'Hậu Giang',
        57 => 'Kiên Giang',
        58 => 'Long An',
        59 => 'Sóc Trăng',
        60 => 'Tiền Giang',
        61 => 'Tây Ninh',
        62 => 'Trà Vinh',
        63 => 'Vĩnh Long'
    ];
    return $arrcity;
}
function get_city($index)
{
    $arrcity = [
        1 => 'Hà Nội',
        2 => 'Hải Phòng',
        3 => 'Bắc Giang',
        4 => 'Bắc Kạn',
        5 => 'Bắc Ninh',
        6 => 'Cao Bằng',
        7 => 'Điện Biên',
        8 => 'Hòa Bình',
        9 => 'Hải Dương',
        10 => 'Hà Giang',
        11 => 'Hà Nam',
        12 => 'Hưng Yên',
        13 => 'Lào Cai',
        14 => 'Lai Châu',
        15 => 'Lạng Sơn',
        16 => 'Ninh Bình',
        17 => 'Nam Định',
        18 => 'Phú Thọ',
        19 => 'Quảng Ninh',
        20 => 'Sơn La',
        21 => 'Thái Bình',
        22 => 'Thái Nguyên',
        23 => 'Tuyên Quang',
        24 => 'Vĩnh Phúc',
        25 => 'Yên Bái',
        26 => 'Đà Nẵng',
        27 => 'Thừa Thiên Huế',
        28 => 'Khánh Hòa',
        29 => 'Lâm Đồng',
        30 => 'Bình Định',
        31 => 'Bình Thuận',
        32 => 'Đắk Lắk',
        33 => 'Đắk Nông',
        34 => 'Gia Lai',
        35 => 'Hà Tĩnh',
        36 => 'Kon Tum',
        37 => 'Nghệ An',
        38 => 'Ninh Thuận',
        39 => 'Phú Yên',
        40 => 'Quảng Bình',
        41 => 'Quảng Nam',
        42 => 'Quảng Ngãi',
        43 => 'Quảng Trị',
        44 => 'Thanh Hóa',
        45 => 'Hồ Chí Minh',
        46 => 'Bình Dương',
        47 => 'Bà Rịa Vũng Tàu',
        48 => 'Cần Thơ',
        49 => 'An Giang',
        50 => 'Bạc Liêu',
        51 => 'Bình Phước',
        52 => 'Bến Tre',
        53 => 'Cà Mau',
        54 => 'Đồng Tháp',
        55 => 'Đồng Nai',
        56 => 'Hậu Giang',
        57 => 'Kiên Giang',
        58 => 'Long An',
        59 => 'Sóc Trăng',
        60 => 'Tiền Giang',
        61 => 'Tây Ninh',
        62 => 'Trà Vinh',
        63 => 'Vĩnh Long'
    ];
    return $arrcity[$index];
}
// vị trí / cấp bậc
function all_vi_tri()
{
    $arr_vitri = [
        1 => 'Mới tốt nghiệp',
        2 => 'Thực tập sinh',
        3 => 'Nhân viên',
        4 => 'Trưởng nhóm',
        5 => 'Trưởng phòng',
        6 => 'Giám đốc và cấp cao hơn',
    ];
    return $arr_vitri;
}
function get_vi_tri($index)
{
    $arr_vitri = [
        1 => 'Mới tốt nghiệp',
        2 => 'Thực tập sinh',
        3 => 'Nhân viên',
        4 => 'Trưởng nhóm',
        5 => 'Trưởng phòng',
        6 => 'Giám đốc và cấp cao hơn',
    ];
    return $arr_vitri[$index];
}
// hình thức làm việc
function all_htlv()
{
    $arr = [
        1 => 'Làm việc tại công ty',
        2 => 'Làm việc online (Remote)',
    ];
    return $arr;
}
function get_htlv($index)
{
    $arr = [
        1 => 'Làm việc tại công ty',
        2 => 'Làm việc online (Remote)',
    ];
    if ($index > 0) {
        return $arr[$index];
    } else {
        return 'Chưa cập nhập';
    }
}
// loại hình làm việc
function all_lhlv()
{
    $arr = [
        1 => 'Bán thời gian',
        2 => 'Toàn thời gian',
    ];
    return $arr;
}
function get_lhlv($index)
{
    $arr = [
        1 => 'Bán thời gian',
        2 => 'Toàn thời gian',
    ];
    if ($index > 0) {
        return $arr[$index];
    } else {
        return 'Chưa cập nhập';
    }
}
// hình thức lương
function all_htl()
{
    $arr = [
        1 => 'Cố định',
        2 => 'Ước lượng',
        3 => 'Thỏa thuận',
    ];
    return $arr;
}
function get_htl($index)
{
    $arr = [
        1 => 'Cố định',
        2 => 'Ước lượng',
        3 => 'Thỏa thuận',
    ];
    if ($index > 0) {
        return $arr[$index];
    } else {
        return 'Chưa cập nhập';
    }
}

// trảlương
function all_ml()
{
    $arr = [
        1 => 'Giờ',
        2 => 'Tuần',
        3 => 'Ngày',
        4 => 'Tháng',
        5 => 'Dự án',
    ];
    return $arr;
}
function get_ml($index)
{
    $arr = [
        1 => 'Giờ',
        2 => 'Tuần',
        3 => 'Ngày',
        4 => 'Tháng',
        5 => 'Dự án',
    ];
    if ($index > 0) {
        return $arr[$index];
    } else {
        return 'Chưa cập nhập';
    }
}
//Giới tính
function all_sex()
{
    $arr = [
        1 => 'Nam',
        2 => 'Nữ',
        3 => 'Không yêu cầu',
    ];
    return $arr;
}
function get_sex($index)
{
    $arr = [
        1 => 'Nam',
        2 => 'Nữ',
        3 => 'Không yêu cầu',
    ];
    if ($index > 0) {
        return $arr[$index];
    } else {
        return 'Chưa cập nhập';
    }
}

//Tình trạng hôn nhân
function all_mary()
{
    $arr = [
        1 => 'Độc thân',
        2 => 'Kết hôn',
    ];
    return $arr;
}
function get_mary($index)
{
    $arr = [
        1 => 'Độc thân',
        2 => 'Kết hôn',
    ];
    if ($index > 0) {
        return $arr[$index];
    } else {
        return 'Chưa cập nhập';
    }
}

// hình thức trả lương
function all_httl()
{
    $arr = [
        1 => 'Trả lương theo giờ',
        2 => 'Trả lương theo tuần',
        3 => 'Trả lương theo ngày',
        4 => 'Trả lương theo tháng',
        5 => 'Trả lương theo dự án',
    ];
    return $arr;
}
function get_httl($index)
{
    $arr = [
        1 => 'Trả lương theo giờ',
        2 => 'Trả lương theo tuần',
        3 => 'Trả lương theo ngày',
        4 => 'Trả lương theo tháng',
        5 => 'Trả lương theo dự án',
    ];
    if ($index > 0) {
        return $arr[$index];
    } else {
        return 'Chưa cập nhập';
    }
}

// học vấn
function all_hv()
{
    $arr = [
        1 => 'Không yêu cầu',
        2 => 'Đại học',
        3 => 'Cao đẳng',
        4 => 'Phổ thông',
    ];
    return $arr;
}
function get_hv($index)
{
    $arr = [
        1 => 'Không yêu cầu',
        2 => 'Đại học',
        3 => 'Cao đẳng',
        4 => 'Phổ thông',
    ];
    if ($index > 0) {
        return $arr[$index];
    } else {
        return 'Chưa cập nhập';
    }
}

// kinh nghiệm
function all_exp()
{
    $arr = [
        1 => 'Không yêu cầu',
        2 => 'Dưới 1 năm',
        3 => '1-2 năm',
        4 => 'Trên 20 năm',
    ];
    return $arr;
}
function get_exp($index)
{
    $arr = [
        1 => 'Không yêu cầu',
        2 => 'Dưới 1 năm',
        3 => '1-2 năm',
        4 => 'Trên 20 năm',
    ];
    if ($index > 0) {
        return $arr[$index];
    } else {
        return 'Chưa cập nhập';
    }
}

function time_elapsed_string2($ptime, $cre_time = '')
{
    $etime = $ptime - time();


    if ($etime < 1) {
        return 'Hết hạn';
    }

    $a = array(
        365 * 24 * 60 * 60  =>  'năm',
        30 * 24 * 60 * 60  =>  'tháng',
        24 * 60 * 60  =>  'ngày',
        60 * 60  =>  'giờ',
        60  =>  'phút',
        1  =>  'giây'
    );
    $a_plural = array(
        'năm'  => 'năm',
        'tháng' => 'tháng',
        'ngày' => 'ngày',
        'giờ'  => 'giờ',
        'phút' => 'phút',
        'giây' => 'giây'
    );

    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return 'Còn ' . $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . '';
        }
    }
}
// lấy ds cate
function list_category()
{
    $CI = &get_instance();
    $CI->load->model('Models');
    $select = 'cat_id,cat_name,cat_alias';
    $table = 'category';
    $condition = '';
    $querry = $CI->Models->select_where_and($select, $table, $condition)->result_array();
    foreach ($querry as $value) {
        $arr[$value['cat_id']] = $value;
    }
    return $arr;
}
// lấy ds tag
function list_category_tag()
{
    $CI = &get_instance();
    $CI->load->model('Models');
    $select = 'tag_id,tag_name,tag_parent,tag_alias';
    $table = 'category_tag';
    $condition = '';
    $querry = $CI->Models->select_where_and($select, $table, $condition)->result_array();
    foreach ($querry as $value) {
        $arr[$value['tag_id']] = $value;
    }
    return $arr;
}
//lấy ds tinh thành
function list_city()
{
    $CI = &get_instance();
    $CI->load->database();

    $CI->db->select('*');
    $CI->db->where('cit_parent', 0);
    $array = $CI->db->get('city2')->result_array();
    $result = [];
    foreach ($array as $item) {
        $result[$item['cit_id']] = $item;
    }
    return $result;
}
function get_city_where($id_city)
{
    $CI = &get_instance();
    $CI->load->database();

    $CI->db->select('*');
    $CI->db->where('cit_id', $id_city);
    $array = $CI->db->get('city2')->row_array();
    return $array['cit_name'];
}
function url_ungvien($uv_alias, $uv_id)
{
    $url = '/' . $uv_alias . '-uv' . $uv_id . '.html';
    return $url;
}
function url_avt_ungvien($uv_createtime, $uv_avatar)
{
    $url = '/upload/uv/' . date('Y', $uv_createtime) . '/' . date('m', $uv_createtime) . '/' . date('d', $uv_createtime) . '/' . $uv_avatar;
    return $url;
}
function url_uv_city($uv_city)
{
    $url = 'ung-vien-theo-gio-tai-' . vn_str_filter(get_city($uv_city)) . '-k0t' . $uv_city . '.html';
    return $url;
}
function url_uv_lhlv($loailv)
{
    $url = '/ung-vien-theo-gio?keyword=&loailv=' . $loailv;
    return $url;
}
function url_uv_htlv($hinhthuc)
{
    $url = '/ung-vien-theo-gio?keyword=&hinhthuc=' . $hinhthuc;
    return $url;
}
function url_uv_luong($luong)
{
    $url = '/ung-vien-theo-gio?keyword=&luong=' . $luong;
    return $url;
}
function url_uv_honnhan($honnhan)
{
    $url = '/ung-vien-theo-gio?keyword=&honnhan=' . $honnhan;
    return $url;
}
function url_vieclam($new_alias, $new_id)
{
    $url = '/' . $new_alias . '-job' . $new_id . '.html';
    return $url;
}
function url_vieclam_city($cit_name, $cit_id)
{
    $url = '/tim-viec-lam-theo-gio-tai-' . vn_str_filter($cit_name) . '-nn0tt' . $cit_id . '.html';
    return $url;
}
function url_ntd($ntd_alias, $ntd_id)
{
    $url = '/' . $ntd_alias . '-ntd' . $ntd_id . '.html';
    return $url;
}
function url_avt_ntd($ntd_create_time, $ntd_avatar)
{
    $url = ' /upload/ntd/' . date('Y', $ntd_create_time) . '/' . date('m', $ntd_create_time) . '/' . date('d', $ntd_create_time) . '/' . $ntd_avatar;
    return $url;
}
function url_cv_uv($cat_alias, $cat_id)
{
    $url = '/ung-vien-' . $cat_alias . '-theo-gio-k' . $cat_id . 't0.html';
    return $url;
}
function url_vieclam_nn($cat_alias, $cat_id)
{
    $url = '/tim-viec-lam-' . $cat_alias . '-theo-gio-nn' . $cat_id . 'tt0.html';
    return $url;
}
function get_luong($uv_luong_1, $uv_luong_2, $uv_luong_3)
{
    if ($uv_luong_1 == 1) {
        $luong = get_htl($uv_luong_1) . '<br/>' . $uv_luong_2 . 'đ' . '/' . get_ml($uv_luong_3);
    } else if ($uv_luong_1 == 2) {
        $arr_price = explode('-', $uv_luong_2);
        $price_start = $arr_price[0];
        $price_end = $arr_price[1];
        $luong = get_htl($uv_luong_1) . '<br/>' . $price_start . ' - ' . $price_end . 'đ' . '/' . get_ml($uv_luong_3);
    } else if ($uv_luong_1 == 3 || $uv_luong_1 == 0) {
        $luong = 'Thỏa thuận';
    }
    return $luong;
}
// trạng thái ứng tuyển 
function all_stt_apply()
{
    $all_stt_apply = [
        0 => 'Đã nộp',
        1 => 'Đến phỏng vấn',
        2 => 'Hồ sơ đạt yêu cầu',
        3 => 'Hồ sơ không đạt yêu cầu',
    ];
    return $all_stt_apply;
}
function time_elapsed_string($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1) {
        return '0 giây';
    }
    $a = array(
        365 * 24 * 60 * 60  =>  'năm',
        30 * 24 * 60 * 60  =>  'tháng',
        24 * 60 * 60  =>  'ngày',
        60 * 60  =>  'giờ',
        60  =>  'phút',
        1  =>  'giây'
    );
    $a_plural = array(
        'năm'  => 'năm',
        'tháng' => 'tháng',
        'ngày' => 'ngày',
        'giờ'  => 'giờ',
        'phút' => 'phút',
        'giây' => 'giây'
    );
    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' trước';
        }
    }
}
//lấy quận huyện
function get_district($id)
{
    $CI = &get_instance();
    $CI->load->database();

    $CI->db->select('cit_id, cit_name, cit_parent');
    $CI->db->where('cit_id', $id);
    $result = $CI->db->get('city2')->row_array();
    return $result;
}
//lấy ra danh sách quận huyện theo tỉnh thành
function list_district($id_city)
{
    $CI = &get_instance();
    $CI->load->database();

    $CI->db->select('*');
    $CI->db->where('cit_parent', $id_city);
    $array = $CI->db->get('city2')->result_array();
    $result = [];
    foreach ($array as $item) {
        $result[$item['cit_id']] = $item;
    }
    return $result;
}
// tạo nội dung, mục lục bài viết chân trang
function remove_accent($mystring)
{
    $marTViet = array(
        "à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ",
        "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ",
        "ì", "í", "ị", "ỉ", "ĩ",
        "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ",
        "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
        "ỳ", "ý", "ỵ", "ỷ", "ỹ",
        "đ",
        "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
        "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
        "Ì", "Í", "Ị", "Ỉ", "Ĩ",
        "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
        "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
        "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
        "Đ",
        "'"
    );

    $marKoDau = array(
        "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a",
        "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
        "i", "i", "i", "i", "i",
        "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o",
        "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
        "y", "y", "y", "y", "y",
        "d",
        "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A",
        "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
        "I", "I", "I", "I", "I",
        "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O",
        "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
        "Y", "Y", "Y", "Y", "Y",
        "D",
        ""
    );

    return str_replace($marTViet, $marKoDau, $mystring);
}
function replaceTitle($title)
{
    $title = html_entity_decode($title, ENT_COMPAT, 'UTF-8');
    $title  = remove_accent($title);
    $title = str_replace('/', '', $title);
    $title = preg_replace('/[^\00-\255]+/u', '', $title);

    if (preg_match("/[\p{Han}]/simu", $title)) {
        $title = str_replace(' ', '-', $title);
    } else {
        $arr_str  = array("&lt;", "&gt;", "/", " / ", "\\", "&apos;", "&quot;", "&amp;", "lt;", "gt;", "apos;", "quot;", "amp;", "&lt", "&gt", "&apos", "&quot", "&amp", "&#34;", "&#39;", "&#38;", "&#60;", "&#62;");

        $title  = str_replace($arr_str, " ", $title);
        $title  = preg_replace('/\p{P}|\p{S}/u', ' ', $title);
        $title = preg_replace('/[^0-9a-zA-Z\s]+/', ' ', $title);

        //Remove double space
        $array = array(
            '    ' => ' ',
            '   ' => ' ',
            '  ' => ' ',
        );
        $title = trim(strtr($title, $array));
        $title  = str_replace(" ", "-", $title);
        $title  = urlencode($title);
        // remove cac ky tu dac biet sau khi urlencode
        $array_apter = array("%0D%0A", "%", "&");
        $title  = str_replace($array_apter, "-", $title);
        $title  = strtolower($title);
    }
    return $title;
}
function makeML_content($content, $search, $replace)
{
    if ($content != '') {
        require_once APPPATH . "helpers/simple_html_dom_helper.php";
        $opts = array('http' => array('method' => "GET", 'header' => "Accept-language: en\r\n" . "Cookie: foo=bar\r\n", 'user_agent' => 'simple_html_dom'));
        $context = stream_context_create($opts);

        $html = str_get_html($content, FALSE, $context);
        $h2s = $html->find("h2,h3,h4");
        $patterns = array('/\d+\.\d+\.\d+\.\s/i', '/\d+\.\d+\.\s/i', '/\d+\.\s/i');
        foreach ($h2s as $h2) {
            $text = preg_replace($patterns, '', str_replace('&nbsp;', ' ', $h2->plaintext));
            $id = replaceTitle($text);
            if ($id == $search) {
                $id = $replace;
            }
            $h2->id = $id;
        }
        $html = $html->save();
        return $html;
    }
}
function makeML($content, $search, $replace, $link)
{
    if ($content != '') {
        require_once APPPATH . "helpers/simple_html_dom_helper.php";
        $html = str_get_html($content);
        $h2s = $html->find("h2,h3,h4");
        $patterns = array('/\d+\.\d+\.\d+\.\s/i', '/\d+\.\d+\.\s/i', '/\d+\.\s/i');
        $ml = "<div class='boxmucluc'><ul>";
        $i = $u = $j = 0;
        foreach ($h2s as $h2) {
            $text = preg_replace($patterns, '', $h2->plaintext, 1);
            $id = replaceTitle($text);
            if ($id == $search) {
                $id = $replace;
            }
            $h2->id = $id;
            if ($h2->tag == 'h2') {
                $i++;
                $ml .= "<li><a class='ml_h2' href='" . $link . "#" . $id . "'>" . $i . ". " . trim($text) . "</a></li>";
                $j = 0;
            }
            if ($h2->tag == 'h3') {
                $j++;
                $ml .= "<li><a class='ml_h3' href='" . $link . "#" . $id . "'>" . $i . "." . $j . ". " . trim($text) . "</a></li>";
                $u = 0;
            }
            if ($h2->tag == 'h4') {
                $u++;
                $ml .= "<li><a class='ml_h4' href='" . $link . "#" . $id . "'>" . $i . "." . $j . "." . $u . ". " . trim($text) . "</a></li>";
            }
        }
        $ml .= '</ul></div>';
        echo $ml;
    }
}

function create_slug($string)
{
    $search = array(
        '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
        '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
        '#(ì|í|ị|ỉ|ĩ)#',
        '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
        '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
        '#(ỳ|ý|ỵ|ỷ|ỹ)#',
        '#(đ)#',
        '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
        '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
        '#(Ì|Í|Ị|Ỉ|Ĩ)#',
        '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
        '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
        '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
        '#(Đ)#',
        "/[^a-zA-Z0-9\-\_]/",
    );
    $replace = array(
        'a',
        'e',
        'i',
        'o',
        'u',
        'y',
        'd',
        'A',
        'E',
        'I',
        'O',
        'U',
        'Y',
        'D',
        '-',
    );
    $string = preg_replace($search, $replace, $string);
    $string = preg_replace('/(-)+/', '-', $string);
    $string = strtolower($string);
    return $string;
}
function checkStrInStr($str)
{
    $flag = true;
    $array_mau = ['tuyen-gap', 'hot', 'can-gap', 'luong-cao'];
    $string = create_slug($str);
    for ($i = 0; $i < count($array_mau); $i++) {
        if (strpos(trim($string), $array_mau[$i]) !== false) {
            $flag = 0;
        }
    }
    return $flag;
}

function checkAllKiTu($str, $array)
{
    $flag = true;
    for ($i = 0; $i < count($array); $i++) {
        if (strpos(trim($str), $array[$i]) !== false) {
            $flag = false;
        }
    }
    return $flag;
}
