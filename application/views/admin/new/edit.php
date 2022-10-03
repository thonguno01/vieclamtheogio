<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quản lý tin tuyển dụng
            <small>Sửa tin</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Quản lý tin tuyển dụng</a></li>
            <li><a href="">Sửa tin</a></li>
        </ol>
    </section>


    <div class="info_work container">
        <div class="info_work_title py-4">
            <h1 class="info_work_title_text">Thông tin việc làm(<span class="n_red_star">*</span>)</h1>
        </div>

        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Tiêu đề tin tuyển dụng(<span class="n_red_star">*</span>)</label>
            <input type="text" class="form-control" id="ntd_tieude" placeholder="Tiêu đề tin tuyển dụng" value='<?=$new_tin['new_title']?>' >
            <input type="hidden" name="new_id" id="new_id" value="<?=$new_tin['new_id']?>">
            <p class="n_dtin_ntd_eror n_eror_tieude"></p>
        </div>

        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Công ty đăng(<span class="n_red_star">*</span>)</label>
            <div class="n_dtin_ntd_input">
                <select id="new_user">
                    <option value="0">Chọn công ty đăng </option>
                    <?php foreach($ntd as $list): ?>
                        <option class="id_user" value="<?=$list['ntd_id']?>" <?php if ($new_tin['new_user_id']==$list['ntd_id'] ) echo 'selected';?>><?=$list['ntd_company']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <p class="n_dtin_ntd_eror n_eror_user"></p> 
        </div>

        <div class="info_word_form row">
            <div class="col-sm-6">
                <div class="sm-3 pt-2 dtin_ntd_info">
                    <label class="form-label">Loại công việc (<span class="n_red_star">*</span>)</label>
                    <div class="n_dky_ntd_input n_type_congviec">
                        <select class="" id="n_type_congviec">
                            <option value="0">Chọn loại công việc </option>
                            <?php foreach ($cate as $value) :?>
                                <option value="<?=$value['cat_id']?>"<?php if ($new_tin['new_cat']==$value['cat_id'] ) echo 'selected';?> ><?=$value['cat_name'] ?></option> 
                            <?php endforeach ?>
                        </select>
                    </div>
                    <p class="n_dtin_ntd_eror n_eror_type_congviec"></p>
                </div>

                <div class="sm-3 pt-2 dtin_ntd_info">
                    <label class="form-label">Yêu cầu độ tuổi (<span class="n_red_star">*</span>)</label>
                    <input type="text" class="pwd form-control" id="ntd_age" placeholder="Nhập độ tuổi" value="<?=$new_tin['new_age']?>" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                    <p class="n_dtin_ntd_eror n_eror_age"></p>
                </div>
                <div class="sm-3 pt-2 dtin_ntd_info">
                    <label class="form-label">Cấp bậc (<span class="n_red_star">*</span>)</label>
                    <div class="n_dtin_ntd_input n_level">
                        <select class="" id="n_level">
                            <?php
                                $all_vi_tri = all_vi_tri();
                                foreach ($all_vi_tri as $key=>$value):
                            ?>
                            <option value="<?=$key?>" <?php if ($new_tin['new_cap_bac']== $key) echo 'selected';?>><?=$value?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                    <p class="n_dtin_ntd_eror n_eror_level"></p>
                </div>
                <div class="sm-3 pt-2 dtin_ntd_info">
                    <label class="form-label">Kinh nghiệm làm việc (<span class="n_red_star">*</span>)</label>
                    <div class="n_dtin_ntd_input n_exp_work">
                        <select class="" id="n_exp_work">
                            <option value="0">Chọn mức kinh nghiệm làm việc </option>
                            <?php
                                $all_exp = all_exp();
                                foreach ($all_exp as $key=>$value):
                            ?>
                            <option value="<?=$key?>" <?php if ($new_tin['new_knlv']== $key) echo 'selected';?>><?=$value?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                    <p class="n_dtin_ntd_eror n_eror_exp_work"></p>
                </div>
                <div class="sm-3 pt-2 dtin_ntd_info">
                    <label class="form-label">Loại hình làm việc (<span class="n_red_star">*</span>)</label>
                    <div class="n_dtin_ntd_input n_type_working">
                        <select class="" id="n_type_working">
                            <?php
                                $all_lhlv = all_lhlv();
                                foreach ($all_lhlv as $key=>$value):
                            ?>
                            <option value="<?=$key?>"  <?php if ($new_tin['new_loai_hinh']== $key) echo 'selected';?>><?=$value?></option>
                            <?php
                                endforeach;
                            ?> 
                        </select>
                    </div>
                    <p class="n_dtin_ntd_eror n_eror_type_working"></p>
                </div>

                <div class="sm-3 pt-2 dtin_ntd_info">
                    <label class="form-label">Hạn nộp hồ sơ</label>
                    <input type="date" class="form-control" id="ntd_date"  value='<?=date('Y-m-d',$new_tin['new_han_nop'])?>'>
                    <p class="n_dtin_ntd_eror n_eror_date"></p>
                </div>
            </div>


            <div class="col-sm-6">

                <div class="sm-3 pt-2 dtin_ntd_info">
                    <label class="form-label">Chi tiết công việc(<span class="n_red_star">*</span>)</label>
                    <div class="n_dky_ntd_input ntd_chi_tiet">
                        <select class="" id="ntd_chi_tiet"> 
                            <?php foreach ($ctcv as $key => $dis) {?>
                                <option value="<?=$dis['tag_id']?>" <? if($dis['tag_id'] == $new_tin['new_tag']) echo "selected" ; ?>>
                                <?=$dis['tag_name']?></option>
                            <?} ?>
                        </select>
                    </div>
                    <p class="n_dtin_ntd_eror n_eror_chi_tiet"></p>
                </div>

                <div class="sm-3 pt-2 dtin_ntd_info">
                    <label class="form-label">Giới tính (<span class="n_red_star">*</span>)</label>
                    <div class="n_dtin_ntd_input n_sex">
                        <select class="" id="n_sex">
                            <?php
                                $all_sex = all_sex();
                                foreach ($all_sex as $key=>$value):
                            ?>
                            <option value="<?=$key?>" <?php if ($new_tin['new_sex']== $key) echo 'selected';?> ><?=$value?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                    <p class="n_dtin_ntd_eror n_eror_sex"></p>
                </div>

                <div class="sm-3 pt-2 dtin_ntd_info">
                    <label class="form-label">Học vấn tối thiểu (<span class="n_red_star">*</span>)</label>
                    <div class="n_dtin_ntd_input n_hoc_van">
                        <select class="" id="n_hoc_van">
                            <?php
                                $all_hv = all_hv();
                                foreach ($all_hv as $key=>$value):
                            ?>
                            <option value="<?=$key?>"  <?php if ($new_tin['new_hoc_van']== $key) echo 'selected';?>><?=$value?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                    <p class="n_dtin_ntd_eror n_eror_hoc_van"></p>
                </div>


                <div class="sm-3 pt-2 dtin_ntd_info">
                    <label class="form-label">Hình thức trả lương (<span class="n_red_star">*</span>)</label>
                    <div class="n_dtin_ntd_input n_way_pay">
                        <select class="" id="n_way_pay">
                                <?php
                                $all_httl = all_httl();
                                foreach ($all_httl as $key=>$value):
                            ?>
                                <option value="<?=$key?>"<?php if ($new_tin['new_httl']== $key) echo 'selected';?> ><?=$value?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <p class="n_dtin_ntd_eror n_eror_way_pay"></p>
                </div>

                <div class="sm-3 pt-2 dtin_ntd_info">
                    <label class="form-label">Hình thức làm việc (<span class="n_red_star">*</span>)</label>
                    <div class="n_dtin_ntd_input n_way_working">
                        <select class="" id="n_way_working">
                            <?php
                                $all_htlv = all_htlv();
                                foreach ($all_htlv as $key=>$value):
                            ?>
                            <option value="<?=$key?>"<?php if ($new_tin['new_hinh_thuc']== $key) echo 'selected';?> ><?=$value?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                    <p class="n_dtin_ntd_eror n_eror_way_working"></p>
                </div>

                <div class="sm-3 pt-2 dtin_ntd_info">
                    <label class="form-label">Mức lương(<span class="n_red_star">*</span>)</label>
                    <div class="n_dtin_ntd_input n_salary_level">
                        <select class="" id="n_salary_level" onchange="showDiv(this)" >
                            <?php
                                $luong1= all_htl();
                                foreach ($luong1 as $key=>$value):
                            ?>
                            <option value="<?=$key?>" <?=($new_tin['new_luong_1']==$key?'selected':'')?>><?=$value?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                        <?php
                        if($new_tin['new_luong_1'] == 1){
                            $class_codinh = 'price_show';
                            $class_uocluong = 'price_hide';
                            $price_codinh = $new_tin['new_luong_2'];
                            $price_start = $price_end = '';
                            $disabled = '';
                        }else if($new_tin['new_luong_1'] == 2){
                            $class_codinh = 'price_hide';
                            $class_uocluong = 'price_show';
                            $price_codinh = '';
                            $arr_price = explode('-', $new_tin['new_luong_2']);
                            $price_start = $arr_price[0];
                            $price_end = $arr_price[1];
                            $disabled = '';
                        }else{
                            $class_codinh = 'price_show';
                            $class_uocluong = 'price_hide';
                            $price_codinh = '';
                            $price_start = '';
                            $price_end = '';
                            $disabled = 'disabled';
                        }
                        ?>
                        <div id="input_salary" class="<?=$class_codinh?>">
                            <input type="text" class="form-control" id="ntd_salary_money" placeholder="Nhập số tiền" value="<?=$price_codinh?>" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" <?=$disabled?>> 
                        </div>
                        <div id="salary_hidden" class="<?=$class_uocluong?>">
                            <input type="text" class="form-control" id="ntd_salary_money_uocluong" placeholder="100000" value="<?=$price_start?>" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">/
                            <input type="text" class="form-control" id="ntd_salary_money_uocluong2" placeholder="100000" value="<?=$price_end?>" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                        </div>
                        
                        <select class="" id="n_salary_time">
                            <?php
                                $luong_3 = all_httl();
                                foreach ($luong_3 as $key => $value) :?>
                                    <option value="<?=$key?>" <?=($new_tin['new_luong_3']==$key?'selected':'')?>><?=$value?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                    <p class="n_dtin_ntd_eror n_eror_salary_level"></p>
                </div>
            </div>
        </div>

        <div class="pt-2 dtin_ntd_info info_detail ">
            <label class="form-label">Nơi làm việc(<span class="n_red_star">*</span>)</label>
            <p class="n_dtin_ntd_eror n_eror_dcct"></p>
            <div class="n_dtin_ntd_input n_noi_lam_viec">
                <input type="checkbox" id="n_noi_lam_viec" class="form-check-input">
                <label class="form-label" for="flexRadioDefault1">
                    Làm việc tại địa chỉ công ty :<span id="location_permanent"><?=get_city_where($new_tin['new_city'])?>, <?=get_city_where($new_tin['new_qh'])?></span>
                </label>
            </div>
            <div class="n_dtin_ntd_input n_location_choose">
                <div class="sm-3 pt-2 dtin_ntd_info city_box">
                    <label class="form-label">Tỉnh/Thành phố(<span class="n_red_star">*</span>)</label>
                    <div class="n_dtin_ntd_input n_city">
                        <select class="" id="n_city">
                            <option value="0">Tất cả</option>
                            <?php
                                $cities = list_city();
                                foreach ($cities as $key=>$value):
                            ?>
                            <option value="<?=$key?>"<?php if ($new_tin['new_city']== $key) echo 'selected'; ?> ><?=$value['cit_name']?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="sm-3 pt-2 dtin_ntd_info qh_box">
                    <label class="form-label">Quận/Huyện(<span class="n_red_star">*</span>)</label>
                    <div class="n_dtin_ntd_input n_qh"  >
                        <select class="" id="n_qh" qh_id=<?=$ntd_infor['ntd_quanhuyen']?>>
                            <?php $list_district = list_district($new_tin['new_city']);
                            foreach ($list_district as $key=>$value) :?>
                                <option value="<?=$key?>"<?php if ($new_tin['new_qh'] == $key ) echo 'selected';?> ><?=$value['cit_name'] ?></option> 
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="sm-3 pt-2 dtin_ntd_info dcct_box">
                    <label class="form-label">Địa chỉ cụ thể(<span class="n_red_star">*</span>)</label>
                    <div class="n_dtin_ntd_input n_dcct">
                        <input type="text" class="form-control" id="n_dcct" placeholder="61 Trần Điền" value="<?=$new_tin['new_address']?>">
                    </div>
                </div>

                </div>
            </div>

            <div class="py-5 dtin_ntd_info calendar_work "> 
                <div class="calendar_work_title py-5">
                    <h1 class="calendar_work_title_text">Lịch làm việc (<span class="n_red_star">*</span>)</h1>
                </div>
                <div class="n_ca_lam">
                    <input type="checkbox" class="myCheckbox" data-target="n_detail_ca_lam" id="n_time_lam_viec" class="form-check-input" <?php if($new_tin['new_no_calam'] == 0){echo "checked";} ?>>
                    <label class="form-label" for="flexRadioDefault1">
                        Có thể linh động thời gian, thỏa thuận chi tiết sau
                    </label>
                </div>

                <p class="n_dtin_ntd_eror n_eror_lichLV"></p>
                    <?php 
                        $new_ca_start =  explode(",",$new_tin['new_ca_start']);
                        $new_ca_end =  explode(",",$new_tin['new_ca_end']);
                        $new_t2 =  explode(",",$new_tin['new_t2']);
                        $new_t3 =  explode(",",$new_tin['new_t3']);
                        $new_t4 =  explode(",",$new_tin['new_t4']);
                        $new_t5 =  explode(",",$new_tin['new_t5']);
                        $new_t6 =  explode(",",$new_tin['new_t6']);
                        $new_t7 =  explode(",",$new_tin['new_t7']);
                        $new_cn =  explode(",",$new_tin['new_cn']);
                    ?>
                <div class="n_detail_ca_lam_total" data-value="">
                    <?php for ($i=0; $i < count($new_ca_start); $i++) {?>
                        <div class="n_gio_lam1 pt-3 pb-4 default_ca_lam">
                            <p class="n_text_label">Ca <?=$i+1?></p>
                            <div class="n_dtin_ntd_input n_gio_lam">
                                <label class="form-label label_gio_lam">Từ</label>  
                                <input type="time" class="form-control n_gio_lam_from" value="<?=$new_ca_start[$i]?>"<?php if($new_tin['new_no_calam'] == 0){echo "disabled";} ?>>
                            </div>
                            <div class="n_dtin_ntd_input n_gio_lam">
                                <label class="form-label label_gio_lam">Đến</label>
                                <input type="time" class="form-control n_gio_lam_to"  value="<?=$new_ca_end[$i]?>" <?php if($new_tin['new_no_calam'] == 0){echo "disabled";} ?>>
                            </div>
                            <?php if($i != 0){?>
                                <div class="xoa_ca_lam" onclick="xoa_ca_lam(this)">
                                    <h2 id="xoa_ca_lam"><img src="/images/carbon_delete.png" alt=""></h2>
                                </div>
                            <?} ?>
                            
                        </div>
                        <div class="n_detail_ca_lam">
                            <div class="n_dow n_mon">
                                <p class="n_tdow n_mo new_t2 <?php if($new_t2[$i] == 1) echo 'n_tdow_pick' ?>" id="new_t2" value="<?=$new_t2[$i]?>">Thứ 2</p>
                            </div>
                            <div class="n_dow n_tue">
                                <p class="n_tdow n_mo new_t3 <?php if($new_t3[$i] == 1) echo 'n_tdow_pick' ?>" id="new_t3" value="<?=$new_t3[$i]?>">Thứ 3</p>
                            </div>
                            <div class="n_dow n_wen">
                                <p class="n_tdow n_mo new_t4 <?php if($new_t4[$i] == 1) echo 'n_tdow_pick' ?>" id="new_t4" value="<?=$new_t4[$i]?>">Thứ 4</p>
                            </div>
                            <div class="n_dow n_thu">
                                <p class="n_tdow n_mo new_t5 <?php if($new_t5[$i] == 1) echo 'n_tdow_pick' ?>" id="new_t5" value="<?=$new_t5[$i]?>">Thứ 5</p>
                            </div>
                            <div class="n_dow n_fri">
                                <p class="n_tdow n_mo new_t6 <?php if($new_t6[$i] == 1) echo 'n_tdow_pick' ?>" id="new_t6" value="<?=$new_t6[$i]?>">Thứ 6</p>
                            </div>
                            <div class="n_dow n_sat">
                                <p class="n_tdow n_mo new_t7 <?php if($new_t7[$i] == 1) echo 'n_tdow_pick' ?>" id="new_t7" value="<?=$new_t7[$i]?>">Thứ 7</p>
                            </div>
                            <div class="n_dow n_sun">
                                <p class="n_tdow n_mo new_cn <?php if($new_cn[$i] == 1) echo 'n_tdow_pick' ?>" id="new_cn" value="<?=$new_cn[$i]?>">Chủ nhật</p>
                            </div>
                        </div>
                    <?} ?>
                </div> 
                
                    
                <!-- <div class="n_detail_ca_lam_total" data-value="">
                    <div class="n_gio_lam1 pt-3 pb-4 default_ca_lam">
                        <p class="n_text_label">Ca 1</p>
                        <div class="n_dtin_ntd_input n_gio_lam">
                            <label class="form-label label_gio_lam">Từ</label>
                            <input type="time" class="form-control n_gio_lam_from" value="<?=$new_tin['new_ca_start']?>">
                        </div>
                        <div class="n_dtin_ntd_input n_gio_lam">
                            <label class="form-label label_gio_lam">Đến</label>
                            <input type="time" class="form-control n_gio_lam_to"  value="<?=$new_tin['new_ca_end']?>">
                        </div>
                    </div>
                    <div class="n_detail_ca_lam">
                        <div class="n_dow n_mon">
                            <p class="n_tdow n_mo" value="2">Thứ 2</p>
                        </div>
                        <div class="n_dow n_tue">
                            <p class="n_tdow n_mo" value="3">Thứ 3</p>
                        </div>
                        <div class="n_dow n_wen">
                            <p class="n_tdow n_mo" value="4">Thứ 4</p>
                        </div>
                        <div class="n_dow n_thu">
                            <p class="n_tdow n_mo" value="5">Thứ 5</p>
                        </div>
                        <div class="n_dow n_fri">
                            <p class="n_tdow n_mo" value="6">Thứ 6</p>
                        </div>
                        <div class="n_dow n_sat">
                            <p class="n_tdow n_mo" value="7">Thứ 7</p>
                        </div>
                        <div class="n_dow n_sun">
                            <p class="n_tdow n_mo" value="8">Chủ Nhật</p>
                        </div>
                    </div>
                </div>   -->
                <div class="n_add_calam p-4">
                        <h2 id="them_ca_lam"><img src="/images/add_staff.png" alt="">Thêm ca làm</h2>
                    </div>  
            </div>

            <div class="py-5 dtin_ntd_info detail_congviec ">
                <div class="calendar_work_title py-5">
                    <h1 class="calendar_work_title_text">Mô tả công việc(<span class="n_red_star">*</span>)</h1>
                </div>
                <div class="n_jd">
                    <textarea class="editor" id="ntd_mtcv" name="editor" rows="10"  placeholder="Bạn cần nhập tối thiểu 50 từ
                    - Tiêu đề cho vị trí công việc cần tuyển dụng là gì?
                    ( Phần này nêu tên chính xác của vị trí công việc cần tuyển dụng)
                    - Mục tiêu của vị trí công việc: “vị trí này tồn tại để làm gì cho công ty?”
                    - Các nhiệm vụ chính của vị trí công việc là gì?
                    - Địa chỉ nơi làm việc
                    - Nội dung công việc cần thực hiện: ... "><?=$new_tin['new_mota']?></textarea>
                    
                </div>
                <p class="n_dtin_ntd_eror n_eror_mtcv"></p>

                <div class="calendar_work_title py-5">
                    <h1 class="calendar_work_title_text">Yêu cầu công việc(<span class="n_red_star">*</span>)</h1>
                </div>
                <div class="n_jd">
                    <textarea class="editor" id="ntd_yccv" name="editor" rows="10"  placeholder="Bạn cần nhập tối thiểu 50 từ
        - Trách nhiệm của nhân viên cần làm là gì?
        - Nhiệm vụ công việc cần thực hiện hàng ngày là gì?
        - Những kỹ năng nào cần có để thực hiện công việc tốt nhất?
        Những kỹ năng bắt buộc (Những kỹ năng cần có là gì?)
        Những kỹ năng mang tính khuyến khích (Ngoài ra ứng viên có thể đáp ứng những kỹ năng nào để phát triển công việc tốt nhất?)
        - Bằng cấp, chứng chỉ phù hợp với công việc
        - Yêu cầu về kinh nghiệm, thái độ, phẩm chất/thái
        - Ngoài ra tùy vào đặc thù công việc tuyển dụng để nêu ra các yêu cầu khác như giới tính, ngoại hình,..."><?=$new_tin['new_yeu_cau']?></textarea>
                </div>
                <p class="n_dtin_ntd_eror n_eror_yccv"></p>

                <div class="calendar_work_title py-5">
                    <h1 class="calendar_work_title_text">Quyền lợi được hưởng(<span class="n_red_star">*</span>)</h1>
                </div>
                <div class="n_jd">
                    <textarea class="editor"  id="ntd_qldh" name="editor" rows="10"  placeholder="Bạn cần nhập tối thiểu 50 từ
        - Chế độ về mức lương, thưởng, chế độ đãi ngộ.
        - Các chế độ đóng bảo hiểm xã hội và phúc lợi khác của nhân viên cụ thể là gì?
        - Môi trường làm việc của công ty hấp dẫn như thế nào? Có thể mang đến những cơ hội học tập, huấn luyện cho ứng viên ra sao?
        - Cơ hội thăng tiến của nhân viên là như thế nào? "><?=$new_tin['new_quyen']?></textarea>
                </div>
                <p class="n_dtin_ntd_eror n_eror_qldh"></p>
            </div>
            <div class="text-center">
                <button class="btn_up_post btn-warning"><img src="/images/btn_up_post.png" alt="">Lưu</button>
            </div>
    </div>
</div>