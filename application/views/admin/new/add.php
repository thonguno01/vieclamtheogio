<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quản lý tin tuyển dụng
            <small>Danh sách</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Quản lý tin tuyển dụng</a></li>
            <li><a href="">Danh sách</a></li>
        </ol>
    </section>

    <div class="info_work container">
            <div class="info_work_title py-4">
                <h1 class="info_work_title_text">Thông tin việc làm(<span class="n_red_star">*</span>)</h1>
            </div>

            <div class="sm-3 pt-2 dtin_ntd_info">
                <label class="form-label">Tiêu đề tin tuyển dụng(<span class="n_red_star">*</span>)</label>
                <input type="text" class="form-control" id="ntd_tieude" placeholder="Tiêu đề tin tuyển dụng">
                <p class="n_dtin_ntd_eror n_eror_tieude"></p>
            </div>

            <div class="sm-3 pt-2 dtin_ntd_info">
                <label class="form-label">Công ty đăng(<span class="n_red_star">*</span>)</label>
                <div class="n_dtin_ntd_input">
                    <select id="new_user">
                        <option value="0">Chọn công ty đăng </option>
                        <?php foreach($ntd as $list): ?>
                            <option class="id_user" value="<?=$list['ntd_id']?>"><?=$list['ntd_company']?></option>
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
                                    <option value="<?=$value['cat_id']?>"><?=$value['cat_name'] ?></option> 
                                <?php endforeach ?>
                            </select>
                        </div>
                        <p class="n_dtin_ntd_eror n_eror_type_congviec"></p>
                    </div>

                    <div class="sm-3 pt-2 dtin_ntd_info">
                        <label class="form-label">Yêu cầu độ tuổi (<span class="n_red_star">*</span>)</label>
                        <input type="text" class="pwd form-control" id="ntd_age" placeholder="Nhập độ tuổi" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                        <p class="n_dtin_ntd_eror n_eror_age"></p>
                    </div>
                    <div class="sm-3 pt-2 dtin_ntd_info">
                        <label class="form-label">Cấp bậc (<span class="n_red_star">*</span>)</label>
                        <div class="n_dtin_ntd_input n_level">
                            <select class="" id="n_level">
                                <option value="0">Chọn cấp bậc</option>
                                <?php
                                    $all_vi_tri = all_vi_tri();
                                    foreach ($all_vi_tri as $key=>$value):
                                ?>
                                <option value="<?=$key?>" ><?=$value?></option>
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
                                    foreach ($all_exp    as $key=>$value):
                                ?>
                                <option value="<?=$key?>" ><?=$value?></option>
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
                                <option value="0">Chọn loại hình làm việc </option>
                                <?php
                                    $all_lhlv = all_lhlv();
                                    foreach ($all_lhlv as $key=>$value):
                                ?>
                                <option value="<?=$key?>"><?=$value?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                        </div>
                        <p class="n_dtin_ntd_eror n_eror_type_working"></p>
                    </div>

                    <div class="sm-3 pt-2 dtin_ntd_info">
                        <label class="form-label">Hạn nộp hồ sơ</label>
                        <input type="date" class="form-control" id="ntd_date" >
                        <p class="n_dtin_ntd_eror n_eror_date"></p>
                    </div>
                </div>


                <div class="col-sm-6">

                    <div class="sm-3 pt-2 dtin_ntd_info">
                        <label class="form-label">Chi tiết công việc(<span class="n_red_star">*</span>)</label>
                        <div class="n_dky_ntd_input ntd_chi_tiet">
                            <select class="" id="ntd_chi_tiet">
                                
                            </select>
                        </div>
                        <p class="n_dtin_ntd_eror n_eror_chi_tiet"></p>
                    </div>

                    <div class="sm-3 pt-2 dtin_ntd_info">
                        <label class="form-label">Giới tính (<span class="n_red_star">*</span>)</label>
                        <div class="n_dtin_ntd_input n_sex">
                            <select class="" id="n_sex">
                                <option value="0">Chọn giới tính</option>
                                <?php
                                    $all_sex = all_sex();
                                    foreach ($all_sex as $key=>$value):
                                ?>
                                <option value="<?=$key?>"><?=$value?></option>
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
                                <option value="0">Chọn học vấn </option>
                                <?php
                                    $all_hv = all_hv();
                                    foreach ($all_hv as $key=>$value):
                                ?>
                                <option value="<?=$key?>"> <?=$value?></option>
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
                            <option value="0">Chọn học hình thức trả lương </option>
                            <?php
                                    $all_httl = all_httl();
                                    foreach ($all_httl as $key=>$value):
                                ?>
                                <option value="<?=$key?>"><?=$value?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                        </div>
                        <p class="n_dtin_ntd_eror n_eror_way_pay"></p>
                    </div>

                    <div class="sm-3 pt-2 dtin_ntd_info">
                        <label class="form-label">Hình thức làm việc (<span class="n_red_star">*</span>)</label>
                        <div class="n_dtin_ntd_input n_way_working">
                            <select class="" id="n_way_working">
                                <option value="0">Chọn học hình thức làm việc </option>
                                <?php
                                    $all_htlv = all_htlv();
                                    foreach ($all_htlv as $key=>$value):
                                ?>
                                <option value="<?=$key?>"><?=$value?></option>
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
                                    <option value="<?=$key?>"><?=$value?></option>
                                    <?php
                                        endforeach;
                                    ?>
                                </select>
                                
                                <div id="input_salary">
                                     <input type="text" class="form-control" id="ntd_salary_money" placeholder="Nhập số tiền" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                </div>
                                <div id="salary_hidden">
                                    <input type="text" class="form-control" id="ntd_salary_money_uocluong" placeholder="100000" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">/
                                    <input type="text" class="form-control" id="ntd_salary_money_uocluong2" placeholder="100000" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                </div>
                            
                            <select class="" id="n_salary_time">
                                <?php
                                    $luong_3 = all_ml();
                                    foreach ($luong_3 as $key => $value) :?>
                                        <option value="<?=$key?>"><?=$value?></option>
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
                <!-- <div class="n_dtin_ntd_input n_noi_lam_viec">
                    <input type="checkbox" id="n_noi_lam_viec" class="form-check-input" hidden>
                    <label class="form-label" for="flexRadioDefault1" hidden>
                        Làm việc tại địa chỉ công ty: <span id="location_permanent"><?=$ntd_infor['cit_name']?>, <?=get_city($ntd_infor['ntd_city'])?></span>
                    </label>
                </div> -->
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
                                <option value="<?=$key?>" ><?=$value['cit_name']?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="sm-3 pt-2 dtin_ntd_info qh_box">
                        <label class="form-label">Quận/Huyện(<span class="n_red_star">*</span>)</label>
                        <div class="n_dtin_ntd_input n_qh">
                            <select class="" id="n_qh" qh_id=<?=$ntd_infor['ntd_quanhuyen']?>>
                                
                            </select>
                        </div>
                    </div>
                    <div class="sm-3 pt-2 dtin_ntd_info dcct_box">
                        <label class="form-label">Địa chỉ cụ thể(<span class="n_red_star">*</span>)</label>
                        <div class="n_dtin_ntd_input n_dcct">
                            <input type="text" class="form-control" id="n_dcct" placeholder="61 Trần Điền" >
                        </div>
                    </div>
                        
                    </div>
                    <p class="n_dtin_ntd_eror n_eror_dcct"></p>
                </div>

                <div class="py-5 dtin_ntd_info calendar_work "> 
                    <div class="calendar_work_title py-5">
                        <h1 class="calendar_work_title_text">Lịch làm việc (<span class="n_red_star">*</span>)</h1>
                    </div>
                    <div class="n_ca_lam">
                        <label class="form-label" for="flexRadioDefault1">
                            <input type="checkbox" class="myCheckbox" data-target="n_detail_ca_lam" id="n_time_lam_viec" class="form-check-input">
                            Có thể linh động thời gian, thỏa thuận chi tiết sau
                        </label>
                    </div>

                    <div class="n_detail_ca_lam_total">
                        <div class="n_gio_lam1 pt-3 pb-4 default_ca_lam">
                            <p class="n_text_label">Ca 1</p>
                            <div class="n_dtin_ntd_input n_gio_lam">
                                <label class="form-label label_gio_lam">Từ</label>
                                <input type="time" class="form-control n_gio_lam_from">
                            </div>
                            <div class="n_dtin_ntd_input n_gio_lam">
                                <label class="form-label label_gio_lam">Đến</label>
                                <input type="time" class="form-control n_gio_lam_to" >
                            </div>
                            <div class="xoa_ca_lam">
                            </div>
                        </div>
                        
                        <div class="n_detail_ca_lam">
                            <p class="n_tdow n_mo new_t2" id="new_t2" value="0">Thứ 2</p>
                            <p class="n_tdow n_mo new_t3" id="new_t3" value="0">Thứ 3</p>
                            <p class="n_tdow n_mo new_t4" id="new_t4" value="0">Thứ 4</p>
                            <p class="n_tdow n_mo new_t5" id="new_t5" value="0">Thứ 5</p>
                            <p class="n_tdow n_mo new_t6" id="new_t6" value="0">Thứ 6</p>
                            <p class="n_tdow n_mo new_t7" id="new_t7" value="0">Thứ 7</p>
                            <p class="n_tdow n_mo new_cn" id="new_cn" value="0">Chủ Nhật</p>
                        </div>
                        
                    </div>  
                    <div class="n_add_calam p-4">
                        <h2 id="them_ca_lam"><img src="/images/add_staff.png" alt="">Thêm ca làm</h2>
                    </div>  
                    <p class="n_dtin_ntd_eror n_eror_calam"></p>

                </div>

                <div class="py-5 dtin_ntd_info detail_congviec ">
                    <div class="calendar_work_title py-5">
                        <h1 class="calendar_work_title_text">Mô tả công việc(<span class="n_red_star">*</span>)</h1>
                    </div>
                    <div class="n_jd">
                        <textarea class="editor" name="editor"  id="ntd_mtcv" rows="10"  placeholder="Bạn cần nhập tối thiểu 50 từ
    - Tiêu đề cho vị trí công việc cần tuyển dụng là gì? 
    ( Phần này nêu tên chính xác của vị trí công việc cần tuyển dụng)
    - Mục tiêu của vị trí công việc: “vị trí này tồn tại để làm gì cho công ty?”
    - Các nhiệm vụ chính của vị trí công việc là gì?
    - Địa chỉ nơi làm việc
    - Nội dung công việc cần thực hiện: ... "></textarea> 
                    <p class="n_dtin_ntd_eror n_eror_mtcv"></p>             
                        
                    </div>

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
    - Ngoài ra tùy vào đặc thù công việc tuyển dụng để nêu ra các yêu cầu khác như giới tính, ngoại hình,..."></textarea>
                    <p class="n_dtin_ntd_eror n_eror_yccv"></p>
                    </div>

                    <div class="calendar_work_title py-5">
                        <h1 class="calendar_work_title_text">Quyền lợi được hưởng(<span class="n_red_star">*</span>)</h1>
                    </div>
                    <div class="n_jd">
                        <textarea class="editor" id="ntd_qldh" name="editor" rows="10"  placeholder="Bạn cần nhập tối thiểu 50 từ
    - Chế độ về mức lương, thưởng, chế độ đãi ngộ.
    - Các chế độ đóng bảo hiểm xã hội và phúc lợi khác của nhân viên cụ thể là gì?
    - Môi trường làm việc của công ty hấp dẫn như thế nào? Có thể mang đến những cơ hội học tập, huấn luyện cho ứng viên ra sao?
    - Cơ hội thăng tiến của nhân viên là như thế nào? "></textarea>
                     <p class="n_dtin_ntd_eror n_eror_qldh"></p>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn_up_post"><img src="/images/btn_up_post.png" alt="">Đăng tin</button>
                </div>
                
        </div>
</div>
