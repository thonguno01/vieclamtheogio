<style type="text/css">
    .user-img .avt{border-radius:50%;}
    .error {color: red;}
</style>
<?php
    if ($type == "add") {
        $title = "Thêm mới";
        $submit = "add";
        $id = '';
        $name = '';
    }else if($type == "edit"){
        $title = "Cập nhật";
        $submit = "edit";
        $id = $category['id'];
        $name = $category['name'];
    }
?>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <?php echo $title ?> loại tia 
        <small>Danh mục sản phẩm</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Danh mục sản phẩm</a></li>
        <li><a href="#"><?php echo $title ?> loại tia</a></li>
      </ol>
    </section>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form" id="add_edit_ray">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tên loại tia <span>*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nhập nôi dung" value="<?php echo $name ?>">
                                </div>
                            </div>
                            <input type="hidden" name="" id="id" value="<?php echo $id ?>">
                            <input type="hidden" name="" id="submit" value="<?php echo $submit ?>">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Trạng thái<span>*</span></label>
                                    <select name="status" id="status" class="form-control">
                                       <option value="1"  <? if ($type == "edit") {if($category['status'] == '1' ) echo "selected";}?>>Bật</option>
                                        <option value="0"  <? if ($type == "edit") {if($category['status'] == '0' ) echo "selected";}?>>Tắt</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                         <div class="infor-tt text-center">
                            <button class="btn btn_reg1 click_add_tutor" type="submit" name=""><?php echo $title ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>