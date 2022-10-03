<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quản lý thành phố
            <small>Danh sách thành phố</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Quản lý thành phố</a></li>
            <li><a href="">Danh sách</a></li>
        </ol>
    </section>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body ">
                    <div class="input-group collapse navbar-collapse " id="navbarSupportedContent">
                        <div class="input-group-append ml-2 navbar_option" >
                            <form class="search_form" style=" display:flex;width: 20%;" method="get" action="/admin/city_list">
                                <input class="form-control me-2" name="key" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn btn-info search_button" type="submit">Search</button>
                            </form>
                            <p>Có <?= $total;?> tỉnh thành</p>
                        </div>
                    </div>
                    <div class="content_search">
                        <table data-toolbar="#toolbar" data-toggle="table" class="table table-hover" id="list_account">
                            <thead style="background: #f1f4f7;">
                            <tr>
                                <th data-field="id" data-sortable="true">ID</th>
                                <th data-field="name" data-sortable="true">Tên thành phố</th>
                            </tr>
                            </thead>
                            <tbody class="">
                            <?php if(!empty($list_city)){
                                foreach($list_city as $list){?> 
                                    <tr>
                                        <td class="td-count" scope="row"><?= $list['cit_id']; ?></td>
                                        <td><a href="/admin/edit_city/<?=$list['cit_id']?>"><?=$list['cit_name']?></a></td>
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