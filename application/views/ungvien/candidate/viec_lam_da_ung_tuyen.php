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
                        <th>Hạn nộp</th>
                        <th>Ngày nộp</th>
                        <th>Lịch làm</th>
                        <!-- <th>Chat với nhà tuyển dụng</th> -->
                        <th>Xóa</th>
                    </tr>
                    <?php if(!empty($new_applied)){$i = 0;
                        foreach($new_applied as $list){$i++;?> 
                            <tr>
                                <td class=""><?=$start_row + $i?></td>
                                <td><a class="n_company_name" href="<?=url_ntd($list['ntd_alias'], $list['id_ntd'])?>"><?=$list['ntd_company']?></a></td>
                                <td><a class="n_company_name" href="<?=url_vieclam($list['new_alias'], $list['id_new'])?>"><?=$list['new_title']?></a></td>
                                <td><?=date('d/m/Y',$list['new_han_nop'])?></td>
                                <td><?=date('d/m/Y',$list['create_date'])?></td>
                                <td>
                                    <?php 
                                    $arr_calam = explode(",", $list['calamviec']);
                                    $arr_giolam = explode(",", $list['giolam']);
                                    $arr_ngaylam = explode("/", $list['lichlamviec']);
                                    $so_ca = count($arr_calam);
                                    $j =  0;
                                    while ($j < $so_ca) {
                                     if($arr_calam[$j] != 0){?>
                                            <p class="n_vlut_ca">Ca <?=$arr_calam[$j];?>:&nbsp;<?=$arr_giolam[$j];?></p>
                                            <?php echo $arr_ngaylam[$j]; ?>
                                        <?}else{?>
                                            <p class="n_vlut_ca">Thỏa thuận</p>
                                        <?}?>
                                     <?php $j++; }?> 
                                </td>
                                <!-- <td>
                                    <button class="n_vlut_chat">
                                        <img class="n_vlut_chat_black" src="/images/n_icon_chat_blue.svg">
                                        <img class="n_vlut_chat_orange" src="/images/n_icon_chat_orange.svg">
                                    </button>
                                </td> -->
                                <td>
                                    <button class="n_vlut_del del_new_applied" data-idut = "<?=$list['id']?>">
                                        <img class="n_vlut_del_black" src="/images/n_icon_del_black.svg">
                                        <img class="n_vlut_del_orange" src="/images/n_icon_del_orange.svg">
                                    </button>
                                </td>
                            </tr>
                        <?} 
                    }else{?>
                        <tr>
                            <td colspans="7" class="tbd_old_post" >Không có bản ghi nào.</td>
                        </tr>
                    <?}?>     
                </table>
            </div>
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
</div>
<?php $this->load->view("includes/warning_delete"); ?>