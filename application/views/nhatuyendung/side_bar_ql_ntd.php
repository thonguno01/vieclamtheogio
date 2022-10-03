<div class="n_side_bar_ntd ">
    <div class="header_menu_ntd text-center">
        <img class="n_side_bar_avatar" src="<?= $_COOKIE['avatar'] ?>" onerror="this.src='/images/n_defaul_avatar.svg';" alt="">
        <h1 class="name_ntd"><?= $_COOKIE['Name'] ?></h1>
        <?php if (isset($_COOKIE['point'])) { ?>
            <p class="n_ntd_point">Điểm lọc hồ sơ: <?= $_COOKIE['point'] ?></p>
        <?php } ?>
        <?php if (isset($_COOKIE['point']) && $_COOKIE['point'] > 0 && isset($_COOKIE['point_exp']) && $_COOKIE['point_exp'] > 0) { ?>
            <p class="n_ntd_point_exp">Hết hạn ngày: <?= date('d-m-Y', $_COOKIE['point_exp']) ?></p>
        <?php } ?>
    </div>
    <div class="body_menu_ntd menu_mobile">
        <div class="n_side_bar_ql<?= (isset($sidebar) && $sidebar == 10) ? ' n_side_bar_ql_at' : ''; ?>">
            <img class="n_side_bar_ql_icon_at" src="/images/n_icon_qlc_uv_at.svg" alt="">
            <img class="n_side_bar_ql_icon" src="/images/qlc.png" alt="">
            <a href="/quan-ly-chung-ntd" class="n_text_ql">Quản lý chung</a>
        </div>
        <div class="n_side_bar_ql<?= (isset($sidebar) && $sidebar == 20) ? ' n_side_bar_ql_at' : ''; ?>">
            <img class="n_side_bar_ql_icon_at" src="/images/new_post_at.png" alt="">
            <img class="n_side_bar_ql_icon" src="/images/new_post.png" alt="">
            <a href="/dang-tin" class="n_text_ql">Đăng tin mới</a>
        </div>
        <div class="n_side_bar_ql<?= (isset($sidebar) && $sidebar == 30) ? ' n_side_bar_ql_at' : ''; ?>">
            <img class="n_side_bar_ql_icon_at" src="/images/old_post_at.png" alt="">
            <img class="n_side_bar_ql_icon" src="/images/old_post.png" alt="">
            <a href="/tin-da-dang" class="n_text_ql">Tin đã đăng</a>
        </div>
        <div class="n_side_bar_ql n_qlhsut<?= (isset($sidebar) && $sidebar > 40 && $sidebar < 50) ? ' n_side_bar_ql_at' : ''; ?>">
            <img class="n_side_bar_ql_icon_at" src="/images/ql_hs_uv_at.png">
            <img class="n_side_bar_ql_icon" src="/images/ql_hs_uv.png">
            <p class="n_text_ql">Quản lý hồ sơ ứng viên</p>
            <img class="n_drop_down_icon n_side_bar_ql_icon_at<?= (isset($sidebar) && $sidebar > 40 && $sidebar < 50) ? ' n_drop_down' : ''; ?>" src="/images/n_icon_down_blue.svg">
            <img class="n_drop_down_icon n_side_bar_ql_icon" src="/images/n_icon_down.svg">
        </div>
        <div class="n_side_bar_drop_down<?= (isset($sidebar) && $sidebar > 40 && $sidebar < 50) ? '' : ' hide'; ?>">
            <a href="/ung-vien-ung-tuyen" class="n_text_drop_down<?= (isset($sidebar) && $sidebar == 41) ? ' n_side_bar_drop_at' : ''; ?>">Ứng viên ứng tuyển</a>
            <a href="/ung-vien-da-luu" class="n_text_drop_down<?= (isset($sidebar) && $sidebar == 42) ? ' n_side_bar_drop_at' : ''; ?>">Ứng viên đã lưu</a>
            <a href="/ung-vien-tu-diem-loc" class="n_text_drop_down<?= (isset($sidebar) && $sidebar == 42) ? ' n_side_bar_drop_at' : ''; ?>">Ứng viên từ điểm lọc </a>
        </div>
        <div class="n_side_bar_ql n_qltk_ntd<?= (isset($sidebar) && $sidebar > 50 && $sidebar < 60) ? ' n_side_bar_ql_at' : ''; ?>">
            <img class="n_side_bar_ql_icon_at" src="/images/ql_acc_ntd_at.png">
            <img class="n_side_bar_ql_icon" src="/images/ql_acc_ntd.png">
            <p class="n_text_ql">Tài khoản NTD</p>
            <img class="n_drop_down_icon n_side_bar_ql_icon_at<?= (isset($sidebar) && $sidebar > 50 && $sidebar < 60) ? ' n_drop_down' : ''; ?>" src="/images/n_icon_down_blue.svg">
            <img class="n_drop_down_icon n_side_bar_ql_icon" src="/images/n_icon_down.svg">
        </div>
        <div class="n_side_bar_drop_down<?= (isset($sidebar) && $sidebar > 50 && $sidebar < 60) ? '' : ' hide'; ?>">
            <a href="/thong-tin-co-ban-ntd" class="n_text_drop_down<?= (isset($sidebar) && $sidebar == 51) ? ' n_side_bar_drop_at' : ''; ?>">Thông tin cơ bản</a>
            <a href="/gioi-thieu-chung-ntd" class="n_text_drop_down<?= (isset($sidebar) && $sidebar == 52) ? ' n_side_bar_drop_at' : ''; ?>">Giới thiệu chung</a>
        </div>
        <div class="n_side_bar_ql<?= (isset($sidebar) && $sidebar == 60) ? ' n_side_bar_ql_at' : ''; ?>">
            <img class="n_side_bar_ql_icon_at" src="/images/n_icon_dmk_at.svg">
            <img class="n_side_bar_ql_icon" src="/images/change_pass.png">
            <a href="/doi-mat-khau-ntd" class="n_text_ql">Đổi mật khẩu</a>
        </div>
        <div class="n_side_bar_ql<?= (isset($content) && $content) == '' ? ' n_side_bar_ql_at' : ''; ?>">
            <img class="n_side_bar_ql_icon_at" src="/images/n_icon_logout_at.svg">
            <img class="n_side_bar_ql_icon" src="/images/logout.png">
            <a href="#" class="n_text_ql n_hd_btn_log_out">Đăng xuất</a>
        </div>
    </div>
    <div class="n_side_bar_btn_mobi">
        <img class="n_side_bar_btn_mobi_icon" src="/images/n_icon_plus.svg">
    </div>
</div>