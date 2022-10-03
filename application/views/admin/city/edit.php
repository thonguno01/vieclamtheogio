<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quản lý tỉnh thành, quận huyện
            <small>Sửa tỉnh thành, quận huyện</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Quản lý tỉnh thành, quận huyện</a></li>
            <li><a href="">Sửa tỉnh thành, quận huyện</a></li>
        </ol>
    </section>

    <form class="info_work container" id='edit_cate' method='post' action='/admin/Submit_form/add_edit_city'>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Tiêu đề(<span class="n_red_star">*</span>) </label><span class="n_dtin_ntd_eror"></span>
            <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Từ khóa" value='<?= $infor['meta_title'] ?>'>
            <p class=""></p>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Mô tả(<span class="n_red_star">*</span>) </label><span class="n_dtin_ntd_eror"></span>
            <input type="text" class="form-control" id="meta_description" name="meta_description" placeholder="Mô tả" value='<?= $infor['meta_description'] ?>'>
            <input type="hidden" class="form-control" id="cat_id" name="cit_id" placeholder="Tên ngành nghề" value='<?= $infor['cit_id'] ?>'>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Từ khóa(<span class="n_red_star">*</span>) </label><span class="n_dtin_ntd_eror"></span>
            <input type="text" class="form-control" id="meta_key" name="meta_key" placeholder="Từ khóa" value='<?= $infor['meta_key'] ?>'>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Nội dung bài viết(<span class="n_red_star">*</span>) </label><span class="n_dtin_ntd_eror"></span>
            ​<textarea rows="5" cols="70" id="editor_nd" name="content"><?= $infor['content'] ?></textarea>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Tiêu đề gợi ý(<span class="n_red_star">*</span>) </label><span class="n_dtin_ntd_eror"></span>
            <input type="text" class="form-control" id="title_suggest" name="title_suggest" placeholder="Từ khóa" value='<?= $infor['title_suggest'] ?>'>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Nội dung gợi ý(<span class="n_red_star">*</span>) </label><span class="n_dtin_ntd_eror"></span>
            ​<textarea rows="5" cols="70" id="editor_ndgy" name="content_suggest"><?= $infor['content_suggest'] ?></textarea>
        </div>
        <div class="text-center">
            <button class="btn_up_post btn-primary" data-id=<?= $id ?>><?= $id > 0 ? 'Lưu' : 'Thêm mới' ?></button>
        </div>
    </form>
</div>