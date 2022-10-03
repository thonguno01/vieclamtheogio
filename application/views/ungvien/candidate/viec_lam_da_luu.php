<div class="n_content">
    <?php $this->load->view("includes/side_bar_ql_uv"); ?>
    <div class="n_vlut_container">
        <div class="n_vlut_sub_container">
            <div class="n_vlut_table_content">
                <table>
                    <tr>
                        <th>STT</th>
                        <th>Tên công ty/ Người tuyển dụng</th>
                        <th>Tên công việc</th>
                        <th>Lịch làm</th>
                        <th>Lương</th>
                        <th>Xóa</th>
                    </tr>
                    <?php if(!empty($   )){$i = 0;
                        foreach($new_saved as $list){  $i++;?>  
                            <tr>
                                <td class=""><?=$start_row + $i?></td>
                                <td><a class="n_company_name" href="<?=url_ntd($list['ntd_alias'], $list['id_ntd'])?>"><?=$list['ntd_company']?></a></td>
                                <td><a class="n_company_name" href="<?=url_vieclam($list['new_alias'], $list['id_new'])?>"><?=$list['new_title']?></a></td>
                                <td>
                                    <?
                                    $new_no_calam = $list['new_no_calam'];
                                    $arr_giolam_start = explode(",", $list['new_ca_start']);
                                    $arr_giolam_end = explode(",", $list['new_ca_end']);
                                    $so_ca = count($arr_giolam_start);

                                    $arr_new_t2 = explode(",", $list['new_t2']);
                                    $arr_new_t3 = explode(",", $list['new_t3']);
                                    $arr_new_t4 = explode(",", $list['new_t4']);
                                    $arr_new_t5 = explode(",", $list['new_t5']);
                                    $arr_new_t6 = explode(",", $list['new_t6']);
                                    $arr_new_t7 = explode(",", $list['new_t7']);
                                    $arr_new_cn = explode(",", $list['new_cn']);
                                    
                                    if($new_no_calam != 0){
                                        for ($i=0; $i < $so_ca ; $i++) {?>
                                            <p class="n_vlut_ca">Ca <?=$i+1;?>:&nbsp;<?=$arr_giolam_start[$i];?> - <?=$arr_giolam_end[$i];?></p>
                                            <? if($arr_new_t2[$i] != 0){
                                                echo "Thứ 2 ";
                                            }
                                            if($arr_new_t3[$i] != 0){
                                                echo "Thứ 3 ";
                                            }
                                            if($arr_new_t4[$i] != 0){
                                                echo "Thứ 4 ";
                                            }
                                            if($arr_new_t5[$i] != 0){
                                                echo "Thứ 5 ";
                                            }
                                            if($arr_new_t6[$i] != 0){
                                                echo "Thứ 6 ";
                                            }
                                            if($arr_new_t7[$i] != 0){
                                                echo "Thứ 7 ";
                                            }
                                            if($arr_new_cn[$i] != 0){
                                                echo "CN ";
                                            }
                                            ?>
                                        <?}
                                    }else{?>
                                        <p class="n_vlut_ca">Thỏa thuận</p>
                                    <?}?> 
                                </td>
                                <td><?=get_luong($list['new_luong_1'], $list['new_luong_2'], $list['new_luong_1'])?></td>
                                <td>
                                    <button class="n_vldl_del unsave_new" data-idsave ="<?=$list['id']?>" data-new="<?=$list['id_new']?>" data-idntd ="<?=$list['id_ntd']?>">
                                        <img class="n_vldl_del_black" src="/images/n_icon_del_black.svg">
                                        <img class="n_vldl_del_orange" src="/images/n_icon_del_orange.svg">
                                    </button>
                                </td>
                            </tr>
                        <?} 
                    }else{?>
                        <tr>
                            <td colspans="6" class="tbd_old_post" >Không có bản ghi nào.</td>
                        </tr>
                    <?}?>        
                </table>
            </div>
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div> 
</div>
<?php $this->load->view("includes/warning_delete"); ?>