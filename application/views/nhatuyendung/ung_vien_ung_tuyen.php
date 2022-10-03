<div class="total_qlc">
    <div class=" menu_qlc_ntd">
        <?php include "side_bar_ql_ntd.php"; ?>
    </div>

    <div class="content_uvut">
        <div class="info_uvut container">
            <div class="info_uvut_title py-4">
                <h1 class="info_uvut_title_text">Ứng viên đã ứng tuyển</h1>
            </div>

            <div class="head_btn">
                <form method="POST" action="">
                    <div class="excel">
                        <button value="excel_uv_apply" type="submit" class="btn_excel excel_uv_apply" name="excel_uv_apply">
                            <img src="/images/excel_btn.png" alt="">Xuất Excel
                        </button>
                    </div>
                </form>
                <div class="danh_sach_uvut">
                    <div class="danh_sach_uvut_input n_uvut">
                        <select id="n_uvut" class="filter_uv_ut_stt">
                            <option value="-1">Tất cả</option>
                            <?php $all_stt_apply = all_stt_apply();

                            if (!isset($status_ut)) { ?>
                                <?php foreach ($all_stt_apply as $key => $value) { ?>
                                    <option value="<?= $key ?>"><?= $value ?></option>
                                <? }
                            } else {
                                foreach ($all_stt_apply as $key => $value) {
                                    if ($status_ut == $key) {
                                        $checked = "selected";
                                    } else {
                                        $checked = '';
                                    }
                                ?>
                                    <option <?= $checked ?> data-tokens="<?= $key ?>" value="<?= $key ?>"><?= $value ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="danh_sach_uvut_table pt-4">
                <table>
                    <tr>
                        <td class="th_uvut_header">Tên ứng viên</td>
                        <td class="th_uvut_header">Vị trí ứng tuyển</td>
                        <td class="th_uvut_header">Địa chỉ</td>
                        <td class="th_uvut_header">Email & SĐT</td>
                        <td class="th_uvut_header">Ngày nộp</td>
                        <td class="th_uvut_header">Lịch làm</td>
                        <td class="th_uvut_header">Ghi chú</td>
                        <td class="th_uvut_header">Kết quả</td>
                    </tr>
                    <?php if (!empty($uv_apllied)) {
                        $i = 0;
                        foreach ($uv_apllied as $list) {
                            $i++; ?>
                            <tr>
                                <td class="tbd_old_post tbd_name" scope="col"><?= $start_row + $i ?> .<a href="<?= url_ungvien($list['uv_alias'], $list['uv_id']) ?>"><span style="color:#2758DD"><?= $list['uv_name'] ?></span><a /></td>
                                <td class="tbd_old_post">
                                    <a href="<?= url_vieclam($list['new_alias'], $list['new_id']) ?>"><span style="color:#2758DD"><?= $list['new_title'] ?></span><a />
                                </td>
                                <td class="tbd_old_post"><?= $list['uv_address'] ?></td>
                                <td class="tbd_old_post">
                                    <span style="color:#5DC5F4"><?= $list['uv_phone'] ?></span><br>
                                    <span style="color:#007653"><?= $list['uv_email'] ?></span>
                                </td>
                                <td class="tbd_old_post"><?= date('d/m/Y', $list['create_date']) ?></td>
                                <td class="tbd_old_post">
                                    <?php
                                    $arr_calam = explode(",", $list['calamviec']);
                                    $arr_giolam = explode(",", $list['giolam']);
                                    $arr_ngaylam = explode("/", $list['lichlamviec']);
                                    $so_ca = count($arr_calam);
                                    $j =  0;
                                    while ($j < $so_ca) {
                                        if ($arr_calam[$j] != 0) { ?>
                                            <span style="white-space:nowrap;background: #5279E4; color:#fff;">Ca <?= $arr_calam[$j]; ?>:&nbsp;<?= $arr_giolam[$j]; ?></span>
                                            <br><?php echo $arr_ngaylam[$j]; ?>
                                        <? } else { ?>
                                            <span style="white-space:nowrap;background: #5279E4; color:#fff;">Thỏa thuận</span>
                                        <? } ?>
                                    <?php $j++;
                                    } ?>
                                </td>
                                <td class="tbd_old_post"><?= $list['note'] ?></td>
                                <td class="tbd_old_post tbd_old_post_option">
                                    <div class="status_cv">
                                        <select id="status_cv" class="stt_uv_apply" data-idUt=<?= $list['id'] ?>>
                                            <?php $all_stt_apply = all_stt_apply();
                                            foreach ($all_stt_apply as $key => $value) : ?>
                                                <option value="<?= $key ?>" <?php if ($list['status'] == $key) echo 'selected'; ?>><?= $value ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        <? }
                    } else { ?>
                        <tr>
                            <td colspans="8" class="tbd_old_post">Không có bản ghi nào.</td>
                        </tr>
                    <? } ?>
                </table>
            </div>
            <div class="py-4">
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("includes/warning_delete"); ?>