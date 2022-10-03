<div class="total_qlc">
    <div class=" menu_qlc_ntd">
        <?php include "side_bar_ql_ntd.php"; ?>
    </div>

    <div class="content_forgot_pass">

        <div class="container form_forgot_pass">
            <div class="forgot_pass_img text-center">
                <img src="/images/password_img.png" alt="">
            </div>
            <div class="form_pass">
                <div class="sm-3 pt-2 pass_eror_info">
                    <label class="form-label">Mật khẩu hiện tại(<span class="n_red_star">*</span>)</label>
                    <input type="password" class="pwd form-control" id="old_password" placeholder="Nhập mật khẩu" >
                    <button class="n_show_pwd"><img class="n_pwd_eye" src="/images/n_icon_open_eye.svg"></button>
                </div>
                <p class="pass_eror n_eror_pass"></p>
                <div class="sm-3 pt-2 pass_eror_info">
                    <label class="form-label new_pass">Mật khẩu mới(<span class="n_red_star">*</span>)</label>
                    <input type="password" class="pwd form-control" id="new_password" placeholder="Nhập mật khẩu" >
                    <button class="n_show_pwd"><img class="n_pwd_eye" src="/images/n_icon_open_eye.svg"></button>
                    
                </div>
                <p class="pass_eror n_eror_new_pass"></p>
                <div class="sm-3 pt-2 pass_eror_info">
                    <label class="form-label rep_pass">Nhập lại mật khẩu(<span class="n_red_star">*</span>)</label>
                    <input type="password" class="pwd form-control" id="rep_new_password" placeholder="Nhập mật khẩu" >
                    <button class="n_show_pwd"><img class="n_pwd_eye" src="/images/n_icon_open_eye.svg"></button>
                    
                </div>
                <p class="pass_eror n_eror_rep_new_pass"></p>
                <p class="n_text_force">(<span class="n_red_star">*</span>) Thông tin bắt buộc</p>
            </div>
            <div class="change_pass text-center pt-5">
                <button class="btn btn_change_pass">Đổi mật khẩu</button>
            </div>
            
        </div>
    </div>
</div>
<?php $this->load->view("includes/popup_doimk_thanhcong"); ?>