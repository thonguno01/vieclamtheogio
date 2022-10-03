<div class="n_content">
    <?php $this->load->view("includes/side_bar_ql_uv"); ?>
    <?php $this->load->view("includes/tab_bar_ql_hs"); ?>
    <div class="n_ttcb_content">
        <!-- content bên trong vs margin auto display flex -->
        <div class="n_ttcb_sub_content">
            <!-- danh sách kinh nghiệm đã có -->
            <div class="n_list_exp">
                <input class="n_id_update" type="hidden" value="0">
                <?php foreach ($infor as $value) : ?>
                    <div class="n_ttcb_row">
                        <div class="n_ttcb_row_left n_knlv_row_content" data-id=<?= $value['id_knlv'] ?>>
                            <img class="n_knlv_kn_ava" src="/images/n_knlv_avata.svg">
                            <div class="n_knlv_kn_text">
                                <p class="n_knlv_kn_txt"><span class="n_knlv_kn_title">Tên công ty:</span> <span class="n_knlv_kn_txt n_name_txt"><?= $value['com_name'] ?></span></p>
                                <p class="n_knlv_kn_txt"><span class="n_knlv_kn_title">Chức danh / Vị trí:</span> <span class="n_knlv_kn_txt n_vt_txt" data-id="<?= $value['vi_tri'] ?>"><?= get_vi_tri($value['vi_tri']) ?></span></p>
                                <p class="n_knlv_kn_txt"><span class="n_knlv_kn_title">Thời gian:</span> <span class="n_knlv_kn_itxt">Từ</span> <span class="n_knlv_kn_txt n_from_txt"><?= date('d/m/Y', $value['date_from']) ?></span> <span class="n_knlv_kn_itxt">đến</span> <span class="n_knlv_kn_txt n_to_txt"><?= date('d/m/Y', $value['date_to']) ?></span></p>
                                <p class="n_knlv_kn_txt"><span class="n_knlv_kn_title">Mô tả:</span> <span class="n_knlv_kn_ides"><?= $value['mo_ta'] ?></span></p>
                            </div>
                            <button class="n_knlv_kn_func n_btn_edit" onclick="edit_exp(this)">
                                <img src="/images/n_icon_pen.svg">
                            </button>
                            <button class="n_knlv_kn_func n_btn_del" onclick="del_exp(this)" data-id=<?= $value['id_knlv'] ?>>
                                <img src="/images/n_icon_del.svg">
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- form cập nhập kinh nghiệm -->
            <div class="n_ttcb_row">
                <!-- bên trái  -->
                <div class="n_ttcb_row_left">
                    <p class="n_ttcb_label">Tên công ty (<span class="n_red_star">*</span>)</p>
                    <input class="n_ttcb_input n_name" type="text" placeholder="Nhập tên công ty">
                    <p class="n_ttcb_eror n_name_error"></p>
                </div>
                <!-- bên phải -->
                <div class="n_ttcb_row_right">
                    <p class="n_ttcb_label">Chức danh / Vị trí (<span class="n_red_star">*</span>)</p>
                    <select class="n_ttcb_input" id="n_vt">
                        <option value="">Chọn chức danh / vị trí</option>
                        <?php
                        $chuc_vu = [
                            ['cv_id' => 1, 'cv_name' => 'Mới tốt nghiếp'],
                            ['cv_id' => 2, 'cv_name' => 'Thực tập sinh'],
                            ['cv_id' => 3, 'cv_name' => 'Nhân viên'],
                            ['cv_id' => 4, 'cv_name' => 'Trưởng nhóm'],
                            ['cv_id' => 5, 'cv_name' => 'Trưởng phòng'],
                            ['cv_id' => 6, 'cv_name' => 'Giám đốc và cấp cao hơn'],
                        ];
                        $vitri = explode(',', $infor['vi_tri']);
                        foreach ($chuc_vu as $value) : ?>
                            <option value="<?= $value['cv_id'] ?>" <?php if (in_array($value['cv_id'], $vitri)) echo 'selected'; ?>><?= $value['cv_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p class="n_ttcb_eror n_vt_error"></p>
                </div>
            </div>
            <div class="n_ttcb_row">
                <!-- bên trái  -->
                <div class="n_ttcb_row_left">
                    <p class="n_ttcb_label">Ngày bắt đầu (<span class="n_red_star">*</span>)</p>
                    <input class="n_ttcb_input n_date_start" type="date" placeholder="Nhập tên công ty">
                    <p class="n_ttcb_eror n_date_start_error"></p>
                </div>
                <!-- bên phải -->
                <div class="n_ttcb_row_right">
                    <p class="n_ttcb_label">Ngày kết thúc (<span class="n_red_star">*</span>)</p>
                    <input class="n_ttcb_input n_date_end" type="date" placeholder="Nhập tên công ty">
                    <p class="n_ttcb_eror n_date_end_error"></p>
                </div>
            </div>
            <div class="n_ttcb_row">
                <div class="n_ttcb_row_right">
                    <p class="n_ttcb_label">Mô tả ngắn về kỹ năng của bản thân</p>
                    <textarea class="n_knlv_mota" placeholder="Mô tả về kỹ năng của bản thân:
    - Ứng viên từng làm công việc gì?
    - Công việc đó kéo dài trong bao lâu?
    - Ứng viên có những kỹ làm việc nào?"></textarea>

                    <p class="n_knlv_add_exp"><button class="n_btn_add"><img src="/images/n_icon_circle_plus.svg">Thêm kinh nghiệm</button></p>
                </div>

            </div>
            <p class="n_ttcb_eror n_n_knlv_mota_error text-left w-100 pl-3"></p>
            <button class="n_ttcb_update">Cập nhật</button>
        </div>
    </div>
</div>
<?php $this->load->view("includes/warning_delete"); ?>