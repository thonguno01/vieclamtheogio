<div class="n_sub_body_search">
    <div class="n_search">
        <div class="search_input">
            <img src="/images/timkiem.svg" class="vieclamic" alt="">
            <input class="n_key" id="keyword_uv" type="text" <?php if (!isset($keyword_uv) || $keyword_uv == "") { ?> placeholder="Nhập từ khóa mong muốn..." <? } else { ?> value="<?= $keyword_uv ?>" <? } ?> oninput="this.value = this.value.replace(/^[' '.]/g, '');">
        </div>
        <select id="n_city_uv" class="n_city_uv">
            <img src="/images/vieclam.svg" class="vieclamic" alt="">
            <?php
            $cities = list_city();
            if (!isset($id_city_uv)) { ?>
                <option data-tokens="0" value="0">Tất cả địa điểm</option>
                <?php foreach ($cities as $key => $ct) { ?>
                    <option value="<?= $ct["cit_id"] ?>"> <?= $ct["cit_name"] ?></option>
                <? }
            } else {
                foreach ($cities as $key => $ct) {
                    if ($id_city_uv == $ct["cit_id"]) {
                        $checked = "selected";
                    } else {
                        $checked = '';
                    }
                ?>
                    <option <?php echo $checked ?> data-tokens="<?php echo $ct["cit_id"] ?>" value="<?php echo $ct["cit_id"] ?>"><?php echo $ct["cit_name"] ?></option>
            <?php }
            } ?>
        </select>
        <button class="n_tim_kiem"> Tìm kiếm </button>
    </div>
</div>
<button type="button" class="btn btn-outline-info button_menu_job" data-toggle="modal" data-target="#myModal"><img src="/images/boloc.svg" alt="">
    Bộ lọc
