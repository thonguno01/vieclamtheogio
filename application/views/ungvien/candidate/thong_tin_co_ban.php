<div class="n_content">
    <?php $this->load->view("includes/side_bar_ql_uv"); ?>
    <?php $this->load->view("includes/tab_bar_ql_hs"); ?>
    <!-- toàn bộ cục content -->
    <div class="n_ttcb_content">
        <!-- content bên trong vs margin auto display flex -->
        <div class="n_ttcb_sub_content">
            <div class="n_ttcb_avatar">
                <div class="n_ttcb_avatar_img">
                    <img id="preview_logo" src="<?= $_COOKIE['avatar'] ?>" onerror="this.src='/images/n_defaul_avatar.svg';">
                </div>
                <div class="n_ttcb_avatar_up">
                    <label for="up_photo"><img src="/images/n_icon_cam_plus.svg"></label>
                </div>
                <input hidden id="up_photo" type="file" onchange="loadFile(event)">
            </div>
            <!-- dòng 1 -->
            <div class="n_ttcb_row">
                <!-- bên trái  -->
                <div class="n_ttcb_row_left">
                    <p class="n_ttcb_label">Họ và tên (<span class="n_red_star">*</span>)</p>
                    <input class="n_ttcb_input n_name" type="text" value="<?= $_COOKIE['Name'] ?>" placeholder="Nhập họ tên">
                    <p class="n_ttcb_eror n_name_error"></p>
                </div>
                <!-- bên phải -->
                <div class="n_ttcb_row_right">
                    <p class="n_text_force">(<span class="n_red_star">*</span>) Thông tin bắt buộc</p>
                    <p class="n_ttcb_label n_email">Email (<span class="n_red_star">*</span>)</p>
                    <input class="n_ttcb_input" type="text" readonly disabled value="<?= $_COOKIE['email'] ?>">
                    <p class="n_ttcb_eror n_email_error"></p>
                </div>
            </div>
            <!-- dòng 2 -->
            <div class="n_ttcb_row n_ttcb_cb">
                <!-- bên trái  -->
                <div class="n_ttcb_row_left n_ttcb_row">
                    <div class="n_ttcb_radio">
                        <p class="n_ttcb_label">Giới tính (<span class="n_red_star">*</span>)</p>
                        <div class="n_ttcb_row">
                            <div class="n_ttcb_input_radio"><input class="n_sex" name="n_sex" value="1" <?php if ($infor['uv_sex'] == 1) echo 'checked'; ?> type="radio"> Nam</div>
                            <div class="n_ttcb_input_radio"><input class="n_sex" name="n_sex" value="2" <?php if ($infor['uv_sex'] == 2) echo 'checked'; ?> type="radio"> Nữ</div>
                        </div>
                        <p class="n_ttcb_eror n_sex_error"></p>
                    </div>
                    <div class="n_ttcb_radio">
                        <p class="n_ttcb_label">Tình trạng hôn nhân</p>
                        <div class="n_ttcb_row">
                            <div class="n_ttcb_input_radio"><input class="" name="n_mary" value="1" <?php if ($infor['uv_mary'] == 1) echo 'checked'; ?> type="radio"> Độc thân</div>
                            <div class="n_ttcb_input_radio n_kh"><input class="" name="n_mary" value="2" <?php if ($infor['uv_mary'] == 2) echo 'checked'; ?> type="radio"> Đã kết hôn</div>
                        </div>
                        <p class="n_ttcb_eror n_mary_error"></p>
                    </div>
                </div>
                <!-- bên phải -->
                <div class="n_ttcb_row_right">
                    <p class="n_ttcb_label">Ngày sinh (<span class="n_red_star">*</span>)</p>
                    <input class="n_ttcb_input n_dob" type="date" value='<?= ($infor['uv_dob'] > 0) ? date('Y-m-d', $infor['uv_dob']) : '' ?>'>
                    <p class="n_ttcb_eror n_dob_error"></p>
                </div>
            </div>
            <!-- dòng 3 -->
            <div class="n_ttcb_row">
                <!-- bên trái  -->
                <div class="n_ttcb_row_left">
                    <p class="n_ttcb_label">Tỉnh thành (<span class="n_red_star">*</span>)</p>
                    <select class="n_ttcb_input" id="n_city">
                        <option value="">Tất cả</option>
                        <?php
                        $cities = all_city();
                        foreach ($cities as $key => $value) :
                        ?>
                            <option value="<?= $key ?>" <?php if ($infor['uv_city'] == $key) echo 'selected'; ?>><?= $value ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                    <p class="n_ttcb_eror n_city_error"></p>
                </div>
                <!-- bên phải -->
                <div class="n_ttcb_row_right">
                    <p class="n_ttcb_label">Quận / Huyện (<span class="n_red_star">*</span>)</p>
                    <select class="n_ttcb_input" id="n_qh" qh_id=<?= $infor['uv_qh'] ?>>
                        <option value="0">Tất cả</option>
                    </select>
                    <p class="n_ttcb_eror n_qh_error"></p>
                </div>
            </div>
            <!-- dòng 4 -->
            <div class="n_ttcb_row">
                <!-- bên trái  -->
                <div class="n_ttcb_row_left">
                    <p class="n_ttcb_label">Địa chỉ cụ thể (<span class="n_red_star">*</span>)</p>
                    <input class="n_ttcb_input n_addr" type="text" value='<?= $infor['uv_address'] ?>' placeholder="Nhập địa chỉ">
                    <p class="n_ttcb_eror n_addr_error"></p>
                </div>
                <!-- bên phải -->
                <div class="n_ttcb_row_right">
                    <p class="n_ttcb_label">Số điện thoại (<span class="n_red_star">*</span>)</p>
                    <input class="n_ttcb_input n_tel" type="text" value='<?= $infor['uv_phone'] ?>'>
                    <p class="n_ttcb_eror n_tel_error"></p>
                </div>
            </div>
            <!-- button -->
            <button class="n_ttcb_update" id="n_ttcb_update">Cập nhật</button>
        </div>
    </div>

</div>