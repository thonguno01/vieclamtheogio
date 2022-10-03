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
                            <button style="margin-bottom: 15px;border: 1px solid #979797;background: linear-gradient(to bottom, white 0%, #dcdcdc 100%);border-radius: 5px;"><a href="/admin/add_tag">Thêm mới</a></button>
                            <form class="search_form" style=" display:flex;width: 20%;" method="get" action="/admin//tag/list">
                                <input class="form-control me-2" name="key" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn btn-info search_button" type="submit">Search</button>
                            </form>
                            <p>Có <?= $total;?> ngành nghề</p>
                        </div>
                    </div>
                    <div class="content_search">
                        <table data-toolbar="#toolbar" data-toggle="table" class="table table-hover" id="list_account">
                            <thead style="background: #f1f4f7;">
                            <tr>
                                <th data-field="id" data-sortable="true">ID</th>
                                <th data-field="tag_name" data-sortable="true">Tên tag</th>
                                <th data-field="tag_parent" data-sortable="true">Tag parent</th>
                                <th data-field="date" data-sortable="true">Create Date</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody class="">
                            <?php 
                            $cate = list_category();
                            if(!empty($list_tag)){
                                foreach($list_tag as $list){ 
                                    $i = 0;
                            ?> 
                                <tr>
                                    <td class="td-count" scope="row"><?= $list['tag_id']; ?></td>
                                    <td><?=$list['tag_name'];?></td>
                                    <td><?=($list['tag_parent']>0)?$cate[$list['tag_parent']]['cat_name']:'';?></td>
                                    <td> <?=date('m-d-Y',$list['created_at'])?></td>
                                    <td class="form-group">
                                        <a href="/admin/edit_tag/<? echo $list['tag_id'] ?>" class="btn btn-primary" style="padding: 4px 6px;"><i
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