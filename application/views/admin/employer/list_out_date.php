
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
                                <form class="search_form"  method="get" action="/admin/employer_out_date">
                                    <input class="search_box me-2" name="newid" type="search" placeholder="Tìm theo id" aria-label="Search">
                                    <input class="search_box me-2" name="newtitle" type="search" placeholder="Tìm theo tin" aria-label="Search">
                                    <input class="search_box me-2" name="newuser" type="search" placeholder="Tìm theo tên nhà tuyển dụng" aria-label="Search">
                                    <input class="search_box me-2" name="newcreate" type="date" placeholder="Tìm theo ngày đăng ký" aria-label="Search">  
                                    <input class="search_box me-2" name="newoutdate" type="date" placeholder="Tìm theo ngày hết hạn" aria-label="Search">  
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
                                    
                                    <button class="btn btn-info search_button" type="submit">Tìm kiếm</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="content_search">
                    <h4>Có <?= $total;?> nhà tuyển dụng có bài viết sắp hết hạn </h4>
                        <table data-toolbar="#toolbar" data-toggle="table" class="table table-hover" id="list_account">
                            <thead style="background: #f1f4f7;">
                            <tr>
                                <th data-field="id" data-sortable="true">ID</th>
                                <th data-field="name" data-sortable="true">Tên nhà tuyển dụng</th>
                                <th data-field="role" data-sortable="true">Bài viết</th>
                                <th data-field="role" data-sortable="true">Ngày đăng</th>
                                <th data-field="role" data-sortable="true">Thời hạn</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody class="">
                            <?php if(!empty($list_out_date)){
                                foreach($list_out_date as $list){ $i = 0;?> 
                                    <tr>
                                        <td class="td-count" scope="row"><?= $list['new_id']; ?></td>
                                        <td><a href="<?=url_ntd($list['ntd_alias'], $list['ntd_id'])?>"><?=$list['ntd_company']?></a></td>
                                        <td><a target="_blank" href="<?=url_vieclam($list['new_alias'], $list['new_id'])?>"><?=$list['new_title']?></a></td>
                                        <td><?=date('d-m-Y',$list['new_create_time']);?></td>
                                        <td>
                                            <?php 
                                                echo time_elapsed_string2($list['new_han_nop'],'');   
                                            ?>
                                        </td>
                                        <td class="form-group">
                                            <a href="edit/<?php echo $list['new_id']; ?>" class="btn btn-primary" style="padding: 4px 6px;"><i
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