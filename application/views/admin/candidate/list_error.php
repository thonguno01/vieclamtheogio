
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quản lý tài khoản
            <small>Danh sách tài khoản ứng viên</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Danh sách tài khoản ứng viên</a></li>
            <li><a href="">Danh sách</a></li>
        </ol>
    </section>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body ">
                    <div class="input-group collapse navbar-collapse " id="navbarSupportedContent">
                        <div class="input-group-append ml-2 navbar_option" >
                            <div class="input-group-append search_area ml-2 navbar_option" >
                                <form class="search_form"  method="get" action="/admin/candidate_error">
                                    <input class="search_box me-2" name="uvid" type="search" placeholder="Tìm theo id" aria-label="Search">
                                    <input class="search_box me-2" name="uvname" type="search" placeholder="Tìm theo tên ứng viên" aria-label="Search">
                                    <button class="btn btn-info search_button" type="submit">Tìm kiếm</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="content_search">
                    <p>Có <?= $total;?> ứng viên đăng ký lỗi </p>
                        <table data-toolbar="#toolbar" data-toggle="table" class="table table-hover" id="list_account">
                            <thead style="background: #f1f4f7;">
                            <tr>
                                <th data-field="id" data-sortable="true">ID</th>
                                <th data-field="name" data-sortable="true">Tên ứng viên</th>
                                <th data-field="email" data-sortable="true">Email</th>
                                <th data-field="phone" data-sortable="true">Số điện thoại </th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody class="">
                            <?php if(!empty($list_error)){
                                foreach($list_error as $list){?> 
                                    <tr>
                                        <td class="td-count" scope="row"><?= $list['id']; ?></td>
                                        <td><?=$list['uv_name']?></td>
                                        <td>
                                            <?php 
                                                if ($list['uv_email'] == ''){
                                                    echo "Còn thiếu email";
                                                } else {
                                                    echo $list['uv_email'];    
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if ($list['uv_phone'] == ''){
                                                    echo "Còn thiếu số điện thoại ";
                                                } else {
                                                    echo $list['uv_phone'];   
                                                }
                                            ?>
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