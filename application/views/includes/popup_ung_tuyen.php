<div class="popup_ung_tuyen_bg">
    <div class="popup_ung_tuyen_box">
        <div class="button_close_popup_ut text-center">
            <img class="btn_x n_close_popup_ut" src="/images/n_icon_plus.svg" alt="">
            <img class="line_x" src="/images/line.png" alt="">
        </div>
        <h1 class="popup_ut_title text-center">Ứng tuyển</h1>
        <div class="popup_ca_lam container">
        <?php
        if ($infor_job['new_no_calam'] == 0){
            echo '<h1 class="popup_ca_lam_text">Công việc này có ca làm linh hoạt, bạn sẽ được sắp xếp cụ thể khi trao đổi trực tiếp.</h1>';
        }else{
            $start = explode(',',$infor_job['new_ca_start']);
            $end = explode(',',$infor_job['new_ca_end']);
            $t2 = explode(',',$infor_job['new_t2']);
            $t3 = explode(',',$infor_job['new_t3']);
            $t4 = explode(',',$infor_job['new_t4']);
            $t5 = explode(',',$infor_job['new_t5']);
            $t6 = explode(',',$infor_job['new_t6']);
            $t7 = explode(',',$infor_job['new_t7']);
            $cn = explode(',',$infor_job['new_cn']);
            $total_ca = count($start);
        ?>
            <h1 class="popup_ca_lam_text">Công việc này có <span class="calam_span"><?=$total_ca?></span> ca</h1>
            <h1 class="popup_ca_lam_text py-3">Chọn buổi bạn có thể đi làm</h1>
            <div class="n_detail_ca_lam_total">
                <?php for ($i=1; $i <= $total_ca; $i++) :?>
                    <div class="ca_lam">
                        <div class="n_gio_lam1 pt-3 pb-4 default_ca_lam">
                            <p class="n_text_label">Ca <?=$i?>: (<span id="ca_<?=$i?>" class="calam_span"><?=$start[$i-1]?> - <?=$end[$i-1]?></span>)</p> 
                        </div>
                    
                        <div class="n_detail_ca_lam">
                            <div class="n_dow n_mon">
                                <p class="n_tdow n_mo" value="<?=10*$i+2?>">Thứ 2</p>
                            </div>
                            <div class="n_dow n_tue">
                                <p class="n_tdow n_mo" value="<?=10*$i+3?>">Thứ 3</p>
                            </div>
                            <div class="n_dow n_wen">
                                <p class="n_tdow n_mo" value="<?=10*$i+4?>">Thứ 4</p>
                            </div>
                            <div class="n_dow n_thu">
                                <p class="n_tdow n_mo" value="<?=10*$i+5?>">Thứ 5</p>
                            </div>
                            <div class="n_dow n_fri">
                                <p class="n_tdow n_mo" value="<?=10*$i+6?>">Thứ 6</p>
                            </div>
                            <div class="n_dow n_sat">
                                <p class="n_tdow n_mo" value="<?=10*$i+7?>">Thứ 7</p>
                            </div>
                            <div class="n_dow n_sun">
                                <p class="n_tdow n_mo" value="<?=10*$i+8?>">Chủ Nhật</p>
                            </div>
                        </div>  
                    </div>
                <?php endfor;?>
            </div>
        <?php }?>

            <div class="btn_save text-center pt-4">
                <button class="btn_save_ut btn" data-ca="<?=$infor_job['new_no_calam']?>">Lưu</button>
            </div>

            <div class="ca_lam_saved">
                <div name="" id="ca_lam_saved"></div>
            </div>

            <div class="note_ntd pt-4">
                <h1 class="note_ntd_text">Ghi chú gửi nhà tuyển dụng</h1>
                <textarea name="" id="note_ntd"></textarea>
            </div>

            <div class="btn_send_uc" data-iduser="<?=(isset($_COOKIE['Type']) && $_COOKIE['Type']==3)?$_COOKIE['UserId']:''?>" data-idnew="<?=$infor_job['new_id']?>" data-idntd="<?=$infor_job['ntd_id']?>" data-ca="<?=$infor_job['new_no_calam']?>">
                <img class="btn_send_uc_img" src="/images/send_yc.png" alt="">
                <img class="btn_sent_uc_img" src="/images/sent_yc.png" alt="">
            </div>
        </div>
    </div>
</div>