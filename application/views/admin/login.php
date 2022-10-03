<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Log in</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="/cssjsadmin/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/cssjsadmin/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="/cssjsadmin/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="/cssjsadmin/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="/cssjsadmin/plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="/css/validator.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style>
    .has-feedback label~.form-control-feedback{top: 0;}
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a><b>Admin</b></a>
  </div>
  <div class="login-box-body">
    <form id="admin-login">
      <fieldset>
        <div class="form-group has-feedback t-form-group">
            <input type="text" class="form-control admin_user" placeholder="Username" name="username" rules="required" autofocus>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <span class="form-message"></span>
        </div>
        <div class="form-group has-feedback t-form-group">
          <input type="password" class="form-control admin_pass" placeholder="Password" id="password" name="password" rules="required">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          <span class="form-message err_com_pass"></span>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat loginAdminUser">Đăng nhập</button>
          </div>
        </div>
      </fieldset>
    </form>
  </div>
</div>
<script src="/cssjsadmin/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/cssjsadmin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/cssjsadmin/plugins/iCheck/icheck.min.js"></script>
<script src="/js/jquery.validate.min.js"></script>
<script src="/cssjsadmin/dist/js/login.js"></script>
</body>
</html>
