<?php $CI = &get_instance();
$CI->load->model('models/Models'); ?>
<div class="n_side_bar_uv_1">
    <div class="n_side_bar_uv">
        <div class="n_side_bar_top">
            <div class="n_side_bar_top_left">
                <div class="n_side_bar_avatar">
                    <img src="<?= $_COOKIE['avatar'] ?>" onerror="this.src='/images/n_defaul_avatar.svg';">
                </div>
                <p class="n_text n_side_bar_id">Mã hồ sơ: <?= $_COOKIE['UserId'] ?></p>
            </div>
            <div class="n_side_bar_top_right">
                <? $get_uv   = $CI->Models->select_sql('user_uv', 'uv_found,number_refresh', array('uv_id' => $_COOKIE['UserId']), null, null, null, null, null, 0); ?>
                <p class="n_text n_side_bar_name"><?= $_COOKIE['Name'] ?></p>
                <p class="n_text n_side_bar_email"><?= $_COOKIE['email'] ?></p>
                <div class="n_side_bar_allow_find">
                    <input id="switch" hidden type="checkbox" <? if ($get_uv['uv_found'] == 1) {
                                                                    echo "checked";
                                                                } ?>>
                    <label for="switch" class="n_side_bar_checkbox" onclick="ntd_found_uv(<?= $_COOKIE['UserId'] ?>)"></label>
                    <p class="n_text n_side_bar_allow_find_text">Cho phép NTD tìm kiếm</p>
                </div>
                <a onclick="lammoi_hsuv(<?= $_COOKIE['UserId'] ?>)" class="n_side_bar_renew">
                    <img class="n_side_bar_renew_icon" src="/images/n_icon_reuse.svg">
                    <p class="n_text n_side_bar_renew_text">Làm mới hồ sơ</p>
                    <p class="n_side_bar_renew_tooltip"> Làm mới giúp hồ sơ Ứng viên được đẩy lên vị trí đầu tiên tại Page "Danh sách ứng viên"</p>
                </a>
                <p class="n_text n_side_bar_renew_rest">Còn <?= $get_uv['number_refresh'] ?>/5 lần làm mới tháng này</p>
            </div>
        </div>
        <div class="n_side_bar_bottom menu_mobile">
            <div class="n_side_bar_ql<?= (isset($sidebar) && $sidebar == 10) ? ' n_side_bar_ql_at' : ''; ?>">
                <img class="n_side_bar_ql_icon_at" src="/images/n_icon_qlc_uv_at.svg">
                <img class="n_side_bar_ql_icon" src="/images/n_icon_qlc_uv.svg">
                <a href="/quan-ly-chung-ung-vien" class="n_text_ql">Quản lý chung</a>
            </div>
            <div class="n_side_bar_ql n_qlhs<?= (isset($sidebar) && $sidebar > 20 && $sidebar < 30) ? ' n_side_bar_ql_at' : ''; ?>">
                <img class="n_side_bar_ql_icon_at" src="/images/n_icon_ql_hs_uv_at.svg">
                <img class="n_side_bar_ql_icon" src="/images/n_icon_ql_hs_uv.svg">
                <p class="n_text_ql">Quản lý hồ sơ</p>
                <img class="hide_drop_icon n_drop_down_icon_at<?= (isset($sidebar) && $sidebar > 20 && $sidebar < 30) ? ' n_drop_down' : ''; ?>" src="/images/n_icon_down_blue.svg">
                <img class="hide_drop_icon n_drop_down_icon" src="/images/n_icon_down.svg">
            </div>
            <div class="n_side_bar_drop_down<?= (isset($sidebar) && $sidebar > 20 && $sidebar < 30) ? '' : ' hide'; ?>">
                <a href="/thong-tin-co-ban-uv" class="n_text_drop_down<?= (isset($sidebar) && $sidebar == 21) ? ' n_side_bar_drop_at' : ''; ?>">Thông tin cơ bản </a>
                <a href="/cong-viec-mong-muon" class="n_text_drop_down<?= (isset($sidebar) && $sidebar == 22) ? ' n_side_bar_drop_at' : ''; ?>">Công việc mong muốn </a>
                <a href="/gioi-thieu-chung-uv" class="n_text_drop_down<?= (isset($sidebar) && $sidebar == 23) ? ' n_side_bar_drop_at' : ''; ?>">Giới thiệu chung </a>
                <a href="/kinh-nghiem-lam-viec" class="n_text_drop_down<?= (isset($sidebar) && $sidebar == 24) ? ' n_side_bar_drop_at' : ''; ?>">Kinh nghiệm làm việc</a>
            </div>
            <div class="n_side_bar_ql<?= (isset($sidebar) && $sidebar == 30) ? ' n_side_bar_ql_at' : ''; ?>">
                <img class="n_side_bar_ql_icon_at" src="/images/n_icon_vldut_at.svg">
                <img class="n_side_bar_ql_icon" src="/images/n_icon_vldut.svg">
                <a href="/viec-lam-da-ung-tuyen" class="n_text_ql">Việc làm đã ứng tuyển</a>
            </div>
            <div class="n_side_bar_ql<?= (isset($sidebar) && $sidebar == 40) ? ' n_side_bar_ql_at' : ''; ?>">
                <img class="n_side_bar_ql_icon_at" src="/images/n_icon_vldl_at.svg">
                <img class="n_side_bar_ql_icon" src="/images/n_icon_vldl.svg">
                <a href="/viec-lam-da-luu" class="n_text_ql">Việc làm đã lưu</a>
            </div>
            <div class="n_side_bar_ql<?= (isset($sidebar) && $sidebar == 50) ? ' n_side_bar_ql_at' : ''; ?>">
                <img class="n_side_bar_ql_icon_at" src="/images/n_icon_ntdxhs_at.svg">
                <img class="n_side_bar_ql_icon" src="/images/n_icon_ntdxhs.svg">
                <a href="/nha-tuyen-dung-xem-ho-so" class="n_text_ql">Nhà tuyển dụng đã xem hồ sơ</a>
            </div>
            <div class="n_side_bar_ql<?= (isset($sidebar) && $sidebar == 60) ? ' n_side_bar_ql_at' : ''; ?>">
                <img class="n_side_bar_ql_icon_at" src="/images/n_icon_dmk_at.svg">
                <img class="n_side_bar_ql_icon" src="/images/n_icon_dmk.svg">
                <a href="/doi-mat-khau-ung-vien" class="n_text_ql">Đổi mật khẩu</a>
            </div>
            <div class="n_side_bar_ql<?= (isset($sidebar) && $sidebar == 70) ? ' n_side_bar_ql_at' : ''; ?>">
                <img class="n_side_bar_ql_icon_at" src="/images/n_icon_logout_at.svg">
                <img class="n_side_bar_ql_icon" src="/images/n_icon_logout.svg">
                <p class="n_text_ql n_hd_btn_log_out">Đăng xuất</p>
            </div>
        </div>
        <div class="n_side_bar_btn_mobi">
            <img class="n_side_bar_btn_mobi_icon" src="/images/n_icon_plus.svg">
        </div>
    </div>
</div>