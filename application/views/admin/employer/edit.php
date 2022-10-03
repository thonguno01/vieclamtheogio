<div class="content-wrapper">
    <div class="n_dky_uv_left">
        <section class="content-header">
            <h1>
                Quản lý tài khoản
                <small>Sửa</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i>Quản lý tài khoản</a></li>
                <li><a href="">Sửa</a></li>
            </ol>
        </section>

        <div class="container">
            <div class="avatar_ntd text-center">
                <div class="preview_up">
                    <img id="preview_logo" src="/upload/ntd/<?=date('Y',$info_employer['ntd_create_time'])?>/<?=date('m',$info_employer['ntd_create_time'])?>/<?=date('d',$info_employer['ntd_create_time'])?>/<?=$info_employer['ntd_avatar']?>" onerror="this.src='/images/fake_avatar_ntd.png';">
                </div>
                <!-- <div class="upload_avatar">
                    <label for="up_photo"><img src="/images/n_icon_cam_plus.svg"></label>
                </div>
                <input hidden id="up_photo" type="file" onchange="upFile(event)"> -->
            </div>


        <div class="row no-gutters pt-4 form_thong_tin_co_ban">
            <div class="col-sm-6 form_ttcb">
                <div class="sm-3 pt-2 thong_tin_info">
                    <label class="form-label">Tên doanh nghiệp/Nhà tuyển dụng (<span class="n_red_star">*</span>)</label>
                    <input type="Text" class="form-control" id="ntd_name" placeholder="Nhập tên doanh nghiệp / Nhà tuyển dụng" value="<?=$info_employer['ntd_company']?>">
                    <p class="n_dky_ntd_eror n_eror_name"></p>
                </div>
            </div>

            <div class="col-sm-6 form_ttcb">
                <div class="sm-3 pt-2 thong_tin_info">
                    <label class="form-label">Email đăng nhập (<span class="n_red_star">*</span>)</label>
                    <input type="text" class="form-control" id="ntd_email disabledInput" placeholder="Hhp@gmail.com" disabled value="<?=$info_employer['ntd_email']?>">
                    <input type="text" class="id_employer" value="<?php echo $id ?>" hidden>
                    <p class="n_dky_ntd_eror n_eror_email"></p>
                </div>
            </div>

            <div class="col-sm-6 form_ttcb">
                <div class="sm-3 pt-2 thong_tin_info">
                    <label class="form-label">Số điện thoại (<span class="n_red_star">*</span>)</label>
                    <input type="text" class="form-control" id="ntd_tel" placeholder="0146893467" value='<?=$info_employer['ntd_phone']?>'>
                    <p class="n_dky_ntd_eror n_eror_tel"></p>
                </div>
            </div>

            <div class="col-sm-6 form_ttcb">
                <div class="sm-3 pt-2 thong_tin_info">
                    <label class="form-label">Tỉnh/Thành phố (<span class="n_red_star">*</span>)</label>
                    <div class="n_dky_ntd_input n_city" >
                        <select class="" id="n_city">
                            <option value="0">Chọn tỉnh /thành phố</option>
                            <?php
                                $cities = all_city();
                                foreach ($cities as $key=>$value):
                            ?>
                            <option value="<?=$key?>" <?php if ($info_employer['ntd_city']== $key) echo 'selected'; ?> ><?=$value?></option>
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
                    <div class="n_dky_ntd_input n_qh" >
                        <select class="" id="n_qh" qh_id=<?=$info_employer['ntd_quanhuyen']?>>
                            <option value="0">Chọn quận /huyện</option>
                            
                        </select>
                    </div>
                    <p class="n_dky_ntd_eror n_eror_qh"></p>
                </div>
            </div>
                            
            <div class="col-sm-6 form_ttcb">
                <div class="sm-3 pt-2 thong_tin_info">
                    <label class="form-label">Mã số thuế (<span class="note">Nếu có</span>)</label>
                    <input type="text" class="form-control" id="ntd_mst" placeholder="Nhập mã số thuế" >
                    <p class="n_dky_ntd_eror n_eror_mst"></p>
                </div> 
            </div>
            <div class="col-sm-6 form_ttcb">
                <div class="thong_tin_info dcct_form" >
                    <label class="form-label">Địa chỉ cụ thể (<span class="n_red_star">*</span>)</label>
                    <input type="text" class="form-control" id="ntd_dia_chi" placeholder="SN 16 Nguyên An Ninh"  value="<?=$info_employer['ntd_address']?>" >
                    <p class="n_dky_ntd_eror n_eror_address"></p>
                </div>
            </div>
            <div class="col-sm-6 status_acc form_ttcb">
                <label for="" class="form-label lbl_name_tag"><span>* </span>Status:</label><br>
                    <input type="radio" name="status" value="1"<?php if ($info_employer['ntd_authentic']==1) echo'checked' ?>>: Đã xác thực
                    <input type="radio" name="status" value="0"<?php if ($info_employer['ntd_authentic']==0) echo'checked' ?>>: Chưa xác thực
                <p class="n_dky_uv_eror n_status_error"></p>
            </div>
        </div>
        <div class="btn_update py-5 text-center">
                <button class="btn btn_update_thong_tin btn-warning">Cập nhật</button>
        </div>
            
</div>