<div class="n_body_search_1">
    <div class="n_sub_body_search">
        <?php
        $this->load->view('/includes/search_job')
        ?>
    </div>
</div>
<div class="container">
    <div class="py-4 detail_ntd">
        <div class="head_detail_img">
            <?php
            $d = date('d', $ntd_detail['ntd_create_time']);
            $m = date('m', $ntd_detail['ntd_create_time']);
            $y = date('Y', $ntd_detail['ntd_create_time']);
            ?>
            <img id="background_ntd" src="<?= '/upload/ntd/' . $y . '/' . $m . '/' . $d . '/' . $ntd_detail['ntd_cover_background'] ?>" onerror="this.src='/images/head_detail_img.png';" alt="">
        </div>
        <div class="detail_ntd_title">
            <div class="n_detail_ntd_left">
                <div class="detail_ntd_img">
                    <img class="img_ntd" src="<?= '/upload/ntd/' . $y . '/' . $m . '/' . $d . '/' . $ntd_detail['ntd_avatar'] ?>" onerror="this.src='/images/avatar_qlc_ntd.png';" alt="">
                </div>
                <div class="header_info_ntd">
                    <h1 id="ntd_name"><?= $ntd_detail['ntd_company'] ?></h1>
                    <div class="address_ntd">
                        <img class="address_ntd_img" src="/images/n_map.svg" alt="">
                        <img class="address_ntd_line" src="/images/line_dash.svg" alt="">
                        <div class="h1_address py-3">
                            <p class="address_ntd_text">Khu vực : <span class="address_ntd_span"><?= get_city($ntd_detail['ntd_city']) ?></span></p>
                            <p class="address_ntd_text">Địa chỉ cụ thể : <span class="address_ntd_span"><?= $ntd_detail['ntd_address'] ?>, <?= $ntd_detail['cit_name'] ?>, <?= get_city($ntd_detail['ntd_city']) ?></span></p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="address_ntd_mobile">
                <img class="address_ntd_img" src="/images/n_map.svg" alt="">
                <img class="address_ntd_line" src="/images/line_dash.svg" alt="">
                <div class="h1_address py-3">
                    <h1 class="address_ntd_text">Khu vực : <span class="address_ntd_span"><?= get_city($ntd_detail['ntd_city']) ?></span></h1>
                    <h1 class="address_ntd_text">Địa chỉ cụ thể : <span class="address_ntd_span"><?= $ntd_detail['ntd_address'] ?>, <?= $ntd_detail['cit_name'] ?>, <?= get_city($ntd_detail['ntd_city']) ?></span></h1>
                </div>
            </div>
            <!-- option_2 -->
            <div class="more_option_2 text-center">
                <a class="message_text py-2" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                    <img src="/images/message-text.png" alt="">Chat với nhà tuyển dụng
                </a>
                <div class="social_ntd py-3">
                    <a href=""><img src="/images/facebook.png" alt=""></a>
                    <a href=""><img src="/images/Linkedin.png" alt="ewd"></a>
                    <a href=""><img src="/images/twiter.png" alt=""></a>
                </div>
            </div>
            <div class="detail_ntd_info">
                <div class="detail_ntd_options text-center">
                    <div class="work_ntd">
                        <p class="work_viec_lam"><span class="number_work"><?= $total_job ?></span><br>Việc làm</p>
                    </div>

                    <div class="more_option">
                        <a class="message_text py-2" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                            <img src="/images/message-text.png" alt="">Chat với nhà tuyển dụng
                        </a>
                        <div class="social_ntd py-3">
                            <a href=""><img src="/images/facebook.png" alt=""></a>
                            <a href=""><img src="/images/Linkedin.png" alt="ddd"></a>
                            <a href=""><img src="/images/twiter.png" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="introduce_ntd">
        <div class="introduce_ntd_box1">
            <h2 class="introduce_ntd_box1_title">Giới thiệu chung</h2>
            <div class="introduce_ntd_content">
                <p><?= $ntd_detail['ntd_gioi_thieu'] ?>
                </p>
            </div>
        </div>
        <div class="introduce_ntd_box2">
            <h2 class="introduce_ntd_box1_title">Thông tin nhà tuyển dụng</h2>
            <div class="introduce_ntd_content ntd_content_info">
                <?php
                if (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) { ?>
                    <h3 class="content_info_ntd">Mã số thuế:<span class="span_tt"><?= $ntd_detail['ntd_msthue'] ?></span></h3>
                    <h3 class="content_info_ntd">SĐT:<span class="span_tt"><?= $ntd_detail['ntd_phone'] ?></span></h3>
                    <h3 class="content_info_ntd">Email:<span class="span_tt"><?= $ntd_detail['ntd_email'] ?></span></h3>
                    <h3 class="content_info_ntd">Website:<span class="span_tt">ntd.com</span></h3>
                    <h3 class="content_info_ntd">Zalo:<span class="span_tt"><?= $ntd_detail['ntd_zalo'] ?></span></h3>
                    <h3 class="content_info_ntd"> Skype:<span class="span_tt"><?= $ntd_detail['ntd_skype'] ?></span></h3>
            </div>
        <?php } else { ?>
            <h3 class="content_info_ntd">Mã số thuế:<span class="span_tt">Thông tin đã bị ẩn</span></h3>
            <h3 class="content_info_ntd">SĐT:<span class="span_tt">Thông tin đã bị ẩn</span></h3>
            <h3 class="content_info_ntd">Email:<span class="span_tt">Thông tin đã bị ẩn</span></h3>
            <h3 class="content_info_ntd">Website:<span class="span_tt">Thông tin đã bị ẩn</span></h3>
            <h3 class="content_info_ntd">Zalo:<span class="span_tt">Thông tin đã bị ẩn</span></h3>
            <h3 class="content_info_ntd"> Skype:<span class="span_tt">Thông tin đã bị ẩn</span></h3>
        </div>
        <div class="text-center">
            <button class="btn btn_ttct">Xem chi tiết</button>
        </div>
    <?php }
    ?>
    </div>
