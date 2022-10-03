<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quản lý tài khoản
            <small>Danh sách tài khoản admin</small>
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
                    <div class="input-group collapse navbar-collapse " id="navbarSupportedContent">
                    <button style="margin-bottom: 15px;border: 1px solid #979797;background: linear-gradient(to bottom, white 0%, #dcdcdc 100%);border-radius: 5px;"><a href="/admin/add_admin">Thêm mới</a></button>
                        
                        <div class="input-group-append search_area ml-2 navbar_option" >
                            <form class="search_form"  method="get" action="/admin/list_admin">
                                    <input class="search_box me-2" name="adminid" type="search" placeholder="Tìm theo id" aria-label="Search">
                                    <input class="search_box me-2" name="adminusername" type="search" placeholder="Tìm theo username" aria-label="Search">
                                    <input class="search_box me-2" name="adminname" type="search" placeholder="Tìm theo tên" aria-label="Search">
                                    <input class="search_box me-2" name="adminemail" type="search" placeholder="Tìm theo email" aria-label="Search">
                                    <input class="search_box me-2" name="adminphone" type="search" placeholder="Tìm theo số điện thoại" aria-label="Search">
                                    <input class="search_box me-2" name="admindate" type="date" placeholder="Tìm theo ngày đăng ký" aria-label="Search">   
                                <button class="btn btn-info search_button" type="submit">Tìm kiếm</button>
                            </form>
                        </div>
                    </div>
                    <div class="content_search">
                        <p>Có <?= $total;?> tài khoản admin </p>

                        <table data-toolbar="#toolbar" data-toggle="table" class="table table-hover" id="list_account">
                            <thead style="background: #f1f4f7;">
                            <tr>
                                <th data-field="id" data-sortable="true">ID</th>
                                <th data-field="usernmae" data-sortable="true">Username</th>
                                <th data-field="uname" data-sortable="true">Tên admin</th>
                                <th data-field="phone" data-sortable="true">Số điện thoại</th>
                                <th data-field="email" data-sortable="true">Email</th>
                                <th data-field="date" data-sortable="true">Ngày tạo</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody class="">
                            <?php if(!empty($list_admin)){
                                foreach($list_admin as $list){ $i = 0;?> 
                                   
                                    <tr>
                                        <td class="td-count" scope="row"><?= $list['id']; ?></td>
                                        <td><?=$list['username'];?></td>
                                        <td><?=$list['name'];?></td>
                                        <td> <?=$list['phone']?></td>
                                        <td> <?=$list['email']?></td>
                                        <td> <?=date('m-d-Y',$list['create_date'])?></td>
                                        <td class="form-group">
                                            <a href="/admin/edit_account/<? echo $list['id'] ?>" class="btn btn-primary" style="padding: 4px 6px;"><i
                                                        class="glyphicon glyphicon-pencil"></i></a>
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