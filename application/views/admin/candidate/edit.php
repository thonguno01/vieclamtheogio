<style>
    th,td {
        padding: 5px 10px;
        border: 1px solid #d2d6de;
        text-align: center;
    }

    table {
        width: 100%;
    }
    .right{
        padding: 15px;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quản lý tài khoản
            <small>Sửa</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="list_user_admin.php"><i class="fa fa-dashboard"></i>Quản lý tài khoản</a></li>
            <li><a href="">Sửa</a></li>
        </ol>
    </section>
    <div class="n_dky_uv_avatar">
            <div class="n_dky_uv_avatar_img">
                <img id="preview_logo" src="/upload/uv/<?=date('Y',$info_candidate['uv_createtime'])?>/<?=date('m',$info_candidate['uv_createtime'])?>/<?=date('d',$info_candidate['uv_createtime'])?>/<?=$info_candidate['uv_avatar']?>" onerror="this.src='/images/n_defaul_avatar.svg'">
            </div>
            <!-- <div class="n_dky_uv_avatar_up">
                <label for="up_photo"><img src="/images/n_icon_cam_plus.svg"></label>
            </div> -->
        </div>
        <div class="n_dky_uv_form"> 
            <div class="n_dky_uv_row">
                <div class="n_dky_uv_col">
                    <p class="n_text_label">Họ và tên (<span class="n_red_star">*</span>)</p>
                    <input class="n_dky_uv_input" id="n_dky_name" type="text" placeholder="Nhập họ và tên" value="<?=$info_candidate['uv_name'];?>">
                    <p class="n_dky_uv_eror n_eror_name"></p>
                </div>
                <div class="n_dky_uv_col">
                    <p class="n_text_force">(<span class="n_red_star">*</span>) Thông tin bắt buộc</p>
                    <p class="n_text_label">Email (<span class="n_red_star">*</span>)</p>
                    <input class="n_dky_uv_input" id="n_dky_email" type="text" placeholder="Nhập email" value="<?php echo $info_candidate['uv_email'] ?>" disabled id="email">
                    <input type="text" class="id_candidate" value="<?php echo $id ?>" hidden>
                    <p class="n_dky_uv_eror n_eror_email"></p>
                </div>
            </div>
            <div class="n_dky_uv_row">
                <div class="n_dky_uv_col">
                    <p class="n_text_label">Tỉnh / Thành phố (<span class="n_red_star">*</span>)</p>
                    <div class="n_dky_uv_input n_city">
                        <select class="" id="n_city">
                            <option value="0">Chọn tỉnh / thành phố</option>
                            <?php
                                $cities = all_city();
                                foreach ($cities as $key=>$value):
                            ?>
                            <option value="<?=$key?>" <?php if ($info_candidate['uv_city']== $key) echo 'selected'; ?>><?=$value?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                    <p class="n_dky_uv_eror n_eror_city"></p>
                </div>
                <div class="n_dky_uv_col">
                    <p class="n_text_label">Quận / Huyện (<span class="n_red_star">*</span>)</p>
                    <div class="n_dky_uv_input n_city">
                        <select class="" id="n_qh" qh_id=<?=$info_candidate['uv_qh']?>>
                            <option value="0">Chọn quận / huyện</option>
                        </select>
                    </div>
                    <p class="n_dky_uv_eror n_eror_qh"></p>
                </div>
            </div>
            <div class="n_dky_uv_row">
                <div class="n_dky_uv_col">
                    <p class="n_text_label">Địa chỉ cụ thể (<span class="n_red_star">*</span>)</p>
                    <input class="n_dky_uv_input_addr" id="n_addr" type="text" placeholder="Nhập địa chỉ cụ thể" value='<?=$info_candidate['uv_address']?>'>
                    <p class="n_dky_uv_eror n_eror_addr"></p>
                </div>
            </div>
            <div class="n_dky_uv_row">
                <div class="n_dky_uv_col">
                    <p class="n_text_label">Loại công việc (<span class="n_red_star">*</span>)</p>
                    <div class="n_dky_uv_input n_city">
                        <select class="" id="n_cate" multiple>
                        <option value="">Tất cả</option>
                            <?php 
                                $categoties = [
                                    ['cat_id'=>1,'cat_name'=>'Bán hàng'],
                                    ['cat_id'=>2,'cat_name'=>'Phục vụ/Tạp vụ'],
                                    ['cat_id'=>3,'cat_name'=>'Xây dựng công trình'],
                                    ['cat_id'=>4,'cat_name'=>'Bốc vác'],
                                    ['cat_id'=>5,'cat_name'=>'Hành chính'],
                                    ['cat_id'=>6,'cat_name'=>'Giao hàng'],
                                    ['cat_id'=>7,'cat_name'=>'Nhà hàng /Khách sạn'],
                                    ['cat_id'=>8,'cat_name'=>'Tổ chức sự kiện'],
                                    ['cat_id'=>9,'cat_name'=>'Kho bãi'],
                                    ['cat_id'=>10,'cat_name'=>'Nấu ăn'],
                                ];
                                $cat = explode(',',$info_candidate['uv_cat']);
                                foreach($categoties as $value):?>
                                
                                <option value="<?=$value['cat_id']?>" <?php if (in_array($value['cat_id'],$cat)) echo 'selected';?>><?=$value['cat_name'] ?></option> 

                            <?php endforeach; ?>
                        </select>
                    </div>
                    <p class="n_dky_uv_eror n_eror_cate"></p>
                </div>
                <div class="n_dky_uv_col">
                    <p class="n_text_label">Công việc cụ thể muốn ứng tuyển (<span class="n_red_star">*</span>)</p>
                    <input class="n_dky_uv_input" id="n_cv" type="text" placeholder="Nhập công việc muốn ứng tuyển" value='<?=$info_candidate['uv_vitri']?>'>
                    <p class="n_dky_uv_eror n_eror_cv"></p>
                </div>
            </div>
            <div class="n_dky_uv_row">
                <div class="n_dky_uv_col">
                    <p class="n_text_label">Nơi làm việc mong muốn (<span class="n_red_star">*</span>)</p>
                    <div class="n_dky_uv_input n_city">
                        <select class="" id="n_city_hope" multiple>
                            <option value="1">Tất cả</option>
                            <?php
                                $cities = all_city();
                                foreach ($cities as $key=>$value):
                            ?>
                            <option value="<?=$key?>" <?php if ($info_candidate['uv_city_hope']== $key) echo 'selected'; ?>><?=$value?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                    <p class="n_dky_uv_eror n_eror_city_hope"></p>
                </div>
                <div class="n_dky_uv_col">
                    <p class="n_text_label">Số điện thoại (<span class="n_red_star">*</span>)</p>
                    <input class="n_dky_uv_input" id="n_tel" type="text" placeholder="Nhập số điện thoại " value='<?=$info_candidate['uv_phone']?>'>
                    <p class="n_dky_uv_eror n_eror_tel"></p>
                </div>
            </div>
           
            <div class="n_dky_uv_row status_acc mb-3">
                <label for="" class="label_tit lbl_name_tag"><span>* </span>Status:</label><br>
                    <input type="radio" name="status" value="1"<?php if ($info_candidate['uv_authentic']==1) echo'checked' ?>>: Đã xác thực
                    <input type="radio" name="status" value="0"<?php if ($info_candidate['uv_authentic']==0) echo'checked' ?>>: Chưa xác thực
                <p class="n_dky_uv_eror n_status_error"></p>
            </div>
            <div class="n_dky_uv_row">
                <div class="n_dky_uv_col n_col_center">
                    <button class="update_user_admin btn btn-warning">Cập nhật</button>
                </div>
            </div>
        </div>
    </div>
</div>

