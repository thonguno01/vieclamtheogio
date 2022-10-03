<?php $CI = &get_instance();
$CI->load->model('models/Models');
if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type'])) {
    if ($_COOKIE['Type'] == 3) { // ứng viên
        $type = 1;
        $user = 'id_uv';
        $select = 'notification.*, user_ntd.ntd_company as name, user_ntd.ntd_alias as alias,user_ntd.ntd_create_time as createtime,user_ntd.ntd_avatar as avatar';
        $join = array('user_ntd' => 'notification.id_ntd = user_ntd.ntd_id');
    } else if ($_COOKIE['Type'] == 4) { // ntd
        $type = 2;
        $user = 'id_ntd';
        $select = 'notification.*, user_uv.uv_name as name, user_uv.uv_alias as alias,new.new_title, new.new_alias,user_uv.uv_createtime as createtime,user_uv.uv_avatar as avatar ';
        $join = array('user_uv' => 'notification.id_uv = user_uv.uv_id', 'new' => 'notification.id_new = new.new_id');
    }
    $get_noti  = $CI->Models->select_sql('notification', $select, array($user => $_COOKIE['UserId'], 'type' => $type), null, $join, array('id' => 'DESC'), null, null, 1);
}
?>
<div class="header_wrapper">
    <div class="header_wrapper_left">
        <div class="header_wrapper-left-img_back">
            <img class="btn_menu_responsive" src="/images/menu_responsive.png" alt="https://vieclam123.vn">
            <a href="https://vieclam123.vn/"><img class="back_img" src="/images/back.png" alt="https://vieclam123.vn"></a>
        </div>
        <a href="/"><img class="logo" src="/images/logo_vieclamtheo_h.png" alt="https://vieclamtheogio.vieclam123.vn"></a>
    </div>
    <a href="/"><img class="logo_responsive" src="/images/logo_vieclamtheo_h.png" alt="https://vieclamtheogio.vieclam123.vn"></a>
    <div class="header_wrapper_right">
        <nav class="header_menu">
            <ul class="header_menu_list">
                <li class="header_menu_item">
                    <a href="/tim-viec-lam.html">
                        Danh sách việc làm
                    </a>
                </li>
                <li class="header_menu_item">
                    <a href="/ung-vien-theo-gio">
                        Danh sách ứng viên
                    </a>
                </li>
                <li class="header_menu_item">
                    <a href="https://vieclam123.vn/viec-lam/bang-gia/" target="_blank">
                        Bảng giá
                    </a>
                </li>
                <!-- <li class="header_menu_item">
                    <a>
                        Liên hệ
                    </a>
                </li> -->
                <li class="header_menu_item">
                    <a href="https://vieclam123.vn/gioi-thieu-chung" target="_blank">
                        Giới thiệu
                    </a>
                </li>
            </ul>
        </nav>
        <?php if (isset($_COOKIE['UserId']) && $_COOKIE['UserId'] > 0) : ?>
            <!-- da dang ky -->
            <div class="after_login">
                <div class="round_blue notify">
                    <img class="bell_img" src="/images/lucide_bell-ring.svg" alt="Thông báo">
                    <div class="number_red"><?= count($get_noti) ?></div>
                    <div class="dropdown_notify">
                        <div class="n_dropdown">
                            <img class="tam_giac_2" src="/images/tam_giac.png" alt="dropdown">
                            <ul class="dropdown_notify_list">
                                <?php if (!empty($get_noti)) {
                                    $i = 0;
                                    foreach ($get_noti as $list) {
                                        $i++; ?>
                                        <li class="dropdown_notify_item">
                                            <div class="dropdown_notify_item_link" data-idNoti="<?= $list['id'] ?>">
                                                <div class="dropdown_notify_item_img">
                                                    <!-- <div class="border_img"> -->
                                                    <? if ($list['type'] == 1) {
                                                        $avt = url_avt_ntd($list['createtime'], $list['avatar']);
                                                    } else if ($list['type'] == 2) {
                                                        $avt = url_avt_ungvien($list['createtime'], $list['avatar']);
                                                    } ?>
                                                    <img class="img" src="<?= $avt ?>" onerror="this.src='/images/n_ava_logo.png';" alt="Ảnh đại diện">
                                                    <!-- </div> -->
                                                </div>
                                                <div class="dropdown_notify_content">
                                                    <p class="dropdown_notify_content_text">
                                                        <? if ($list['status'] == 1) {
                                                            $noti1 = '<a href="' . url_ntd($list['alias'], $list['id_ntd']) . '">' . $list['name'] . '</a>';
                                                            $noti = "đã lưu thông tin của bạn.";
                                                            $noti2 = "";
                                                        } else if ($list['status'] == 2) {
                                                            $noti1 = '<a href="' . url_ntd($list['alias'], $list['id_ntd']) . '">' . $list['name'] . '</a>';
                                                            $noti = "đã xem hồ sơ của bạn.";
                                                            $noti2 = "";
                                                        } else if ($list['status'] == 3) {
                                                            $noti1 = '<a href="' . url_ungvien($list['alias'], $list['id_uv']) . '">' . $list['name'] . '</a>';
                                                            $noti = "đã lưu thông tin việc làm ";
                                                            $noti2 = '<span style="font-weight: bold"><a href="' . url_vieclam($list['new_alias'], $list['id_new']) . '">' . $list['new_title'] . '</a></span> của bạn';
                                                        } else if ($list['status'] == 4) {
                                                            $noti1 = '<a href="' . url_ungvien($list['alias'], $list['id_uv']) . '">' . $list['name'] . '</a>';
                                                            $noti = "đã ứng tuyển việc làm ";
                                                            $noti2 = '<span style="font-weight: bold"><a href="' . url_vieclam($list['new_alias'], $list['id_new']) . '">' . $list['new_title'] . '</a></span> của bạn';
                                                        } ?>
                                                        <span style="font-weight: bold"><?= $noti1 ?></span> <?= $noti . $noti2 ?>
                                                    </p>
                                                    <p class="dropdown_notify_content_time">
                                                        <?= time_elapsed_string($list['create_date']) ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    <? }
                                } else { ?>
                                    <?php echo 'Không có thông báo nào.' ?>
                                <? } ?>
                            </ul>
                        </div>
                        <div class="delete_notify">
                            Xóa tất cả
                        </div>
                    </div>
                </div>
                <div class="round_blue chat">
                    <img src="/images/si-glyph_bubble-message-text.svg" alt="Tin nhắn">
                    <div class="number_red">2</div>

                </div>
                <div class="avatar_div">
                    <div class="avatar">
                        <img class="img" src="<?= $_COOKIE['avatar'] ?>" onerror="this.src='/images/n_ava_logo.png';" alt="Ảnh đại diện ">
                    </div>
                    <div class="dropdown_avatar">
                        <div class="email_header">
                            <img class="tam_giac" src="/images/tam_giac.png" alt="drop-down">
                            <?= $_COOKIE['email'] ?>
                        </div>
                        <ul class="dropdown_header_list">
                            <li class="dropdown_header_item">
                                <a href="<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? '/quan-ly-chung-ung-vien' : '/quan-ly-chung-ntd' ?>" class="dropdown_header_item_link">
                                    <div class="dropdown_header_item_link_img">
                                        <img src="/images/icon_qltk.svg" alt="Quản lý tài khoản">
                                    </div>
                                    <p class="dropdown_header_item_link_text">Quản lý tài khoản</p>
                                </a>

                            </li>
                            <li class="dropdown_header_item">
                                <a class="dropdown_header_item_link">
                                    <div class="dropdown_header_item_link_img">
                                        <img src="/images/logout.svg" alt="Đăng xuất">
                                    </div>
                                    <p class="dropdown_header_item_link_text n_hd_btn_log_out">Đăng xuất</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <!-- chua dang ky -->
            <div class="btn_login_signup n_not_375">
                <a href="/dang-nhap.html" class="btn_custom n_btn_login">Đăng nhập</a>
                <a href="/dang-ky.html" class="btn_custom btn_signup">Đăng ký</a>
            </div>
        <?php endif; ?>
    </div>

