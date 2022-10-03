<style type="text/css">
    .user-img .avt{border-radius:50%;}
    .error {color: red;}
</style>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Thêm mới sản phẩm 
        <small>Dang mục sản phẩm</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dang mục sản phẩm</a></li>
        <li><a href="#">Thêm mới sản phẩm</a></li>
      </ol>
    </section>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <form class="form" id="add_product" onsubmit="return false" enctype="multipart/form-data">
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group ">
                                                        <label for="">Ảnh sản phẩm <span>*</span></label>
                                                        <input type="file" name="image" id="image" accept="image/x-png,image/gif,image/jpeg" class="image">
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="">Ảnh mô tả <span>*</span></label>
                                                        <input type="file" name="des_images[]" id="des_images" accept="image/x-png,image/gif,image/jpeg" class="des_images" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group t-form-group">
                                                        <label for="">Mã sản phẩm <span>*</span></label>
                                                        <input type="text" class="form-control" name="code_product" id="code_product" placeholder="Nhập Mã sản phẩm">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Tên sản phẩm <span>*</span></label>
                                                        <input type="text" class="form-control" name="name" id="name" placeholder="Nhập Tên">
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group t-form-group">
                                                        <label for="">Hiển thị <span>*</span></label>
                                                        <select class=" form-control select" name="status"  id= "status" >
                                                            <option value="1"> Bật</option>
                                                            <option value="0"> Tắt</option>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Loại sản phẩm<span>*</span></label>
                                                        <select class=" form-control select" name="category"  id= "category" >
                                                            <option value=""  > Chọn loại sản phẩm</option>
                                                            <option value="1"  > Đọc mã vạch 1D</option>
                                                            <option value="2"  > Đọc mã vạch 2D</option>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Loại tia<span>*</span></label>
                                                        <select class=" form-control select" name="ray_style"  id= "ray_style" >
                                                            <option value=""  > Chọn Loại tia</option>
                                                            <option value="1"  > Đa tia</option>
                                                            <option value="2"  > Đơn tia</option>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Kiểu dáng<span>*</span></label>
                                                        <select class=" form-control select" name="style"  id= "style" >
                                                            <option value=""  > Chọn Kiểu dáng</option>
                                                            <option value="2"  > Để bàn</option>
                                                            <option value="1"  > Cầm tay</option>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Giá cũ<span>*</span></label>
                                                        <input type="text" class="form-control" name="price_old" id="price_old" placeholder="Nhập giá">
                                                    </div>
                                                     <div class="form-group password t-form-group">
                                                        <label for="">Giảm giá <span>*</span></label>
                                                        <input type="number" class="form-control"  name ="discount"  id="discount"  placeholder="Nhập giảm giá">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Hãng sản xuất<span>*</span></label>
                                                        <select class=" form-control select" name="manufacturer"  id= "manufacturer" >
                                                            <option value=""  > Chọn Hãng sản xuất</option>
                                                            <?php foreach ($manufacturer as $key => $m) {?>
                                                                <option value="<?=$m['id']?>"> <?=$m['name']?></option>
                                                            <?} ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Kết nối<span>*</span></label>
                                                        <select class=" form-control select" name="connector"  id= "connector" >
                                                            <option value=""  > Chọn Kết nối</option>
                                                            <option value="1"  > Có dây</option>
                                                            <option value="2"  > Không dây</option>
                                                            
                                                        </select>
                                                    </div>
                                                     <div class="form-group ">
                                                        <label for="">Giá mới <span>*</span></label>
                                                        <input type="text" class="form-control"  name ="price_new" id="price_new" readonly>
                                                    </div>
                                                     <div class="form-group ">
                                                        <label for="">Số lượng <span>*</span></label>
                                                        <input type="number" class="form-control"  name ="quantity" id="quantity" placeholder="Nhập số lượng">
                                                    </div>
                                                </div>
                                            </div>
                                            <h3>Thông số sản phẩm</h3>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group t-form-group">
                                                        <label for="">Thông số sản phẩm <span>*</span></label>
                                                        <textarea class="form-control" name="parameter"  id="parameter" placeholder="Nhập thông số sản phẩm" rows="5" cols="25"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <h3>Thông số kỹ thuật</h3>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group t-form-group">
                                                        <label for="">Thương hiệu <span>*</span></label>
                                                        <input type="text" class="form-control" name="thuong_hieu" id="thuong_hieu" placeholder="Nhập thưing hiệu">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Model <span>*</span></label>
                                                        <input type="text" class="form-control" name="model" id="model" placeholder="Nhập mẫu">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Công nghệ quét <span>*</span></label>
                                                        <input type="text" class="form-control" name="cong_nghe_quet" id="cong_nghe_quet" placeholder="Nhập công nghệ quét">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Độ tương phản <span>*</span></label>
                                                        <input type="text" class="form-control" name="do_tuong_phan" id="do_tuong_phan" placeholder="Nhập độ tương phản">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Đọc mã vạch <span>*</span></label>
                                                        <input type="text" class="form-control" name="doc_ma_vach" id="doc_ma_vach" placeholder="Nhập đọc mã vạch">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Chân đế <span>*</span></label>
                                                        <select class=" form-control select" name="chan_de"  id= "chan_de" >
                                                            <option value=""> Chọn chân đế</option>
                                                            <option value="1"> Có</option>
                                                            <option value="2"> Không</option>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Điện áp <span>*</span></label>
                                                        <input type="text" class="form-control" name="dien_ap" id="dien_ap" placeholder="Nhập điện áp">
                                                    </div>
                                                    <div class="form-group password t-form-group">
                                                        <label for="">Bảo hành <span>*</span></label>
                                                        <input type="text" class="form-control show_pass show_pass2"  name ="bao_hanh"  id="bao_hanh"  placeholder="Nhập Bảo hành">
                                                    </div>
                                                     
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group t-form-group">
                                                        <label for="">Độ phân giải <span>*</span></label>
                                                        <input type="text" class="form-control" name="do_phan_giai" id="do_phan_giai" placeholder="Nhập độ phân giải">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Độ bền <span>*</span></label>
                                                        <input type="text" class="form-control" name="do_ben" id="do_ben" placeholder="Nhập độ bền">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Góc quét <span>*</span></label>
                                                        <input type="text" class="form-control" name="goc_quet" id="goc_quet" placeholder="Nhập góc quét">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Trọng lượng <span>*</span></label>
                                                        <input type="text" class="form-control" name="trong_luong" id="trong_luong" placeholder="Nhập trọng lượng">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Kích thước <span>*</span></label>
                                                        <input type="text" class="form-control" name="kich_thuoc" id="kich_thuoc" placeholder="Nhập kích thước">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Màu sắc <span>*</span></label>
                                                        <input type="text" class="form-control" name="mau_sac" id="mau_sac" placeholder="Nhập màu sắc">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Phụ kiện <span>*</span></label>
                                                        <input type="text" class="form-control" name="phu_kien" id="phu_kien" placeholder="Nhập phụ kiện">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Xuất xứ <span>*</span></label>
                                                        <input type="text" class="form-control" name="xuat_xu" id="xuat_xu" placeholder="Nhập xuất xứ">
                                                    </div>
                                                </div>
                                                <div class="form-group t-form-group">
                                                    <label for="">Cổng giao tiếp <span>*</span></label>
                                                    <input type="text" class="form-control" name="cong_giao_tiep" id="cong_giao_tiep" placeholder="Nhập Cổng giao tiếp">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="" class="label_tit title">Mô tả sản phẩm</label>
                                                    <textarea name="review_product" class="" id="review_product" cols="30" rows="10"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Tags<span>*</span></label>
                                                    <select class=" form-control select" name="tags[]"  id= "tags" multiple>
                                                        <option value=""  > Chọn tags</option>
                                                        <?php foreach ($tags as $key => $t) {?>
                                                            <option value="<?=$t['id']?>"> <?=$t['name']?></option>
                                                        <?} ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <h3>SEO</h3>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group t-form-group">
                                                    <label for="">Title </label>
                                                    <input type="text" class="form-control" name="title" id="title" placeholder="Nhập Title">
                                                </div>
                                                <div class="form-group t-form-group">
                                                    <label for="">Description (tối đa 160 ký tự) </label>
                                                    <input type="text" class="form-control" name="description" id="description" placeholder="Nhập Description">
                                                </div>
                                                <div class="form-group t-form-group">
                                                    <label for="">Keyword </label>
                                                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Nhập Keyword">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="infor-tt text-center col-md-12">
                                            <button class="btn btn_reg1 click_add_tutor" type="submit">Thêm mới</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>