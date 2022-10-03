<div class="change_pass">
    <div class="img_change_pass">
        <img src="/images/n_dky_uv.svg" alt="">
    </div>
    <div class="box_set_pass">
        <div class="box_inside_set_pass">
            <div class="text-center py-3 set_pass_title">
                <h1 class="set_pass_title_text">Đặt lại mật khẩu</h1>
            </div>
            <form id="changePass">
                <div class="set_pass_form">
                    <div class="pb-3 new_password">
                        <label class="form-label">Mật khẩu mới </label>
                        <input type="password" class="pwd form-control" id="new_password" placeholder="Nhập mật khẩu">
                        <img src="/images/key_pass.png" alt="" class="key_icon">
                        <p class="n_pass_eror n_eror_pass"></p>
                    </div>
                    <div class="pb-3 new_password">
                        <label class="form-label">Nhập lại mật khẩu mới </label>
                        <input type="password" class="pwd form-control" id="rep_new_password" placeholder="Nhập mật khẩu mới">
                        <img src="/images/key_pass.png" alt="" class="key_icon">
                        <p class="n_pass_eror n_eror_new_pass"></p>
                    </div>
                    <div class="text-center">
                        <input type="hidden" data-id="<?= $id ?>" data-type="<?= $type ?>" id="id_email">
                        <button type="submit" class="btn btn_save_change">Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>