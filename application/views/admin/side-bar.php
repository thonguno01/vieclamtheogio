<?php 
$check = 0;
if ($this->session->userdata('admin')){
    $ad = $this->session->userdata('admin');
    $id_ad = $ad['id'];
    
    $CI=&get_instance();
    $CI->load->model('Admin_model');
    if ($id_ad != 1) {
        $join = array('admin_user_right' => '(adu_admin_module_id  = mod_id AND adu_admin_id = ' . $id_ad . ')');
    }else{
        $join = null;
    }
    $module = $CI->Admin_model->select_data('modules','*',null,$join,array('mod_order'  => "ASC"),null,null,1);
}
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                 <?php if ($admin["image"] != "" || $admin["image"] != null) {?>
                    <img src="/<?=$admin["image"]?>" alt="User Image" class="img-circle">
                <?}else{?>
                    <img src="/images/avatar_qlc_ntd.png" class="img-circle" alt="User Image">
                <?}?>
            </div>
            <div class="pull-left info">
                <p><?php echo $admin['username'] ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU</li>
            <li>
                <a href="/admin/home">
                    <i class="fa fa-folder"></i> <span>Trang chủ</span>
                    <span class="pull-right-container">
            </span>
                </a>

            </li>
            <?
            foreach($module as $row){
                $access_mod_id[] = $row['mod_id'];
                if($row['mod_id'] != 12){
                ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-folder"></i> <span><?= $row['mod_name'] ?></span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        </li>
                        <?
                        $mod_listname = explode('|', $row['mod_listname']);
                        $mod_listfile = explode('|', $row['mod_listfile']);
                        for($i = 0; $i < count($mod_listname); $i++) {
                            ?>
                            <li class=""><a href="/admin/<?=$mod_listfile[$i]?>"><i class="fa fa-circle-o"></i> <?=$mod_listname[$i]?></a>
                            </li>
                            <?
                        }
                        ?>
                    </ul>
                </li>
                <?
            }}
            // if(!in_array($mod_id, $access_mod_id))
            //     redirect('/');


            ?>
        </ul>
    </section>
</aside>