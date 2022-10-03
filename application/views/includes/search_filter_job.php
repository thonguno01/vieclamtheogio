<div class="n_body_search_1">
    <div class="n_sub_body_search">
        <?php $this->load->view("includes/search_job.php"); ?>
        <button class="n_filter_btn">
            <img src="/images/n_filter_menu.svg" />
            Bộ lọc
        </button>
    </div>
</div>
<div class="n_body_search_2">
    <p class="n_title">việc làm theo giờ mới nhất</p>
    <div class="n_filter_opt n_filter_options_after">
        <div class="n_filter_opt n_filter_options_before">
        </div>
    </div>
    <div class="n_filter_opt n_filter_options">
        <div class="n_filter_option">
            <p class="n_filter_option_label">Hình thức trả lương</p>
            <select class="n_filter_option_select" id="n_httl">
                <option value="0">Tất cả</option>
                <?php
                $arr = all_httl();
                foreach ($arr as $key => $value) {
                    if (isset($htl) && $htl == $key) {
                        echo '<option selected value="' . $key . '">' . $value . '</option>';
                    } else {
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="n_filter_option">
            <p class="n_filter_option_label">Trình độ học vấn</p>
            <select class="n_filter_option_select" id="n_hv">
                <option value="0">Tất cả</option>
                <?php
                $arr = all_hv();
                foreach ($arr as $key => $value) {
                    if (isset($hv) && $hv == $key) {
                        echo '<option selected value="' . $key . '">' . $value . '</option>';
                    } else {
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="n_filter_option">
            <p class="n_filter_option_label">Giới tính</p>
            <select class="n_filter_option_select" id="n_gt">
                <option value="0">Tất cả</option>
                <?php
                $arr = all_sex();
                foreach ($arr as $key => $value) {
                    if (isset($gt) && $gt == $key) {
                        echo '<option selected value="' . $key . '">' . $value . '</option>';
                    } else {
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="n_filter_option">
            <p class="n_filter_option_label">Cấp bậc</p>
            <select class="n_filter_option_select" id="n_cb">
                <option value="0">Tất cả</option>
                <?php
                $arr = all_vi_tri();
                foreach ($arr as $key => $value) {
                    if (isset($cb) && $cb == $key) {
                        echo '<option selected value="' . $key . '">' . $value . '</option>';
                    } else {
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="n_filter_option">
            <p class="n_filter_option_label">Kinh nghiệm làm việc</p>
            <select class="n_filter_option_select" id="n_knlv">
                <option value="0">Tất cả</option>
                <?php
                $arr = all_exp();
                foreach ($arr as $key => $value) {
                    if (isset($kn) && $kn == $key) {
                        echo '<option selected value="' . $key . '">' . $value . '</option>';
                    } else {
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="n_filter_option">
            <p class="n_filter_option_label">Loại hình làm việc</p>
            <select class="n_filter_option_select" id="n_lhlv">
                <option value="0">Tất cả</option>
                <?php
                $arr = all_lhlv();
                foreach ($arr as $key => $value) {
                    if (isset($lh) && $lh == $key) {
                        echo '<option selected value="' . $key . '">' . $value . '</option>';
                    } else {
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="n_filter_option">
            <p class="n_filter_option_label">Hình thức làm việc</p>
            <select class="n_filter_option_select" id="n_htlv">
                <option value="0">Tất cả</option>
                <?php
                $arr = all_htlv();
                foreach ($arr as $key => $value) {
                    if (isset($ht) && $ht == $key) {
                        echo '<option selected value="' . $key . '">' . $value . '</option>';
                    } else {
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>
</div>
<div class="n_modal_filter_mobile">
    <div class="n_modal_filter_content">
        <div class="n_modal_filter_header">
            <p class="text">Bộ lọc tìm kiếm</p>
            <button class="n_close_filter"><img src="/images/n_icon_close.svg"></button>
        </div>
        <div class="n_modal_filter_body">
            <div class="n_modal_filter">
                <p class="text">Hình thức trả lương</p>
                <div class="n_filter_option_div n_httl" data-value=<?= isset($htl) ? $htl : 0 ?>>
                    <?php
                    $arr = all_httl();
                    foreach ($arr as $key => $value) {
                        if (isset($htl) && $htl == $key) {
                            echo '<div class="n_option n_option_select" data-value=' . $key . '>' . $value . '</div>';
                        } else {
                            echo '<div class="n_option" data-value=' . $key . '>' . $value . '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="n_modal_filter">
                <p class="text">Trình độ học vấn</p>
                <div class="n_filter_option_div n_hv" data-value=<?= isset($hv) ? $hv : 0 ?>>
                    <?php
                    $arr = all_hv();
                    foreach ($arr as $key => $value) {
                        if (isset($hv) && $hv == $key) {
                            echo '<div class="n_option n_option_select" data-value=' . $key . '>' . $value . '</div>';
                        } else {
                            echo '<div class="n_option" data-value=' . $key . '>' . $value . '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="n_modal_filter">
                <p class="text">Cấp bậc</p>
                <div class="n_filter_option_div n_cb" data-value=<?= isset($cb) ? $cb : 0 ?>>
                    <?php
                    $arr = all_vi_tri();
                    foreach ($arr as $key => $value) {
                        if (isset($cb) && $cb == $key) {
                            echo '<div class="n_option n_option_select" data-value=' . $key . '>' . $value . '</div>';
                        } else {
                            echo '<div class="n_option" data-value=' . $key . '>' . $value . '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="n_modal_filter">
                <p class="text">Giới tính</p>
                <div class="n_filter_option_div n_gt" data-value=<?= isset($gt) ? $gt : 0 ?>>
                    <?php
                    $arr = all_sex();
                    foreach ($arr as $key => $value) {
                        if (isset($gt) && $gt == $key) {
                            echo '<div class="n_option n_option_select" data-value=' . $key . '>' . $value . '</div>';
                        } else {
                            echo '<div class="n_option" data-value=' . $key . '>' . $value . '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="n_modal_filter">
                <p class="text">Kinh nghiệm làm việc</p>
                <div class="n_filter_option_div n_knlv" data-value=<?= isset($kn) ? $kn : 0 ?>>
                    <?php
                    $arr = all_exp();
                    foreach ($arr as $key => $value) {
                        if (isset($kn) && $kn == $key) {
                            echo '<div class="n_option n_option_select" data-value=' . $key . '>' . $value . '</div>';
                        } else {
                            echo '<div class="n_option" data-value=' . $key . '>' . $value . '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="n_modal_filter">
                <p class="text">Loại hình làm việc</p>
                <div class="n_filter_option_div n_lhlv" data-value=<?= isset($lh) ? $lh : 0 ?>>
                    <?php
                    $arr = all_lhlv();
                    foreach ($arr as $key => $value) {
                        if (isset($lh) && $lh == $key) {
                            echo '<div class="n_option n_option_select" data-value=' . $key . '>' . $value . '</div>';
                        } else {
                            echo '<div class="n_option" data-value=' . $key . '>' . $value . '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="n_modal_filter">
                <p class="text">Hình thức làm việc</p>
                <div class="n_filter_option_div n_htlv" data-value=<?= isset($ht) ? $ht : 0 ?>>
                    <?php
                    $arr = all_htlv();
                    foreach ($arr as $key => $value) {
                        if (isset($ht) && $ht == $key) {
                            echo '<div class="n_option n_option_select" data-value=' . $key . '>' . $value . '</div>';
                        } else {
                            echo '<div class="n_option" data-value=' . $key . '>' . $value . '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="n_modal_filter_footer">
            <button class="n_del_filter">Thiết lập lại</button>
            <button class="n_filter">Lọc</button>
        </div>
    </div>
</div>