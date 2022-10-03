  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Bảng điều kiển
        <small>Trang chủ</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class="active">Bảng điều kiển</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?=$total_ntd?></h3>

              <p>Nhà tuyển dụng đăng ký trong ngày</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="/admin/employer/list?ntdid=&ntdname=&ntdemail=&ntdphone=&ntddate=<?=date('Y-m-d',time())?>&ntdsign_up=&ntdstatus=" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?=$total_uv?><sup style="font-size: 20px"></sup></h3>

              <p>Ứng viên đăng ký trong ngày</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="/admin/candidate/list?uvid=&uvname=&uvemail=&uvphone=&uvdate=<?=date('Y-m-d',time())?>&uvsign_up=&uvstatus=" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      
        
      </div>
      <div class="row">
      </div>

    </section>
  </div>

  <div class="control-sidebar-bg"></div>
</div>
