<div class="n_body_search_1">
    <div class="n_sub_body_search">
        <?php $this->load->view("includes/search_job.php"); ?>
        <?php $cate = list_category(); ?>
    </div>
</div>
<div class="n_detail_job_container">
    <div class="n_detail_job_content">
        <div class="n_detail_job_1">
            <p class="n_bread_cum"><a class="n_bread_cum_link" href="/">Trang chủ</a> / <a class="n_bread_cum_link" href="/tim-viec-lam-<?= $cate[$infor_job['new_cat']]['cat_alias'] ?>-theo-gio-nn<?= $infor_job['new_cat'] ?>tt0.html">Việc làm theo giờ <?= $cate[$infor_job['new_cat']]['cat_name'] ?></a> / <span class="n_bread_cum_txt"><?= $infor_job['new_title'] ?></span></p>
        </div>
        <div class="n_detail_job_2">
            <div class="n_detail_job_top">
                <div class="n_detail_job_2_left">
                    <?php
                    $d = date('d', $infor_job['ntd_create_time']);
                    $m = date('m', $infor_job['ntd_create_time']);
                    $y = date('Y', $infor_job['ntd_create_time']);
                    ?>
                    <div class="n_detail_job_avatar">
                        <img class="" src="<?= '/upload/ntd/' . $y . '/' . $m . '/' . $d . '/' . $infor_job['ntd_avatar'] ?>" onerror="this.src='/images/n_ava_logo.png';" alt="<?= $infor_job['new_title'] ?>">
                        <!-- <img class="" src="/images/n_ava_logo.png"> -->
                    </div>
                    <div class="n_detail_job_share_mobile">
                        <a rel="nofollow" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"><img id="" src="/images/n_icon_fb.svg"></a>
                        <a rel="nofollow" target="_blank" href="https://www.linkedin.com/sharer.php?u=<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"><img id="" src="/images/n_icon_likedin.svg"></a>
                        <a rel="nofollow" target="_blank" href="https://www.twitter.com/sharer.php?u=<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"><img id="" src="/images/n_icon_twi.svg"></a>

                    </div>
                </div>
                <div class="n_detail_job_2_right">
                    <h1 class="n_detail_job_name"><?= $infor_job['new_title'] ?></h1>
                    <div class="n_text_in4_lhlv">
                        <?php
                        if ($infor_job['new_hinh_thuc'] == 2)
                            echo '<span class="n_detail_job_htlv">Remote</span></p>'
                        ?>
                    </div>
                    <p class="n_detail_job_com_name"><img class="n_detail_job_icon" src="/images/n_dtuv_icon_5.svg"><a class="n_detail_job_com_link" href="/<?= $infor_job['ntd_alias'] ?>-ntd<?= $infor_job['new_user_id'] ?>.html"><?= $infor_job['ntd_company'] ?></a></p>
                    <div class="n_detail_job_addr">
                        <img class="n_detail_job_icon" src="/images/n_map.svg">
                        <img class="n_icon_dash" src="/images/line_dash.svg">
                        <p class="n_detail_job_in4"><span class="n_detail_job_in4_label">Khu vực: </span><?= get_district($infor_job['new_qh'])['cit_name'] ?>, <?= get_city($infor_job['new_city']) ?></p>
                        <p class="n_detail_job_in4"><span class="n_detail_job_in4_label">Địa chỉ chi tiết: </span><?= $infor_job['new_address'] ?>, <?= get_district($infor_job['new_qh'])['cit_name'] ?>, <?= get_city($infor_job['new_city']) ?></p>
                    </div>
                    <p class="n_detail_job_in4"><img class="n_detail_job_icon" src="/images/n_icon_calendar.svg"><span class="n_detail_job_in4_label">Hạn nộp hồ sơ: </span><?= date('d-m-Y', $infor_job['new_han_nop']) ?></p>
                    <p class="n_detail_job_view">Lượt xem: <?= $infor_job['view_new'] ?></p>
                </div>
                <div class="n_detail_job_abs">
                    <div class="n_detail_job_func n_job_func">
                        <?php if ($save_new > 0) { ?>
                            <div class="n_job_like_after hide"></div>
                            <button class="n_btn_like n_job_like hide" onClick="save_new(<?= $infor_job['ntd_id'] ?>,<?= $infor_job['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                <img src="/images/n_icon_heart_plus.svg">
                                Lưu
                            </button>
                            <div class="n_job_liked_after"></div>
                            <button class="n_btn_like n_job_liked" onClick="save_new(<?= $infor_job['ntd_id'] ?>,<?= $infor_job['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                <img src="/images/n_icon_heart_plus.svg">
                                Đã lưu
                            </button>
                        <?php } else { ?>
                            <div class="n_job_like_after"></div>
                            <button class="n_btn_like n_job_like" onClick="save_new(<?= $infor_job['ntd_id'] ?>,<?= $infor_job['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                <img src="/images/n_icon_heart_plus.svg">
                                Lưu
                            </button>
                            <div class="n_job_liked_after hide"></div>
                            <button class="n_btn_like n_job_liked hide" onClick="save_new(<?= $infor_job['ntd_id'] ?>,<?= $infor_job['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                <img src="/images/n_icon_heart_plus.svg">
                                Đã lưu
                            </button>
                        <?php } ?>
                        <div class="n_job_chat_after"></div>
                        <button class="n_job_chat" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                            <img src="/images/n_icon_chat.svg">
                            Chat
                        </button>
                        <?php if ($infor_job['new_han_nop'] < time()) { ?>
                            <!-- tin hết hạn -->
                            <div class="n_job_hh_after"></div>
                            <div class="n_job_hh">
                                <img src="/images/n_icon_thh.svg">
                                Đã hết hạn
                            </div>
                        <?php } else if ($apply_new > 0) { ?>
                            <!-- đã ứng tuyển -->
                            <div class="n_job_uted_after"></div>
                            <button class="n_job_uted">
                                <img src="/images/n_icon_ut.svg">
                                Đã ứng tuyển
                            </button>
                        <?php } else { ?>
                            <div class="n_job_ut_after n_btn_ut"></div>
                            <button class="n_job_ut n_btn_ut" data-iduser="<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>" data-ca="<?= $infor_job['new_no_calam'] ?>">
                                <img src="/images/n_icon_ut.svg">
                                Ứng tuyển
                            </button>
                            <!-- đã ứng tuyển -->
                            <div class="n_job_uted_after hide"></div>
                            <button class="n_job_uted hide">
                                <img src="/images/n_icon_ut.svg">
                                Đã ứng tuyển
                            </button>
                        <?php } ?>
                    </div>
                    <div class="n_detail_job_share">
                        <a rel="nofollow" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"><img id="" src="/images/n_icon_fb.svg"></a>
                        <a rel="nofollow" target="_blank" href="https://www.linkedin.com/sharer.php?u=<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"><img id="" src="/images/n_icon_likedin.svg"></a>
                        <a rel="nofollow" target="_blank" href="https://www.twitter.com/sharer.php?u=<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"><img id="" src="/images/n_icon_twi.svg"></a>
                    </div>
                </div>
            </div>
            <div class="n_detail_job_bottom">
                <p class="n_detail_job_in4"><img class="n_detail_job_icon" src="/images/n_icon_dollar.svg"><span class="n_detail_job_label">Mức lương:</span>
                    <?php if ($infor_job['new_luong_1'] == 1) {
                        echo  '<span class="n_detail_job_in4_spt">' . get_htl($infor_job['new_luong_1']) . '-' . number_format((float)$infor_job['new_luong_2']) . 'VNĐ/' . get_ml($infor_job['new_luong_3']) . '</span>';
                    } else if ($infor_job['new_luong_1'] == 2) {
                        $arr_price = explode('-', $infor_job['new_luong_2']);

                        $price1 = number_format($arr_price[0]);
                        $price2 = number_format($arr_price[1]);
                        $price = $price1 . '-' . $price2;
                        echo '<span class="n_detail_job_in4_spt">' . $price . 'VNĐ/' . get_ml($infor_job['new_luong_3']) . '</span>';
                    } else {
                        echo '<span class="n_detail_job_in4_spt">Thỏa thuận</span>';
                    }
                    ?>

                </p>
                <p class="n_detail_job_in4"><img class="n_detail_job_icon" src="/images/n_dtuv_icon_2_blue.svg"><span class="n_detail_job_label">Giới tính: </span><?= get_sex($infor_job['new_sex']) ?></p>
                <p class="n_detail_job_in4"><img class="n_detail_job_icon" src="/images/n_icon_award.svg"><span class="n_detail_job_label">Kinh nghiệm làm việc: </span> <?= get_exp($infor_job['new_knlv']) ?></p>
                <!-- <p class="n_detail_job_in4"><img class="n_detail_job_icon" src="/images/n_icon_note_2.svg"><span class="n_detail_job_label">Số lượng tuyển dụng: </span>3</p> -->
                <p class="n_detail_job_in4"><img class="n_detail_job_icon" src="/images/n_icon_briefcase.svg"><span class="n_detail_job_label">Loại công việc: </span> <span class="n_detail_job_tag"><?= $cate[$infor_job['new_cat']]['cat_name'] ?></span></p>
                <p class="n_detail_job_in4"><img class="n_detail_job_icon" src="/images/n_icon_hat.svg"><span class="n_detail_job_label">Học vấn tối thiểu: </span><?= get_hv($infor_job['new_hoc_van']) ?></p>
                <p class="n_detail_job_in4"><img class="n_detail_job_icon" src="/images/n_icon_book_blue.svg"><span class="n_detail_job_label">Loại hình làm việc: </span> <span class="n_detail_job_tag"><?= get_lhlv($infor_job['new_loai_hinh']) ?></span></p>
                <p class="n_detail_job_in4"><img class="n_detail_job_icon" src="/images/n_icon_signpost_blue.svg"><span class="n_detail_job_label">Hình thức làm việc: </span> <span class="n_detail_job_tag"><?= get_htlv($infor_job['new_hinh_thuc']) ?></span></p>
                <p class="n_detail_job_in4"><img class="n_detail_job_icon" src="/images/n_dtuv_icon_3_blue.svg"><span class="n_detail_job_label">Yêu cầu độ tuổi: </span><?= $infor_job['new_age'] ?></p>
                <p class="n_detail_job_in4"><img class="n_detail_job_icon" src="/images/n_icon_wallet.svg"><span class="n_detail_job_label">Hình thức trả lương: </span><?= get_httl($infor_job['new_httl']) ?></p>
            </div>
        </div>
        <div class="n_detail_job_3">
            <div class="n_detail_job_3_left">
                <div class="n_dtj_3">
                    <div class="n_dtj_3_header">
                        <h2 class="n_dtj_3_header_txt">Lịch làm việc</h2>
                    </div>
                    <?php
                    if ($infor_job['new_no_calam'] == 0) {
                        echo '<p class="n_detail_job_txt">Công việc này có ca làm linh hoạt, bạn sẽ được sắp xếp cụ thể khi trao đổi trực tiếp.</p>';
                    } else {
                        $start = explode(',', $infor_job['new_ca_start']);
                        $end = explode(',', $infor_job['new_ca_end']);
                        $t2 = explode(',', $infor_job['new_t2']);
                        $t3 = explode(',', $infor_job['new_t3']);
                        $t4 = explode(',', $infor_job['new_t4']);
                        $t5 = explode(',', $infor_job['new_t5']);
                        $t6 = explode(',', $infor_job['new_t6']);
                        $t7 = explode(',', $infor_job['new_t7']);
                        $cn = explode(',', $infor_job['new_cn']);
                        $total_ca = count($start);
                        echo '<p class="n_detail_job_txt">Công việc này có ' . $total_ca . ' ca làm, bạn sẽ được sắp xếp cụ thể khi trao đổi trực tiếp.</p>';
                        for ($i = 0; $i < $total_ca; $i++) : ?>
                            <div class="n_detail_uv_ca_lam">
                                <span class="n_detail_job_ca_stt">Ca <?= $i + 1 ?></span>
                                <span class="n_detail_job_ca_time">Giờ làm việc:<?= $start[$i] ?>-<?= $end[$i] ?></span>
                                <p class="n_detail_uv_dow<?= $t2[$i] == 1 ? ' n_detail_uv_dow_pick' : '' ?>">Thứ 2</p>
                                <p class="n_detail_uv_dow<?= $t3[$i] == 1 ? ' n_detail_uv_dow_pick' : '' ?>">Thứ 3</p>
                                <p class="n_detail_uv_dow<?= $t4[$i] == 1 ? ' n_detail_uv_dow_pick' : '' ?>">Thứ 4</p>
                                <p class="n_detail_uv_dow<?= $t5[$i] == 1 ? ' n_detail_uv_dow_pick' : '' ?>">Thứ 5</p>
                                <p class="n_detail_uv_dow<?= $t6[$i] == 1 ? ' n_detail_uv_dow_pick' : '' ?>">Thứ 6</p>
                                <p class="n_detail_uv_dow<?= $t7[$i] == 1 ? ' n_detail_uv_dow_pick' : '' ?>">Thứ 7</p>
                                <p class="n_detail_uv_dow<?= $cn[$i] == 1 ? ' n_detail_uv_dow_pick' : '' ?>">Chủ nhật</p>
                            </div>
                    <?php endfor;
                    } ?>

                </div>
                <div class="n_dtj_3">
                    <div class="n_dtj_3_header">
                        <h2 class="n_dtj_3_header_txt">Mô tả công việc</h2>
                    </div>
                    <p class="n_detail_job_mota"><?= $infor_job['new_mota'] ?></p>
                </div>
                <div class="n_dtj_3">
                    <div class="n_dtj_3_header">
                        <h2 class="n_dtj_3_header_txt">Yêu cầu công việc</h2>
                    </div>
                    <p class="n_detail_job_mota"><?= $infor_job['new_yeu_cau'] ?></p>
                </div>
                <div class="n_dtj_3">
                    <div class="n_dtj_3_header">
                        <h2 class="n_dtj_3_header_txt">Quyền lợi</h2>
                    </div>
                    <p class="n_detail_job_mota"><?= $infor_job['new_quyen'] ?></p>
                </div>
                <div class="n_dtj_3">
                    <?php if ($infor_job['new_han_nop'] < time()) { ?>
                        <!-- tin hết hạn -->
                        <div class="n_job_hh_bottom">
                            <img src="/images/n_icon_thh.svg">
                            Đã hết hạn
                        </div>
                    <?php } else if ($apply_new > 0) { ?>
                        <!-- đã ứng tuyển -->
                        <button class="n_job_uted_bottom">
                            <img src="/images/n_icon_ut.svg">
                            Đã ứng tuyển
                        </button>
                    <?php } else { ?>
                        <button class="n_job_ut_bottom n_btn_ut" data-iduser="<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>" data-ca="<?= $infor_job['new_no_calam'] ?>">
                            <img src="/images/n_icon_ut.svg">
                            Ứng tuyển
                        </button>
                        <!-- đã ứng tuyển -->
                        <button class="n_job_uted_bottom hide">
                            <img src="/images/n_icon_ut.svg">
                            Đã ứng tuyển
                        </button>
                    <?php } ?>
                </div>
            </div>
            <div class="n_detail_job_3_right">
                <!-- <div class="n_detail_job_ttlh">
                    <p class="n_detail_job_ttlh_title">Thông tin người liên hệ</p>
                    <p class="n_detail_job_name_lh"><span class="n_detail_job_in4_label">Tên người liên hệ: </span>Nguyễn Hồng Hải</p>
                    <p class="n_detail_job_email_lh"><span class="n_detail_job_in4_label">Email: </span>honghainguyen@gmail.com</p>
                    <p class="n_detail_job_email_lh"><span class="n_detail_job_in4_label">Số điện thoại: </span>0917000376</p>
                </div> -->
                <div class="n_list_job_of_com">
                    <h2 class="n_detail_job_ttlh_title">Việc làm cùng nhà tuyển dụng</h2>
                    <?php foreach ($job as $value) : ?>
                        <div class="n_job_of_com">
                            <h3 class="n_job_of_com_name"><a href="/<?= $value['new_alias'] ?>-job<?= $value['new_id'] ?>.html" class="n_job_of_com_name_link"><?= $value['new_title'] ?></a></h3>
                            <p class="n_job_of_com_in4"><img class="n_job_of_com_icon" src="/images/n_icon_map.svg"><a class="n_job_of_com_in4" href="/tim-viec-lam-theo-gio-tai-<?= vn_str_filter(get_city($value['new_city'])) ?>-nn0tt<?= $value['new_city'] ?>.html"><?= get_city($value['new_city']) ?></a></p>
                            <p class="n_job_of_com_in4"><img class="n_job_of_com_icon" src="/images/n_icon_briefcase.svg"><a class="n_job_of_com_in4" href="/tim-viec-lam.html?key=&lh=<?= $value['new_loai_hinh'] ?>"><?= get_lhlv($value['new_loai_hinh']) ?></a></p>
                            <p class="n_job_of_com_in4"><img class="n_job_of_com_icon" src="/images/n_icon_dollar.svg"><span class="n_detail_job_in4_spt">
                                    <?php if ($value['new_luong_1'] == 0) {
                                        echo 'Thỏa thuận';
                                    } else if ($value['new_luong_1'] == 2) {
                                        $arr_price = explode('-', $value['new_luong_2']);
                                        $price1 = number_format($arr_price[0]);
                                        $price2 = number_format($arr_price[1]);
                                        $price = $price1 . '-' . $price1;
                                        echo $price . 'VNĐ/' . get_ml($value['new_luong_3']);
                                    } else {
                                        echo number_format((float)$value['new_luong_2']) . 'VNĐ/' . get_ml($value['new_luong_3']);
                                    }
                                    ?>
                                </span></p>
                        </div>
                    <?php endforeach; ?>
                    <p class="n_list_job_of_com_seemore"><a class="n_list_job_of_com_seemore_link" href="/<?= $value['ntd_alias'] ?>-ntd<?= $value['new_user_id'] ?>.html">Xem tất cả >></a></p>
                </div>
                <div class="n_list_tag">
                    <p class="n_list_tag_title"><img src="/images/n_icon_tag.svg">Từ khóa liên quan:</p>
                    <div class="">
                        <p class="n_tag">Bán hàng</p>
                        <p class="n_tag">Nhân viên bán hàng </p>
                        <p class="n_tag">Việc làm theo giờ</p>
                        <p class="n_tag">Nhân viên bán hàng </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="type_login" value="3">
<?php $this->load->view("includes/popup_dang_nhap"); ?>
<?php $this->load->view("includes/popup_ung_tuyen"); ?>