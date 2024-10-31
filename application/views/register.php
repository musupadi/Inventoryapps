<html><head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="<?= base_url() ?>/img/logo-pu.png">
  <title>Registration Page</title>
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
  <style>
    .custom-file-upload {
      border: 1px solid #ccc;
      display: inline-block;
      padding: 6px 12px;
      cursor: pointer;
      background-color: #f9f9f9;
      color: #333;
      border-radius: 4px;
      font-family: Arial, sans-serif;
    }

    .custom-file-upload:hover {
      background-color: #e9e9e9;
    }

    /* Hide the actual file input */
    input[type="file"] {
      display: none;
    }
  </style>
</head>
<body class="hold-transition register-page">
<div class="register-box" style="margin-top: 40px">
  <div class="register-logo">
    <p><b>User</b> Registration</p>
  </div>

  <div class="register-box-body" style="border-radius: 7px; margin-bottom: 100px">
    <?php echo form_open_multipart('Login/register')?>
    <form action="<?php echo base_url('Login/register')?>" method="post">
      <div class="form-group has-feedback">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" placeholder="Name" id="name">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <label for="username">Username</label>
        <input type="text" class="form-control" name = "username" placeholder="Username" id="username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" placeholder="Password" id="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" placeholder="Email" id="email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <label for="department">Department</label>
        <input type="department" class="form-control" name="department" placeholder="Department" id="department">
        <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <label for="phone_number">Phone Number</label>
        <input type="text" class="form-control" name="phone_number" placeholder="Phone Number" id="phone_number">
        <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <label for="file-upload" class="custom-file-upload">
            <i class="fa fa-cloud-upload"></i> Upload Photo Profile</label>
          <input type="file" class="form-control" name="gambar" size="20" id="file-upload">
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <div class="login" style="text-align: center">
      <a href="<?php echo base_url("login") ?>" class="text-center">Already have an Account?</a>
    </div>
  </div>
  <!-- /.form-box -->
</div>
<div style="height: 15px"></div>
<!-- /.register-box -->

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


</body></html>