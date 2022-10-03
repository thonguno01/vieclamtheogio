<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quản lý tài khoản
            <small>Thêm mới</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Quản lý tài khoản</a></li>
            <li><a href="">Thêm mới</a></li>
        </ol>
    </section>

    <div class="container">
        <div class="avatar_ntd text-center py-4">
            <div class="preview_up">
                <img id="preview_logo" src="/images/n_defaul_avatar.svg">
            </div>
            <div class="upload_avatar">
                <label for="up_photo"><img src="/images/n_icon_cam_plus.svg"></label>
            </div>
            <input hidden id="up_photo" type="file" onchange="loadFile(event)">
        </div>
        <div class="container py-5">
            <div class="row desktop_screen">
                <div class="col-sm-6">
                    <div class="sm-3 pt-2 dky_ntd_info">
                        <label class="form-label">Email (<span class="n_red_star">*</span>)</label>
                        <input type="email" class="form-control" id="ntd_email" placeholder="Nhập email">
                        <p class="n_dky_ntd_eror n_eror_email"></p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="sm-3 pt-2 dky_ntd_info">
                        <p class="n_text_force">(<span class="n_red_star">*</span>) Thông tin bắt buộc</p>
                        <label class="form-label">Số điện thoại (<span class="n_red_star">*</span>)</label>
                        <input type="number" class="form-control" id="ntd_number" placeholder="Nhập số điện thoại">
                        <p class="n_dky_ntd_eror n_eror_number"></p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="sm-3 pt-2 dky_ntd_info">
                        <label class="form-label">Mật khẩu (<span class="n_red_star">*</span>)</label>
                        <input type="password" class="pwd pwd_ntd form-control" id="ntd_password" placeholder="Nhập mật khẩu">
                        <button class="n_show_pwd"><img class="n_pwd_eye" src="/images/n_icon_open_eye.svg"></button>
                        <p class="n_dky_ntd_eror n_eror_pass"></p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="sm-3 pt-2 dky_ntd_info">
                        <label class="form-label">Nhập lại mật khẩu (<span class="n_red_star">*</span>)</label>
                        <input type="password" class="rep_pwd pwd_ntd form-control" id="ntd_repass" placeholder="Nhập lại mật khẩu">
                        <button class="n_show_pwd"><img class="n_pwd_eye" src="/images/n_icon_open_eye.svg"></button>
                        <p class="n_dky_ntd_eror n_eror_repass"></p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="sm-3 pt-2 dky_ntd_info">
                        <label class="form-label">Tỉnh thành (<span class="n_red_star">*</span>)</label>
                        <div class="n_dky_ntd_input n_city">
                            <select class="" id="n_city">
                                <option value="0">Chọn tỉnh / thành phố</option>
                                <?php
                                $cities = all_city();
                                foreach ($cities as $key => $value) :
                                ?>
                                    <option value="<?= $key ?>"><?= $value ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <p class="n_dky_ntd_eror n_eror_city"></p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="sm-3 pt-2 dky_ntd_info">
                        <label class="form-label">Quận/Huyện (<span class="n_red_star">*</span>)</label>
                        <div class="n_dky_ntd_input n_qh">
                            <select class="" id="n_qh">
                                <option value="0">Chọn quận / huyện</option>
                            </select>
                        </div>
                        <p class="n_dky_ntd_eror n_eror_qh"></p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="sm-3 pt-2 dky_ntd_info">
                        <label class="form-label">Địa chỉ cụ thể (<span class="n_red_star">*</span>)</label>
                        <input type="address" class="form-control" id="ntd_address" placeholder="VD: SN 13 Hoàng Quốc Việt">
                        <p class="n_dky_ntd_eror n_eror_address"></p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="sm-3 pt-2 dky_ntd_info">
                        <label class="form-label">Tên doanh nghiệp/Người tuyển dụng (<span class="n_red_star">*</span>)</label>
                        <input type="name" class="form-control" id="ntd_name" placeholder="Nhập tên doanh nghiệp/Người tuyển dụng">
                        <p class="n_dky_ntd_eror n_eror_name"></p>
                    </div>
                </div>
            </div>
            <div class="dky_ntd_info status_acc mb-3">
                <label for="" class="label_tit lbl_name_tag"><span>* </span>Status:</label><br>
                <input type="radio" name="status" value="1">: Đã xác thực
                <input type="radio" name="status" value="0">: Chưa xác thực
                <p class="n_dky_uv_eror n_status_error"></p>
            </div>
        </div>
        <button class="btn btn-primary submit_form_ntd">Đăng ký</button>
    </div>
</div>