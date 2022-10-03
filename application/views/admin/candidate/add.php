<div class="content-wrapper">
    <div class="n_dky_uv_left">
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

        <div class="n_dky_uv_avatar">
            <div class="n_dky_uv_avatar_img">
                <img id="preview_logo" src="/images/n_defaul_avatar.svg">
            </div>
            <div class="n_dky_uv_avatar_up">
                <label for="up_photo"><img src="/images/n_icon_cam_plus.svg"></label>
            </div>
            <input hidden id="up_photo" type="file" onchange="loadFile(event)" >
        </div>
        <div class="n_dky_uv_form"> 
            <div class="n_dky_uv_row">
                <div class="n_dky_uv_col">
                    <p class="n_text_label">Họ và tên (<span class="n_red_star">*</span>)</p>
                    <input class="n_dky_uv_input" id="n_dky_name" type="text" placeholder="Nhập họ và tên">
                    <p class="n_dky_uv_eror n_eror_name"></p>
                </div>
                <div class="n_dky_uv_col">
                    <p class="n_text_force">(<span class="n_red_star">*</span>) Thông tin bắt buộc</p>
                    <p class="n_text_label">Email (<span class="n_red_star">*</span>)</p>
                    <input class="n_dky_uv_input" id="n_dky_email" type="text" placeholder="Nhập email">
                    <p class="n_dky_uv_eror n_eror_email"></p>
                </div>
            </div>
            <div class="n_dky_uv_row">
                <div class="n_dky_uv_col">
                    <p class="n_text_label">Mật khẩu (<span class="n_red_star">*</span>)</p>
                    <input class="n_dky_uv_input n_pwd" id="n_dky_pwd" type="password" placeholder="Nhập mật khẩu">
                    <button class="n_show_pwd"><img class="n_pwd_eye" src="/images/n_icon_open_eye.svg"></button>
                    <p class="n_dky_uv_eror n_eror_pwd"></p>
                </div>
                <div class="n_dky_uv_col">
                    <p class="n_text_label">Nhập lại mật khẩu (<span class="n_red_star">*</span>)</p>
                    <input class="n_dky_uv_input n_re_pwd" id="n_dky_re_pwd" type="password" placeholder="Nhập lại mật khẩu">
                    <button class="n_show_pwd"><img class="n_pwd_eye" src="/images/n_icon_open_eye.svg"></button>
                    <p class="n_dky_uv_eror n_eror_re_pwd"></p>
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
                            <option value="<?=$key?>"><?=$value?></option>
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
                        <select class="" id="n_qh">
                            <option value="0">Chọn quận / huyện</option>
                        </select>
                    </div>
                    <p class="n_dky_uv_eror n_eror_qh"></p>
                </div>
            </div>
            <div class="n_dky_uv_row">
                <div class="n_dky_uv_col">
                    <p class="n_text_label">Địa chỉ cụ thể (<span class="n_red_star">*</span>)</p>
                    <input class="n_dky_uv_input_addr" id="n_addr" type="text" placeholder="Nhập địa chỉ cụ thể">
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
                    <input class="n_dky_uv_input" id="n_cv" type="text" placeholder="Nhập công việc muốn ứng tuyển">
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
                            <option value="<?=$key?>"><?=$value?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                    <p class="n_dky_uv_eror n_eror_city_hope"></p>
                </div>
                <div class="n_dky_uv_col">
                    <p class="n_text_label">Số điện thoại (<span class="n_red_star">*</span>)</p>
                    <input class="n_dky_uv_input" id="n_tel" type="text" placeholder="Nhập số điện thoại ">
                    <p class="n_dky_uv_eror n_eror_tel"></p>
                </div>
            </div>
            <div class="n_dky_uv_row">
                <div class="n_dky_uv_col">
                    <p class="n_text_label">Buổi có thể đi làm (<span class="n_red_star">*</span>)</p>
                    <div class="n_ca_lam_radio">
                        <div class="n_ca_lam"><div class="checkbox_boder" time="mo"><div class="checkbox_checked"></div></div><p class="n_ca_lam_text">Đi làm full sáng</p></div>
                        <div class="n_ca_lam"><div class="checkbox_boder" time="no"><div class="checkbox_checked"></div></div><p class="n_ca_lam_text">Đi làm full chiều</p></div>
                        <div class="n_ca_lam"><div class="checkbox_boder" time="ni"><div class="checkbox_checked"></div></div><p class="n_ca_lam_text">Đi làm full tối</p></div>
                        <div class="n_ca_lam_4"><div class="checkbox_boder" time="none"><div class="checkbox_checked"></div></div><p class="n_ca_lam_text">Có thể đi làm linh động theo sắp xếp của NTD</p></div>
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
                    <p class="n_dky_uv_eror n_eror_ca_lam"></p>
                </div>
            </div>
            <div class="n_dky_uv_row status_acc mb-3">
                <label for="" class="label_tit lbl_name_tag"><span>* </span>Status:</label><br>
                    <input type="radio" name="status" value="1">: Đã xác thực
                    <input type="radio" name="status" value="0">: Chưa xác thực
                <p class="n_dky_uv_eror n_status_error"></p>
            </div>
            <div class="n_dky_uv_row">
                <div class="n_dky_uv_col n_col_center">
                    <button class="n_dky_uv_btn">Đăng ký</button>
                </div>
            </div>
        </div>
    </div>
</div> 