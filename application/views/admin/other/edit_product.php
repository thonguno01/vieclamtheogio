<style type="text/css">
    .user-img .avt{border-radius:50%;}
    .error {color: red;}
</style>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Cập nhật sản phẩm 
        <small>Dang mục sản phẩm</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dang mục sản phẩm</a></li>
        <li><a href="#">Cập nhật sản phẩm</a></li>
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
                                    <form class="form" id="edit_product" enctype="multipart/form-data">
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group ">
                                                        <label for="">Ảnh sản phẩm <span>*</span></label>
                                                        <?php if ($product['image'] != '' || $product['image'] != null) {?>
                                                            <img style="width: 100px; height:100px;" src="/images/item/<?= $product['image'] ?>">
                                                        <?} ?>
                                                        <input type="file" name="image" id="image" accept="image/x-png,image/gif,image/jpeg" class="image">
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="">Ảnh mô tả <span>*</span></label>
                                                        <?php if ($product['des_images'] != '' || $product['des_images'] != null) {
                                                            $list_image = explode(',', $product['des_images']);
                                                            foreach ($list_image as $key => $value) { ?>
                                                              <img style="width: 100px; height:100px;" src="/images/item/<?= $value; ?>">
                                                          <?php }
                                                          } ?>
                                                        <input type="file" name="des_images[]" id="des_images" accept="image/x-png,image/gif,image/jpeg" class="des_images" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group t-form-group">
                                                        <label for="">Mã sản phẩm <span>*</span></label>
                                                        <input type="hidden" name="id" id="id" value="<?php echo $product['id'] ?>">
                                                        <input type="text" class="form-control" name="code_product" id="code_product" placeholder="Nhập Mã sản phẩm" value="<?php echo $product['code_product'] ?>">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Tên sản phẩm <span>*</span></label>
                                                        <input type="text" class="form-control" name="name" id="name" placeholder="Nhập Tên" value="<?php echo $product['name'] ?>">
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group t-form-group">
                                                        <label for="">Hiển thị <span>*</span></label>
                                                        <select class=" form-control select" name="status"  id= "status" >
                                                            <option value="1" <?=($product['status'] == 1)?'selected':''?>>Bật</option>
                                                            <option value="0" <?=($product['status'] == 0)?'selected':''?>>Tắt</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Loại sản phẩm<span>*</span></label>
                                                        <select class=" form-control select" name="category"  id= "category" >
                                                            <option value=""  > Chọn loại sản phẩm</option>
                                                            <option value="1" <?=($product['category'] == 1)?'selected':''?>>Đọc mã vạch 1D</option>
                                                            <option value="2" <?=($product['category'] == 2)?'selected':''?>>Đọc mã vạch 2D</option>
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
                                                            <option value="1" <?=($product['ray_style'] == 1)?'selected':''?>>Đa tia</option>
                                                            <option value="2" <?=($product['ray_style'] == 2)?'selected':''?>>Đơn tia</option>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Kiểu dáng<span>*</span></label>
                                                        <select class=" form-control select" name="style"  id= "style" >
                                                            <option value=""  > Chọn Kiểu dáng</option>
                                                            <option value="1" <?=($product['style'] == 1)?'selected':''?>>Để bàn</option>
                                                            <option value="2" <?=($product['style'] == 2)?'selected':''?>>Cầm tay</option>
                                                        </select>
                                                    </div>
                                                     <div class="form-group">
                                                        <label for="">Giá cũ<span>*</span></label>
                                                        <input type="text" class="form-control" name="price_old" id="price_old" placeholder="Nhập giá" value="<?php echo $product['price_old'] ?>">
                                                    </div>
                                                     <div class="form-group password t-form-group">
                                                        <label for="">Giảm giá <span>*</span></label>
                                                        <input type="number" class="form-control"  name ="discount"  id="discount"  placeholder="Nhập giảm giá" value="<?php echo $product['discount'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Hãng sản xuất<span>*</span></label>
                                                        <select class=" form-control select" name="manufacturer"  id= "manufacturer" >
                                                            <option value=""  > Chọn Hãng sản xuất</option>
                                                            <?php foreach ($manufacturer as $key => $m) {?>
                                                                <option value="<?=$m['id']?>" <? if($product['manufacturer']==$m['id']) echo "selected" ; ?>>
                                                                    <? echo $m['name'] ?></option>
                                                            <?  } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Kết nối<span>*</span></label>
                                                        <select class=" form-control select"  name="connector"  id= "connector" >
                                                            <option value=""  > Chọn Kết nối</option>
                                                            <option value="1" <?=($product['connector'] == 1)?'selected':''?>>Có dây</option>
                                                            <option value="2" <?=($product['connector'] == 2)?'selected':''?>>Không dây</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group password t-form-group">
                                                        <label for="">Giá mới <span>*</span></label>
                                                        <input type="text" class="form-control"  name ="price_new" id="price_new" readonly value="<?php echo $product['price_new'] ?>">
                                                    </div>
                                                    <div class="form-group password t-form-group">
                                                        <label for="">Số lượng <span>*</span></label>
                                                        <input type="number" class="form-control"  name ="quantity" id="quantity" placeholder="Nhập số lượng" value="<?php echo $product['quantity'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <h3>Thông số sản phẩm</h3>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group t-form-group">
                                                        <label for="">Thông số sản phẩm <span>*</span></label>
                                                        <textarea class="form-control" name="parameter"  id="parameter" placeholder="Nhập thông số sản phẩm" rows="5" cols="25"><?php echo str_replace("|","\r\n",$product['parameter']) ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <h3>Thông số kỹ thuật</h3>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group t-form-group">
                                                        <label for="">Thương hiệu <span>*</span></label>
                                                        <input type="text" class="form-control" name="thuong_hieu" id="thuong_hieu" placeholder="Nhập thương hiệu" value="<?php echo $product['thuong_hieu'] ?>">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Model <span>*</span></label>
                                                        <input type="text" class="form-control" name="model" id="model" placeholder="Nhập mẫu" value="<?php echo $product['model'] ?>">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Công nghệ quét <span>*</span></label>
                                                        <input type="text" class="form-control" name="cong_nghe_quet" id="cong_nghe_quet" placeholder="Nhập công nghệ quét" value="<?php echo $product['cong_nghe_quet'] ?>">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Độ tương phản <span>*</span></label>
                                                        <input type="text" class="form-control" name="do_tuong_phan" id="do_tuong_phan" placeholder="Nhập độ tương phản" value="<?php echo $product['do_tuong_phan'] ?>">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Đọc mã vạch <span>*</span></label>
                                                        <input type="text" class="form-control" name="doc_ma_vach" id="doc_ma_vach" placeholder="Nhập đọc mã vạch" value="<?php echo $product['doc_ma_vach'] ?>">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Chân đế <span>*</span></label>
                                                        <select class=" form-control select" name="chan_de"  id= "chan_de" >
                                                            <option value=""> Chọn chân đế</option>
                                                            <option value="1" <?=($product['chan_de'] == 1)?'selected':''?>>Có</option>
                                                            <option value="2" <?=($product['chan_de'] == 2)?'selected':''?>>Không</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Điện áp <span>*</span></label>
                                                        <input type="text" class="form-control" name="dien_ap" id="dien_ap" placeholder="Nhập điện áp" value="<?php echo $product['dien_ap'] ?>">
                                                    </div>
                                                    <div class="form-group password t-form-group">
                                                        <label for="">Bảo hành <span>*</span></label>
                                                        <input type="text" class="form-control show_pass show_pass2"  name ="bao_hanh"  id="bao_hanh"  placeholder="Nhập Bảo hành" value="<?php echo $product['bao_hanh'] ?>">
                                                    </div>
                                                     
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group t-form-group">
                                                        <label for="">Độ phân giải <span>*</span></label>
                                                        <input type="text" class="form-control" name="do_phan_giai" id="do_phan_giai" placeholder="Nhập độ phân giải" value="<?php echo $product['do_phan_giai'] ?>">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Độ bền <span>*</span></label>
                                                        <input type="text" class="form-control" name="do_ben" id="do_ben" placeholder="Nhập độ bền" value="<?php echo $product['do_ben'] ?>">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Góc quét <span>*</span></label>
                                                        <input type="text" class="form-control" name="goc_quet" id="goc_quet" placeholder="Nhập góc quét" value="<?php echo $product['goc_quet'] ?>">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Trọng lượng <span>*</span></label>
                                                        <input type="text" class="form-control" name="trong_luong" id="trong_luong" placeholder="Nhập trọng lượng" value="<?php echo $product['trong_luong'] ?>">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Kích thước <span>*</span></label>
                                                        <input type="text" class="form-control" name="kich_thuoc" id="kich_thuoc" placeholder="Nhập kích thước" value="<?php echo $product['kich_thuoc'] ?>">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Màu sắc <span>*</span></label>
                                                        <input type="text" class="form-control" name="mau_sac" id="mau_sac" placeholder="Nhập màu sắc" value="<?php echo $product['mau_sac'] ?>">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Phụ kiện <span>*</span></label>
                                                        <input type="text" class="form-control" name="phu_kien" id="phu_kien" placeholder="Nhập phụ kiện" value="<?php echo $product['phu_kien'] ?>">
                                                    </div>
                                                    <div class="form-group t-form-group">
                                                        <label for="">Xuất xứ <span>*</span></label>
                                                        <input type="text" class="form-control" name="xuat_xu" id="xuat_xu" placeholder="Nhập xuất xứ" value="<?php echo $product['xuat_xu'] ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group t-form-group">
                                                    <label for="">Cổng giao tiếp <span>*</span></label>
                                                    <input type="text" class="form-control" name="cong_giao_tiep" id="cong_giao_tiep" placeholder="Nhập Cổng giao tiếp" value="<?php echo $product['cong_giao_tiep'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="" class="label_tit title">Mô tả sản phẩm</label>
                                                    <textarea name="review_product" class="" id="review_product" cols="30" rows="10"><?php echo $product['review_product'] ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Tags<span>*</span></label>
                                                    <?php $tag = $product['tags'];
                                                          $tag_ex = explode(',', $tag);?>
                                                    <select class=" form-control select" name="tags[]"  id= "tags" multiple>
                                                        <option value=""  > Chọn tags</option>
                                                        <? foreach ($tags as $key => $t) {?>
                                                            <option value="<?= $t['id'] ?>" <? if(in_array($t['id'], $tag_ex)) { echo "selected"; } ?>>
                                                            <?= $t['name'] ?></option>
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
                                                    <input type="text" class="form-control" name="title" id="title" placeholder="Nhập Title" value="<?php echo $product['title'] ?>">
                                                </div>
                                                <div class="form-group t-form-group">
                                                    <label for="">Description (tối đa 160 ký tự) </label>
                                                    <input type="text" class="form-control" name="description" id="description" placeholder="Nhập Description" value="<?php echo $product['description'] ?>">
                                                </div>
                                                <div class="form-group t-form-group">
                                                    <label for="">Keyword </label>
                                                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Nhập Keyword" value="<?php echo $product['keyword'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="infor-tt text-center col-md-12">
                                            <button class="btn btn_reg1 click_add_tutor" type="submit">Cập nhật</button>
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