</div>

<div class="vi_tri_tuyen_dung py-5">
    <h2 class="vi_tri_tuyen_dung_title">Vị trí đang tuyển dụng</h2>
    <div class="list_vi_tri pt-4 ">
        <?php
        foreach ($ntd_job as $value) : ?>
            <div class="n_one_job">
                <div class="n_one_job_left">
                    <div class="n_one_job_top">
                        <a href="/any-ntd1.html" class="n_job_logo"><img src="<?= '/upload/ntd/' . $y . '/' . $m . '/' . $d . '/' . $ntd_detail['ntd_avatar'] ?>" onerror="this.src='/images/n_ava_logo.png'" alt="<?= $value['new_title'] ?>"></a>
                        <div class="n_job_detail">
                            <div class="n_job_in4_name">
                                <h3><a href="/<?= $value['new_alias'] ?>-job<?= $value['new_id'] ?>.html" class="n_text_in4_name"><?= $value['new_title'] ?></a></h3>
                            </div>
                            <div class="n_job_in4s">
                                <div class="n_job_in4 n_job_tt">
                                    <img src="/images/n_icon_map.svg">
                                    <p class="n_text_in4_o"><?= get_city($value['new_city']) ?></p>
                                </div>
                                <div class="n_job_in4 n_job_in4_after_768">
                                    <img src="/images/n_icon_briefcase.svg">
                                    <p class="n_text_in4_o"><?= get_lhlv($value['new_loai_hinh']) ?></p>
                                </div>
                                <div class="n_job_in4 n_job_in4_after_768">
                                    <img src="/images/n_icon_clock.svg">
                                    <p class="n_text_in4_o">
                                        <?php
                                        echo time_elapsed_string2($value['new_han_nop'], '');
                                        ?>
                                    </p>
                                </div>
                                <div class="n_job_in4 n_job_sa">
                                    <img src="/images/n_icon_dollar.svg">
                                    <p class="n_text_in4_o n_text_in4_spt">
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
                                    </p>
                                </div>
                                <div class="n_job_in4 n_job_in4_after_768">
                                    <img src="/images/n_icon_wallet.svg">
                                    <p class="n_text_in4_o"><?= get_httl($value['new_httl']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="n_one_job_bottom">
                        <div class="n_job_in4">
                            <img src="/images/n_icon_clock.svg">
                            <p class="n_text_in4_o">
                                <?php
                                echo time_elapsed_string2($value['new_han_nop'], '');
                                ?>
                            </p>
                        </div>
                        <div class="n_job_in4">
                            <img src="/images/n_icon_wallet.svg">
                            <p class="n_text_in4_o"><?= get_httl($value['new_httl']) ?></p>
                        </div>
                        <div class="n_job_in4">
                            <img src="/images/n_icon_briefcase.svg">
                            <p class="n_text_in4_o"><?= get_lhlv($value['new_loai_hinh']) ?></p>
                        </div>
                    </div>
                </div>

                <div class="n_job_func">
                    <?php if (in_array($value['new_id'], $save_new)) { ?>
                        <div class="n_job_like_after hide"></div>
                        <button class="n_btn_like n_job_like hide" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                            <img src="/images/n_icon_heart_plus.svg">
                        </button>
                        <div class="n_job_liked_after"></div>
                        <button class="n_btn_like n_job_liked" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                            <img src="/images/n_icon_heart_plus.svg">
                        </button>
                    <?php } else { ?>
                        <div class="n_job_like_after"></div>
                        <button class="n_btn_like n_job_like" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                            <img src="/images/n_icon_heart_plus.svg">
                        </button>
                        <div class="n_job_liked_after hide"></div>
                        <button class="n_btn_like n_job_liked hide" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                            <img src="/images/n_icon_heart_plus.svg">
                        </button>
                    <?php } ?>
                    <div class="n_job_chat_after"></div>
                    <button class="n_job_chat" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                        <img src="/images/n_icon_chat.svg">
                    </button>
                </div>

                <?php
                if ($value['new_hinh_thuc'] == 2)
                    echo '<div class="n_text_in4_lhlv">
                                <p class="n_text_in4_lhlv_text">Remote</p>
                            </div>'
                ?>
            </div>
        <?php endforeach; ?>
    </div>

</div>
</div>

<div class="img_job container py-5">
    <h2 class="vi_tri_tuyen_dung_title">Hình ảnh</h2>
    <div class="list_img pt-4 ">
        <?php
        $d = date('d', $ntd_detail['ntd_create_time']);
        $m = date('m', $ntd_detail['ntd_create_time']);
        $y = date('Y', $ntd_detail['ntd_create_time']);
        ?>
        <div class="list_img_ntd">
            <img class="hinh_anh_ntd" src="<?= '/upload/ntd/' . $y . '/' . $m . '/' . $d . '/' . $ntd_detail['ntd_img_1'] ?>" onerror="this.src='/images/team.png';" alt="">
        </div>
        <div class="list_img_ntd">
            <img class="hinh_anh_ntd" src="<?= '/upload/ntd/' . $y . '/' . $m . '/' . $d . '/' . $ntd_detail['ntd_img_2'] ?>" onerror="this.src='/images/pciture_bg.png';" alt="">
        </div>
        <div class="list_img_ntd">
            <img class="hinh_anh_ntd" src="<?= '/upload/ntd/' . $y . '/' . $m . '/' . $d . '/' . $ntd_detail['ntd_img_3'] ?>" onerror="this.src='/images/team_work.png';" alt="">
        </div>
    </div>
</div>

<div class="chinh_sach_phuc_loi container py-5">
    <h2 class="vi_tri_tuyen_dung_title ">Chính sách và phúc lợi</h2>
    <div class="phuc_loi_chinh_sach text-center py-3">
        <div class="nl_cs">
            <img class="img_phuc_loi_chinh_sach" src="/images/nhanluc.png" alt="">
            <h1 class="nl_cs_text py-3">CHÍNH SÁCH PHÁT TRIỂN NHÂN LỰC</h1>
            <p class="nl_cs_txt">
                <?= $ntd_detail['ntd_csptnl'] ?>
            </p>
        </div>
        <div class="nl_cs">
            <img class="img_phuc_loi_chinh_sach" src="/images/thangtien.png" alt="">
            <h1 class="nl_cs_text py-3">CƠ HỘI THĂNG TIẾN</h1>
            <p class="nl_cs_txt">
                <?= $ntd_detail['ntd_chtt'] ?>
            </p>
        </div>
        <div class="nl_cs">
            <img class="img_phuc_loi_chinh_sach" src="/images/loinhuan.png" alt="">
            <h1 class="nl_cs_text py-3">LƯƠNG, THƯỞNG, LỢI NHUẬN</h1>
            <p class="nl_cs_txt">
                <?= $ntd_detail['ntd_salary_award'] ?>
            </p>
        </div>
    </div>
</div>
</div>
<input type="hidden" class="type_login" value="3">
<?php $this->load->view("includes/popup_dang_nhap"); ?>