<div class="total_qlc">
    <div class=" menu_qlc_ntd">
        <?php include "side_bar_ql_ntd.php"; ?>
    </div>

    <div class="content_introduce_work">
        <div class="intro_work container">
            <div class="intro_work_title py-4">
                <h1 class="intro_work_title_text">Giới thiệu chung(<span class="n_red_star">*</span>)</h1>
            </div>

            <div class="head_intro_work">
            <textarea class="editor" name="editor" id="mtdn" rows="10"  placeholder="Mô tả về doanh nghiệp / nhà tuyển dụng:
*Tên doanh nghiệp / nhà tuyển dụng
*Doanh nghiệp được thành lập khi nào?
*Lĩnh vực kinh doanh, làm việc của doanh nghiệp / nhà tuyển dụng là gì?"><?=$infor['ntd_gioi_thieu']?></textarea>
            <p class="n_dtin_ntd_eror n_eror_mtdn"></p>
            </div> 

            <div class="intro_work_title py-4">
                <h1 class="intro_work_title_text">Hình ảnh</h1>
            </div>
            <div class="intro_work_img"> 
                <div class="row no-gutters">
                 <?php $cre_time = explode('/',$_COOKIE['avatar']); ?>
                    <div class="col-sm-4 img_intro">
                        <div class="preview_up1">
                                <img id="preview_logo1" src="<?=url_avt_ntd($infor['ntd_create_time'],$infor['ntd_img_1'])?>" >
                            </div>
                        <div class="upload_photo">
                            <label for="up_photo1"><img src='/images/camera_add.png'></label>
                        </div>
                        <input hidden id="up_photo1" type="file" onchange="upFile(event)">
                    </div>
                    <div class="col-sm-4 img_intro">
                        <div class="preview_up2">
                            <img id="preview_logo2" src="<?=url_avt_ntd($infor['ntd_create_time'],$infor['ntd_img_2'])?>">
                        </div>
                        <div class="upload_photo">
                            <label for="up_photo2"><img src='/images/camera_add.png'></label>
                        </div>
                        <input hidden id="up_photo2" type="file" onchange="loadFile(event)">
                    </div>
                    <div class="col-sm-4 img_intro">
                        <div class="preview_up3">
                            <img id="preview_logo3" src="<?=url_avt_ntd($infor['ntd_create_time'],$infor['ntd_img_3'])?>" >
                        </div>
                        <div class="upload_photo">
                            <label for="up_photo3"><img src='/images/camera_add.png'></label>
                        </div>
                        <input hidden id="up_photo3" type="file" onchange="postFile(event)">
                    </div>
                </div>
            </div>
 
            <div class="intro_work_title py-4">
                <h1 class="intro_work_title_text">Chính sách và phúc lợi</h1>
            </div>

            <div class="intro_work_title_area  py-4">
                <h1 class="intro_work_text">Chính sách phát triển nhân lực</h1>
            </div>
            <div class="head_intro_work">
            <textarea class="editor" name="editor" id="csptnl" rows="10"  placeholder="*Các chính sách mở rộng nguồn nhân lực chất lượng
*Phát triển nguồn nhân lực hướng tới mục tiêu gì, nguồn nhân lực đó sẽ có chất lượng ra sao?"><?=$infor['ntd_csptnl']?></textarea>
            <p class="n_dtin_ntd_eror n_eror_csptnl"></p>   
            </div>

            <div class="intro_work_title_area  py-4">
                <h1 class="intro_work_text">Cơ hội thăng tiến</h1>
            </div>
            <div class="head_intro_work">
            <textarea class="editor" name="editor" id="chtt" rows="10"  placeholder="*Làm việc ở doanh nghiệp, ứng viên có cơ hội thăng tiến như thế nào?
*Cơ hội học tập, nâng cao kinh nghiệm, kiến thức trong công việc tại doanh nghiệp"><?=$infor['ntd_chtt']?></textarea>  
            <p class="n_dtin_ntd_eror n_eror_chtt"></p>
            </div>

            <div class="intro_work_title_area  py-4">
                <h1 class="intro_work_text">Lương, thưởng, lợi nhuận</h1>
            </div>
            <div class="head_intro_work">
            <textarea class="editor" name="editor" id="hlln" rows="10"  placeholder="Chế độ lương, thưởng, lợi nhuận của doanh nghiệp như thế nào?
*Chính sách đóng bảo hiểm, trợ cấp,...ra sao?
*Hàng năm có các hoạt động gì đặc sắc cho nhân viên không?
*Các chế độ nghỉ phép, sinh nhật, ngày lễ,...."><?=$infor['ntd_salary_award']?></textarea> 
            <p class="n_dtin_ntd_eror n_eror_hlln"></p>   
            </div>
            <div class="btn_update py-5 text-center">
                <button class="btn btn_update_intro">Cập nhật</button>
            </div>
        </div>
    </div>

</div>