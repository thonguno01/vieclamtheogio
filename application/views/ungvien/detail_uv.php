<div class="n_body_search_1">
    <?php $this->load->view("includes/search_form.php"); ?>
</div>
<div class="n_detail_uv_container">
    <div class="n_detail_uv_content">
        <div class="n_detail_uv_content_1">
            <div class="n_detail_uv_content_1_top">
                <div class="n_detail_uv_content_1_left">
                    <div class="n_detail_uv_avatar">
                        <img class="" src="<?= url_avt_ungvien($infor['uv_createtime'], $infor['uv_avatar']) ?>" onerror="this.src='/images/n_defaul_avatar.svg';" alt="<?= $infor['uv_name'] ?>">
                    </div>
                    <div class="n_link_share_mobile">
                        <a rel="nofollow" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"><img id="" src="/images/n_icon_fb.svg"></a>
                        <a rel="nofollow" target="_blank" href="https://www.linkedin.com/sharer.php?u=<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"><img id="" src="/images/n_icon_likedin.svg"></a>
                        <a rel="nofollow" target="_blank" href="https://www.twitter.com/sharer.php?u=<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"><img id="" src="/images/n_icon_twi.svg"></a>

                    </div>
                </div>
                <div class="n_detail_uv_content_1_right">
                    <h1 class="n_detail_uv_name"><?= $infor['uv_name'] ?></h1>
                    <p class="n_detail_uv_job"><?= $infor['uv_vitri'] ?></p>
                    <div class="n_detail_uv_item">

                        <p class="n_detail_uv_label"><img src="/images/n_dtuv_icon_1.svg">Mã hồ sơ: <span class="n_dtuv_in4_txt"><?= $infor['uv_id'] ?></span></p>
                    </div>
                    <div class="n_detail_uv_item">

                        <p class="n_detail_uv_label"><img src="/images/n_dtuv_icon_2.svg">Giới tính: <span class="n_dtuv_in4_txt"><?= get_sex($infor['uv_sex']) ?></span></p>
                    </div>
                    <div class="n_detail_uv_item">

                        <p class="n_detail_uv_label"><img src="/images/n_dtuv_icon_3.svg">Ngày sinh: <span class="n_dtuv_in4_txt"><?= date('d-m-Y', $infor['uv_dob']) ?></span></p>
                    </div>
                    <div class="n_detail_uv_item">

                        <?php
                        $infor['uv_city_hope'] = (substr($infor['uv_city_hope'], -1) == ',') ? substr($infor['uv_city_hope'], 0, -1) :  $infor['uv_city_hope'];
                        $uv_city_hope = explode(',', $infor['uv_city_hope']);

                        if (count($uv_city_hope) > 0) {
                            foreach ($uv_city_hope as $key => $value) {
                                $uv_city_hope[$key] = get_city($value);
                            }
                            $uv_city_hope = implode(', ', $uv_city_hope);
                        } else {
                            $uv_city_hope = get_city($uv_city_hope[0]);
                        }
                        ?>
                        <p class="n_detail_uv_label"><img src="/images/n_map.svg">Địa chỉ: <span class="n_dtuv_in4_txt"><?= $infor['uv_address'] ?></span></p>

                    </div>
                    <div class="n_detail_uv_item">

                        <p class="n_detail_uv_label"><img src="/images/n_dtuv_icon_5.svg">Nơi làm việc mong muốn: <span class="n_dtuv_in4_txt"><?= $uv_city_hope ?></span></p>

                    </div>
                    <div class="n_detail_uv_item">

                        <p class="n_detail_uv_label"><img src="/images/n_dtuv_icon_5.svg">Ngày cập nhật : <span class="n_dtuv_in4_txt"><?= date('d-m-Y', $infor['date_refresh']) ?></span></p>

                    </div>
                </div>
            </div>
            <div class="n_detail_uv_content_1_bottom">
                <div class="n_detail_uv_item">

                    <p class="n_detail_uv_label"><img src="/images/n_map.svg">Địa chỉ: <span class="n_dtuv_in4_txt"><?= $infor['uv_address'] ?></span></p>
                </div>
                <div class="n_detail_uv_item">
                    <p class="n_detail_uv_label"><img src="/images/n_dtuv_icon_5.svg">Nơi làm việc mong muốn: <span class="n_dtuv_in4_txt"><?= $uv_city_hope ?></span></p>
                </div>
            </div>
            <div class="n_detail_uv_content_1_abs">
                <div class="n_job_func">
                    <div class="n_job_like_after"></div>
                    <?php
                    if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) {
                        if ($check_save_uv == null) { ?>
                            <div class="n_job_like_after"></div>
                            <button class="n_btn_like n_job_like" onClick="save_uv(<?= $infor['uv_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) ? $_COOKIE['UserId'] : '' ?>>
                                <img src="/images/n_icon_heart_plus.svg">
                                Lưu ứng viên
                            </button>
                            <div class="n_job_liked_after hide"></div>
                            <button class="n_btn_like n_job_liked hide" onClick="save_uv(<?= $infor['uv_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) ? $_COOKIE['UserId'] : '' ?>>
                                <img src="/images/n_icon_heart_plus.svg">
                                Đã lưu
                            </button>
                        <? } else { ?>
                            <div class="n_job_like_after"></div>
                            <button class="n_btn_like n_job_like hide" onClick="save_uv(<?= $infor['uv_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) ? $_COOKIE['UserId'] : '' ?>>
                                <img src="/images/n_icon_heart_plus.svg">
                                Lưu ứng viên
                            </button>
                            <div class="n_job_liked_after hide"></div>
                            <button class="n_btn_like n_job_liked" onClick="save_uv(<?= $infor['uv_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) ? $_COOKIE['UserId'] : '' ?>>
                                <img src="/images/n_icon_heart_plus.svg">
                                Đã lưu
                            </button>
                        <? }
                    } else { ?>
                        <button class="n_btn_like n_job_like" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) ? $_COOKIE['UserId'] : '' ?>>
                            <img src="/images/n_icon_heart_plus.svg">
                            Lưu ứng viên
                        </button>
                    <? } ?>
                    <div class="n_job_chat_after"></div>
                    <button class="n_job_chat" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) ? $_COOKIE['UserId'] : '' ?>>
                        <img src="/images/n_icon_chat.svg">
                        Chat
                    </button>
                </div>
                <div class="n_link_share">
                    <a rel="nofollow" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"><img id="" src="/images/n_icon_fb.svg"></a>
                    <a rel="nofollow" target="_blank" href="https://www.linkedin.com/sharer.php?u=<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"><img id="" src="/images/n_icon_likedin.svg"></a>
                    <a rel="nofollow" target="_blank" href="https://www.twitter.com/sharer.php?u=<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"><img id="" src="/images/n_icon_twi.svg"></a>

                </div>
            </div>
        </div>
        <div class="n_detail_uv_content_2">
            <div class="n_detail_uv_content_2_left">
                <div class="n_detail_uv_item">
                    <img id="" src="/images/n_icon_briefcase_666666.svg">
                    <p class="n_detail_uv_label">Loại công việc nhận làm:</p>
                    <?php $uv_cat = explode(',', $infor['uv_cat']); ?>
                    <?php
                    $list_cat = [];
                    foreach ($category as $value) {
                        $list_cat += [$value['cat_id'] => ['cat_name' => $value['cat_name'], 'cat_alias' => $value['cat_alias']]];
                    }
                    ?>
                    <?php foreach ($category as $cat_value) : ?>
                        <?php if (in_array($cat_value['cat_id'], $uv_cat) == true) { ?>
                            <a href="<?= url_cv_uv($cat_value['cat_alias'], $cat_value['cat_id']) ?>">
                                <p class="n_detail_uv_tag"><?= $cat_value['cat_name'] ?></p>
                            </a>
                        <?php } ?>
                    <?php endforeach; ?>
                </div>
                <div class="n_detail_uv_item">
                    <img src="/images/n_icon_book.svg">
                    <p class="n_detail_uv_label">Loại hình làm việc:</p>
                    <a href="<?= url_uv_lhlv($infor['uv_loai_hinh']) ?>">
                        <p class="n_detail_uv_tag"><?= get_lhlv($infor['uv_loai_hinh']) ?></p>
                    </a>
                </div>
                <div class="n_detail_uv_item">
                    <img src="/images/n_icon_signpost.svg">
                    <p class="n_detail_uv_label">Hình thức làm việc:</p>
                    <a href="<?= url_uv_htlv($infor['uv_hinh_thuc']) ?>">
                        <p class="n_detail_uv_tag"><?= get_htlv($infor['uv_hinh_thuc']) ?></p>
                    </a>
                </div>
                <div class="n_detail_uv_item">
                    <img src="/images/n_icon_coin.svg">
                    <p class="n_detail_uv_label">Mức lương mong muốn:</p>
                    <a href="<?= url_uv_luong($infor['uv_luong_1']) ?>">
                        <p class="n_detail_uv_not_tag"><?= get_htl($infor['uv_luong_1']) ?></p>
                    </a>
                </div>
                <div class="n_detail_uv_item">
                    <img src="/images/n_icon_mary.svg">
                    <p class="n_detail_uv_label">Tình trạng hôn nhân:</p>
                    <a href="<?= url_uv_honnhan($infor['uv_mary']) ?>">
                        <p class="n_detail_uv_not_tag"><?= get_mary($infor['uv_mary']) ?></p>
                    </a>
                </div>
            </div>
            <div class="n_detail_uv_content_2_right">
                <p class="n_detail_uv_content_2_right_title">Thông tin ứng viên</p>
                <?php
                if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) {
                    if ($check_see_uv == null) {
                        $check_see = 1; ?>
                        <div class="n_detail_uv_item">
                            <p class="n_detail_uv_label">SĐT: <span class="n_detail_uv_hide_in4 n_phone">Thông tin đã bị ẩn</span></p>

                        </div>
                        <div class="n_detail_uv_item">
                            <p class="n_detail_uv_label">Email: <span class="n_detail_uv_hide_in4 n_email">Thông tin đã bị ẩn</span></p>

                        </div>
                    <? } else {
                        $check_see = 2;
                        $sixMonth = getDate()[0] - $check_see_uv['create_date'];
                        // 6 thang k được xem nữa
                        if ($sixMonth >= 15552000) {
                            $delete_see_uv = [
                                'id_ntd' => $check_save_uv['id_ntd'],
                                'id_uv' => $check_save_uv['id_uv'],
                            ];
                            $result = $this->Models->delete_data('see_uv', $delete_see_uv);
                        }
                    ?>
                        <div class="n_detail_uv_item">
                            <p class="n_detail_uv_label">SĐT: <span class="n_detail_uv_hide_in4 n_phone"><?= $check_see_uv['uv_email'] ?></span></p>

                        </div>
                        <div class="n_detail_uv_item">
                            <p class="n_detail_uv_label">Email: <span class="n_detail_uv_hide_in4 n_email"><?= $check_see_uv['uv_phone'] ?></span></p>

                        </div>
                    <? }
                } else {
                    $check_see = 0; ?>
                    <div class="n_detail_uv_item">
                        <p class="n_detail_uv_label">SĐT: <span class="n_detail_uv_hide_in4 n_phone">Thông tin đã bị ẩn</span></p>

                    </div>
                    <div class="n_detail_uv_item">
                        <p class="n_detail_uv_label">Email: <span class="n_detail_uv_hide_in4 n_email">Thông tin đã bị ẩn</span></p>

                    </div>
                <? } ?>
                <div class="n_detail_uv_show_in4_btn">
                    <button id="n_show_in4" class="ntd_xemtt_uv" data-iduv="<?= $infor['uv_id'] ?>" data-check="<?= $check_see ?>" data-point=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) ? $_COOKIE['point'] : '' ?> data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) ? $_COOKIE['UserId'] : '' ?>>Xem chi tiết</button>
                </div>
            </div>
        </div>
        <div class="n_detail_uv_content_3">
            <div class="n_detail_uv_3" data-value="<?= $infor['uv_calam'] ?>">
                <div class="n_detail_uv_3_header">
                    <h2 class="n_detail_uv_3_header_txt">Buổi có thể đi làm</h2>
                </div>
                <div class="n_detail_uv_ca_lam">
                    <span class="n_detail_uv_tod">Sáng</span>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("21", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Thứ 2</p>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("31", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Thứ 3</p>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("41", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Thứ 4</p>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("51", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Thứ 5</p>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("61", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Thứ 6</p>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("71", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Thứ 7</p>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("81", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Chủ nhật</p>
                    <span class="n_detail_uv_tod">Chiều</span>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("22", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Thứ 2</p>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("32", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Thứ 3</p>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("42", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Thứ 4</p>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("52", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Thứ 5</p>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("62", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Thứ 6</p>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("72", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Thứ 7</p>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("82", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Chủ nhật</p>
                    <span class="n_detail_uv_tod">Tối</span>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("23", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Thứ 2</p>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("33", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Thứ 3</p>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("43", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Thứ 4</p>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("53", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Thứ 5</p>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("63", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Thứ 6</p>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("73", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Thứ 7</p>
                    <p class="n_detail_uv_dow <?php $array = explode(",", $infor['uv_calam']);
                                                if (in_array("83", $array)) {
                                                    echo 'n_detail_uv_dow_pick';
                                                } ?>">Chủ nhật</p>
                </div>
            </div>
            <div class="n_detail_uv_3">
                <div class="n_detail_uv_3_header">
                    <h2 class="n_detail_uv_3_header_txt">Giới thiệu chung</h2>
                </div>
                <div class="n_detail_uv_gtc">
                    <?= $infor['uv_gtc'] ?>
                </div>
            </div>
            <div class="n_detail_uv_3">
                <div class="n_detail_uv_3_header">
                    <h2 class="n_detail_uv_3_header_txt">Kinh nghiệm làm việc</h2>
                </div>
                <?php foreach ($work_infor as $in4name) : ?>

                    <div class="n_detail_uv_knlv">
                        <p class="n_detail_uv_knlv_label">Tên công ty: <span class="n_detail_uv_knlv_txt"> <?= $in4name['com_name'] ?></span></p>
                        <p class="n_detail_uv_knlv_label">Chức danh / Vị trí: <span class="n_detail_uv_knlv_txt"><?= get_vi_tri($in4name['vi_tri']) ?></span></p>
                        <p class="n_detail_uv_knlv_label">Thời gian bắt đầu: <span class="n_detail_uv_knlv_txt"><?= date('d-m-Y', $in4name['date_from']) ?></span></p>
                        <p class="n_detail_uv_knlv_label">Thời gian kết thúc: <span class="n_detail_uv_knlv_txt"><?= date('d-m-Y', $in4name['date_to']) ?></span></p>
                        <p class="n_detail_uv_knlv_label">Mô tả ngắn về kinh nghiệm:</p>
                    </div>
                    <div class="n_detail_uv_gtc">
                        <?= $in4name['mo_ta'] ?>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
    <div class="n_other_uv_container">
        <p class="n_other_uv_title">Ứng viên tiềm năng khác</p>
        <div class="n_other_uv_list">
            <div class="n_other_uv_sub_list">
                <?php foreach ($uvtn as $value) : ?>
                    <div class="n_other_uv_one_uv">
                        <div class="n_other_uv_avatar">
                            <a href="<?= url_ungvien($value['uv_alias'], $value['uv_id']) ?>"><img src="<?= url_avt_ungvien($value['uv_createtime'], $value['uv_avatar']) ?>"></a>
                        </div>
                        <div class="n_other_uv_in4">
                            <a href="<?= url_ungvien($value['uv_alias'], $value['uv_id']) ?>" class="n_other_uv_name"><?= $value['uv_name'] ?></a>
                            <div class="n_detail_uv_item">
                                <p class="n_other_uv_txt_cate">
                                    <span class="n_other_uv_txt_cate_img"><img src="/images/n_icon_map.svg"></span>
                                    <a href="<?= url_uv_city($value['uv_city']) ?>" class="n_other_uv_txt"><?= get_city($value['uv_city']) ?></a>
                                </p>
                            </div>
                            <div class="n_detail_uv_item">
                                <p class="n_other_uv_txt_cate">
                                    <span class="n_other_uv_txt_cate_img"><img src="/images/n_icon_briefcase.svg"></span>
                                    <?php
                                    $other_uv_cate = explode(',', $value['uv_cat']);
                                    if (count($other_uv_cate) > 0) {
                                        foreach ($other_uv_cate as $i => $x) {
                                            $other_uv_cate[$i] = '<span><a class="n_other_uv_txt_cate_link" href="' . url_cv_uv($list_cat[$x]['cat_alias'], $x) . '">' . $list_cat[$x]['cat_name'] . '</a></span>';
                                        }
                                        $other_uv_cate = implode(' / ', $other_uv_cate);
                                    } else {
                                        $x = $other_uv_cate[0];
                                        $other_uv_cate = '<span><a class="n_other_uv_txt_cate_link" href="' . url_cv_uv($list_cat[$x]['cat_alias'], $x) . '">' . $list_cat[$x]['cat_name'] . '</a></span>';
                                    }
                                    echo $other_uv_cate;
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <p class="n_other_uv_see_more"><a href="<?= url_cv_uv($list_cat[$cat_tn]['cat_alias'], $cat_tn) ?>" class="n_other_uv_see_more_link">Xem thêm >></a></p>
    </div>
</div>
<input type="hidden" class="type_login" value="4">
<?php $this->load->view("includes/popup_dang_nhap"); ?>