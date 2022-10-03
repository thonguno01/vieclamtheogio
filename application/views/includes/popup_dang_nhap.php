<div class="background_login">

    <div class="background-nav">
        <img src="/images/background_nav_login.svg" class="img_background" alt="background đăng nhập">
        
        <div class="button_close_popup_dn text-center">
            <img class="btn_x n_close_popup_dn" src="/images/n_icon_plus.svg" alt="">
            <img class="line_x" src="/images/line.png" alt="">
        </div>
        <div class="form_login">
            <p class="text_1 n_dn_title">BẠN CẦN ĐĂNG NHẬP ĐỂ THỰC HIỆN THAO TÁC</p>
            <form class="form_login_page">
                <div class="inp_login inp_email">
                    <img src="/images/icon_email_login.svg" class="icon_email" alt="icon email">
                    <input type="text" placeholder="Nhập email đăng nhập" id="email" name="email">
                </div>
                <p class="error" id="email-error-container"></p>
                <div class="inp_login">
                    <img src="/images/icon_lock_login.svg" class="icon_pass" alt="icon mật khẩu">
                    <input type="password" placeholder="Nhập mật khẩu" id="pass" name="pass">
                    <img src="/images/icon_see_pass.svg" class="icon_see_pass" onclick="show_pass(this)" alt="icon hiển thị mật khẩu">
                </div>
                <p class="error" id="pass-error-container"></p>
                <a href="/quen-mat-khau.html">
                    <p class="text_3">Quên mật khẩu?</p>
                </a>
                <button class="btn_login">Đăng nhập</button>
            </form>

            <div class="text-center pt-3">
                <h1 class="no_acc">Bạn chưa có tài khoản?</h1>
                <h1><a href="/dang-ky.html" class="sign_up_now">ĐĂNG KÝ NGAY</a></h1>
            </div>
        </div>
        
    </div>
</div>