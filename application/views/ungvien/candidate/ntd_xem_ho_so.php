<div class="n_content">
    <?php $this->load->view("includes/side_bar_ql_uv"); ?>
    <div class="n_vlut_container">
        <div class="n_vlut_sub_container">
            <div class="n_vlut_table_content">
                <table>
                    <tr>
                        <th>STT</th>
                        <th>Tên công ty/ Người tuyển dụng</th>
                        <th>Thời gian</th>
                    </tr>
                    <?php if(!empty($ntd_xemhoso)){$i = 0;
                        foreach($ntd_xemhoso as $list){$i++;?> 
                            <tr>
                                <td><?=$start_row + $i?></td>
                                <td><a class="n_company_name" href="<?=url_ntd($list['ntd_alias'], $list['id_ntd'])?>"><?=$list['ntd_company']?></a></td>
                                <td><?=date('d/m/Y',$list['create_date'])?></td>
                            </tr>
                        <?} 
                    }else{?>
                        <tr>
                            <td colspans="3" class="tbd_old_post" >Không có bản ghi nào.</td>
                        </tr>
                    <?}?> 
                </table>
            </div>
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
</div>