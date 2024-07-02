<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?php echo NAME_APL." | ".$app_title;?></title>
	<link rel="shortcut icon" href="https://survey.actconsulting.co/assets/images/act.png" type="image/x-icon" />

	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="<?php echo PLUG_URL;?>fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="<?php echo PLUG_URL;?>sweetalert2/sweetalert2.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo ASSETS_URL;?>adminlte/css/adminlte.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<!-- IonIcons -->
<!--
	<link rel="stylesheet" href="https://code.ionicframework.com/1.3.3/css/ionic.min.css">
-->

	<!-- jQuery -->
	<script src="<?php echo PLUG_URL;?>jquery/jquery.min.js"></script>
	<script src="<?php echo PLUG_URL;?>jquery-ui/jquery-ui.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo PLUG_URL;?>bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo ASSETS_URL;?>adminlte/js/adminlte.min.js"></script>

	<style type="text/css">
	</style>
	<style>.nav-tabs-custom > .nav-tabs > li.active{border-top-color:#f02 }.blue-tooltip+.tooltip>.tooltip-inner{background-color:#0084FF}.blue-tooltip+.tooltip>.tooltip-arrow{border-bottom-color:#0084FF}.form-control1{background-color:#fff;background-image:none;border:1px solid #ccc;border-radius:4px;box-shadow:0 1px 1px rgba(0,0,0,.075) inset;color:#555;display:block;padding:2px 6px;transition:border-color .15s ease-in-out 0s,box-shadow .15s ease-in-out 0s;float:right}.page-title{font-weight:700}.column{width:33%;float:left}.check1{border:1px dashed #999}.form-actions{clear:left;border:1px solid #ddd;padding:10px;background:#eee;height:50px}.nav-tabs-custom ul.nav li{background-color:#ccc}.labelval{font-size:11pt;vertical-align:baseline;display:inline}.list-group-item{display: list-item;}.modifValue{margin-left:10px;margin-right:-30px;}.btn-hide{display:none}.btn-show{display:none;float: right;padding-right: 20px;}
	.thanks_img {width: 375px;padding: 5%;}
	@media screen and (max-width: 600px) {
	  .thanks_img {
	    width: 100%;padding: 5%;
	  }
	}
	</style>

</head>
<body class="layout-top-nav" style="height: auto; background-color: #222d32;padding:2%">
	<div class="wrapper">
		<div class="container-fluid row justify-content-center">
			<div class="col-8">
				<div class="card">
<?php
$img_url = "https://fakeimg.pl/250x75/?retina=1&text=$nameAccount";
if($logo_account) $img_url = base_url("uploads/$sAccountId/$logo_account");
?>					<center>
					<img src="<?= $img_url;?>" class="card-img-top thanks_img" alt="<?= $nameAccount;?>">
					</center>
					<div class="card-body">
						<h3 class=""><?php echo $page_title;?></h3>
						<p class="card-text"><?php echo $page_content;?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
