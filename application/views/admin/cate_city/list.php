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
                                <form class="search_form"  method="get" action="/admin/list_job_city">
                                    <select class="" name="category" id="category">
                                        <option value="">Tất cả</option>
                                        <?php
                                            $cate = list_category();
                                            foreach ($cate as $key=>$value):
                                        ?>
                                        <option value="<?=$key?>"><?=$value['cat_name']?></option>
                                        <?php
                                            endforeach;
                                        ?>
                                    </select>
                                    <select class="" name="city" id="city">
                                        <option value="">Tất cả</option>
                                        <?php
                                            $cities = all_city();
                                            foreach ($cities as $key=>$value):
                                        ?>
                                        <option value="<?=$key?>"><?=$value?></option>
                                        <?php
                                            endforeach;
                                        ?>
                                    </select>
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
                                <th data-field="cit_name" data-sortable="true">Thành phố</th>
                                <th data-field="cat_name" data-sortable="true">Ngành nghề</th>
                                <th data-field="meta_title" data-sortable="true">Tiêu đề</th>
                                <th data-field="date" data-sortable="true">Ngày tạo</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody class="">
                            <?php if(!empty($list_cit_job)){
                                foreach($list_cit_job as $list){ $i = 0;?> 
                                   
                                    <tr>
                                        <td class="td-count" scope="row"><?= $list['id']; ?></td>
                                        <td><?=get_city($list['cit_id']);?></td>
                                        <td><?=$cate[$list['cat_id']]['cat_name'];?></td>
                                        <td><?=$list['meta_title']?></td>
                                        <td> <?=date('m-d-Y',$list['created_at'])?></td>
                                        <td class="form-group">
                                            <a href="/admin/edit_job_city/<?=$list['cat_id']?>/<?=$list['cit_id']?>" class="btn btn-primary" style="padding: 4px 6px;"><i
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