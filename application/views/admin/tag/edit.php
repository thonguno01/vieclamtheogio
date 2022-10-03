<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quản lý tag
            <small>Sửa tag</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Quản lý tag</a></li>
            <li><a href="">Sửa tag</a></li>
        </ol>
    </section>

    <form class="info_work container">
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Tên tag(<span class="n_red_star">*</span>)</label>
            <input type="text" class="form-control" id="tag_name" name="tag_name" placeholder="Tên tag" value='<?= empty($infor['tag_name']) ? '' :  $infor['tag_name']  ?>'>
            <input type="hidden" class="form-control" id="tag_id" name="tag_id" placeholder="Tên tag" value='<?= $infor['tag_id'] ?>'>
            <p class="n_dtin_ntd_eror n_eror_tieude"></p>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Loại công việc (<span class="n_red_star">*</span>)</label>
            <div class="n_dky_ntd_input n_type_congviec">
                <select class="" id="n_type_congviec">
                    <option value="0">Chọn loại công việc </option>
                    <?php foreach ($cate as $value) : ?>
                        <option value="<?= $value['cat_id'] ?>" <?php if ($infor['tag_parent'] == $value['cat_id']) echo 'selected'; ?>><?= $value['cat_name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <p class="n_dtin_ntd_eror n_eror_type_congviec"></p>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Mô tả(<span class="n_red_star">*</span>)</label>
            <input type="text" class="form-control" id="tag_des" name="tag_des" placeholder="Mô tả" value='<?= $infor['tag_des'] ?>'>
            <p class="n_dtin_ntd_eror n_eror_tieude"></p>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Từ khóa(<span class="n_red_star">*</span>)</label>
            <input type="text" class="form-control" id="tag_key" name="tag_key" placeholder="Từ khóa" value='<?= $infor['tag_key'] ?>'>
            <p class="n_dtin_ntd_eror n_eror_tieude"></p>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Nội dung bài viết(<span class="n_red_star">*</span>)</label>
            ​<textarea rows="5" cols="70" name="content" id="editor_nd"><?= $infor['content'] ?></textarea>
            <p class="n_dtin_ntd_eror n_eror_tieude"></p>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Tiêu đề gợi ý(<span class="n_red_star">*</span>)</label>
            <input type="text" class="form-control" id="title_suggest" name="title_suggest" placeholder="Từ khóa" value='<?= $infor['title_suggest'] ?>'>
            <p class="n_dtin_ntd_eror n_eror_tieude"></p>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Nội dung gợi ý(<span class="n_red_star">*</span>)</label>
            ​<textarea rows="5" cols="70" name="content" id="editor_ndgy"><?= $infor['content_suggest'] ?></textarea>
            <p class="n_dtin_ntd_eror n_eror_tieude"></p>
        </div>
        <div class="text-center">
            <button class="btn_up_post" data-id=<?= $tag_id ?>><?= $tag_id > 0 ? 'Lưu' : 'Thêm mới' ?></button>
        </div>
    </form>
</div>