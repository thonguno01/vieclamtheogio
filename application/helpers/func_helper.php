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
    $pagination['first_link'] = '?????u';
    $pagination['last_link'] = 'Cu???i';
    $pagination['query_string_segment'] = 'page';
    $pagination['use_page_numbers'] = TRUE;
    return $pagination;
}
function vn_str_filter($title)
{
    $marTViet = array(
        "??", "??", "???", "???", "??", "??", "???", "???", "???", "???", "???", "??", "???", "???", "???", "???", "???",
        "??", "??", "???", "???", "???", "??", "???", "???", "???", "???", "???",
        "??", "??", "???", "???", "??",
        "??", "??", "???", "???", "??", "??", "???", "???", "???", "???", "???", "??", "???", "???", "???", "???", "???",
        "??", "??", "???", "???", "??", "??", "???", "???", "???", "???", "???",
        "???", "??", "???", "???", "???",
        "??", "??", "'",
        "??", "??", "???", "???", "??", "??", "???", "???", "???", "???", "???", "??", "???", "???", "???", "???", "???",
        "??", "??", "???", "???", "???", "??", "???", "???", "???", "???", "???",
        "??", "??", "???", "???", "??",
        "??", "??", "???", "???", "??", "??", "???", "???", "???", "???", "???", "??", "???", "???", "???", "???", "???",
        "??", "??", "???", "???", "??", "??", "???", "???", "???", "???", "???",
        "???", "??", "???", "???", "???",
        "??", "??", "'"
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
// t???nh th??nh
function all_city()
{
    $arrcity = [
        1 => 'H?? N???i',
        2 => 'H???i Ph??ng',
        3 => 'B???c Giang',
        4 => 'B???c K???n',
        5 => 'B???c Ninh',
        6 => 'Cao B???ng',
        7 => '??i???n Bi??n',
        8 => 'H??a B??nh',
        9 => 'H???i D????ng',
        10 => 'H?? Giang',
        11 => 'H?? Nam',
        12 => 'H??ng Y??n',
        13 => 'L??o Cai',
        14 => 'Lai Ch??u',
        15 => 'L???ng S??n',
        16 => 'Ninh B??nh',
        17 => 'Nam ?????nh',
        18 => 'Ph?? Th???',
        19 => 'Qu???ng Ninh',
        20 => 'S??n La',
        21 => 'Th??i B??nh',
        22 => 'Th??i Nguy??n',
        23 => 'Tuy??n Quang',
        24 => 'V??nh Ph??c',
        25 => 'Y??n B??i',
        26 => '???? N???ng',
        27 => 'Th???a Thi??n Hu???',
        28 => 'Kh??nh H??a',
        29 => 'L??m ?????ng',
        30 => 'B??nh ?????nh',
        31 => 'B??nh Thu???n',
        32 => '?????k L???k',
        33 => '?????k N??ng',
        34 => 'Gia Lai',
        35 => 'H?? T??nh',
        36 => 'Kon Tum',
        37 => 'Ngh??? An',
        38 => 'Ninh Thu???n',
        39 => 'Ph?? Y??n',
        40 => 'Qu???ng B??nh',
        41 => 'Qu???ng Nam',
        42 => 'Qu???ng Ng??i',
        43 => 'Qu???ng Tr???',
        44 => 'Thanh H??a',
        45 => 'H??? Ch?? Minh',
        46 => 'B??nh D????ng',
        47 => 'B?? R???a V??ng T??u',
        48 => 'C???n Th??',
        49 => 'An Giang',
        50 => 'B???c Li??u',
        51 => 'B??nh Ph?????c',
        52 => 'B???n Tre',
        53 => 'C?? Mau',
        54 => '?????ng Th??p',
        55 => '?????ng Nai',
        56 => 'H???u Giang',
        57 => 'Ki??n Giang',
        58 => 'Long An',
        59 => 'S??c Tr??ng',
        60 => 'Ti???n Giang',
        61 => 'T??y Ninh',
        62 => 'Tr?? Vinh',
        63 => 'V??nh Long'
    ];
    return $arrcity;
}
function get_city($index)
{
    $arrcity = [
        1 => 'H?? N???i',
        2 => 'H???i Ph??ng',
        3 => 'B???c Giang',
        4 => 'B???c K???n',
        5 => 'B???c Ninh',
        6 => 'Cao B???ng',
        7 => '??i???n Bi??n',
        8 => 'H??a B??nh',
        9 => 'H???i D????ng',
        10 => 'H?? Giang',
        11 => 'H?? Nam',
        12 => 'H??ng Y??n',
        13 => 'L??o Cai',
        14 => 'Lai Ch??u',
        15 => 'L???ng S??n',
        16 => 'Ninh B??nh',
        17 => 'Nam ?????nh',
        18 => 'Ph?? Th???',
        19 => 'Qu???ng Ninh',
        20 => 'S??n La',
        21 => 'Th??i B??nh',
        22 => 'Th??i Nguy??n',
        23 => 'Tuy??n Quang',
        24 => 'V??nh Ph??c',
        25 => 'Y??n B??i',
        26 => '???? N???ng',
        27 => 'Th???a Thi??n Hu???',
        28 => 'Kh??nh H??a',
        29 => 'L??m ?????ng',
        30 => 'B??nh ?????nh',
        31 => 'B??nh Thu???n',
        32 => '?????k L???k',
        33 => '?????k N??ng',
        34 => 'Gia Lai',
        35 => 'H?? T??nh',
        36 => 'Kon Tum',
        37 => 'Ngh??? An',
        38 => 'Ninh Thu???n',
        39 => 'Ph?? Y??n',
        40 => 'Qu???ng B??nh',
        41 => 'Qu???ng Nam',
        42 => 'Qu???ng Ng??i',
        43 => 'Qu???ng Tr???',
        44 => 'Thanh H??a',
        45 => 'H??? Ch?? Minh',
        46 => 'B??nh D????ng',
        47 => 'B?? R???a V??ng T??u',
        48 => 'C???n Th??',
        49 => 'An Giang',
        50 => 'B???c Li??u',
        51 => 'B??nh Ph?????c',
        52 => 'B???n Tre',
        53 => 'C?? Mau',
        54 => '?????ng Th??p',
        55 => '?????ng Nai',
        56 => 'H???u Giang',
        57 => 'Ki??n Giang',
        58 => 'Long An',
        59 => 'S??c Tr??ng',
        60 => 'Ti???n Giang',
        61 => 'T??y Ninh',
        62 => 'Tr?? Vinh',
        63 => 'V??nh Long'
    ];
    return $arrcity[$index];
}
// v??? tr?? / c???p b???c
function all_vi_tri()
{
    $arr_vitri = [
        1 => 'M???i t???t nghi???p',
        2 => 'Th???c t???p sinh',
        3 => 'Nh??n vi??n',
        4 => 'Tr?????ng nh??m',
        5 => 'Tr?????ng ph??ng',
        6 => 'Gi??m ?????c v?? c???p cao h??n',
    ];
    return $arr_vitri;
}
function get_vi_tri($index)
{
    $arr_vitri = [
        1 => 'M???i t???t nghi???p',
        2 => 'Th???c t???p sinh',
        3 => 'Nh??n vi??n',
        4 => 'Tr?????ng nh??m',
        5 => 'Tr?????ng ph??ng',
        6 => 'Gi??m ?????c v?? c???p cao h??n',
    ];
    return $arr_vitri[$index];
}
// h??nh th???c l??m vi???c
function all_htlv()
{
    $arr = [
        1 => 'L??m vi???c t???i c??ng ty',
        2 => 'L??m vi???c online (Remote)',
    ];
    return $arr;
}
function get_htlv($index)
{
    $arr = [
        1 => 'L??m vi???c t???i c??ng ty',
        2 => 'L??m vi???c online (Remote)',
    ];
    if ($index > 0) {
        return $arr[$index];
    } else {
        return 'Ch??a c???p nh???p';
    }
}
// lo???i h??nh l??m vi???c
function all_lhlv()
{
    $arr = [
        1 => 'B??n th???i gian',
        2 => 'To??n th???i gian',
    ];
    return $arr;
}
function get_lhlv($index)
{
    $arr = [
        1 => 'B??n th???i gian',
        2 => 'To??n th???i gian',
    ];
    if ($index > 0) {
        return $arr[$index];
    } else {
        return 'Ch??a c???p nh???p';
    }
}
// h??nh th???c l????ng
function all_htl()
{
    $arr = [
        1 => 'C??? ?????nh',
        2 => '?????c l?????ng',
        3 => 'Th???a thu???n',
    ];
    return $arr;
}
function get_htl($index)
{
    $arr = [
        1 => 'C??? ?????nh',
        2 => '?????c l?????ng',
        3 => 'Th???a thu???n',
    ];
    if ($index > 0) {
        return $arr[$index];
    } else {
        return 'Ch??a c???p nh???p';
    }
}

// tr???l????ng
function all_ml()
{
    $arr = [
        1 => 'Gi???',
        2 => 'Tu???n',
        3 => 'Ng??y',
        4 => 'Th??ng',
        5 => 'D??? ??n',
    ];
    return $arr;
}
function get_ml($index)
{
    $arr = [
        1 => 'Gi???',
        2 => 'Tu???n',
        3 => 'Ng??y',
        4 => 'Th??ng',
        5 => 'D??? ??n',
    ];
    if ($index > 0) {
        return $arr[$index];
    } else {
        return 'Ch??a c???p nh???p';
    }
}
//Gi???i t??nh
function all_sex()
{
    $arr = [
        1 => 'Nam',
        2 => 'N???',
        3 => 'Kh??ng y??u c???u',
    ];
    return $arr;
}
function get_sex($index)
{
    $arr = [
        1 => 'Nam',
        2 => 'N???',
        3 => 'Kh??ng y??u c???u',
    ];
    if ($index > 0) {
        return $arr[$index];
    } else {
        return 'Ch??a c???p nh???p';
    }
}

//T??nh tr???ng h??n nh??n
function all_mary()
{
    $arr = [
        1 => '?????c th??n',
        2 => 'K???t h??n',
    ];
    return $arr;
}
function get_mary($index)
{
    $arr = [
        1 => '?????c th??n',
        2 => 'K???t h??n',
    ];
    if ($index > 0) {
        return $arr[$index];
    } else {
        return 'Ch??a c???p nh???p';
    }
}

// h??nh th???c tr??? l????ng
function all_httl()
{
    $arr = [
        1 => 'Tr??? l????ng theo gi???',
        2 => 'Tr??? l????ng theo tu???n',
        3 => 'Tr??? l????ng theo ng??y',
        4 => 'Tr??? l????ng theo th??ng',
        5 => 'Tr??? l????ng theo d??? ??n',
    ];
    return $arr;
}
function get_httl($index)
{
    $arr = [
        1 => 'Tr??? l????ng theo gi???',
        2 => 'Tr??? l????ng theo tu???n',
        3 => 'Tr??? l????ng theo ng??y',
        4 => 'Tr??? l????ng theo th??ng',
        5 => 'Tr??? l????ng theo d??? ??n',
    ];
    if ($index > 0) {
        return $arr[$index];
    } else {
        return 'Ch??a c???p nh???p';
    }
}

// h???c v???n
function all_hv()
{
    $arr = [
        1 => 'Kh??ng y??u c???u',
        2 => '?????i h???c',
        3 => 'Cao ?????ng',
        4 => 'Ph??? th??ng',
    ];
    return $arr;
}
function get_hv($index)
{
    $arr = [
        1 => 'Kh??ng y??u c???u',
        2 => '?????i h???c',
        3 => 'Cao ?????ng',
        4 => 'Ph??? th??ng',
    ];
    if ($index > 0) {
        return $arr[$index];
    } else {
        return 'Ch??a c???p nh???p';
    }
}

// kinh nghi???m
function all_exp()
{
    $arr = [
        1 => 'Kh??ng y??u c???u',
        2 => 'D?????i 1 n??m',
        3 => '1-2 n??m',
        4 => 'Tr??n 20 n??m',
    ];
    return $arr;
}
function get_exp($index)
{
    $arr = [
        1 => 'Kh??ng y??u c???u',
        2 => 'D?????i 1 n??m',
        3 => '1-2 n??m',
        4 => 'Tr??n 20 n??m',
    ];
    if ($index > 0) {
        return $arr[$index];
    } else {
        return 'Ch??a c???p nh???p';
    }
}

function time_elapsed_string2($ptime, $cre_time = '')
{
    $etime = $ptime - time();


    if ($etime < 1) {
        return 'H???t h???n';
    }

    $a = array(
        365 * 24 * 60 * 60  =>  'n??m',
        30 * 24 * 60 * 60  =>  'th??ng',
        24 * 60 * 60  =>  'ng??y',
        60 * 60  =>  'gi???',
        60  =>  'ph??t',
        1  =>  'gi??y'
    );
    $a_plural = array(
        'n??m'  => 'n??m',
        'th??ng' => 'th??ng',
        'ng??y' => 'ng??y',
        'gi???'  => 'gi???',
        'ph??t' => 'ph??t',
        'gi??y' => 'gi??y'
    );

    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return 'C??n ' . $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . '';
        }
    }
}
// l???y ds cate
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
// l???y ds tag
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
//l???y ds tinh th??nh
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
        $luong = get_htl($uv_luong_1) . '<br/>' . $uv_luong_2 . '??' . '/' . get_ml($uv_luong_3);
    } else if ($uv_luong_1 == 2) {
        $arr_price = explode('-', $uv_luong_2);
        $price_start = $arr_price[0];
        $price_end = $arr_price[1];
        $luong = get_htl($uv_luong_1) . '<br/>' . $price_start . ' - ' . $price_end . '??' . '/' . get_ml($uv_luong_3);
    } else if ($uv_luong_1 == 3 || $uv_luong_1 == 0) {
        $luong = 'Th???a thu???n';
    }
    return $luong;
}
// tr???ng th??i ???ng tuy???n 
function all_stt_apply()
{
    $all_stt_apply = [
        0 => '???? n???p',
        1 => '?????n ph???ng v???n',
        2 => 'H??? s?? ?????t y??u c???u',
        3 => 'H??? s?? kh??ng ?????t y??u c???u',
    ];
    return $all_stt_apply;
}
function time_elapsed_string($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1) {
        return '0 gi??y';
    }
    $a = array(
        365 * 24 * 60 * 60  =>  'n??m',
        30 * 24 * 60 * 60  =>  'th??ng',
        24 * 60 * 60  =>  'ng??y',
        60 * 60  =>  'gi???',
        60  =>  'ph??t',
        1  =>  'gi??y'
    );
    $a_plural = array(
        'n??m'  => 'n??m',
        'th??ng' => 'th??ng',
        'ng??y' => 'ng??y',
        'gi???'  => 'gi???',
        'ph??t' => 'ph??t',
        'gi??y' => 'gi??y'
    );
    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' tr?????c';
        }
    }
}
//l???y qu???n huy???n
function get_district($id)
{
    $CI = &get_instance();
    $CI->load->database();

    $CI->db->select('cit_id, cit_name, cit_parent');
    $CI->db->where('cit_id', $id);
    $result = $CI->db->get('city2')->row_array();
    return $result;
}
//l???y ra danh s??ch qu???n huy???n theo t???nh th??nh
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
// t???o n???i dung, m???c l???c b??i vi???t ch??n trang
function remove_accent($mystring)
{
    $marTViet = array(
        "??", "??", "???", "???", "??", "??", "???", "???", "???", "???", "???", "??", "???", "???", "???", "???", "???",
        "??", "??", "???", "???", "???", "??", "???", "???", "???", "???", "???",
        "??", "??", "???", "???", "??",
        "??", "??", "???", "???", "??", "??", "???", "???", "???", "???", "???", "??", "???", "???", "???", "???", "???",
        "??", "??", "???", "???", "??", "??", "???", "???", "???", "???", "???",
        "???", "??", "???", "???", "???",
        "??",
        "??", "??", "???", "???", "??", "??", "???", "???", "???", "???", "???", "??", "???", "???", "???", "???", "???",
        "??", "??", "???", "???", "???", "??", "???", "???", "???", "???", "???",
        "??", "??", "???", "???", "??",
        "??", "??", "???", "???", "??", "??", "???", "???", "???", "???", "???", "??", "???", "???", "???", "???", "???",
        "??", "??", "???", "???", "??", "??", "???", "???", "???", "???", "???",
        "???", "??", "???", "???", "???",
        "??",
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
        '#(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)#',
        '#(??|??|???|???|???|??|???|???|???|???|???)#',
        '#(??|??|???|???|??)#',
        '#(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)#',
        '#(??|??|???|???|??|??|???|???|???|???|???)#',
        '#(???|??|???|???|???)#',
        '#(??)#',
        '#(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)#',
        '#(??|??|???|???|???|??|???|???|???|???|???)#',
        '#(??|??|???|???|??)#',
        '#(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)#',
        '#(??|??|???|???|??|??|???|???|???|???|???)#',
        '#(???|??|???|???|???)#',
        '#(??)#',
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
