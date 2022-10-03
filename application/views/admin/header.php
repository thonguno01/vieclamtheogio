<?php
// $admin = $this->session->userdata('admin');
$admin = $this->Models->select_where_and('*', 'tbl_admin', ['username' =>  $_COOKIE['username']])->row_array();
// echo "<pre>";
// var_dump($admin);
// die;
?>
<header class="main-header">
    <a href="index2.html" class="logo">
        <span class="logo-mini"><b>A</b>D</span>
        <span class="logo-lg"><b>Admin</b></span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <style type="text/css">
                    .nav>li>a>img {
                        float: left;
                        width: 25px;
                        height: 25px;
                        border-radius: 50%;
                        margin-right: 10px;
                        margin-top: -2px;
                        max-width: none;
                    }
                </style>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php if ($admin["image"] != "" || $admin["image"] != null) { ?>
                            <img src="/<?= $admin["image"] ?>" alt="User Image" class="img-circle">
                        <? } else { ?>
                            <img src="/images/avatar_qlc_ntd.png" class="img-circle" alt="User Image">
                        <? } ?>
                        <span class="hidden-xs"><?php echo $admin['username'] ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <?php if ($admin["image"] != "" || $admin["image"] != null) { ?>
                                <img src="/<?= $admin["image"] ?>" alt="User Image" class="img-circle">
                            <? } else { ?>
                                <img src="/images/avatar_qlc_ntd.png" class="img-circle" alt="User Image">
                            <? } ?>
                            <p>
                                <?php echo $admin['username'] ?>
                                <small><?php echo date("d/m/Y", $admin["create_date"]); ?></small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="/admin/change_pass" class="btn btn-default btn-flat">Đổi mật khẩu</a>
                            </div>
                            <div class="pull-right">
                                <a href="/admin/logout" class="btn btn-default btn-flat" onclick="return confirm('Bạn có chắc muốn đăng xuất không?')">Đăng xuất</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li>
                </li>
            </ul>
        </div>
    </nav>
</header>