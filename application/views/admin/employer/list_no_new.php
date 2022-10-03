
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
                            <div class="input-group-append search_area ml-2 navbar_option" >
                                <form class="search_form"  method="get" action="/admin/employer_not_new">
                                    <input class="search_box me-2" name="ntdid" type="search" placeholder="Tìm theo id" aria-label="Search">
                                    <input class="search_box me-2" name="ntdname" type="search" placeholder="Tìm theo tên nhà tuyển dụng" aria-label="Search">
                                    <button class="btn btn-info search_button" type="submit">Tìm kiếm</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="content_search">
                    <p>Có <?= $total;?> nhà tuyển dụng chưa đăng bài </p>
                        <table data-toolbar="#toolbar" data-toggle="table" class="table table-hover" id="list_account">
                            <thead style="background: #f1f4f7;">
                            <tr>
                                <th data-field="id" data-sortable="true">ID</th>
                                <th data-field="name" data-sortable="true">Tên nhà tuyển dụng</th>
                                <th data-field="email" data-sortable="true">Email</th>
                                <th data-field="phone" data-sortable="true">Số điện thoại </th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody class="">
                            <?php if(!empty($list_no_new)){
                                foreach($list_no_new as $list){?> 
                                    <tr>
                                        <td class="td-count" scope="row"><?= $list['ntd_id']; ?></td>
                                        <td><a href="<?=url_ntd($list['ntd_alias'], $list['ntd_id'])?>"><?=$list['ntd_company']?></a></td>
                                        <td><?= $list['ntd_email']; ?></td>
                                        <td><?= $list['ntd_phone']; ?></td>
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