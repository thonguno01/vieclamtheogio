<div class="n_content">
    <?php $this->load->view("includes/side_bar_ql_uv"); ?>
    <div class="n_qlc_container">
        <div class="n_qlc_charts">
            <div class="n_qlc_column_charts">
            <svg class="n_qlc_line_group" viewbox="0 -10 242 252" width="242" height="252" xmlns="http://www.w3.org/2000/svg">
                <rect x="0" y="0" width="1" height="242" fill="rgba(39, 88, 221, 0.35)"/>
                <rect x="0" y="12" width="242" height="1" fill="rgba(39, 88, 221, 0.35)"/>
                <rect x="0" y="35" width="242" height="1" fill="rgba(39, 88, 221, 0.35)"/>
                <rect x="0" y="58" width="242" height="1" fill="rgba(39, 88, 221, 0.35)"/>
                <rect x="0" y="81" width="242" height="1" fill="rgba(39, 88, 221, 0.35)"/>
                <rect x="0" y="104" width="242" height="1" fill="rgba(39, 88, 221, 0.35)"/>
                <rect x="0" y="127" width="242" height="1" fill="rgba(39, 88, 221, 0.35)"/>
                <rect x="0" y="150" width="242" height="1" fill="rgba(39, 88, 221, 0.35)"/>
                <rect x="0" y="173" width="242" height="1" fill="rgba(39, 88, 221, 0.35)"/>
                <rect x="0" y="196" width="242" height="1" fill="rgba(39, 88, 221, 0.35)"/>
                <rect x="0" y="218" width="242" height="1" fill="rgba(39, 88, 221, 0.35)"/>
                
                <rect class="n_col_chart_1" x="19"  y="<?=((100-$percent1)*2.3+12<233)?(100-$percent1)*2.3+12:233?>" width="30" height="<?=($percent1*2.3>9)?$percent1*2.3:9?>" rx="10" ry="10" fill="#694CFF"/>
                <rect class="n_col_chart_1" x="71"  y="<?=((100-$percent2)*2.3+12<233)?(100-$percent2)*2.3+12:233?>" width="30" height="<?=($percent2*2.3>9)?$percent2*2.3:9?>" rx="10" ry="10" fill="#ED4E61"/>
                <rect class="n_col_chart_1" x="123" y="<?=((100-$percent3)*2.3+12<233)?(100-$percent3)*2.3+12:233?>" width="30" height="<?=($percent3*2.3>9)?$percent3*2.3:9?>" rx="10" ry="10" fill="#F25CFF"/>
                <rect class="n_col_chart_1" x="175" y="<?=((100-$percent4)*2.3+12<233)?(100-$percent4)*2.3+12:233?>" width="30" height="<?=($percent4*2.3>9)?$percent4*2.3:9?>" rx="10" ry="10" fill="#16B743"/>
                
                <text class="n_col_chart_text" x="23"  y="<?=((100-$percent1)*2.3<221)?(100-$percent1)*2.3:221?>" alignment-baseline="central" text-anchor="start" fill="#694CFF" font-size="13"><?=$percent1?>%</text>
                <text class="n_col_chart_text" x="75"  y="<?=((100-$percent2)*2.3<221)?(100-$percent2)*2.3:221?>" alignment-baseline="central" text-anchor="start" fill="#ED4E61" font-size="13"><?=$percent2?>%</text>
                <text class="n_col_chart_text" x="128" y="<?=((100-$percent3)*2.3<221)?(100-$percent3)*2.3:221?>" alignment-baseline="central" text-anchor="start" fill="#F25CFF" font-size="13"><?=$percent3?>%</text>
                <text class="n_col_chart_text" x="180" y="<?=((100-$percent4)*2.3<221)?(100-$percent4)*2.3:221?>" alignment-baseline="central" text-anchor="start" fill="#16B743" font-size="13"><?=$percent4?>%</text>
            </svg>

            </div>
            <div class="n_qlc_circle_charts">
                <div class="n_qlc_circle_chart_1">
                    <svg class="circle-chart" viewbox="0 0 50 50" width="50" height="50" xmlns="http://www.w3.org/2000/svg">
                        <circle class="circle-chart__background" cx="25" cy="25" r="23" stroke="#c4c4c4" stroke-width="2" fill="none" />
                        <circle class="circle-chart__circle" cx="25" cy="25" r="23" stroke="#694CFF" stroke-width="2" stroke-dasharray="<?=($percent1/100)*(46*3.1415)?>,<?=(100-$percent1)/100*(46*3.1415)?>" stroke-linecap="butt" fill="none" />
                        <g class="circle-chart__info">
                            <text class="circle-chart__percent" x="25" y="25" alignment-baseline="central" text-anchor="middle" font-size="15"><?=$percent1?>%</text>
                        </g>
                    </svg>
                    <p class="n_qlc_circle_chart_txt">Thông tin cơ bản</p>
                    <a class="n_qlc_circle_chart_link" href="/thong-tin-co-ban-uv">Cập nhật ngay >></a>
                </div>
                <div class="n_qlc_circle_chart_1">
                    <svg class="circle-chart" viewbox="0 0 50 50" width="50" height="50" xmlns="http://www.w3.org/2000/svg">
                        <circle class="circle-chart__background" cx="25" cy="25" r="23" stroke="#c4c4c4" stroke-width="2" fill="none" />
                        <circle class="circle-chart__circle" cx="25" cy="25" r="23" stroke="#ED4E61" stroke-width="2" stroke-dasharray="<?=($percent2/100)*(46*3.1415)?>,<?=(100-$percent2)/100*(46*3.1415)?>" stroke-linecap="butt" fill="none" />
                        <g class="circle-chart__info">
                            <text class="circle-chart__percent" x="25" y="25" alignment-baseline="central" text-anchor="middle" font-size="15"><?=$percent2?>%</text>
                        </g>
                    </svg>
                    <p class="n_qlc_circle_chart_txt">Công việc mong muốn</p>
                    <a class="n_qlc_circle_chart_link" href="/cong-viec-mong-muon">Cập nhật ngay >></a>
                </div>
                <div class="n_qlc_circle_chart_1">
                    <svg class="circle-chart" viewbox="0 0 50 50" width="50" height="50" xmlns="http://www.w3.org/2000/svg">
                        <circle class="circle-chart__background" cx="25" cy="25" r="23" stroke="#c4c4c4" stroke-width="2" fill="none" />
                        <circle class="circle-chart__circle" cx="25" cy="25" r="23" stroke="#F25CFF" stroke-width="2" stroke-dasharray="<?=($percent3/100)*(46*3.1415)?>,<?=(100-$percent3)/100*(46*3.1415)?>" stroke-linecap="butt" fill="none" />
                        <g class="circle-chart__info">
                            <text class="circle-chart__percent" x="25" y="25" alignment-baseline="central" text-anchor="middle" font-size="15"><?=$percent3?>%</text>
                        </g>
                    </svg>
                    <p class="n_qlc_circle_chart_txt">Giới thiệu chung</p>
                    <a class="n_qlc_circle_chart_link" href="/gioi-thieu-chung-uv">Cập nhật ngay >></a>
                </div>
                <div class="n_qlc_circle_chart_1">
                    <svg class="circle-chart" viewbox="0 0 50 50" width="50" height="50" xmlns="http://www.w3.org/2000/svg">
                        <circle class="circle-chart__background" cx="25" cy="25" r="23" stroke="#c4c4c4" stroke-width="2" fill="none" />
                        <circle class="circle-chart__circle" cx="25" cy="25" r="23" stroke="#16B743" stroke-width="2" stroke-dasharray="<?=($percent4/100)*(46*3.1415)?>,<?=(100-$percent4)/100*(46*3.1415)?>" stroke-linecap="butt" fill="none" />
                        <g class="circle-chart__info">
                            <text class="circle-chart__percent" x="25" y="25" alignment-baseline="central" text-anchor="middle" font-size="15"><?=$percent4?>%</text>
                        </g>
                    </svg>
                    <p class="n_qlc_circle_chart_txt">Kinh nghiệm làm việc</p>
                    <a class="n_qlc_circle_chart_link" href="/kinh-nghiem-lam-viec">Cập nhật ngay >></a>
                </div>            
            </div>
        </div>

        <div class="n_qlc_link_list">
            <div class="n_qlc_link_div">
                <div class="n_qlc_link_title">
                    <div class="n_qlc_link_title_img">
                        <img src="/images/n_case_white.svg">
                    </div>
                    <p class="n_qlc_link_title_txt">Việc làm đã ứng tuyển</p>
                </div>
                <div class="n_qlc_link_number">
                    <p class="n_qlc_link_num"><span class="n_qlc_link_big_num"><?=$apply_new?></span> Công việc</p>
                </div>
                <div class="n_qlc_link_">
                    <a href="/viec-lam-da-ung-tuyen" class="n_qlc_link">Xem chi tiết >></a>
                </div>
            </div>
            <div class="n_qlc_link_div">
                <div class="n_qlc_link_title">
                    <div class="n_qlc_link_title_img">
                        <img class="" src="/images/n_icon_heart_plus.svg">
                    </div>
                    <p class="n_qlc_link_title_txt">Việc làm đã lưu</p>
                </div>
                <div class="n_qlc_link_number">
                    <p class="n_qlc_link_num"><span class="n_qlc_link_big_num"><?=$save_new?></span> Công việc</p>
                </div>
                <div class="n_qlc_link_">
                    <a href="/viec-lam-da-luu" class="n_qlc_link">Xem chi tiết >></a>
                </div>
            </div>
            <div class="n_qlc_link_div">
                <div class="n_qlc_link_title">
                    <div class="n_qlc_link_title_img">
                        <img class="" src="/images/n_search_white.svg">
                    </div>
                    <p class="n_qlc_link_title_txt">Nhà tuyển dụng đã xem hồ sơ</p>
                </div>
                <div class="n_qlc_link_number">
                    <p class="n_qlc_link_num"><span class="n_qlc_link_big_num"><?=$ntd_xemhoso?></span> NTD</p>
                </div>
                <div class="n_qlc_link_">
                    <a href="/nha-tuyen-dung-xem-ho-so" class="n_qlc_link">Xem chi tiết >></a>
                </div>
            </div>
            <div class="n_qlc_link_div">
                <img class="n_qlc_tao_cv_img" src="/images/n_tao_cv.png">
                <img class="n_qlc_tao_cv_close" src="/images/n_icon_plus_C4C4C4.svg">
                <p class="n_qlc_tao_cv_title">Tạo CV online dễ dàng</p>
                <p class="n_qlc_tao_cv_title">CV đa dạng mẫu mã, ngôn ngữ</p>
                <p class="n_qlc_tao_cv_title">Tăng khả năng tìm kiếm việc làm</p>
                <a href="https://vieclam123.vn/mau-cv-xin-viec/" class="n_qlc_tao_cv_btn" target="_blank">Tạo CV online ngay</a>
            </div>
        </div>
    </div>
</div>