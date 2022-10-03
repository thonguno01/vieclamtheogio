<div class="total_qlc">
    <div class=" menu_qlc_ntd">
        <?php include "side_bar_ql_ntd.php"; ?>
    </div>
    <div class="content_uvut">
        <div class="info_uvut container">
            <div class="info_uvut_title py-4">
                <h1 class="info_uvut_title_text">Ứng viên từ điểm lọc</h1>
            </div>
            <div class="head_btn">
                <form method="POST" action="">
                    <div class="excel">
                        <button value="btn_excel_ung_vien_tu_diem_loc" type="submit" class="btn_excel btn_excel_save_uv" name="btn_excel_ung_vien_tu_diem_loc">
                            <img src="/images/excel_btn.png" alt="">Xuất Excel
                        </button>
                    </div>
                </form>

            </div>
            <div class="danh_sach_uvut_table pt-4 table-responsive-xl">
                <table class=" table text-center">
                    <thead class="title_table_old_post">
                        <tr>
                            <th class="th_old_post" scope="col">Tên ứng viên</th>
                            <th class="th_old_post" scope="col">Loại công việc</th>
                            <th class="th_old_post" scope="col">Địa chỉ</th>
                            <th class="th_old_post" scope="col">Ngày lưu</th>
                            <th class="th_old_post" scope="col">Email & SĐT</th>
                            <th class="th_old_post" scope="col">Mức lương mong muốn</th>
                            <th class="th_old_post" scope="col">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($see_uv)) {
                            $i = 0;
                            foreach ($see_uv as $list) {
                                $i++; ?>
                                <tr>
                                    <td class="tbd_old_post tbd_name" scope="col"><?= $start_row + $i ?> .<a href="<?= url_ungvien($list['uv_alias'], $list['uv_id']) ?>"><span style="color:#2758DD"><?= $list['uv_name'] ?></span><a /></td>
                                    <td class="tbd_old_post" scope="col">
                                        <div class="tbd_tag_cv">
                                            <?php $uv_cat = explode(',', $list['uv_cat']);
                                            foreach ($category as $cat_value) : ?>
                                                <?php if (in_array($cat_value['cat_id'], $uv_cat) == true) { ?>
                                                    <a class="url_cv_uv" href="<?= url_cv_uv($cat_value['cat_alias'], $cat_value['cat_id']) ?>"><span class="tag_cv"><?= $cat_value['cat_name'] ?></span></a>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                    <td class="tbd_old_post" scope="col"><?= $list['uv_address'] ?></td>
                                    <td class="tbd_old_post" scope="col"><?= date('d/m/Y', $list['create_date']) ?></td>
                                    <td class="tbd_old_post" scope="col">
                                        <span style="color:#5DC5F4"><?= $list['uv_phone'] ?></span><br>
                                        <span style="color:#007653"><?= $list['uv_email'] ?></span>
                                    </td>

                                    <td class="tbd_old_post" scope="col"><?= get_luong($list['uv_luong_1'], $list['uv_luong_2'], $list['uv_luong_1']) ?></td>
                                    <td class="tbd_old_post tbd_old_post_option" scope="col">
                                        <a class="btn_options unsave_uv" data-idntd="<?= $list['id_ntd'] ?>" data-iduv="<?= $list['uv_id'] ?>"><img src="/images/delete_btn.png" alt="Delete"></a>
                                    </td>
                                </tr>
                            <? }
                        } else { ?>
                            <tr>
                                <td colspans="7" class="tbd_old_post">Không có bản ghi nào.</td>
                            </tr>
                        <? } ?>
                    </tbody>
                </table>
            </div>
            <div class="py-4">
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("includes/warning_delete"); ?>