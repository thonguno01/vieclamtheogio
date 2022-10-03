<style>
    th,td {
        padding: 5px 10px;
        border: 1px solid #d2d6de;
        text-align: center;
    }

    table {
        width: 100%;
    }
    .right{
        padding: 15px;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quản lý tài khoản
            <small>Sửa</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="list_user_admin.php"><i class="fa fa-dashboard"></i>Quản lý tài khoản</a></li>
            <li><a href="">Sửa</a></li>
        </ol>
    </section>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body ">
                    <div class="content_search">
                        <form action="" method="POST" id="add_tags" style="width: 100%" class="edit_account">
                            <div class="left"  style="width: 50%; float: left"> 
                                <div class="row_tag">
                                    <label for="" class="label_tit lbl_name_tag">Tên đăng nhập</label>
                                    <input type="text" class="name_tag" name="userName" value="<?php echo $info_admin['username'] ?>" disabled id="name" id="name">
                                    <input type="hidden" class="name_tag" name="id" value="<?php echo $info_admin['id'] ?>" id="id">
                                </div>
                                <div class="row_tag">
                                    <label for="" class="label_tit lbl_name_tag">Họ tên</label>
                                    <input type="text" class="name_tag" name="name" value="<?=$info_admin['name'];?>" id="fullname">
                                </div>
                                <div class="row_tag">
                                    <label for="" class="label_tit lbl_name_tag">Số điện thoại</label>
                                    <input type="text" class="name_tag" name="phone" value="<?=$info_admin['phone'];?>" id="phone">
                                </div>
                                <div class="row_tag">
                                    <label for="" class="label_tit lbl_name_tag"><span>* </span>Mật khẩu mới</label>
                                    <input type="password" id="password" class="name_tag" name="password">
                                </div>
                                <div class="row_tag">
                                    <label for="" class="label_tit lbl_name_tag"><span>* </span>Nhập lại mật khẩu</label>
                                    <input type="password" class="name_tag" name="repassword">
                                </div>
                                <div class="row_tag">
                                    <label for="" class="label_tit lbl_name_tag"><span>* </span>Email</label>
                                    <input type="email" class="name_tag" name="email"  value="<?=$info_admin['email'];?>" id="email">
                                </div>
                            </div>
                            <div class="right" style="width: 50%; float:right;">
                                <div class="row_tag">
                                    <label for="" class="label_tit lbl_name_tag"><span>* </span>Quyền quản lý</label>
                                    <table>
                                        <tr>
                                            <th>Chọn</th>
                                            <th>Danh sách</th>
                                        </tr>
                                        <?php foreach($admin_module as $row_modul){ ?>
                                            <? $qr_check_role = $this->Admin_model->select_data('admin_user_right','*',array('adu_admin_id'=>$info_admin['id'],'adu_admin_module_id'=>$row_modul['mod_id']),null,null, null, null,0);

                                            if ($qr_check_role) {
                                                $modul_checked = ' checked ';
                                                if($qr_check_role['adu_add'] == 1){
                                                    $add_checked = ' checked ';
                                                }else{
                                                    $add_checked = '';
                                                }
                                                if($qr_check_role['adu_edit'] == 1){
                                                    $edit_checked = ' checked ';
                                                }else{
                                                    $edit_checked = '';
                                                }
                                            }else{
                                                $modul_checked = '';
                                                $add_checked = '';
                                                $edit_checked = '';
                                            }?>
                                            <tr>
                                                <td><input type="checkbox" value="<?=$row_modul['mod_id']?>" id="modul" name="modul" <?=$modul_checked;?>></td>
                                                <td><?=$row_modul['mod_name'];?></td>
                                            </tr>
                                         <?}?> 
                                    </table>
                                </div>
                            </div>

                            <div class="row_tag" style="width: 100%">
                                <input type="submit" name="update_user_admin" class="update_user_admin" value="Cập nhật">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

