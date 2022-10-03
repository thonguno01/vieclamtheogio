<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quản lý tin tuyển dụng
            <small>Danh sách</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Quản lý tin tuyển dụng</a></li>
            <li><a href="">Danh sách</a></li>
        </ol>
    </section>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body ">
                    <div class="input-group collapse navbar-collapse " id="navbarSupportedContent">
                        <div class="input-group-append ml-2 navbar_option" >
                            <button style="margin-bottom: 15px;border: 1px solid #979797;background: linear-gradient(to bottom, white 0%, #dcdcdc 100%);border-radius: 5px;"><a href="/admin/add_new">Thêm mới</a></button>
                            <div class="input-group-append search_area ml-2 navbar_option" >
                                <form class="search_form"  method="get" action="/admin/new_list">
                                    <input class="search_box me-2" name="new_id" type="search" placeholder="Tìm theo id" aria-label="Search">
                                    <input class="search_box me-2" name="new_title" type="search" placeholder="Tìm theo tiêu đề" aria-label="Search">
                                    <input class="search_box me-2" name="new_user" type="search" placeholder="Tìm theo người đăng" aria-label="Search">
                                    <input class="search_box me-2" name="new_date" type="date" placeholder="Tìm theo ngày đăng" aria-label="Search">
                                    <button class="btn btn-info search_button" type="submit">Tìm kiếm</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="content_search">
                        <p>Có <?= $total;?> tin tuyển dụng </p>

                        <table data-toolbar="#toolbar" data-toggle="table" class="table table-hover" id="list_account">
                            <thead style="background: #f1f4f7;">
                            <tr>
                                <th data-field="id" data-sortable="true">ID</th>
                                <th data-field="title" data-sortable="true">Tiêu đề</th>
                                <th data-field="name" data-sortable="true">Người đăng</th>
                                <th data-field="date" data-sortable="true">Ngày đăng</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody class="">
                            <?php if(!empty($list_new)){
                                foreach($list_new as $list){ $i = 0;?> 
                                    <tr>
                                        <td class="td-count" scope="row"><?= $list['new_id']; ?></td>
                                        <td><a target="_blank" href="<?=url_vieclam($list['new_alias'], $list['new_id'])?>"><?=$list['new_title']?></a></td>
                                        <td> <?=$list['ntd_company']?></td>
                                        <td><?=date('d-m-Y',$list['new_create_time']);?></td>
                                        <td class="form-group">
                                            <a href="/admin/edit_new/<?php echo $list['new_id']; ?>" class="btn btn-primary" style="padding: 4px 6px;"><i
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