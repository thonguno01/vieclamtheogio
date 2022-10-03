<?php $CI = &get_instance();
$CI->load->model('models/Models'); ?>
<div class="pagecolor"></div>
<div class="uv_page">
    <div class="container">
        <?php
        $this->load->view('/includes/search_form')
        ?>

        <div class="container">
            <div class="title">
                <div>
                    <h1 class="text-center tieude">TỔNG HỢP DANH SÁCH ỨNG VIÊN TÌM VIỆC THEO GIỜ MỚI NHẤT</h1>
                </div>
                <div class="container-fluid menu_job">
                    <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3 no-gutters">
                        <div class="p-3">
                            <p class="n_filter_uv_label">Hình thức làm việc</p>
                            <select name="" class="select loc_nangcao s_hinhthuc">
                                <option value="0">Tất cả</option>
                                <?php $all_htlv = all_htlv();
                                if (!isset($hinhthuc_uv)) { ?>
                                    <?php foreach ($all_htlv as $key => $value) { ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <? }
                                } else {
                                    foreach ($all_htlv as $key => $value) {
                                        if ($hinhthuc_uv == $key) {
                                            $checked = "selected";
                                        } else {
                                            $checked = '';
                                        }
                                    ?>
                                        <option <?= $checked ?> data-tokens="<?= $key ?>" value="<?= $key ?>"><?= $value ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="p-3">
                            <p class="n_filter_uv_label">Loại hình làm việc</p>
                            <select name="" class="select loc_nangcao s_loailv">
                                <option value="0">Tất cả</option>
                                <?php $all_lhlv = all_lhlv();
                                if (!isset($loailv_uv)) { ?>
                                    <?php foreach ($all_lhlv as $key => $value) { ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <? }
                                } else {
                                    foreach ($all_lhlv as $key => $value) {
                                        if ($loailv_uv == $key) {
                                            $checked = "selected";
                                        } else {
                                            $checked = '';
                                        }
                                    ?>
                                        <option <?= $checked ?> data-tokens="<?= $key ?>" value="<?= $key ?>"><?= $value ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="p-3">
                            <p class="n_filter_uv_label">Giới tính</p>
                            <select name="" class="select loc_nangcao s_gioitinh">
                                <option value="0">Tất cả</option>
                                <?php $all_sex = all_sex();
                                if (!isset($gioitinh_uv)) { ?>
                                    <?php foreach ($all_sex as $key => $value) { ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <? }
                                } else {
                                    foreach ($all_sex as $key => $value) {
                                        if ($gioitinh_uv == $key) {
                                            $checked = "selected";
                                        } else {
                                            $checked = '';
                                        }
                                    ?>
                                        <option <?= $checked ?> data-tokens="<?= $key ?>" value="<?= $key ?>"><?= $value ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="p-3">
                            <p class="n_filter_uv_label">Tình trạng hôn nhân</p>
                            <select name="" class="select loc_nangcao s_honnhan">
                                <option value="0">Tất cả</option>
                                <?php $all_mary = all_mary();
                                if (!isset($honnhan_uv)) { ?>
                                    <?php foreach ($all_mary as $key => $value) { ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <? }
                                } else {
                                    foreach ($all_mary as $key => $value) {
                                        if ($honnhan_uv == $key) {
                                            $checked = "selected";
                                        } else {
                                            $checked = '';
                                        }
                                    ?>
                                        <option <?= $checked ?> data-tokens="<?= $key ?>" value="<?= $key ?>"><?= $value ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="p-3">
                            <p class="n_filter_uv_label">Mức lương mong muốn</p>
                            <select name="" class="select loc_nangcao s_luong">
                                <option value="0">Tất cả</option>
                                <?php $all_htl = all_htl();
                                if (!isset($luong_uv)) { ?>
                                    <?php foreach ($all_htl as $key => $value) { ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <? }
                                } else {
                                    foreach ($all_htl as $key => $value) {
                                        if ($luong_uv == $key) {
                                            $checked = "selected";
                                        } else {
                                            $checked = '';
                                        }
                                    ?>
                                        <option <?= $checked ?> data-tokens="<?= $key ?>" value="<?= $key ?>"><?= $value ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="danhsach ">
            <div>
                <h2><a class="trangchu" href="/"> Trang chủ</a> /Danh sách ứng viên <?= isset($bread_cum_title) ? $bread_cum_title : '' ?></h2>
            </div>
            <div class="container_infor">
                <div class="n_tuv_title">
                    <p class="title_new_uv">Danh sách ứng viên <?= isset($bread_cum_title) ? $bread_cum_title : '' ?> mới nhất</p>
                </div>
                <div class="row no-gutters ">
                    <?php foreach ($infor as $value) : ?>
                        <div class="col-sm-6 box_uv ">
                            <div class="box_info">
                                <div class="row">
                                    <div class="infor">
                                        <?php
                                        if (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) {
                                            $id_ntd = $_COOKIE['UserId'];
                                            $check_save_uv   = $CI->Models->select_sql('save_uv', '*', array('id_ntd' => $id_ntd, 'id_uv' => $value['uv_id']), null, null, null, null, null, 0);
                                            if ($check_save_uv != null) { ?>
                                                <button class="Group1000003744 button_save_uv" onClick="save_uv(<?= $value['uv_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) ? $_COOKIE['UserId'] : '' ?>>
                                                    <img src="/images/Group 1000003745.svg" alt="">
                                                </button>
                                            <? } else { ?>
                                                <button class="Group1000003744 button_save_uv" onClick="save_uv(<?= $value['uv_id'] ?>)" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) ? $_COOKIE['UserId'] : '' ?>>
                                                    <img src="/images/Group 1000003744.svg" alt="">
                                                </button>
                                            <? } ?>
                                        <? } else { ?>
                                            <button class="Group1000003744 button_save_uv" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) ? $_COOKIE['UserId'] : '' ?>>
                                                <img src="/images/Group 1000003744.svg" alt="">
                                            </button>
                                        <? } ?>
                                        <button class="Group1000005125 button_chat" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) ? $_COOKIE['UserId'] : '' ?>>
                                            <img src="/images/Group 1000005125.svg" alt="">
                                        </button>
                                        <div class="alert-hover">
                                            <p> Lưu ứng viên</p>
                                        </div>
                                        <div class="chat-hover">
                                            <p>Chat với ứng viên</p>
                                        </div>
                                        <div class="row_box_info">
                                            <div class="avatar_box">
                                                <div class="avatar_cage">
                                                    <a href="<?= url_ungvien($value['uv_alias'], $value['uv_id']) ?>">
                                                        <img src="/upload/uv/<?= date('Y', $value['uv_createtime']) ?>/<?= date('m', $value['uv_createtime']) ?>/<?= date('d', $value['uv_createtime']) ?>/<?= $value['uv_avatar'] ?>" onerror="this.src='/images/Ellipse 515.png';" class="avatar_uv" alt="<?= $value['uv_name'] ?>">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="info">
                                                <a href="<?= url_ungvien($value['uv_alias'], $value['uv_id']) ?>">
                                                    <h3 class="name">

                                                        <?= $value['uv_name'] ?>
                                                    </h3>
                                                </a>
                                                <p class="job"><?= $value['uv_vitri'] ?></p>

                                                <a href="/ung-vien-theo-gio-tai-<?= vn_str_filter(get_city($value['uv_city'])) ?>-k0t<?= $value['uv_city'] ?>.html">
                                                    <p class="address"><img class="n_uv_icon" src="/images/n_icon_map.svg"><?= get_city($value['uv_city']) ?></p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="description py-2">
                                        <p class="job_des"><img class="n_uv_icon" src="/images/n_icon_briefcase.svg">Công việc nhận làm:
                                            <?php $uv_cat = explode(',', $value['uv_cat']); ?>
                                            <?php foreach ($category as $cat_value) : ?>
                                                <?php if (in_array($cat_value['cat_id'], $uv_cat) == true) { ?>
                                                    <a class="cv_nhanlam" href="<?= url_cv_uv($cat_value['cat_alias'], $cat_value['cat_id']) ?>"><?= $cat_value['cat_name'] ?></a> /
                                                <?php } ?>
                                            <?php endforeach; ?>
                                        </p>
                                        <p class="job_des">
                                            <img class="n_uv_icon" src="/images/book.svg">Loại hình làm việc:
                                            <a class="btn_type_work" href="<?= url_uv_lhlv($value['uv_loai_hinh']) ?>"><?= get_lhlv($value['uv_loai_hinh']) ?></a>
                                        </p>

                                        <p class="job_des">
                                            <img class="n_uv_icon" src="/images/signpost.svg">Hình thức làm việc:
                                            <a class="btn_type_work" href="<?= url_uv_htlv($value['uv_hinh_thuc']) ?>"><?= get_htlv($value['uv_hinh_thuc']) ?></a>
                                        </p>
                                        <p class="job_des">
                                            <img class="n_uv_icon" src="/images/usd-coin-(usdc).svg">Mức lương mong muốn:
                                            <a href="<?= url_uv_luong($value['uv_luong_1']) ?>"><span id="salary"><?= get_htl($value['uv_luong_1']) ?></span></a>
                                        </p>
                                    </div>
                                </div>
                                <?php
                                if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) {
                                    $check_see_uv   =  $this->Models->select_sql('see_uv', 'see_uv.*, user_uv.uv_email, user_uv.uv_phone', array('see_uv.id_ntd' => $_COOKIE['UserId'], 'see_uv.id_uv' => $value['uv_id']), null, array('user_uv' => 'see_uv.id_uv = user_uv.uv_id'), null, null, null, 0);
                                }

                                if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) {
                                    $condition = [
                                        'id_uv' =>  $value['uv_id'],
                                        'id_ntd' => $_COOKIE['UserId'],
                                        'id_new' => 0,
                                        'status' => 5,
                                    ];
                                    $result = $this->Models->select_data('*', 'notification', [], $condition, '', '', '');


                                    if ($result->num_rows() != null) {
                                        $hour24h = getDate()[0] - $result->row_array()['create_date'];
                                        // if ($hour24h < 86400) {
                                ?>
                                        <div class="seen d-flex w-100 justify-content-end ">
                                            <span class="bg-warning pl-2 pr-2 text-white" style="font-size: 14px;"> Đã xem</span>
                                        </div>
                                    <?php   }
                                    // }
                                    ?>

                                    <?php
                                    if ($check_see_uv != null) {
                                        // $motNgay = getDate()[0] - $check_see_uv['create_date'];
                                        // if ($motNgay < 15520) {
                                    ?>
                                        <div class="seen d-flex w-100 justify-content-end ">
                                            <span class="bg-success pl-2 pr-2 text-white" style="font-size: 14px;"> Đã mở</span>
                                        </div>
                                <?php
                                    }
                                    // }
                                }
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php echo $this->pagination->create_links(); ?>
            </div>
            <div class="bottombg">
                <img src="/images/bottom.png" alt="">
                <button type="button" class="btn btn-warning btn_bottom" data-iduser=<?= (isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) ? $_COOKIE['UserId'] : '' ?>>
                    Đăng tin tuyển dụng ngay
                </button>
            </div>
        </div>
    </div>
</div>
</div>
<input type="hidden" class="type_login" value="4">
<?php $this->load->view("includes/popup_dang_nhap"); ?>