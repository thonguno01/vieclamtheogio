<?php   
$CI=&get_instance();
$CI->load->model('Admin_model');
 ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quản lý tài khoản
            <small>Danh sách</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Quản lý tài khoản</a></li>
            <li><a href="">Danh sách</a></li>
        </ol>
    </section>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body ">
                    <div class="input-group " style="display: flex;width: 100%;justify-content: flex-end;">
                        <div class="input-group-append ml-2" style="margin-left: 1.5rem!important;">
                            <button style="margin-bottom: 15px;border: 1px solid #979797;background: linear-gradient(to bottom, white 0%, #dcdcdc 100%);border-radius: 5px;"><a href="/admin/add_account">Thêm mới</a></button>
                        </div>
                    </div>
                    <div class="content_search">
                        <table data-toolbar="#toolbar" data-toggle="table" class="table table-hover" id="list_account">
                            <thead style="background: #f1f4f7;">
                            <tr>
                                <th data-field="stt" data-sortable="true">ID</th>
                                <th data-field="account" data-sortable="true">Email</th>
                                <th data-field="uname" data-sortable="true">Tên đăng nhập</th>
                                <th data-field="name" data-sortable="true">Họ tên</th>
                                <th data-field="role" data-sortable="true">Quyền</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody class="">
                            <?php if(!empty($list_account)){
                                foreach($list_account as $list){ $i = 0;?> 
                                    <?php 
                                    $qr_role = $this->Admin_model->select_data('modules','mod_name',array('adu_admin_id' => $list['id']),array('admin_user_right'=>'adu_admin_module_id=mod_id'),array('mod_order'  => "ASC"), null, null,1);
                                    if ($qr_role) {
                                        foreach($qr_role as $role){
                                            $arr_role[$i][] = $role['mod_name'];
                                        }
                                        $str_role = str_replace('<br>&ensp;&ensp;&ensp;','',implode(", ",$arr_role[$i]));
                                        unset($arr_role[$i]);
                                    }else{
                                        $str_role = '';
                                    }?>
                                    <tr>
                                        <td class="td-count" scope="row"><?= $list['id']; ?></td>
                                        <td> <?=$list['email']?></td>
                                        <td><?=$list['username'];?></td>
                                        <td><?=$list['name'];?></td>
                                        <td>
                                            <?php echo $str_role ?>
                                        </td>
                                        <td class="form-group">
                                            <a href="edit_account/<? echo $list['id'] ?>" class="btn btn-primary" style="padding: 4px 6px;"><i
                                                        class="glyphicon glyphicon-pencil"></i></a>
                                            <a href="delete_account/<? echo $list['id'] ?>" class="btn btn-danger" style="padding: 4px 6px;" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')"><i
                                                        class="glyphicon glyphicon-trash"></i></a>
                                        </td>
                                    </tr>
                                <?} 
                            }?> 
                            </tbody>
                        </table>
                        <div class="t_paginate">
                            <div class="t_paginate_group">  
                                    <?=$links; ?>          
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>