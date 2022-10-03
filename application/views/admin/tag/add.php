<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quản lý ngành nghề
            <small>Thêm mới Tag</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Quản lý ngành nghề</a></li>
            <li><a href="">Thêm mới tag</a></li>
        </ol>
    </section>

    <div class="container">
        <h2>Thêm tag</h2>
        <div class="row">
            <div class="input-group mb-3 col-sm-6">
                <span class="input-group-text" id="basic-addon1">Ngành nghề</span>
                <select name="" id="cate_have_tag">
                    <option value="0">Chọn ngành nghề </option>
                    <?php foreach ($cate as $list) : ?>
                        <option class="id_cat" value="<?= $list['cat_id'] ?>"><?= $list['cat_name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <p class="admin_eror n_eror_catname"></p>
            </div>

            <div class="input-group mb-3 col-sm-6">
                <span class="input-group-text" id="basic-addon1">Tag</span>
                <input type="text" class="form-control tag_name" placeholder="Title" aria-label="Email" aria-describedby="basic-addon1">
                <p class="admin_eror n_eror_tag_name"></p>
            </div>

            <div class="input-group mb-3 col-sm-6">
                <span class="input-group-text" id="basic-addon1">Tag des</span>
                <input type="text" class="form-control tag_des" placeholder="Keyword" aria-label="Keyword" aria-describedby="basic-addon1">
                <p class="admin_eror n_eror_tag_des"></p>
            </div>

            <div class="input-group mb-3 col-sm-6">
                <span class="input-group-text" id="basic-addon1">Tag key</span>
                <textarea class="form-control tag_key" placeholder="Nội dung" aria-label="Nội dung" aria-describedby="basic-addon1"></textarea>
                <p class="admin_eror n_eror_tag_key"></p>
            </div>


            <div class="input-group mb-3 col-sm-6">
                <span class="input-group-text" id="basic-addon1">Tiêu đề tag</span>
                <input type="text" class="form-control title_tag" placeholder="Tiêu đề đề xuất" aria-label="Tiêu đề đề xuất" aria-describedby="basic-addon1">
                <p class="admin_eror n_eror_title_tag"></p>
            </div>

            <div class="input-group mb-3 col-sm-6">
                <span class="input-group-text" id="basic-addon1">Tiêu đề đề xuất</span>
                <input type="text" class="form-control title_suggest" placeholder="Tiêu đề đề xuất" aria-label="Tiêu đề đề xuất" aria-describedby="basic-addon1">
                <p class="admin_eror n_eror_title_suggest"></p>
            </div>

            <div class="input-group mb-3 col-sm-6">
                <span class="input-group-text" id="basic-addon1">Nội dung </span>
                <textarea class="form-control content" placeholder="Nội dung đề xuất" aria-label="Nội dung đề xuất" aria-describedby="basic-addon1"></textarea>
                <p class="admin_eror n_eror_content"></p>
            </div>

            <div class="input-group mb-3 col-sm-6">
                <span class="input-group-text" id="basic-addon1">Nội dung đề xuất</span>
                <textarea class="form-control content_suggest" placeholder="Nội dung đề xuất" aria-label="Nội dung đề xuất" aria-describedby="basic-addon1"></textarea>
                <p class="admin_eror n_eror_content_suggest"></p>
            </div>

            <div class="input-group mb-3 col-sm-6">
                <span class="input-group-text" id="basic-addon1">Tag index</span>
                <input type="checkbox" class="title_suggest tag_index" placeholder="Tag_index" aria-label="Tag index" aria-describedby="basic-addon1" value="1">
                <p class="admin_eror n_eror_cat_index"></p>
            </div>

            <button type="button" class="btn btn-primary add_tag">Add new</button>
        </div>
    </div>

</div>