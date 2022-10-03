<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quản lý ngành nghề
            <small>Danh sách ngành nghề</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Quản lý ngành nghề</a></li>
            <li><a href="">Danh sách ngành nghề</a></li>
        </ol>
    </section>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body ">
                    <div class="input-group collapse navbar-collapse " id="navbarSupportedContent">
                        <div class="input-group-append ml-2 navbar_option" >
                            <button style="margin-bottom: 15px;border: 1px solid #979797;background: linear-gradient(to bottom, white 0%, #dcdcdc 100%);border-radius: 5px;"><a href="/admin/add_job">Thêm mới</a></button>
                            <div class="input-group-append search_area ml-2 navbar_option" >
                                <form class="search_form"  method="get" action="/admin/job_list">
                                    <input class="search_box me-2" name="cat_id" type="search" placeholder="Tìm theo id" aria-label="Search">
                                    <input class="search_box me-2" name="cat_name" type="search" placeholder="Tìm theo tên ngành nghề" aria-label="Search">
                                    <button class="btn btn-info search_button" type="submit">Tìm kiếm</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="content_search">
                    <p>Có <?= $total;?> ngành nghề</p>
                        <table data-toolbar="#toolbar" data-toggle="table" class="table table-hover" id="list_account">
                            <thead style="background: #f1f4f7;">
                            <tr>
                                <th data-field="id" data-sortable="true">ID</th>
                                <th data-field="cat_name" data-sortable="true">Tên ngành nghề</th>
                                <th data-field="cat_alias" data-sortable="true">Alias</th>
                                <th data-field="meta_description" data-sortable="true">Mô tả</th>
                                <th data-field="date" data-sortable="true">Create Date</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody class="">
                            <?php if(!empty($list_cat)){
                                foreach($list_cat as $list){ $i = 0;?> 
                                   
                                    <tr>
                                        <td class="td-count" scope="row"><?= $list['cat_id']; ?></td>
                                        <td><?=$list['cat_name'];?></td>
                                        <td><?=$list['cat_alias'];?></td>
                                        <td style="width:50%;"><?=$list['meta_description'];?></td>
                                        <td> <?=date('m-d-Y',$list['created_at'])?></td>
                                        <td class="form-group">
                                            <a href="/admin/edit_job/<? echo $list['cat_id'] ?>" class="btn btn-primary" style="padding: 4px 6px;"><i
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