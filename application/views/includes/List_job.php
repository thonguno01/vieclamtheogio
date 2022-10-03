<?php $CI = &get_instance();
$CI->load->model('models/Models'); ?>

<?php
// error_reporting(0)
?>

<?php $this->load->view("includes/search_filter_job.php"); ?>
<div class="n_list_job_body">
    <p class="n_bread_cum_txt"><a href="/" class="n_bread_cum">Trang chủ </a>/<?php if (empty($category_name)) {
                                                                                    echo 'Tin Tuyển Dụng Việc Làm Theo Giờ';
                                                                                } else {
                                                                                    echo 'Việc làm ' . $category_name;
                                                                                } ?> </p>
    <div class="n_list_job_title">
        <h2 class="n_list_job_title_text">TIN TUYỂN DỤNG THEO GIỜ <?= $category_name ?> MỚI NHẤT</h2>
    </div>
    <p class="n_list_job_title_num_found">Tìm thấy <span class="n_num_found"><?= $total; ?></span> tin tuyển dụng theo giờ <?= $category_name ?></p>
    <div class="n_list_job_page">
        <?php foreach ($new as $value) : ?>
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
                                <a href="/<?= $value['new_alias'] ?>-job<?= $value['new_id'] ?>.html" title="<?= $value['new_title'] ?>">
                                    <h3 class="n_text_in4_name">
                                        <?= $value['new_title'] ?>
                                    </h3>
                                </a>
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
                                <div class="n_job_in4 n_job_in4_after_768">
                                    <img src="/images/n_icon_wallet.svg">
                                    <p class="n_text_in4_o"><?= get_httl($value['new_httl']) ?></p>
                                </div>
                                <div class="n_job_in4 n_job_in4_after_768">
                                    <img src="/images/n_icon_award.svg">
                                    <p class="n_text_in4_o"><?= get_exp($value['new_knlv']) ?></p>
                                </div>
                                <div class="n_job_in4 n_job_in4_after_768">
                                    <img src="/images/n_icon_clock.svg">
                                    <p class="n_text_in4_o">
                                        <?php
                                        echo time_elapsed_string2($value['new_han_nop'], '');
                                        ?>
                                    </p>
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
                            <button class="n_btn_like n_job_like like" onClick="save_new(<?= $value['ntd_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                <img src="/images/n_icon_heart_plus.svg">
                            </button>
                            <div class="n_job_liked_after hide"></div>
                            <button class="n_btn_like n_job_liked chat hide" onClick="save_new(<?= $value['ntd_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                <img src="/images/n_icon_heart_plus.svg">
                            </button>
                        <? } else { ?>
                            <div class="n_job_liked_after"></div>
                            <button class="n_btn_like n_job_liked like" onClick="save_new(<?= $value['ntd_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                <img src="/images/n_icon_heart_plus.svg">

                            </button>
                            <div class="n_job_like_after hide"></div>
                            <button class="n_btn_like n_job_like chat hide" onClick="save_new(<?= $value['ntd_id'] ?>,<?= $value['new_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                                <img src="/images/n_icon_heart_plus.svg">
                            </button>
                        <? } ?>
                    <? } else { ?>
                        <div class="n_job_like_after"></div>
                        <button class="n_btn_like n_job_like like" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
                            <img src="/images/n_icon_heart_plus.svg">
                        </button>
                    <? } ?>

                    <div class="n_job_chat_after"></div>
                    <button class="n_job_chat chat" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? $_COOKIE['UserId'] : '' ?>>
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
    <?php echo $this->pagination->create_links(); ?>
    <div class="n_list_job_title n_tag_city">
        <h2 class="n_list_job_title_text">SỐ TIN TUYỂN DỤNG VIỆC LÀM TẠI MỘT SỐ TỈNH THÀNH</h2>
    </div>
    <div class="n_list_job_tag_city">
        <?php
        $join1 =   ['user_ntd' => 'new_user_id = ntd_id'];
        $count_new_ha_noi =  $this->Models->select_sql_like_and('new', '*', ['new_city' => 1], '', $join1, '', null, null, 1);
        $count_new_da_nang =  $this->Models->select_sql_like_and('new', '*', ['new_city' => 26], '', $join1, '', null, null, 1);
        $count_new_hcm = $this->Models->select_sql_like_and('new', '*', ['new_city' => 45], '', $join1, '', null, null, 1);
        $count_new_ha_noi_moi_nhat = $this->Models->select_where_and('*', 'new', ['new_city' => 1, 'new_create_time < ' => 86400])->num_rows();
        $count_new_da_nang_moi_nhat = $this->Models->select_where_and('*', 'new', ['new_city' => 26, 'new_create_time < ' => 86400])->num_rows();
        $count_new_hcm_moi_nhat = $this->Models->select_where_and('*', 'new', ['new_city' => 45, 'new_create_time < ' => 86400])->num_rows();
        $join = array('new n' => 'a.id_new = n.new_id');
        $uv_apllied_ha_noi = $this->Models->select_sql('apply_new a', '*', ['a.create_date < ' => 86400, 'n.new_city' => 1], null, $join, null, null, null, 1);
        $uv_apllied_da_nang = $this->Models->select_sql('apply_new a', '*', ['a.create_date < ' => 86400, 'n.new_city' => 26], null, $join, null, null, null, 1);
        $uv_apllied_hcm = $this->Models->select_sql('apply_new a', '*', ['a.create_date < ' => 86400, 'n.new_city' => 45], null, $join, null, null, null, 1);
        ?>
        <div class="n_list_job_tag_one_city">
            <h3 class="n_list_job_tag_city_text_1"><a class="n_list_job_tag_city_link" href="/tim-viec-lam-theo-gio-tai-ha-noi-nn0tt1.html">
                    Việc làm tại Hà Nội
                </a></h3>
            <p class="n_list_job_tag_city_text_2">Số lượng tin tuyển dụng tại Hà Nội: <span class="n_blue"><?= count($count_new_ha_noi) ?></span> tin.</p>
            <p class="n_list_job_tag_city_text_2">Số tin tuyển dụng mới nhất tại Hà Nội: <span class="n_blue"><?= $count_new_ha_noi_moi_nhat ?></span> tin.</p>
            <p class="n_list_job_tag_city_text_2">Số hồ sơ ứng tuyển việc làm trong 24h qua: <span class="n_blue"><?= count($uv_apllied_ha_noi)  ?></span> hồ sơ.</p>
        </div>
        <div class="n_list_job_tag_one_city">
            <h3 class="n_list_job_tag_city_text_1"><a class="n_list_job_tag_city_link" href="/tim-viec-lam-theo-gio-tai-da-nang-nn0tt26.html">Việc làm tại Đà Nẵng</a></h3>
            <p class="n_list_job_tag_city_text_2">Số lượng tin tuyển dụng tại Đà Nẵng: <span class="n_blue"><?= count($count_new_da_nang) ?></span> tin.</p>
            <p class="n_list_job_tag_city_text_2">Số tin tuyển dụng mới nhất tại Đà Nẵng: <span class="n_blue"><?= $count_new_da_nang_moi_nhat ?></span> tin.</p>
            <p class="n_list_job_tag_city_text_2">Số hồ sơ ứng tuyển việc làm trong 24h qua: <span class="n_blue"><?= count($uv_apllied_da_nang) ?></span> hồ sơ.</p>
        </div>
        <div class="n_list_job_tag_one_city">
            <h3 class="n_list_job_tag_city_text_1"><a class="n_list_job_tag_city_link" href="/tim-viec-lam-theo-gio-tai-ho-chi-minh-nn0tt45.html">Việc làm tại Hồ Chí Minh</a></h3>
            <p class="n_list_job_tag_city_text_2">Số lượng tin tuyển dụng tại Hồ Chí Minh: <span class="n_blue"><?= count($count_new_hcm) ?></span> tin.</p>
            <p class="n_list_job_tag_city_text_2">Số tin tuyển dụng mới nhất tại Hồ Chí Minh: <span class="n_blue"><?= $count_new_hcm_moi_nhat ?></span> tin.</p>
            <p class="n_list_job_tag_city_text_2">Số hồ sơ ứng tuyển việc làm trong 24h qua: <span class="n_blue"><?= count($uv_apllied_hcm) ?></span> hồ sơ.</p>
        </div>
    </div>
    <div class="n_list_job_title">
        <h2 class="n_list_job_title_text">VIỆC LÀM THEO GIỜ HOT KHÁC</h2>
    </div>
    <div class="n_list_job_tag_cate">
        <div class="n_list_job_tag_one_cate"><a class="n_list_job_tag_city_link" href="<?= url_vieclam_nn('ban-hang', 1) ?>">Việc làm bán hàng theo giờ</a></div>
        <div class="n_list_job_tag_one_cate"><a class="n_list_job_tag_city_link" href="<?= url_vieclam_nn('giao-hang', 6) ?>">Việc làm giao hàng theo giờ</a></div>
        <div class="n_list_job_tag_one_cate"><a class="n_list_job_tag_city_link" href="<?= url_vieclam_nn('hanh-chinh', 5) ?>">Việc làm hành chính theo giờ</a></div>
        <div class="n_list_job_tag_one_cate"><a class="n_list_job_tag_city_link" href="<?= url_vieclam_nn('nau-an', 10) ?>">Việc làm nấu ăn theo giờ</a></div>
        <div class="n_list_job_tag_one_cate"><a class="n_list_job_tag_city_link" href="<?= url_vieclam_nn('phuc-vu-tap-vu', 2) ?>">Việc làm Phục vụ / Tạp vụ theo giờ</a></div>
        <div class="n_list_job_tag_one_cate"><a class="n_list_job_tag_city_link" href="<?= url_vieclam_nn('xay-dung-cong-trinh', 3) ?>">Việc làm Xây dựng / Công trình theo giờ</a></div>
    </div>
</div>
<?php
// echo $article;

if (isset($article) && $article != '') { ?>
    <div class="n_post">
        <div class="q-contents-article">
            <?php
            echo $article;
            // echo makeML_content($article, '', '');
            ?>
        </div>
        <div class="q-menu-article">
            <div class="q-title-heading">MỤC LỤC</div>
            <?php
            // echo makeML($article, '', '', '');
            ?>
        </div>
    </div>
    <div class="wrap_goi_y" <?php if ($article_title_sg == '' &&   $article_content_sg  == '') {
                                ' style="display: none;border-radius: 15px;"';
                            } else {
                                echo '';
                            }   ?>>
        <div id="wrap_goi_y">
            <div class="tile_goi_y">
                <?php echo $article_title_sg ?>
            </div>
            <div class="content_goi_y">
                <?php echo  $article_content_sg ?>

            </div>
        </div>
    </div>
<?php } ?>
<input type="hidden" class="type_login" value="3">
<?php $this->load->view("includes/popup_dang_nhap"); ?>