<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo NAME_APL;?></title>
	<link rel="icon" href="<?= ASSETS_URL."images/".FAVICON;?>" type="image/x-icon">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo PLUG_URL;?>fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo ASSETS_URL;?>adminlte/css/adminlte.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<style>
body { 
  background: url(<?= ASSETS_URL."images/2663543.jpg";?>) no-repeat center center fixed; 
  -webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;
  background-size: cover;
}
</style>
  </head>
  <body class="hold-transition login-page" style="height:88vh;background: url(<?= ASSETS_URL."images/6271.jpg";?>) no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-8 align-self-center">
				<div class="card text-center">
					<div class="card-header">
						<h2 class="headline text-warning" style="font-size: 100px;font-weight: 300;"><?=$heading;?></h2>
					</div>
					<div class="card-body">
						<h3><?=$message;?>.</h3>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Bootstrap 4 -->
	<script src="<?php echo PLUG_URL;?>bootstrap/js/bootstrap.bundle.min.js"></script>
</html>
