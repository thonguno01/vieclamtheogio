<div class="total_qlc">
    <div class="menu_qlc_ntd">
        <?php include "side_bar_ql_ntd.php"; ?>
    </div>
    <div class="n_qlc_container">
        <!-- <div class="row no-gutters "> -->
        <div class="n_qlc_link_list">
            <div class="n_qlc_link_div">
                <div class="n_qlc_link_title">
                    <div class="n_qlc_link_title_img">
                        <img src="/images/document-copy.png">
                    </div>
                    <div class="n_qlc_title">
                        <p class="n_qlc_link_title_txt">Ứng viên ứng tuyển</p>
                        <div class="n_qlc_link_number">
                            <p class="n_qlc_link_num"><span class="n_qlc_link_big_num"><?= count($uv_apllied) ?></span> Ứng viên</p>
                        </div>
                    </div>
                </div>
                <div class="n_qlc_link_">
                    <a href="/ung-vien-ung-tuyen" class="n_qlc_link">Xem chi tiết >></a>
                </div>
            </div>
            <div class="n_qlc_link_div">
                <div class="n_qlc_link_title">
                    <div class="n_qlc_link_title_img">
                        <img class="" src="/images/document-filter.svg">
                    </div>
                    <div class="n_qlc_title">
                        <p class="n_qlc_link_title_txt">Ứng viên từ điểm lọc</p>
                        <div class="n_qlc_link_number">
                            <p class="n_qlc_link_num"><span class="n_qlc_link_big_num"><?= count($uv_tdl) ?></span> Ứng viên</p>
                        </div>
                    </div>
                </div>
                <div class="n_qlc_link_">
                    <a href="/ung-vien-tu-diem-loc" class="n_qlc_link">Xem chi tiết >></a>
                </div>
            </div>
            <div class="n_qlc_link_div">
                <div class="n_qlc_link_title">
                    <div class="n_qlc_link_title_img">
                        <img class="" src="/images/Group.png">
                    </div>
                    <div class="n_qlc_title">
                        <p class="n_qlc_link_title_txt">Ứng viên được gửi từ chuyên viên</p>
                        <div class="n_qlc_link_number">
                            <p class="n_qlc_link_num"><span class="n_qlc_link_big_num">30</span> Ứng viên</p>
                        </div>
                    </div>
                </div>
                <div class="n_qlc_link_">
                    <a class="n_qlc_link">Xem chi tiết >></a>
                </div>
            </div>
            <div class="n_qlc_link_div speed_ntd_box">
                <img src="/images/tangtocntd.png" alt="">
                <h2 class="speed_ntd">Tăng tốc nhà tuyển dụng</h2>
                <button class="btn_xem_gia" onclick="window.open('https://vieclam123.vn/viec-lam/bang-gia/','_blank')">Xem bảng giá ngay >></button>
            </div>
            <!-- </div> -->
        </div>
        <div class="ql_baidang_1">
            <div class="ql_baidang">
                <div class="n_ql_bai_dang">
                    <div class="n_ql_bai_dang_title">
                        <p class="n_ql_baidang_title_txt">Việc làm hết hạn</p>
                    </div>
                    <div class="n_ql_baidang_number">
                        <p class="n_ql_baidang_num"><span class="ql_baidang_bignum"><?= $count_new_hethan ?></span>Tin tuyển</p>
                    </div>
                </div>
                <div class="n_ql_bai_dang">
                    <div class="n_ql_bai_dang_title">
                        <p class="n_ql_baidang_title_txt">Việc làm còn hạn</p>
                    </div>
                    <div class="n_ql_baidang_number">
                        <p class="n_ql_baidang_num"><span class="ql_baidang_bignum"><?= $count_new_conhan ?></span>Tin tuyển</p>
                    </div>
                </div>
                <div class="n_ql_bai_dang speed_ntd_box_2">
                    <img src="/images/tangtocntd.png" alt="">
                    <h2 class="speed_ntd">Tăng tốc nhà tuyển dụng</h2>
                    <button class="btn_xem_gia">Xem bảng giá ngay >></button>
                </div>
                <div class="n_ql_bai_dang">
                    <div class="n_ql_bai_dang_title">
                        <p class="n_ql_baidang_title_txt">Việc làm sắp hết hạn</p>
                    </div>
                    <div class="n_ql_baidang_number">
                        <p class="n_ql_baidang_num"><span class="ql_baidang_bignum"><?= $count_new_saphethan ?></span>Tin tuyển</p>
                    </div>
                </div>
                <div class="n_ql_bai_dang">
                    <div class="n_ql_bai_dang_title">
                        <p class="n_ql_baidang_title_txt">Số tin đăng trong ngày</p>
                    </div>
                    <div class="n_ql_baidang_number">
                        <p class="n_ql_baidang_num"><span class="ql_baidang_bignum"><?= $count_new_day ?></span>Tin tuyển</p>
                    </div>
                </div>
                <div class="n_ql_bai_dang">
                    <div class="n_ql_bai_dang_title">
                        <p class="n_ql_baidang_title_txt">Số lần làm mới tin</p>
                    </div>
                    <div class="n_ql_baidang_number">
                        <p class="n_ql_baidang_num"><span class="ql_baidang_bignum"><?= $count_refesh_new['total_view_new'] ?></span>Lần</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- button -->
        <div class="btn_post">
            <div class="up_post">
            </div>
            <button class="btn_up_post" onclick="window.location.href='dang-tin';">Đăng tin mới</button>
            <button class="btn_old_post" onclick="window.location.href='tin-da-dang';">Xem tin đã đăng</button>
            <div class="old_post">
            </div>
        </div>
    </div>
</div>