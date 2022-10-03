<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quản lý ngành nghề tại tỉnh thành
            <small>Sửa ngành nghề tại tỉnh thành</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Quản lý ngành nghề tại tỉnh thành</a></li>
            <li><a href="">Sửa ngành nghề tại tỉnh thành</a></li>
        </ol>
    </section>
    <form class="info_work container" method="post" action="/admin/Submit_form/add_edit_cate_city">
        <?php if ($cat_id > 0 && $cit_id > 0) { ?>
            <input type="hidden" id="id" name="id" value='<?= $infor['id'] ?>'>
        <?php } else { ?>
            <div class="sm-3 pt-2 dtin_ntd_info">
                <label class="form-label">Tỉnh thành (<span class="n_red_star">*</span>)</label>
                <div class="n_dky_ntd_input n_type_congviec">
                    <select class="" id="n_city" name="cit_id">
                        <option value="0">Chọn tỉnh thành </option>
                        <?php foreach ($city as $key => $value) : ?>
                            <option value="<?= $key ?>"><?= $value ?></option>
                        <?php endforeach ?>
                    </select>
                    <p class="n_dtin_ntd_eror n_eror_type_congviec"></p>
                </div>
            </div>
            <div class="sm-3 pt-2 dtin_ntd_info">
                <label class="form-label">Loại công việc (<span class="n_red_star">*</span>)</label>
                <div class="n_dky_ntd_input n_type_congviec">
                    <select class="" id="n_type_congviec" name="cat_id">
                        <option value="0">Chọn loại công việc </option>
                        <?php foreach ($cate as $value) : ?>
                            <option value="<?= $value['cat_id'] ?>"><?= $value['cat_name'] ?></option>
                        <?php endforeach ?>
                    </select>
                    <p class="n_dtin_ntd_eror n_eror_type_congviec"></p>
                </div>
            </div>
        <?php } ?>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Tiêu đề(<span class="n_red_star">*</span>)</label>
            <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Tiêu đề" value='<?= empty($infor['meta_title']) ? '' : $infor['meta_title'] ?>'>
            <p class="n_dtin_ntd_eror n_eror_tieude"></p>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Mô tả(<span class="n_red_star">*</span>)</label>
            <input type="text" class="form-control" id="meta_description" name="meta_description" placeholder="Mô tả" value='<?= empty($infor['meta_description']) ? '' : $infor['meta_description'] ?>'>
            <p class="n_dtin_ntd_eror n_eror_tieude"></p>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Từ khóa(<span class="n_red_star">*</span>)</label>
            <input type="text" class="form-control" id="meta_key" name="meta_key" placeholder="Từ khóa" value='<?= empty($infor['meta_key']) ? '' :  $infor['meta_key'] ?>'>
            <p class="n_dtin_ntd_eror n_eror_tieude"></p>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Nội dung bài viết(<span class="n_red_star">*</span>)</label>
            ​<textarea rows="5" cols="70" name="content" id="editor_nd"> <?php if ($this->session->flashdata('content') != null) {
                                                                                echo '';
                                                                            } else {
                                                                                $infor['content'] =  empty($infor['content']) ?   '' : $infor['content'];
                                                                                echo $infor['content'];
                                                                            }
                                                                            ?></textarea>
            <p class="n_dtin_ntd_eror n_eror_tieude"> <?php if ($this->session->flashdata('content') != null) {
                                                            echo $this->session->flashdata('content');
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?></p>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Tiêu đề gợi ý(<span class="n_red_star">*</span>)</label>
            <input type="text" class="form-control" id="title_suggest" name="title_suggest" placeholder="Từ khóa" value='<?= empty($infor['title_suggest']) ? '' :  $infor['title_suggest'] ?>'>
            <p class="n_dtin_ntd_eror n_eror_tieude"></p>
        </div>
        <div class="sm-3 pt-2 dtin_ntd_info">
            <label class="form-label">Nội dung gợi ý(<span class="n_red_star">*</span>)</label>
            ​<textarea rows="5" cols="70" name="content_suggest" id="editor_ndgy"><?= empty($infor['content_suggest']) ? '' :  $infor['content_suggest'] ?></textarea>
            <p class="n_dtin_ntd_eror n_eror_tieude"></p>
        </div>
        <div class="text-center">
            <button class="btn_up_post"><?= ($cat_id > 0 && $cit_id > 0) ? 'Lưu' : 'Thêm mới' ?></button>
        </div>
    </form>
</div>