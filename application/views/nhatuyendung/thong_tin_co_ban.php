<div class="total_qlc">
    <div class=" menu_qlc_ntd">
        <?php include "side_bar_ql_ntd.php"; ?>
    </div>

    <div class="content_thong_tin_co_ban">
        <div class="thong_tin_co_ban container">
            <div class="thong_tin_co_ban_title py-4">
                <h1 class="thong_tin_co_ban_title_text">Thông tin tài khoản</h1>
            </div>

            <div class="head_cover_img">
                <?php $cre_time = explode('/', $_COOKIE['avatar']); ?>
                <img src="<?= 'upload/ntd/' . $cre_time[3] . '/' . $cre_time[4] . '/' . $cre_time[5] . '/' . $infor['ntd_cover_background']
                            ?>" alt="" onerror="this.src='/images/fake_bg_ntd.png';">
                <div class="preview_up1">
                    <img id="preview_logo1">
                    <p id="limit_size_img">1100 x 335px</p>
                </div>
                <div class="upload_photo">
                    <label for="up_photo1"><img src="/images/camera_add.png"></label>
                </div>
                <input hidden id="up_photo1" type="file" onchange="loadFile(event)">
            </div>

            <div class="avatar_ntd text-center">
                <div class="preview_up">
                    <img id="preview_logo" src="<?= $_COOKIE['avatar'] ?>" onerror="this.src='/images/fake_avatar_ntd.png';">
                </div>
                <div class="upload_avatar">
                    <label for="up_photo"><img src="/images/n_icon_cam_plus.svg"></label>
                </div>
                <input hidden id="up_photo" type="file" onchange="upFile(event)">
            </div>


            <div class="row no-gutters pt-4 form_thong_tin_co_ban">
                <div class="col-sm-6 form_ttcb">
                    <div class="sm-3 pt-2 thong_tin_info">
                        <label class="form-label">Tên doanh nghiệp/Nhà tuyển dụng (<span class="n_red_star">*</span>)</label>
                        <input type="Text" class="form-control" id="ntd_name" placeholder="Nhập tên doanh nghiệp / Nhà tuyển dụng" value="<?= $infor['ntd_company'] ?>">
                        <p class="n_dky_ntd_eror n_eror_name"></p>
                    </div>
                </div>

                <div class="col-sm-6 form_ttcb">
                    <div class="sm-3 pt-2 thong_tin_info">
                        <label class="form-label">Email đăng nhập (<span class="n_red_star">*</span>)</label>
                        <input type="text" class="form-control" id="ntd_email disabledInput" placeholder="Hhp@gmail.com" disabled value="<?= $_COOKIE['email'] ?>">
                        <p class="n_dky_ntd_eror n_eror_email"></p>
                    </div>
                </div>

                <div class="col-sm-6 form_ttcb">
                    <div class="sm-3 pt-2 thong_tin_info">
                        <label class="form-label">Số điện thoại (<span class="n_red_star">*</span>)</label>
                        <input type="text" class="pwd form-control" id="ntd_tel" placeholder="0146893467" value='<?= $infor['ntd_phone'] ?>'>
                        <p class="n_dky_ntd_eror n_eror_tel"></p>
                    </div>
                </div>

                <div class="col-sm-6 form_ttcb">
                    <div class="sm-3 pt-2 thong_tin_info">
                        <label class="form-label">Tỉnh/Thành phố (<span class="n_red_star">*</span>)</label>
                        <div class="n_dky_ntd_input n_city">
                            <select class="" id="n_city">
                                <option value="0">Chọn tỉnh /thành phố</option>
                                <?php
                                $cities = all_city();
                                foreach ($cities as $key => $value) :
                                ?>
                                    <option value="<?= $key ?>" <?php if ($infor['ntd_city'] == $key) echo 'selected'; ?>><?= $value ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <p class="n_dky_ntd_eror n_eror_city"></p>
                    </div>
                </div>

                <div class="col-sm-6 form_ttcb">
                    <div class="sm-3 pt-2 thong_tin_info">
                        <label class="form-label">Quận/Huyện (<span class="n_red_star">*</span>)</label>
                        <div class="n_dky_ntd_input n_qh">
                            <select class="" id="n_qh" qh_id=<?= $infor['ntd_quanhuyen'] ?>>
                                <option value="0">Chọn quận /huyện</option>

                            </select>
                        </div>
                        <p class="n_dky_ntd_eror n_eror_qh"></p>
                    </div>
                </div>

                <div class="col-sm-6 form_ttcb">
                    <div class="sm-3 pt-2 thong_tin_info">
                        <label class="form-label">Mã số thuế (<span class="note">Nếu có</span>)</label>
                        <input type="text" class="pwd form-control" id="ntd_mst" placeholder="Nhập mã số thuế" value="<?= $infor['ntd_msthue'] ?>">
                        <p class="n_dky_ntd_eror n_eror_mst"></p>
                    </div>
                </div>
                <div class="col-sm-12 form_ttcb">
                    <div class="thong_tin_info dcct_form">
                        <label class="form-label">Địa chỉ cụ thể (<span class="n_red_star">*</span>)</label>
                        <input type="text" class="pwd form-control" id="ntd_dia_chi" placeholder="SN 16 Nguyên An Ninh" value="<?= $infor['ntd_address'] ?>">
                        <p class="n_dky_ntd_eror n_eror_address"></p>
                    </div>
                </div>

                <div class="thong_tin_info ptlh_form">
                    <label class="form-label">Phương thức liên hệ khác</label>
                    <div class="ptlh row no-gutters">
                        <div class="input-group mb-2 col-sm-6">
                            <div class="input-group-prepend">
                                <div class="input-group-text input_group_box">Zalo</div>
                            </div>
                            <input type="text" class="form-control n_ptlh" id="n_zalo" placeholder="Nhập số điện thoại" value='<?= $infor['ntd_zalo'] ?>'>
                        </div>
                        <div class="input-group mb-2 col-sm-6">
                            <div class="input-group-prepend">
                                <div class="input-group-text input_group_box">Skype</div>
                            </div>
                            <input type="text" class="form-control n_ptlh" id="n_skype" placeholder="Nhập skype" value='<?= $infor['ntd_skype'] ?>'>

                        </div>
                    </div>
                    <p class="n_dky_ntd_eror n_eror_ptlh1"></p>
                    <p class="n_dky_ntd_eror n_eror_ptlh2"></p>
                </div>
            </div>
            <div class="btn_update py-5 text-center">
                <button class="btn btn_update_thong_tin">Cập nhật</button>
            </div>
        </div>
    </div>
</div>