<div class="n_content">
    <?php $this->load->view("includes/side_bar_ql_uv"); ?>
    <div class="n_dmk_container">
        <div class="n_dmk_sub_container">
            <img src="/images/n_dmk.png">
            <div class="n_dmk_form">
                <div class="n_dmk_row">
                    <p class="n_dmk_label">Mật khẩu hiện tại (<span class="n_red_star">*</span>)</p>
                    <input class="n_dkm_input n_pass" type="password">
                    <button class="n_show_pwd"><img class="n_pwd_eye" src="/images/n_icon_open_eye.svg"></button>
                </div>
                <p class="n_error n_pass_error"></p>
                <div class="n_dmk_row">
                    <p class="n_dmk_label">Mật khẩu mới (<span class="n_red_star">*</span>)</p>
                    <input class="n_dkm_input n_new_pass" type="password" oninput="this.value = this.value.replace(/^[' '.]/g, '');">
                    <button class="n_show_pwd"><img class="n_pwd_eye" src="/images/n_icon_open_eye.svg"></button>
                </div>
                <p class="n_error n_new_pass_error"></p>
                <div class="n_dmk_row">
                    <p class="n_dmk_label">Nhập lại mật khẩu (<span class="n_red_star">*</span>)</p>
                    <input class="n_dkm_input n_new_repass" type="password" oninput="this.value = this.value.replace(/^[' '.]/g, '');">
                    <button class="n_show_pwd"><img class="n_pwd_eye" src="/images/n_icon_open_eye.svg"></button>
                </div>
                <p class="n_error n_new_repass_error"></p>
            </div>
            <p class="n_text_force">(<span class="n_red_star">*</span>) Thông tin bắt buộc</p>
            <button class="n_dmk_btn">Đổi mật khẩu</button>
        </div>
    </div>
</div>
<?php $this->load->view("includes/popup_doimk_thanhcong"); ?>