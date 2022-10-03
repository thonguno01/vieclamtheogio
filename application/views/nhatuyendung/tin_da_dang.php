<div class="total_qlc">

    <!--Side bar-->
    <div class=" menu_qlc_ntd">
        <?php include "side_bar_ql_ntd.php"; ?>
    </div>

    <!--Nội dung bài đã đăng-->
    <div class="content_old_post">
        <div class="old_post_work container">
            <div class="old_post_work_title py-4">
                <h1 class="old_post_work_title_text">Tổng số tin tuyển dụng</h1>
                <div>
                    <form method="POST" action="">
                        <div class="excel">
                            <button value="excel_tin_da_dang" type="submit" class="btn_excel excel_uv_apply" name="excel_tin_da_dang">
                                <img src="/images/excel_btn.png" alt="">Xuất Excel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="old_post_work_table table-responsive-xl">


                <table class=" table text-center">
                    <thead class="title_table_old_post">
                        <tr>
                            <th class="th_old_post" scope="col">Id</th>
                            <th class="th_old_post" scope="col" width: 1000px>Tiêu đề</th>
                            <th class="th_old_post" scope="col">Số ứng viên <br> ứng tuyển</th>
                            <th class="th_old_post" scope="col">Lượt xem</th>
                            <th class="th_old_post" scope="col">Trạng thái</th>
                            <th class="th_old_post" scope="col">Ngày đăng</th>
                            <th class="th_old_post" scope="col">Hạn nộp</th>
                            <th class="th_old_post" scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($new_upload as $value) : ?>
                            <tr>
                                <th class="tbd_old_post" scope="col"><?= $value['new_id'] ?></th>
                                <th class="tbd_old_post" scope="col"><a class="n_new_title" href="<?= url_vieclam($value['new_alias'], $value['new_id']) ?>"><?= $value['new_title'] ?></a></th>
                                <th class="tbd_old_post" scope="col"><? if ($value['so_uv_ungtuyen'] != 0) {
                                                                            echo $value['so_uv_ungtuyen'];
                                                                        } else {
                                                                            echo "Chưa có";
                                                                        } ?></th>
                                <th class="tbd_old_post" scope="col"><? if ($value['view_new'] != 0) {
                                                                            echo $value['view_new'];
                                                                        } else {
                                                                            echo "Chưa có";
                                                                        } ?></th>
                                <th class="tbd_old_post" scope="col"><?php
                                                                        $time = $value['new_han_nop'] - $value['new_create_time'];
                                                                        if ($value['new_han_nop'] < getdate()[0]) {
                                                                            echo '<span class="text-danger">Hết hạn</span>';
                                                                        } else {
                                                                            if ($time < 86400) {
                                                                                echo '<span class="text-warning">Sắp hết hạn</span>';
                                                                            } else {
                                                                                echo 'Đã đăng';
                                                                            }
                                                                        }
                                                                        ?></th>
                                <th class="tbd_old_post" scope="col"><?= date('d-m-Y', $value['new_create_time']) ?></th>
                                <th class="tbd_old_post" scope="col"><?= date('d-m-Y', $value['new_han_nop']) ?></th>
                                <th class="tbd_old_post tbd_old_post_option" scope="col">
                                    <a class="btn_options btn_reload btn_reload_new" data-idnew="<?= $value['new_id'] ?>" onclick="refreshNew(<?= $value['new_id'] ?>)"><img src="/images/reload_btn.png" alt="Reload" title="Làm mới"></a>
                                    <a class="btn_options btn_edit" href="/<?= vn_str_filter($value['new_title']) ?>-chinh-sua-tin<?= $value['new_id'] ?>.html"><img src="/images/edit_btn.png" alt="Edit" title="Chỉnh sửa"></a>
                                    <a class="btn_options btn_delete" data-idnew="<?= $value['new_id'] ?>"><img src="/images/delete_btn.png" alt="Delete" title="Xóa"></a>
                                </th>
                            </tr>
                        <?php endforeach; ?>
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