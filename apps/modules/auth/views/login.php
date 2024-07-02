<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo NAME_APL; ?></title>
  <link rel="shortcut icon" href="https://survey.actconsulting.co/assets/images/act.png" type="image/x-icon" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo PLUG_URL; ?>fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo PLUG_URL; ?>icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>adminlte/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    body {
      background: url(<?= ASSETS_URL . "images/5315093.jpg"; ?>) no-repeat center center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
    }
  </style>
</head>

<body class="hold-transition login-page" style="height:88vh;background: url(<?= ASSETS_URL . "images/5315093.jpg"; ?>) no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
  <div class="login-box">
    <!--
  <div class="login-logo" style="background: #f0f8ff00;font-weight: bold;">
	<img src="<?= ASSETS_URL . "images/logo_bumn.png"; ?>" class="img-fluid">
  </div>
-->
    <div class="login-logo">
      <h3> <a href="javascript:void(0)"><b><?php echo NAME_APL; ?></b></a></h3>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <div id="msgERROR" align="center" class="text-danger"><?php if ($this->session->userdata('message')) {
                                                                echo "<p class='text-danger'>" . $this->session->userdata('message') . "</p>";
                                                                $this->session->unset_userdata('message');
                                                              }
                                                              ?></div>


        <form action="auth/login" method="post" id="formLogin">
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="identity" id="identity" data-rule-required="true" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control password" placeholder="Password" name="password" id="password" data-rule-required="true">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="icheck-primary">
                <input type="checkbox" id="vpass">
                <label for="vpass">
                  Lihat Password
                </label>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember" name="remember" value="1">
                <label for="vpass">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <!--
      <p class="mb-1">
        <a href="forgot_password">I forgot my password</a>
      </p>
-->
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?php echo PLUG_URL; ?>jquery/jquery.min.js"></script>
  <script src="<?php echo PLUG_URL; ?>jquery-ui/jquery-ui.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo PLUG_URL; ?>bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo PLUG_URL; ?>jquery-validation/jquery.validate.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo ASSETS_URL; ?>adminlte/js/adminlte.min.js"></script>
  <script type="text/javascript">
    $(function() {
      $('#vpass').click(function() {
        $(this).is(':checked') ? $('.password').attr('type', 'text') : $('.password').attr('type', 'password');
      });
    });
  </script>

</html>