</div>
<!-- tablet -->
<div class="menu_responsive">
    <div class="menu_responsive_header">
        <a href="https://vieclam123.vn/" class="menu_responsive_header_div">
            <img class="back_img_responsive" src="/images/back.png" alt="Quay lại Vieclam123.vn">
            <p class="text_back">Quay lại Vieclam123.vn</p>
        </a>
        <img class="close_menu_response" width="18" height="18" src="/images/Union.svg" alt="Đóng menu">
    </div>
    <?php if (isset($_COOKIE['UserId']) && $_COOKIE['UserId'] > 0) : ?>
        <!-- da dang ky -->
        <div class="tt_tk">
            <div class="avatar_responsive">
                <img class="img" src="<?= $_COOKIE['avatar'] ?>" onerror="this.src='/images/n_ava_logo.png';" alt="Ảnh đại diện ">
            </div>
            <div class="name_email">
                <p class="name"><?= $_COOKIE['Name'] ?></p>
                <p class="email"><?= $_COOKIE['email'] ?></p>
            </div>
            <div class="menu_tt_tk">
                <div class="menu_tt_tk_item">
                    <a href="<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3) ? '/quan-ly-chung-ung-vien' : '/quan-ly-chung-ntd' ?>" class="menu_tt_tk_item_link">
                        Quản lý tài khoản
                    </a>

                </div>
                <div class="menu_tt_tk_item">
                    <a class="menu_tt_tk_item_link n_hd_btn_log_out">
                        Đăng xuất
                    </a>
                </div>
            </div>
        </div>
    <?php else : ?>
        <!-- chua dang ky -->
        <div class="btn_login_signup n_375">
            <a href="/dang-nhap.html" class="btn_custom n_btn_login">Đăng nhập</a>
            <a href="/dang-ky.html" class="btn_custom btn_signup">Đăng ký</a>
        </div>
    <?php endif; ?>
    <div class="menu_bot">
        <div class="menu_tt_tk">
            <div class="menu_tt_tk_item">
                <a href="/tim-viec-lam.html" class="menu_tt_tk_item_link">
                    Danh sách việc làm
                </a>

            </div>
            <div class="menu_tt_tk_item">
                <a href="/ung-vien-theo-gio" class="menu_tt_tk_item_link">
                    Danh sách ứng viên
                </a>
            </div>
            <div class="menu_tt_tk_item">
                <a href="https://vieclam123.vn/viec-lam/bang-gia/" class="menu_tt_tk_item_link">
                    Bảng giá
                </a>
            </div>
            <div class="menu_tt_tk_item">
                <a class="menu_tt_tk_item_link">
                    Liên hệ
                </a>
            </div>
            <div class="menu_tt_tk_item">
                <a href="https://vieclam123.vn/gioi-thieu-chung" class="menu_tt_tk_item_link">
                    Giới thiệu
                </a>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("includes/log_out"); ?>