
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quản lý tài khoản
            <small>Danh sách tài khoản nhà tuyển dụng</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Danh sách tài khoản nhà tuyển dụng</a></li>
            <li><a href="">Danh sách</a></li>
        </ol>
    </section>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body ">
                    <div class="input-group collapse navbar-collapse " id="navbarSupportedContent">
                        <div class="input-group-append ml-2 navbar_option" >
                            <button style="margin-bottom: 15px;border: 1px solid #979797;background: linear-gradient(to bottom, white 0%, #dcdcdc 100%);border-radius: 5px;"><a href="/admin/employer/add">Thêm mới</a></button>
                            <div class="input-group-append search_area ml-2 navbar_option" >
                                <form class="search_form"  method="get" action="/admin/employer/list">
                                    <input class="search_box me-2" name="ntdid" type="search" placeholder="Tìm theo id" aria-label="Search">
                                    <input class="search_box me-2" name="ntdname" type="search" placeholder="Tìm theo tên" aria-label="Search">
                                    <input class="search_box me-2" name="ntdemail" type="search" placeholder="Tìm theo email" aria-label="Search">
                                    <input class="search_box me-2" name="ntdphone" type="search" placeholder="Tìm theo số điện thoại" aria-label="Search">
                                    <input class="search_box me-2" name="ntddate" type="date" placeholder="Tìm theo ngày đăng ký" aria-label="Search">   
                                    <select name="ntdsign_up" class="" id="status">
                                        <option value="">Chọn nguồn đăng ký</option>
                                        <option value="1">Web</option>
                                        <option value="2">App</option>
                                    </select>
                                    <select name="ntdstatus" class="" id="status">
                                        <option value="">Chọn trạng thái</option>
                                        <option value="1">Đã xác thực</option>
                                        <option value="0">Chưa xác thực</option>
                                    </select>
                                    <button class="btn btn-info search_button" type="submit">Tìm kiếm</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="content_search">
                    <p>Có <?= $total;?> tài khoản nhà tuyển dụng </p>
                        <table data-toolbar="#toolbar" data-toggle="table" class="table table-hover" id="list_account">
                            <thead style="background: #f1f4f7;">
                            <tr>
                                <th data-field="id" data-sortable="true">ID</th>
                                <th data-field="name" data-sortable="true">Tên nhà tuyển dụng</th>
                                <th data-field="email" data-sortable="true">Email</th>
                                <th data-field="phone" data-sortable="true">Số điện thoại</th>
                                <th data-field="role" data-sortable="true">Ngày đăng ký</th>
                                <th data-field="role" data-sortable="true">Đăng ký từ</th>
                                <th data-field="status" data-sortable="true">Trạng thái</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody class="">
                            <?php if(!empty($list_employer)){
                                foreach($list_employer as $list){ $i = 0;?> 
                                    <tr>
                                        <td class="td-count" scope="row"><?= $list['ntd_id']; ?></td>
                                        <td><a tagget="_blank" href="<?=url_ntd($list['ntd_alias'], $list['ntd_id'])?>"><?=$list['ntd_company']?></a></td>
                                        <td><?=$list['ntd_email'];?></td>
                                        
                                        <td><?=$list['ntd_phone'];?></td>
                                        <td><?=date('d-m-Y',$list['ntd_create_time']);?></td>
                                        <td><?php if($list['ntd_sign_up_from']==1) {echo('Web');}?></td>
                                        <td>
                                            <?php 
                                            if ($list['ntd_authentic']==1) {
                                                echo "Đã xác thực";
                                                } else {
                                                    echo "Chưa xác thực";
                                                }
                                            ?>
                                        </td>
                                        <td class="form-group">
                                            <a href="edit/<?php echo $list['ntd_id']; ?>" class="btn btn-primary" style="padding: 4px 6px;"><i
                                                        class="glyphicon glyphicon-pencil"></i></a>
                                        </td>
                                    </tr>
                                <?} 
                            }?> 
                            </tbody>
                        </table>
                        <div class="t_paginate">
                            <div class="t_paginate_group">  
                                <?php echo $links; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>