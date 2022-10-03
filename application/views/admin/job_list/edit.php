<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quản lý ngành nghề
            <small>Sửa ngành nghề</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Quản lý ngành nghề</a></li>
            <li><a href="">Sửa ngành nghề</a></li>
        </ol>
    </section>

    <form class="info_work container" id='edit_cate' method='post' action='/admin/Submit_form/add_edit_cate'>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Tiêu đề(<span class="n_red_star">*</span>)</label>
            <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Từ khóa" value='<?=$infor['meta_title']?>'>
            <p class="n_dtin_ntd_eror"></p>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Mô tả(<span class="n_red_star">*</span>)</label>
            <input type="text" class="form-control" id="meta_description" name="meta_description" placeholder="Mô tả" value='<?=$infor['meta_description']?>'>
            <input type="hidden" class="form-control" id="cat_id" name="cat_id" placeholder="Tên ngành nghề" value='<?=$infor['cat_id']?>'>
            <p class="n_dtin_ntd_eror"></p>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Từ khóa(<span class="n_red_star">*</span>)</label>
            <input type="text" class="form-control" id="meta_key" name="meta_key" placeholder="Từ khóa" value='<?=$infor['meta_key']?>'>
            <p class="n_dtin_ntd_eror"></p>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Nội dung bài viết(<span class="n_red_star">*</span>)</label>
            ​<textarea rows="5" cols="70" id="editor_nd" name="content"><?=$infor['content']?></textarea>
            <p class="n_dtin_ntd_eror"></p>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Tiêu đề gợi ý(<span class="n_red_star">*</span>)</label>
            <input type="text" class="form-control" id="title_suggest" name="title_suggest" placeholder="Từ khóa" value='<?=$infor['title_suggest']?>' >
            <p class="n_dtin_ntd_eror"></p>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Nội dung gợi ý(<span class="n_red_star">*</span>)</label>
            ​<textarea rows="5" cols="70" id="editor_ndgy" name="content_suggest"><?=$infor['content_suggest']?></textarea>
            <p class="n_dtin_ntd_eror"></p>
        </div>
        <div class="text-center">
            <button class="btn_up_post btn-warning" data-id=<?=$cate_id?>><?=$cate_id>0?'Lưu':'Thêm mới'?></button>
        </div>
    </form>
</div>