</button>
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Bộ lọc tìm kiếm</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="box_modal_body">
                    <div class="title_modal">Hình thức làm việc</div>
                    <div class="row btn-group btn-group-toggle " data-toggle="buttons">
                        <?php $all_htlv = all_htlv();
                        if (!isset($hinhthuc_uv)) { ?>
                            <?php foreach ($all_htlv as $key => $value) {
                                if ($key == 0) {
                                    $checked = "checked";
                                    $active = "active";
                                } else {
                                    $checked = '';
                                    $active = '';
                                } ?>
                                <label class="btn btn-light col-6 <?= $active ?>">
                                    <input type="radio" name="s_hinhthuc_mb" class="s_hinhthuc_mb" autocomplete="off" value="<?= $key ?>" <?= $checked ?>> <?= $value ?>
                                </label>
                            <? }
                        } else {
                            foreach ($all_htlv as $key => $value) {
                                if ($hinhthuc_uv == $key) {
                                    $checked = "checked";
                                    $active = "active";
                                } else {
                                    $checked = '';
                                    $active = '';
                                }
                            ?>
                                <label class="btn btn-light col-6 <?= $active ?>">
                                    <input type="radio" name="s_hinhthuc_mb" class="s_hinhthuc_mb" autocomplete="off" value="<?= $key ?>" <?= $checked ?>> <?= $value ?>
                                </label>
                        <?php }
                        } ?>
                    </div>
                </div>
                <div class="box_modal_body">
                    <div class="title_modal">Loại hình làm việc</div>
                    <div class="row btn-group btn-group-toggle" data-toggle="buttons">
                        <?php $all_lhlv = all_lhlv();
                        if (!isset($loailv_uv)) { ?>
                            <?php foreach ($all_lhlv as $key => $value) {
                                if ($key == 0) {
                                    $checked = "checked";
                                    $active = "active";
                                } else {
                                    $checked = '';
                                    $active = '';
                                } ?>
                                <label class="btn btn-light col-6 <?= $active ?>">
                                    <input type="radio" name="s_loailv_mb" class="s_loailv_mb" autocomplete="off" value="<?= $key ?>" <?= $checked ?>> <?= $value ?>
                                </label>
                            <? }
                        } else {
                            foreach ($all_lhlv as $key => $value) {
                                if ($loailv_uv == $key) {
                                    $checked = "checked";
                                    $active = "active";
                                } else {
                                    $checked = '';
                                    $active = '';
                                }
                            ?>
                                <label class="btn btn-light col-6 <?= $active ?>">
                                    <input type="radio" name="s_loailv_mb" class="s_loailv_mb" autocomplete="off" value="<?= $key ?>" <?= $checked ?>> <?= $value ?>
                                </label>
                        <?php }
                        } ?>
                    </div>
                </div>
                <div class="box_modal_body">
                    <div class="title_modal">Giới tính</div>
                    <div class="row btn-group btn-group-toggle" data-toggle="buttons">
                        <?php $all_sex = all_sex();
                        if (!isset($gioitinh_uv)) { ?>
                            <?php foreach ($all_sex as $key => $value) {
                                if ($key == 0) {
                                    $checked = "checked";
                                    $active = "active";
                                } else {
                                    $checked = '';
                                    $active = '';
                                } ?>
                                <label class="btn btn-light col-6 <?= $active ?>">
                                    <input type="radio" name="s_gioitinh_mb" class="s_gioitinh_mb" autocomplete="off" value="<?= $key ?>" <?= $checked ?>> <?= $value ?>
                                </label>
                            <? }
                        } else {
                            foreach ($all_sex as $key => $value) {
                                if ($gioitinh_uv == $key) {
                                    $checked = "checked";
                                    $active = "active";
                                } else {
                                    $checked = '';
                                    $active = '';
                                }
                            ?>
                                <label class="btn btn-light col-6 <?= $active ?>">
                                    <input type="radio" name="s_gioitinh_mb" class="s_gioitinh_mb" autocomplete="off" value="<?= $key ?>" <?= $checked ?>> <?= $value ?>
                                </label>
                        <?php }
                        } ?>
                    </div>
                </div>
                <div class="box_modal_body">
                    <div class="title_modal">Tình trạng hôn nhân</div>
                    <div class="row btn-group btn-group-toggle" data-toggle="buttons">
                        <?php $all_mary = all_mary();
                        if (!isset($honnhan_uv)) { ?>
                            <?php foreach ($all_mary as $key => $value) {
                                if ($key == 0) {
                                    $checked = "checked";
                                    $active = "active";
                                } else {
                                    $checked = '';
                                    $active = '';
                                } ?>
                                <label class="btn btn-light col-6 <?= $active ?>">
                                    <input type="radio" name="s_honnhan_mb" class="s_honnhan_mb" autocomplete="off" value="<?= $key ?>" <?= $checked ?>> <?= $value ?>
                                </label>
                            <? }
                        } else {
                            foreach ($all_mary as $key => $value) {
                                if ($honnhan_uv == $key) {
                                    $checked = "checked";
                                    $active = "active";
                                } else {
                                    $checked = '';
                                    $active = '';
                                }
                            ?>
                                <label class="btn btn-light col-6 <?= $active ?>">
                                    <input type="radio" name="s_honnhan_mb" class="s_honnhan_mb" autocomplete="off" value="<?= $key ?>" <?= $checked ?>> <?= $value ?>
                                </label>
                        <?php }
                        } ?>
                    </div>
                </div>
                <div class="box_modal_body" style="border:none ">
                    <div class="title_modal">Mức lương mong muôn</div>
                    <div class="row btn-group btn-group-toggle" data-toggle="buttons">
                        <?php $all_htl = all_htl();
                        if (!isset($luong_uv)) { ?>
                            <?php foreach ($all_htl as $key => $value) {
                                if ($key == 0) {
                                    $checked = "checked";
                                    $active = "active";
                                } else {
                                    $checked = '';
                                    $active = '';
                                } ?>
                                <label class="btn btn-light col-6 <?= $active ?>">
                                    <input type="radio" name="s_luong_mb" class="s_luong_mb" autocomplete="off" value="<?= $key ?>" <?= $checked ?>> <?= $value ?>
                                </label>
                            <? }
                        } else {
                            foreach ($all_htl as $key => $value) {
                                if ($luong_uv == $key) {
                                    $checked = "checked";
                                    $active = "active";
                                } else {
                                    $checked = '';
                                    $active = '';
                                }
                            ?>
                                <label class="btn btn-light col-6 <?= $active ?>">
                                    <input type="radio" name="s_luong_mb" class="s_luong_mb" autocomplete="off" value="<?= $key ?>" <?= $checked ?>> <?= $value ?>
                                </label>
                        <?php }
                        } ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Thiết lập lại</button>
                <button type="button" class="btn btn-primary loc_ungvien_mb" data-dismiss="modal">Lọc</button>
            </div>
        </div>
    </div>
</div>