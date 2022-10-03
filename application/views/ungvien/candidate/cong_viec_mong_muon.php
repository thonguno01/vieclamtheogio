<div class="n_content">
    <?php $this->load->view("includes/side_bar_ql_uv"); ?>
    <?php $this->load->view("includes/tab_bar_ql_hs"); ?>
    <!-- toàn bộ cục content -->
    <div class="n_ttcb_content">
        <!-- content bên trong vs margin auto display flex -->
        <div class="n_ttcb_sub_content">
            <!-- dòng 1 -->
            <div class="n_ttcb_row">
                <!-- bên trái  -->
                <div class="n_ttcb_row_left">
                    <p class="n_ttcb_label">Loại công việc (<span class="n_red_star">*</span>)</p>
                    <select class="n_ttcb_input" id="n_lcv" multiple>
                        <option value="">Tất cả</option>
                        <?php
                        $categoties = list_category();
                        $cat = explode(',', $infor['uv_cat']);
                        foreach ($categoties as $value) : ?>

                            <option value="<?= $value['cat_id'] ?>" <?php if (in_array($value['cat_id'], $cat)) echo 'selected'; ?>><?= $value['cat_name'] ?></option>

                        <?php endforeach; ?>
                    </select>
                    <p class="n_ttcb_eror n_lcv_error"></p>
                </div>
                <!-- bên phải -->
                <div class="n_ttcb_row_right">
                    <p class="n_text_force">(<span class="n_red_star">*</span>) Thông tin bắt buộc</p>
                    <p class="n_ttcb_label">Công việc cụ thể (<span class="n_red_star">*</span>)</p>
                    <input class="n_ttcb_input n_cvct" type="text" value='<?= $infor['uv_vitri'] ?>' placeholder="Công việc cụ thể muốn ứng tuyển">
                    <p class="n_ttcb_eror n_cvct_error"></p>
                </div>
            </div>
            <!-- dòng 2 -->
            <div class="n_ttcb_row">
                <!-- bên trái  -->
                <div class="n_ttcb_row_left">
                    <div class="">
                        <p class="n_ttcb_label">Hình thức làm việc (<span class="n_red_star">*</span>)</p>
                        <select class="n_ttcb_input" id="n_htlv">
                            <option value="0">Tất cả</option>
                            <?php
                            $arr = all_htlv();
                            foreach ($arr as $key => $value) {
                                if ($infor['uv_hinh_thuc'] == $key) {
                                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                                } else {
                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <p class="n_ttcb_eror n_htlv_error"></p>
                    </div>
                    <div class="">
                        <p class="n_ttcb_label">Loại hình làm việc (<span class="n_red_star">*</span>)</p>
                        <select class="n_ttcb_input" id="n_lhlv">
                            <option value="0">Tất cả</option>
                            <?php
                            $arr = all_lhlv();
                            foreach ($arr as $key => $value) {
                                if ($infor['uv_loai_hinh'] == $key) {
                                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                                } else {
                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <p class="n_ttcb_eror n_lhlv_error"></p>
                    </div>
                </div>
                <!-- bên phải -->
                <div class="n_ttcb_row_right">
                    <div class="">
                        <p class="n_ttcb_label">Nơi làm việc mong muốn (<span class="n_red_star">*</span>)</p>
                        <select class="n_ttcb_input" id="n_city" multiple>
                            <option value="">Tất cả</option>
                            <?php
                            $cities = all_city();
                            foreach ($cities as $key => $value) :
                            ?>
                                <option value="<?= $key ?>" <?php if ($infor['uv_city_hope'] == $key) echo 'selected'; ?>><?= $value ?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                        <p class="n_ttcb_eror n_nlvmm_error"></p>
                    </div>
                    <div class="n_cvmm_mlmm">
                        <p class="n_ttcb_label">Mức lương mong muốn (<span class="n_red_star">*</span>)</p>
                        <div class="n_cvmm_luong">
                            <select class="n_ttcb_input" id="n_ht_luong">
                                <?php
                                $luong_1 = all_htl();
                                foreach ($luong_1 as $key => $value) : ?>
                                    <option value="<?= $key ?>" <?= ($infor['uv_luong_1'] == $key ? 'selected' : '') ?>><?= $value ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                            <?php if ($infor['uv_luong_1'] == 2) {
                                $luong_2 = explode('-', $infor['uv_luong_2']);
                                if (count($luong_2) == 1) { ?>
                                    <div class="n_cvmm_luong_3">
                                        <input class="n_luong_min" type="number" min=1 value="<?= $luong_2[0] ?>">/
                                        <input class="n_luong_max" type="number" min=1 value="<?= $luong_2[0] ?>">
                                    </div>
                                <?php } else { ?>
                                    <div class="n_cvmm_luong_3">
                                        <input class="n_luong_min" type="number" min=1 value="<?= $luong_2[0] ?>">/
                                        <input class="n_luong_max" type="number" min=1 value="<?= $luong_2[1] ?>">
                                    </div>
                                <?php } ?>
                                <input class="n_cvmm_luong_1 n_ttcb_input hide" type="number" min=1>

                                <select class="n_ttcb_input" id="n_httl">
                                    <?php
                                    $luong_3 = all_ml();
                                    foreach ($luong_3 as $key => $value) : ?>
                                        <option value="<?= $key ?>" <?= ($infor['uv_luong_3'] == $key ? 'selected' : '') ?>><?= $value ?></option>
                                    <?php
                                    endforeach;
                                    ?>
                                </select>
                            <?php } else if ($infor['uv_luong_1'] == 3) { ?>
                                <div class="n_cvmm_luong_3 hide">
                                    <input class="n_luong_min" type="number" min=1>/
                                    <input class="n_luong_max" type="number" min=1>
                                </div>
                                <input class="n_cvmm_luong_1 n_ttcb_input" type="number" min=1 disabled>
                                <select class="n_ttcb_input" id="n_httl" disabled>
                                    <?php
                                    $luong_3 = all_ml();
                                    foreach ($luong_3 as $key => $value) : ?>
                                        <option value="<?= $key ?>" <?= ($infor['uv_luong_3'] == $key ? 'selected' : '') ?>><?= $value ?></option>
                                    <?php
                                    endforeach;
                                    ?>
                                </select>
                            <?php } else { ?>
                                <div class="n_cvmm_luong_3 hide">
                                    <input class="n_luong_min" type="number" min=1>/
                                    <input class="n_luong_max" type="number" min=1>
                                </div>
                                <input class="n_cvmm_luong_1 n_ttcb_input" type="number" min=1 value="<?= $infor['uv_luong_2'] ?>">
                                <select class="n_ttcb_input" id="n_httl">
                                    <?php
                                    $luong_3 = all_ml();
                                    foreach ($luong_3 as $key => $value) : ?>
                                        <option value="<?= $key ?>" <?= ($infor['uv_luong_3'] == $key ? 'selected' : '') ?>><?= $value ?></option>
                                    <?php
                                    endforeach;
                                    ?>
                                </select>
                            <?php } ?>
                            <!-- <div class="n_cvmm_luong_3 hide">
                                <input class="n_luong_min" type="number" min=1>/
                                <input class="n_luong_max" type="number" min=1>
                            </div>
                            <input class="n_cvmm_luong_1 n_ttcb_input" type="number" min=1>
                            <select class="n_ttcb_input" id="n_httl">
                                <option value="1">Giờ</option>
                                <option value="2">Tuần</option>
                                <option value="3">Tháng</option>
                                <option value="4">Dự án</option>
                            </select> -->
                        </div>
                        <p class="n_ttcb_eror n_htl_error"></p>
                    </div>
                </div>
            </div>
            <!-- dòng 3 -->
            <div class="n_ttcb_row">
                <div class="n_ttcb_row_right" id="n_calam" data-value="<?= $infor['uv_calam'] ?>">
                    <p class="n_ttcb_label">Buổi có thể đi làm (<span class="n_red_star">*</span>)</p>
                    <div class="n_ca_lam_radio">
                        <div class="n_ca_lam">
                            <div class="checkbox_boder" time="mo">
                                <div class="checkbox_checked"></div>
                            </div>
                            <p class="n_ca_lam_text">Đi làm full sáng</p>
                        </div>
                        <div class="n_ca_lam">
                            <div class="checkbox_boder" time="no">
                                <div class="checkbox_checked"></div>
                            </div>
                            <p class="n_ca_lam_text">Đi làm full chiều</p>
                        </div>
                        <div class="n_ca_lam">
                            <div class="checkbox_boder" time="ni">
                                <div class="checkbox_checked"></div>
                            </div>
                            <p class="n_ca_lam_text">Đi làm full tối</p>
                        </div>
                        <div class="n_ca_lam">
                            <div class="checkbox_boder" time="none" id="none">
                                <div class="checkbox_checked"></div>
                            </div>
                            <p class="n_ca_lam_text">Có thể đi làm linh động theo sắp xếp của NTD</p>
                        </div>
                    </div>
                    <div class="n_detail_ca_lam">
                        <div class="n_dow n_mon">
                            <p class="n_ndow">Thứ 2</p>
                            <p class="n_tdow n_mo" value="21">Sáng</p>
                            <p class="n_tdow n_no" value="22">Chiều</p>
                            <p class="n_tdow n_ni" value="23">Tối</p>
                        </div>
                        <div class="n_dow n_tue">
                            <p class="n_ndow">Thứ 3</p>
                            <p class="n_tdow n_mo" value="31">Sáng</p>
                            <p class="n_tdow n_no" value="32">Chiều</p>
                            <p class="n_tdow n_ni" value="33">Tối</p>
                        </div>
                        <div class="n_dow n_wen">
                            <p class="n_ndow">Thứ 4</p>
                            <p class="n_tdow n_mo" value="41">Sáng</p>
                            <p class="n_tdow n_no" value="42">Chiều</p>
                            <p class="n_tdow n_ni" value="43">Tối</p>
                        </div>
                        <div class="n_dow n_thu">
                            <p class="n_ndow">Thứ 5</p>
                            <p class="n_tdow n_mo" value="51">Sáng</p>
                            <p class="n_tdow n_no" value="52">Chiều</p>
                            <p class="n_tdow n_ni" value="53">Tối</p>
                        </div>
                        <div class="n_dow n_fri">
                            <p class="n_ndow">Thứ 6</p>
                            <p class="n_tdow n_mo" value="61">Sáng</p>
                            <p class="n_tdow n_no" value="62">Chiều</p>
                            <p class="n_tdow n_ni" value="63">Tối</p>
                        </div>
                        <div class="n_dow n_sat">
                            <p class="n_ndow">Thứ 7</p>
                            <p class="n_tdow n_mo" value="71">Sáng</p>
                            <p class="n_tdow n_no" value="72">Chiều</p>
                            <p class="n_tdow n_ni" value="73">Tối</p>
                        </div>
                        <div class="n_dow n_sun">
                            <p class="n_ndow">Chủ nhật</p>
                            <p class="n_tdow n_mo" value="81">Sáng</p>
                            <p class="n_tdow n_no" value="82">Chiều</p>
                            <p class="n_tdow n_ni" value="83">Tối</p>
                        </div>
                    </div>
                    <p class="n_ttcb_eror n_eror_ca_lam"></p>
                </div>
            </div>
            <!-- button -->
            <button class="n_ttcb_update">Cập nhật</button>
        </div>
    </div>
</div>