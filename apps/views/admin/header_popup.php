<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="<?php echo PLUG_URL;?>fontawesome-free/css/all.min.css">
	<!-- Other style -->
	<link rel="stylesheet" href="<?php echo PLUG_URL;?>jquery-ui/jquery-ui.min.css">
	<link rel="stylesheet" href="<?php echo PLUG_URL;?>sweetalert2/sweetalert2.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo ASSETS_URL;?>adminlte/css/adminlte.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

	<!-- jQuery -->
	<script src="<?php echo PLUG_URL;?>jquery/jquery.min.js"></script>
	<script src="<?php echo PLUG_URL;?>jquery-ui/jquery-ui.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo PLUG_URL;?>bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- Other JS -->
	<script src="<?php echo PLUG_URL;?>sweetalert2/sweetalert2.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo ASSETS_URL;?>adminlte/js/adminlte.min.js"></script>
<script type="text/javascript">function fnTime(t){if(t){var r=t.split(":");return r[0]+":"+r[1]}return t}function currencyFormate(t){if(null!=t){var r=t.toString().split(".");return r[0].replace(/\B(?=(\d{3})+(?!\d))/g,",")+(r[1]?"."+r[1]:"")}return"0.00"}function dateFormate(t){if(t){var r=t.split("-");return r[2]+"-"+r[1]+"-"+r[0]}return t}function dateTimeFormate(t){if(t){var r=t.split(" "),e=r[0].split("-");return e[2]+"-"+e[1]+"-"+e[0]+" "+r[1]}return t}function dateTimeFormateOnly(t){if(t){var r=t.split(" "),e=r[1].split(":"),i=r[0].split("-");return i[2]+"-"+i[1]+"-"+i[0]+" "+e[0]+":"+e[1]}return t}function vStatus(t){return 1==t?'<i class="text-green fa fa-check"></i>':'<i class="text-red fa fa-file-archive"></i>'}</script>
<body>
