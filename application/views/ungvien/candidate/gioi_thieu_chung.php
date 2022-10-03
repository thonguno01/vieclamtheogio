<div class="n_content">
    <?php $this->load->view("includes/side_bar_ql_uv"); ?>
    <?php $this->load->view("includes/tab_bar_ql_hs"); ?>
    <!-- toàn bộ cục content -->
    <div class="n_ttcb_content">
        <!-- content bên trong vs margin auto display flex -->
        <div class="n_ttcb_sub_content">
            <textarea class="n_gtc_text" placeholder="Mô tả về kỹ năng của bản thân:
- Ứng viên từng làm công việc gì?
- Công việc đó kéo dài trong bao lâu?
- Ứng viên có những kỹ làm việc nào?"><?=$infor['uv_gtc']?></textarea>
            <button class="n_ttcb_update">Cập nhật</button>
        </div>
    </div>
</div>