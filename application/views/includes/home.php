<?php $CI = &get_instance();
$CI->load->model('models/Models'); ?>
<div class="n_banner">
    <div class="n_sub_banner">
        <h1 class="n_banner_text">TÌM VIỆC LÀM THEO GIỜ NHANH CHÓNG - UY TÍN</h1>
        <p class="n_banner_sm_text">Tiếp cận nhanh chóng với những công việc thời vụ chất lượng</p>
    </div>
    <div class="n_sub_body_search">
        <?php $this->load->view("includes/search_job.php"); ?>
    </div>
</div>
<div class="n_home_content">
    <div class="n_title_newest_job">
        <img src="/images/n_icon_tri_left.svg" alt="sang trái">
        <h2 class="n_title_newest_job_text">VIỆC LÀM THEO GIỜ MỚI NHẤT</h2>
        <img src="/images/n_icon_tri_right.svg" alt="sang phải">
    </div>
    <div class="n_list_newest_jobs">
        <?php $i = 1;
        foreach ($list_job as $value) :
            if ($i % 12 == 1) :
        ?>
                <div class="n_list_newest_jobs_page">
                <?php
            endif;
                ?>
                <div class="n_one_job">
                    <div class="n_one_job_left">
                        <div class="n_one_job_top">
                            <?php
                            $d = date('d', $value['ntd_create_time']);
                            $m = date('m', $value['ntd_create_time']);
                            $y = date('Y', $value['ntd_create_time']);
                            ?>
                            <a href="/<?= $value['ntd_alias'] ?>-ntd<?= $value['ntd_id'] ?>.html" class="n_job_logo">
                                <img src="<?= '/upload/ntd/' . $y . '/' . $m . '/' . $d . '/' . $value['ntd_avatar'] ?>" onerror="this.src='/images/n_ava_logo.png';" alt=" <?= $value['new_title'] ?>">
                            </a>
                            <div class="n_job_detail">
                                <div class="n_job_in4_name">
                                    <a href="<?= url_vieclam($value['new_alias'], $value['new_id']) ?>" title="<?= $value['new_title'] ?> ">
                                        <h3 class="n_text_in4_name">
                                            <?= $value['new_title'] ?>
                                        </h3>
                                    </a>
                                </div>
                                <div class="n_job_in4s">
                                    <div class="n_job_in4 n_job_tt">
                                        <img src="/images/n_icon_map.svg">
                                        <a href="<?= url_vieclam_city(get_city($value['new_city']), $value['new_city']) ?>" class="n_text_in4_o"><?= get_city($value['new_city']) ?></a>
                                    </div>
                                    <div class="n_job_in4 n_job_in4_htlv_1">
                                        <img src="/images/n_icon_briefcase.svg">
                                        <p class="n_text_in4_o"><?= get_lhlv($value['new_loai_hinh']) ?></p>
                                    </div>
                                    <div class="n_job_in4 n_job_sa">
                                        <img src="/images/n_icon_dollar.svg">
                                        <p class="n_text_in4_o n_text_in4_spt">
                                            <?php if ($value['new_luong_1'] == 3) {
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
                                    <div class="n_job_in4 n_job_in4_htlv_2">
                                        <img src="/images/n_icon_briefcase.svg">
                                        <p class="n_text_in4_o"><?= get_lhlv($value['new_loai_hinh']) ?></p>
                                    </div>
                                    <div class="n_job_in4 n_job_in4_not_375 n_job_htl">
                                        <img src="/images/n_icon_wallet.svg">
                                        <p class="n_text_in4_o"><?= get_httl($value['new_httl']) ?></p>
                                    </div>
                                    <div class="n_job_in4 n_job_in4_not_375 n_job_exp">
                                        <img src="/images/n_icon_award.svg">
                                        <p class="n_text_in4_o"><?= get_exp($value['new_knlv']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="n_one_job_bottom">
                            <div class="n_job_in4">
                                <img src="/images/n_icon_briefcase.svg">
                                <p class="n_text_in4_o"><?= get_lhlv($value['new_loai_hinh']) ?></p>
                            </div>
                            <div class="n_job_in4">
                                <img src="/images/n_icon_wallet.svg">
                                <p class="n_text_in4_o"><?= get_httl($value['new_httl']) ?></p>
                            </div>
                            <div class="n_job_in4 n_job_exp">
                                <img src="/images/n_icon_award.svg">
                                <p class="n_text_in4_o"><?= get_exp($value['new_knlv']) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="n_job_func">
                        <?php if (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) {
                            $id_uv = $_COOKIE['UserId'];
                            $check_save_new   = $CI->Models->select_sql('save_new', '*', array('id_uv' => $id_uv, 'id_new' => $value['new_id']), null, null, null, null, null, 0);
                            if ($check_save_new == null) { ?>
                                <div class="n_job_like_after"></div>
                                <button class="n_btn_like n_job_like" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                                <div class="n_job_liked_after hide"></div>
                                <button class="n_btn_like n_job_liked hide" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                            <? } else { ?>
                                <div class="n_job_liked_after"></div>
                                <button class="n_btn_like n_job_liked" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                                <div class="n_job_like_after hide"></div>
                                <button class="n_btn_like n_job_like hide" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                            <? } ?>
                        <? } else { ?>
                            <div class="n_job_like_after"></div>
                            <button class="n_btn_like n_job_like" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                <img src="/images/n_icon_heart_plus.svg">
                            </button>
                        <? } ?>

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
                <?php
                if ($i % 12 == 0) :
                ?>
                </div>
        <?php
                endif;
                $i++;
            endforeach;
            $i--;
            if ($i < 84 && $i % 12 != 0) {
                echo '</div>';
            }
        ?>
    </div>
    <div class="n_banner_disco">
        <button class="n_btn_disco_now" onClick="window.location.href='/tim-viec-lam.html'">KHÁM PHÁ NGAY >></button>
    </div>

    <div class="n_title_newest_job n_title_job_cate_hot">
        <img src="/images/n_icon_tri_left.svg">
        <h2 class="n_title_newest_job_text">NHỮNG LOẠI VIỆC LÀM THEO GIỜ HOT NHẤT</h2>
        <img src="/images/n_icon_tri_right.svg">
    </div>
    <?php if (count($day_job) > 0) { ?>
        <div class="n_title_cate_job">
            <div class="n_title_cate_job_div">
                <p class="n_title_cate_job_text">VIỆC LÀM TRẢ LƯƠNG THEO NGÀY</p>
            </div>
            <a href="/tim-viec-lam.html?key=&htl=3" class="n_title_cate_job_see_more"> Xem thêm >> </a>
        </div>
        <div class="n_list_newest_jobs_page n_job_cate">
            <?php foreach ($day_job as $value) : ?>
                <div class="n_one_job">
                    <div class="n_one_job_left">
                        <div class="n_one_job_top">
                            <?php
                            $d = date('d', $value['ntd_create_time']);
                            $m = date('m', $value['ntd_create_time']);
                            $y = date('Y', $value['ntd_create_time']);
                            ?>
                            <a href="/<?= $value['ntd_alias'] ?>-ntd<?= $value['ntd_id'] ?>.html" class="n_job_logo">
                                <img src="<?= '/upload/ntd/' . $y . '/' . $m . '/' . $d . '/' . $value['ntd_avatar'] ?>" onerror="this.src='/images/n_ava_logo.png';" alt="<?= $value['new_title'] ?>">
                            </a>
                            <div class="n_job_detail">
                                <div class="n_job_in4_name">
                                    <a href="<?= url_vieclam($value['new_alias'], $value['new_id']) ?>">
                                        <h3 class="n_text_in4_name"><?= $value['new_title'] ?></h3>
                                    </a>
                                </div>
                                <div class="n_job_in4s">
                                    <div class="n_job_in4 n_job_tt">
                                        <img src="/images/n_icon_map.svg">
                                        <a href="<?= url_vieclam_city(get_city($value['new_city']), $value['new_city']) ?>" class="n_text_in4_o"><?= get_city($value['new_city']) ?></a>
                                    </div>
                                    <div class="n_job_in4 n_job_in4_htlv_1">
                                        <img src="/images/n_icon_briefcase.svg">
                                        <p class="n_text_in4_o"><?= get_lhlv($value['new_loai_hinh']) ?></p>
                                    </div>
                                    <div class="n_job_in4 n_job_sa">
                                        <img src="/images/n_icon_dollar.svg">
                                        <p class="n_text_in4_o n_text_in4_spt">
                                            <?php
                                            if ($value['new_luong_1'] == 3) {
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
                                    <div class="n_job_in4 n_job_in4_htlv_2">
                                        <img src="/images/n_icon_briefcase.svg">
                                        <p class="n_text_in4_o"><?= get_lhlv($value['new_loai_hinh']) ?></p>
                                    </div>
                                    <div class="n_job_in4 n_job_in4_not_375 n_job_htl">
                                        <img src="/images/n_icon_wallet.svg">
                                        <p class="n_text_in4_o"><?= get_httl($value['new_httl']) ?></p>
                                    </div>
                                    <div class="n_job_in4 n_job_in4_not_375 n_job_exp">
                                        <img src="/images/n_icon_award.svg">
                                        <p class="n_text_in4_o"><?= get_exp($value['new_knlv']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="n_one_job_bottom">
                            <div class="n_job_in4">
                                <img src="/images/n_icon_briefcase.svg">
                                <p class="n_text_in4_o"><?= get_lhlv($value['new_loai_hinh']) ?></p>
                            </div>
                            <div class="n_job_in4">
                                <img src="/images/n_icon_wallet.svg">
                                <p class="n_text_in4_o"><?= get_httl($value['new_httl']) ?></p>
                            </div>
                            <div class="n_job_in4 n_job_exp">
                                <img src="/images/n_icon_award.svg">
                                <p class="n_text_in4_o"><?= get_exp($value['new_knlv']) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="n_job_func">
                        <?php if (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) {
                            $id_uv = $_COOKIE['UserId'];
                            $check_save_new   = $CI->Models->select_sql('save_new', '*', array('id_uv' => $id_uv, 'id_new' => $value['new_id']), null, null, null, null, null, 0);
                            if ($check_save_new == null) { ?>
                                <div class="n_job_like_after"></div>
                                <button class="n_btn_like n_job_like" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                                <div class="n_job_liked_after hide"></div>
                                <button class="n_btn_like n_job_liked hide" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                            <? } else { ?>
                                <div class="n_job_liked_after"></div>
                                <button class="n_btn_like n_job_liked" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                                <div class="n_job_like_after hide"></div>
                                <button class="n_btn_like n_job_like hide" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                            <? } ?>
                        <? } else { ?>
                            <div class="n_job_like_after"></div>
                            <button class="n_btn_like n_job_like" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                <img src="/images/n_icon_heart_plus.svg">
                            </button>
                        <? } ?>

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
            <a href="/tim-viec-lam.html?key=&htl=3" class="n_title_cate_job_see_more_375"> Xem thêm
                <img src="/images/n_icon_down_blue.svg">
            </a>
        </div>
    <?php } ?>
    <?php if (count($giao_hang) > 0) { ?>
        <div class="n_title_cate_job">
            <div class="n_title_cate_job_div">
                <p class="n_title_cate_job_text">VIỆC LÀM GIAO HÀNG</p>
            </div>
            <a href="<?= url_vieclam_nn('giao-hang', 6) ?>" class="n_title_cate_job_see_more"> Xem thêm >></a>
        </div>
        <div class="n_list_newest_jobs_page n_job_cate">
            <?php foreach ($giao_hang as $value) : ?>
                <div class="n_one_job">
                    <div class="n_one_job_left">
                        <div class="n_one_job_top">
                            <?php
                            $d = date('d', $value['ntd_create_time']);
                            $m = date('m', $value['ntd_create_time']);
                            $y = date('Y', $value['ntd_create_time']);
                            ?>
                            <a href="/<?= $value['ntd_alias'] ?>-ntd<?= $value['ntd_id'] ?>.html" class="n_job_logo">
                                <img src="<?= '/upload/ntd/' . $y . '/' . $m . '/' . $d . '/' . $value['ntd_avatar'] ?>" onerror="this.src='/images/n_ava_logo.png';" alt="<?= $value['new_title'] ?>">
                            </a>
                            <div class="n_job_detail">
                                <div class="n_job_in4_name">
                                    <a href="<?= url_vieclam($value['new_alias'], $value['new_id']) ?>" class="n_text_in4_name"><?= $value['new_title'] ?></a>
                                </div>
                                <div class="n_job_in4s">
                                    <div class="n_job_in4 n_job_tt">
                                        <img src="/images/n_icon_map.svg">
                                        <a href="<?= url_vieclam_city(get_city($value['new_city']), $value['new_city']) ?>" class="n_text_in4_o"><?= get_city($value['new_city']) ?></a>
                                    </div>
                                    <div class="n_job_in4 n_job_in4_htlv_1">
                                        <img src="/images/n_icon_briefcase.svg">
                                        <p class="n_text_in4_o"><?= get_lhlv($value['new_loai_hinh']) ?></p>
                                    </div>
                                    <div class="n_job_in4 n_job_sa">
                                        <img src="/images/n_icon_dollar.svg">
                                        <p class="n_text_in4_o n_text_in4_spt">
                                            <?php
                                            if ($value['new_luong_1'] == 3) {
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
                                    <div class="n_job_in4 n_job_in4_htlv_2">
                                        <img src="/images/n_icon_briefcase.svg">
                                        <p class="n_text_in4_o"><?= get_lhlv($value['new_loai_hinh']) ?></p>
                                    </div>
                                    <div class="n_job_in4 n_job_in4_not_375 n_job_htl">
                                        <img src="/images/n_icon_wallet.svg">
                                        <p class="n_text_in4_o"><?= get_httl($value['new_httl']) ?></p>
                                    </div>
                                    <div class="n_job_in4 n_job_in4_not_375 n_job_exp">
                                        <img src="/images/n_icon_award.svg">
                                        <p class="n_text_in4_o"><?= get_exp($value['new_knlv']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="n_one_job_bottom">
                            <div class="n_job_in4">
                                <img src="/images/n_icon_briefcase.svg">
                                <p class="n_text_in4_o"><?= get_lhlv($value['new_loai_hinh']) ?></p>
                            </div>
                            <div class="n_job_in4">
                                <img src="/images/n_icon_wallet.svg">
                                <p class="n_text_in4_o"><?= get_httl($value['new_httl']) ?></p>
                            </div>
                            <div class="n_job_in4 n_job_exp">
                                <img src="/images/n_icon_award.svg">
                                <p class="n_text_in4_o"><?= get_exp($value['new_knlv']) ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="n_job_func">
                        <?php if (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) {
                            $id_uv = $_COOKIE['UserId'];
                            $check_save_new   = $CI->Models->select_sql('save_new', '*', array('id_uv' => $id_uv, 'id_new' => $value['new_id']), null, null, null, null, null, 0);
                            if ($check_save_new == null) { ?>
                                <div class="n_job_like_after"></div>
                                <button class="n_btn_like n_job_like" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                                <div class="n_job_liked_after hide"></div>
                                <button class="n_btn_like n_job_liked hide" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                            <? } else { ?>
                                <div class="n_job_liked_after"></div>
                                <button class="n_btn_like n_job_liked" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                                <div class="n_job_like_after hide"></div>
                                <button class="n_btn_like n_job_like hide" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                            <? } ?>
                        <? } else { ?>
                            <div class="n_job_like_after"></div>
                            <button class="n_btn_like n_job_like" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                <img src="/images/n_icon_heart_plus.svg">
                            </button>
                        <? } ?>
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
            <a href="<?= url_vieclam_nn('giao-hang', 6) ?>" class="n_title_cate_job_see_more_375"> Xem thêm
                <img src="/images/n_icon_down_blue.svg">
            </a>
        </div>
    <?php } ?>
    <?php if (count($sell_job) > 0) { ?>
        <div class="n_title_cate_job">
            <div class="n_title_cate_job_div">
                <p class="n_title_cate_job_text">VIỆC LÀM BÁN HÀNG</p>
            </div>
            <a href="<?= url_vieclam_nn('ban-hang', 1) ?>" class="n_title_cate_job_see_more"> Xem thêm >></a>
        </div>
        <div class="n_list_newest_jobs_page n_job_cate">
            <?php foreach ($sell_job as $value) : ?>
                <div class="n_one_job">
                    <div class="n_one_job_left">
                        <div class="n_one_job_top">
                            <?php
                            $d = date('d', $value['ntd_create_time']);
                            $m = date('m', $value['ntd_create_time']);
                            $y = date('Y', $value['ntd_create_time']);
                            ?>
                            <a href="/<?= $value['ntd_alias'] ?>-ntd<?= $value['ntd_id'] ?>.html" class="n_job_logo">
                                <img src="<?= '/upload/ntd/' . $y . '/' . $m . '/' . $d . '/' . $value['ntd_avatar'] ?>" onerror="this.src='/images/n_ava_logo.png';" alt="<?= $value['new_title'] ?>">
                            </a>
                            <div class="n_job_detail">
                                <div class="n_job_in4_name">
                                    <a href="<?= url_vieclam($value['new_alias'], $value['new_id']) ?>" class="n_text_in4_name"><?= $value['new_title'] ?></a>
                                </div>
                                <div class="n_job_in4s">
                                    <div class="n_job_in4 n_job_tt">
                                        <img src="/images/n_icon_map.svg" alt="Địa chỉ">
                                        <a href="<?= url_vieclam_city(get_city($value['new_city']), $value['new_city']) ?>" class="n_text_in4_o"><?= get_city($value['new_city']) ?></a>
                                    </div>
                                    <div class="n_job_in4 n_job_in4_htlv_1">
                                        <img src="/images/n_icon_briefcase.svg" alt="Hình thức làm việc ">
                                        <p class="n_text_in4_o"><?= get_lhlv($value['new_loai_hinh']) ?></p>
                                    </div>
                                    <div class="n_job_in4 n_job_sa">
                                        <img src="/images/n_icon_dollar.svg" alt="Tiền lương">
                                        <p class="n_text_in4_o n_text_in4_spt">
                                            <?php if ($value['new_luong_1'] == 3) {
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
                                    <div class="n_job_in4 n_job_in4_htlv_2">
                                        <img src="/images/n_icon_briefcase.svg" alt="Loại hình làm việc">
                                        <p class="n_text_in4_o"><?= get_lhlv($value['new_loai_hinh']) ?></p>
                                    </div>
                                    <div class="n_job_in4 n_job_in4_not_375 n_job_htl">
                                        <img src="/images/n_icon_wallet.svg">
                                        <p class="n_text_in4_o"><?= get_httl($value['new_httl']) ?></p>
                                    </div>
                                    <div class="n_job_in4 n_job_in4_not_375 n_job_exp">
                                        <img src="/images/n_icon_award.svg">
                                        <p class="n_text_in4_o"><?= get_exp($value['new_knlv']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="n_one_job_bottom">
                            <div class="n_job_in4">
                                <img src="/images/n_icon_briefcase.svg">
                                <p class="n_text_in4_o"><?= get_lhlv($value['new_loai_hinh']) ?></p>
                            </div>
                            <div class="n_job_in4">
                                <img src="/images/n_icon_wallet.svg">
                                <p class="n_text_in4_o"><?= get_httl($value['new_httl']) ?></p>
                            </div>
                            <div class="n_job_in4 n_job_exp">
                                <img src="/images/n_icon_award.svg">
                                <p class="n_text_in4_o"><?= get_exp($value['new_knlv']) ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="n_job_func">
                        <?php if (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) {
                            $id_uv = $_COOKIE['UserId'];
                            $check_save_new   = $CI->Models->select_sql('save_new', '*', array('id_uv' => $id_uv, 'id_new' => $value['new_id']), null, null, null, null, null, 0);
                            if ($check_save_new == null) { ?>
                                <div class="n_job_like_after"></div>
                                <button class="n_btn_like n_job_like" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                                <div class="n_job_liked_after hide"></div>
                                <button class="n_btn_like n_job_liked hide" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                            <? } else { ?>
                                <div class="n_job_liked_after"></div>
                                <button class="n_btn_like n_job_liked" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                                <div class="n_job_like_after hide"></div>
                                <button class="n_btn_like n_job_like hide" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                            <? } ?>
                        <? } else { ?>
                            <div class="n_job_like_after"></div>
                            <button class="n_btn_like n_job_like" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                <img src="/images/n_icon_heart_plus.svg">
                            </button>
                        <? } ?>
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
            <a href="<?= url_vieclam_nn('ban-hang', 1) ?>" class="n_title_cate_job_see_more_375"> Xem thêm
                <img src="/images/n_icon_down_blue.svg">
            </a>
        </div>
    <?php } ?>
    <?php if (count($daily_job) > 0) { ?>
        <div class="n_title_cate_job">
            <div class="n_title_cate_job_div">
                <p class="n_title_cate_job_text"> VIỆC LÀM HÀNH CHÍNH </p>
            </div>
            <a href="<?= url_vieclam_nn('hanh-chinh', 5) ?>" class="n_title_cate_job_see_more"> Xem thêm >></a>
        </div>
        <div class="n_list_newest_jobs_page n_job_cate">
            <?php foreach ($daily_job as $value) : ?>
                <div class="n_one_job">
                    <div class="n_one_job_left">
                        <div class="n_one_job_top">
                            <?php
                            $d = date('d', $value['ntd_create_time']);
                            $m = date('m', $value['ntd_create_time']);
                            $y = date('Y', $value['ntd_create_time']);
                            ?>
                            <a href="/<?= $value['ntd_alias'] ?>-ntd<?= $value['ntd_id'] ?>.html" class="n_job_logo">
                                <img src="<?= '/upload/ntd/' . $y . '/' . $m . '/' . $d . '/' . $value['ntd_avatar'] ?>" onerror="this.src='/images/n_ava_logo.png';" alt="<?= $value['new_title'] ?>">
                            </a>
                            <div class="n_job_detail">
                                <div class="n_job_in4_name">
                                    <a href="<?= url_vieclam($value['new_alias'], $value['new_id']) ?>">
                                        <h3 class="n_text_in4_name">
                                            <?= $value['new_title'] ?>
                                        </h3>
                                    </a>
                                </div>
                                <div class="n_job_in4s">
                                    <div class="n_job_in4 n_job_tt">
                                        <img src="/images/n_icon_map.svg">
                                        <a href="<?= url_vieclam_city(get_city($value['new_city']), $value['new_city']) ?>" class="n_text_in4_o"><?= get_city($value['new_city']) ?></a>
                                    </div>
                                    <div class="n_job_in4 n_job_in4_htlv_1">
                                        <img src="/images/n_icon_briefcase.svg">
                                        <p class="n_text_in4_o"><?= get_lhlv($value['new_loai_hinh']) ?></p>
                                    </div>
                                    <div class="n_job_in4 n_job_sa">
                                        <img src="/images/n_icon_dollar.svg">
                                        <p class="n_text_in4_o n_text_in4_spt">
                                            <?php if ($value['new_luong_1'] == 3) {
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
                                    <div class="n_job_in4 n_job_in4_htlv_2">
                                        <img src="/images/n_icon_briefcase.svg">
                                        <p class="n_text_in4_o"><?= get_lhlv($value['new_loai_hinh']) ?></p>
                                    </div>
                                    <div class="n_job_in4 n_job_in4_not_375 n_job_htl">
                                        <img src="/images/n_icon_wallet.svg">
                                        <p class="n_text_in4_o"><?= get_httl($value['new_httl']) ?></p>
                                    </div>
                                    <div class="n_job_in4 n_job_in4_not_375 n_job_exp">
                                        <img src="/images/n_icon_award.svg">
                                        <p class="n_text_in4_o"><?= get_exp($value['new_knlv']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="n_one_job_bottom">
                            <div class="n_job_in4">
                                <img src="/images/n_icon_briefcase.svg">
                                <p class="n_text_in4_o"><?= get_lhlv($value['new_loai_hinh']) ?></p>
                            </div>
                            <div class="n_job_in4">
                                <img src="/images/n_icon_wallet.svg">
                                <p class="n_text_in4_o"><?= get_httl($value['new_httl']) ?></p>
                            </div>
                            <div class="n_job_in4 n_job_exp">
                                <img src="/images/n_icon_award.svg">
                                <p class="n_text_in4_o"><?= get_exp($value['new_knlv']) ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="n_job_func">
                        <?php if (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) {
                            $id_uv = $_COOKIE['UserId'];
                            $check_save_new   = $CI->Models->select_sql('save_new', '*', array('id_uv' => $id_uv, 'id_new' => $value['new_id']), null, null, null, null, null, 0);
                            if ($check_save_new == null) { ?>
                                <div class="n_job_like_after"></div>
                                <button class="n_btn_like n_job_like" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                                <div class="n_job_liked_after hide"></div>
                                <button class="n_btn_like n_job_liked hide" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                            <? } else { ?>
                                <div class="n_job_liked_after"></div>
                                <button class="n_btn_like n_job_liked" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                                <div class="n_job_like_after hide"></div>
                                <button class="n_btn_like n_job_like hide" onClick="save_new(<?= $value['new_user_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                    <img src="/images/n_icon_heart_plus.svg">
                                </button>
                            <? } ?>
                        <? } else { ?>
                            <div class="n_job_like_after"></div>
                            <button class="n_btn_like n_job_like" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                <img src="/images/n_icon_heart_plus.svg">
                            </button>
                        <? } ?>

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
            <a href="<?= url_vieclam_nn('hanh-chinh', 5) ?>" class="n_title_cate_job_see_more_375"> Xem thêm
                <img src="/images/n_icon_down_blue.svg">
            </a>
        </div>
    <?php } ?>
</div>
<div class="n_title_newest_job n_title_job_city_hot">
    <img src="/images/n_icon_tri_left.svg">
    <h2 class="n_title_newest_job_text">VIỆC LÀM THEO GIỜ TẠI CÁC ĐỊA ĐIỂM HOT NHẤT</h2>
    <img src="/images/n_icon_tri_right.svg">
</div>
<div class="n_job_city_hot">
    <div class="n_job_city_hot_content">
        <div class="n_job_one_city_hot">
            <img src="/images/n_hn.svg" alt=" Việc làm theo giờ tại Hà Nội">
            <div class="n_job_one_city_hot_text">
                <a href="/tim-viec-lam-theo-gio-tai-ha-noi-nn0tt1.html">
                    <h3 class="n_job_one_city_hot_text_1">
                        Việc làm theo giờ tại Hà Nội
                    </h3>
                </a>
                <p class="n_job_one_city_hot_text_2">Hà Nội là thủ đô, thành phố trực thuộc trung ương và là một điểm nóng trong vấn đề việc làm.</p>
            </div>
        </div>
        <div class="n_job_one_city_hot">
            <img src="/images/n_dn.svg" alt="Việc làm theo giờ tại Đà Nẵng">
            <div class="n_job_one_city_hot_text">
                <a href="/tim-viec-lam-theo-gio-tai-da-nang-nn0tt26.html">
                    <h3 class="n_job_one_city_hot_text_1">
                        Việc làm theo giờ tại Đà Nẵng
                    </h3>
                </a>
                <p class="n_job_one_city_hot_text_2">Đà Nẵng là thành phố du lịch trọng điểm của cả nước, nguồn lợi việc làm, nhu cầu nhân lực rất lớn.</p>
            </div>
        </div>
        <div class="n_job_one_city_hot">
            <img src="/images/n_hcm.svg" alt="Việc làm theo giờ tại Hồ Chí Minh">
            <div class="n_job_one_city_hot_text">
                <a href="/tim-viec-lam-theo-gio-tai-ho-chi-minh-nn0tt45.html">
                    <h3 class="n_job_one_city_hot_text_1">
                        Việc làm theo giờ tại Hồ Chí Minh
                    </h3>
                </a>
                <p class="n_job_one_city_hot_text_2">Hồ Chí Minh là trung tâm kinh tế lớn thứ 2 cả nước, với mật độ dân số đông đúc, nơi đây cũng là một trong những điểm nóng có nhu cầu tìm việc làm cao. </p>
            </div>
        </div>
    </div>
</div>
<div class="n_wonder_why">
    <h2 class="n_wonder_why_title"> Tại sao bạn nên tìm việc làm theo giờ tại Vieclam123.vn? </h2>
    <div class="n_wonder_why_content">
        <div class="n_wonder_why_sub_content">
            <img src="/images/n_wonder_why_1.svg">
            <div class="n_wonder_why_content_text">
                <h3 class="n_wonder_why_content_text_1">Thu nhập hấp dẫn</h3>
                <p class="n_wonder_why_content_text_2">Chủ động chọn việc theo giờ có thu nhập cao, phù hợp với bản thân. Nhận lương, thưởng hấp dẫn</p>
            </div>
        </div>
        <div class="n_wonder_why_sub_content_r">
            <img src="/images/n_wonder_why_2.svg">
            <div class="n_wonder_why_content_text">
                <h3 class="n_wonder_why_content_text_1">Giờ làm việc linh hoạt</h3>
                <p class="n_wonder_why_content_text_2">Tùy chọn ngày giờ làm việc, địa điểm phù hợp với bản thân. Ứng tuyển dễ dàng trong vài giây.</p>
            </div>
        </div>
        <div class="n_wonder_why_sub_content">
            <img src="/images/n_wonder_why_3.svg">
            <div class="n_wonder_why_content_text">
                <h3 class="n_wonder_why_content_text_1">Nhà tuyển dụng uy tín</h3>
                <p class="n_wonder_why_content_text_2">Chủ động chọn việc theo giờ có thu nhập cao, phù hợp với bản thân. Nhận lương, thưởng hấp dẫn</p>
            </div>
        </div>
        <div class="n_wonder_why_sub_content_r">
            <img src="/images/n_wonder_why_4.svg">
            <div class="n_wonder_why_content_text">
                <h3 class="n_wonder_why_content_text_1">Hỗ trợ 24/7</h3>
                <p class="n_wonder_why_content_text_2">Đội ngũ tư vấn viên hỗ trợ 24/7. Sẵn sàng giải đáp mọi thắc mắc của bạn.</p>
                <p class="n_wonder_why_content_text_2">Đồng hành cùng bạn đi tìm việc làm theo giờ ưng ý nhất.</p>
            </div>
        </div>
    </div>
</div>

<div class="n_frequent_questions">
    <div class="n_frequent_questions_left">
        <img src="/images/n_question.png">
    </div>
    <div class="n_frequent_questions_right">
        <h2 class="n_frequent_questions_title">CÂU HỎI THƯỜNG GẶP</h2>
        <img class="n_fre_que_img_375" src="/images/n_question.png">
        <div class="n_frequent_one_question">
            <div class="n_frequent_ques">
                <h3 class="n_frequent_ques_text">Tìm việc làm theo giờ tại Vieclam123.vn có mất chi phí không?</h3>
                <img class="n_close" src="/images/n_icon_minus.svg">
                <img class="n_open show" src="/images/n_icon_plus.svg">
            </div>
            <p class="n_frequent_ans">Việc làm theo giờ là hình thức phổ biến tại các cửa hàng, doanh nghiệp,... nhắm đến các đối tượng là sinh viên, các ứng iên có nhu cầu kiếm thêm thu nhập nhưng lại có khung giờ đi làm không cố định. </p>
        </div>
        <div class="n_frequent_one_question">
            <div class="n_frequent_ques">
                <h3 class="n_frequent_ques_text">Việc làm theo giờ là gì? Việc làm theo giờ hướng tới đối tượng nào?</h3>
                <img class="n_close" src="/images/n_icon_minus.svg">
                <img class="n_open show" src="/images/n_icon_plus.svg">
            </div>
            <p class="n_frequent_ans">Việc làm theo giờ là hình thức phổ biến tại các cửa hàng, doanh nghiệp,... nhắm đến các đối tượng là sinh viên, các ứng iên có nhu cầu kiếm thêm thu nhập nhưng lại có khung giờ đi làm không cố định. </p>
        </div>
        <div class="n_frequent_one_question">
            <div class="n_frequent_ques">
                <h3 class="n_frequent_ques_text">Tại sao bạn nên tìm việc làm theo giờ tại Vieclam123.vn ?</h3>
                <img class="n_close" src="/images/n_icon_minus.svg">
                <img class="n_open show" src="/images/n_icon_plus.svg">
            </div>
            <p class="n_frequent_ans">Việc làm theo giờ là hình thức phổ biến tại các cửa hàng, doanh nghiệp,... nhắm đến các đối tượng là sinh viên, các ứng iên có nhu cầu kiếm thêm thu nhập nhưng lại có khung giờ đi làm không cố định. </p>
        </div>
        <div class="n_frequent_one_question">
            <div class="n_frequent_ques">
                <h3 class="n_frequent_ques_text">Có thể nhận cùng lúc nhiều công việc làm theo giờ hay không?</h3>
                <img class="n_close" src="/images/n_icon_minus.svg">
                <img class="n_open show" src="/images/n_icon_plus.svg">
            </div>
            <p class="n_frequent_ans">Việc làm theo giờ là hình thức phổ biến tại các cửa hàng, doanh nghiệp,... nhắm đến các đối tượng là sinh viên, các ứng iên có nhu cầu kiếm thêm thu nhập nhưng lại có khung giờ đi làm không cố định. </p>
        </div>
    </div>
</div>
<input type="hidden" class="type_login" value="3">
<?php $this->load->view("includes/popup_dang_nhap"); ?>