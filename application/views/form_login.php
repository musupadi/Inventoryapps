<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="<?= base_url() ?>/img/logo-pu.png">
  <title>Inventory | Log in </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url();?>asset/AdminLTE-2.4.18/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>asset/AdminLTE-2.4.18/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>asset/AdminLTE-2.4.18/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>asset/AdminLTE-2.4.18/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url();?>asset/AdminLTE-2.4.18/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
  <div class="login-box" style="margin-top: 100px">
  <h1 style="text-align: center; margin-bottom: 25px"><b>Login</b> Account</h1>

  <!-- /.login-logo -->
    <div class="login-box-body" style="border-radius: 10px">
      <div class="box-header with-border">
        <div>
            <img class="img-responsive" src="<?php echo base_url()?>img/logo.jpg" alt="User profile picture" width="150px" style="margin: auto;">
        </div>
    </div>
    <div class="login-box-body">
      <div class="box-header with-border">
      <form action="<?php echo base_url('Login/check_login')?>" method="post">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Username" name="username">
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
          <p><?php echo form_error('username'); ?></p>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          <p><?php echo form_error('password'); ?></p>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          
          <!-- /.col -->
        </div>
        <div class="center" style="text-align: center">
          <p style="color: red; font-style: italic; margin-top: 10px"><?php echo $this->session->flashdata('pesan'); ?></p>
        </div>
      </form>
      <div class="register" style="text-align: center">
        <a href="<?= base_url('Login/register')?>">Create an Account</a>
      </div>
      </div>
    <p class="text-light-blue text-center">Copyright @ 2020 All Right Reserved</p>


  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url();?>asset/AdminLTE-2.4.18/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>asset/AdminLTE-2.4.18/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url();?>asset/AdminLTE-2.4.18/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
