<?php defined('BASEPATH') OR exit('No direct script access allowed');
$wrapper = '#222d32';//'#f02';
$tab_active_color = '#3c8dbc';//'#f02';
$color_content_header = '#FFF';
$btn_mulai = 'btn-info';
$box_medium = 'bg-primary';
$box_small = 'bg-yellow';
$btn_next = 'btn-info';
$btn_next1 = 'btn-success';
//---- MODAL PRIO
$bg_header = '#00acd6';
$color_text_header = '$FFF';
$bg_btn = '#fff';
$color_text_btn = '#00acd6';
$btn_modal = 'btn-info';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?php echo NAME_APL." | ".$app_title;?></title>
	<link rel="shortcut icon" href="https://survey.actconsulting.co/assets/images/act.png" type="image/x-icon" />

	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="<?php echo PLUG_URL;?>fontawesome-free/css/all.min.css">
	<!-- Other style -->
	<link rel="stylesheet" href="<?php echo PLUG_URL;?>jquery-ui/jquery-ui.min.css">
	<link rel="stylesheet" href="<?php echo PLUG_URL;?>sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="<?php echo PLUG_URL;?>fancybox/source/jquery.fancybox.css">
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
	<!-- Other JS -->
	<script src="<?php echo PLUG_URL;?>sweetalert2/sweetalert2.min.js"></script>
	<script src="<?php echo PLUG_URL;?>fancybox/source/jquery.fancybox.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo ASSETS_URL;?>adminlte/js/adminlte.min.js"></script>

	<style type="text/css">
	</style>
	<style>.nav-tabs-custom > .nav-tabs > li.active{border-top-color:#f02 }.blue-tooltip+.tooltip>.tooltip-inner{background-color:#0084FF}.blue-tooltip+.tooltip>.tooltip-arrow{border-bottom-color:#0084FF}.form-control1{background-color:#fff;background-image:none;border:1px solid #ccc;border-radius:4px;box-shadow:0 1px 1px rgba(0,0,0,.075) inset;color:#555;display:block;padding:2px 6px;transition:border-color .15s ease-in-out 0s,box-shadow .15s ease-in-out 0s;float:right}.page-title{font-weight:700}.column{width:33%;float:left}.check1{border:1px dashed #999}.form-actions{clear:left;border:1px solid #ddd;padding:10px;background:#eee;height:50px}.nav-tabs-custom ul.nav li{background-color:#ccc}.labelval{font-size:11pt;vertical-align:baseline;display:inline}.list-group-item{display: list-item;}.modifValue{margin-left:10px;margin-right:-30px;}.btn-hide{display:none}.btn-show{display:none;float: right;padding-right: 20px;}</style>

</head>
<?php
$img_url = "http://placehold.it/150x50?text=$nameAccount";
if($logo_account) $img_url = base_url("uploads/$sAccount/$logo_account");
?>
<body class="layout-top-nav" style="height: auto; background-color: #222d32;" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
	<div class="wrapper">
		<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
			<div class="container-fluid">
				<a class="navbar-brand" href="#">
				  <img src="<?= $img_url;?>" alt="" width="175px">
				</a>
				<div class="collapse navbar-collapse" id="navbarResponsive">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item active">
						<a class="nav-link" href="javascript:void(0);" onClick="fnBack()">Back Demography</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="clearfix">&nbsp;</div>
<?php
$setting = json_decode($set_demo['f_setting'],true);
$personal = json_decode($set_demo['f_page_personal'],true);
$leaderc = json_decode($set_demo['f_page_leaderc'],true);
$leaderd = json_decode($set_demo['f_page_leaderd'],true);
$qopen = json_decode($set_demo['f_page_qopen'],true);
//opn($personal);
?>					
		<div class="container-fluid row">
			<div class="col-md-12">
				<div class="nav-tabs-custom" style="background-color: #FFF;">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item" role="presentation">
							<a class="nav-link" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true"><?php echo $leaderc['judul'][SLANGUAGE];?></a>
						</li>
					</ul>
<?php
//opn($set_demo);
?>					
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
							<form id="frmPersonal" action="/" method="POST">
								<div class="row">
									<div class="col-12" style="padding-top: 1%;padding-left: 1%;">
									<b><?php echo $this->lang->line('panduan');?> :</b>
									<?php echo $leaderc[SLANGUAGE];?>
									</div>
								</div>
								<hr>
								<div class="row">
									<div id="frmSurveyPersonal" class="row col-9 modifValue"></div>
									<div class="col-xs-12 col-md-3">
										<div class="small-box <?php echo $box_medium;?>" >
											<div class="inner">
												  <h3><span id="counter1">0</span></h3>
												  <p><?php echo $this->lang->line('dipilih');?></p>
											</div>
											<div class="icon"><i class="ion ion-checkmark"></i></div>
										</div> <!-- .small-box -->
										
										<div class="small-box <?php echo $box_small;?>">
											<div class="widget-user-header <?php echo $box_small;?>" style="padding:5px;">
												<h5 class="title_pilihan1"><?php echo $this->lang->line('dipilih1');?> <i class="glyphicon glyphicon-ok"></i></h5>
											</div>
											<div class="box-footer no-padding">
												<div id="slotSource" class="slotSourcePV" style='border:solid 1px #F5B4FF;height:100%;' ></div>	
											</div>
										</div> <!-- .small-box -->
									</div> <!-- .col-xs-12 .col-md-3 -->
									<div class="col align-self-end" id="panel-button1">
										<span id="button1" style="display:none;float:right;padding-right:20px;"><button id="btnSubmit1" class="btn <?php echo $btn_next1;?>" /><i class=""></i> <?php echo $this->lang->line('lanjut2');?></button></span>
									</div>
								</div> <!-- row -->
								<div class="clearfix">&nbsp;</div>
							</form>
						</div> <!-- .tab-pane -->
						
						<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
							<form id="frmLeaderC" action="/" method="POST">
								<div class="row">
									<div class="col-12" style="padding-top: 1%;padding-left: 1%;">
									<b><?php echo $this->lang->line('panduan');?> :</b>
									<?php echo $leaderc[SLANGUAGE];?>
									</div>
								</div>
								<hr>
								<div class="row">
									<div id="frmSurveyLeaderC" class="row col-9 modifValue"></div>
									<div class="col-xs-12 col-md-3">
										<div class="small-box <?php echo $box_medium;?>" >
											<div class="inner">
												  <h3><span id="counter2">0</span></h3>
												  <p><?php echo $this->lang->line('dipilih');?></p>
											</div>
											<div class="icon"><i class="ion ion-checkmark"></i></div>
										</div> <!-- .small-box -->
										
										<div class="small-box <?php echo $box_small;?>">
											<div class="widget-user-header <?php echo $box_small;?>" style="padding:5px;">
												<h5 class="title_pilihan2"><?php echo $this->lang->line('dipilih1');?> <i class="glyphicon glyphicon-ok"></i></h5>
											</div>
											<div class="box-footer no-padding">
												<div id="slotSource" class="slotSourceLC" style='border:solid 1px #F5B4FF;height:100%;' ></div>	
											</div>
										</div> <!-- .small-box -->
									</div> <!-- .col-xs-12 .col-md-3 -->
									<div class="col align-self-end" id="panel-button2">
										<span id="button2" style="display:none;float:right;padding-right:20px;"><button id="btnSubmit2" class="btn <?php echo $btn_next1;?>" /><i class=""></i> <?php echo $this->lang->line('lanjut2');?></button></span>
									</div>
								</div> <!-- row -->
								<div class="clearfix">&nbsp;</div>
							</form>
						</div>  <!-- .tab-pane -->
						
						<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
							<form id="frmLeaderD" action="/" method="POST">
								<div class="row">
									<div class="col-12" style="padding-top: 1%;padding-left: 1%;">
									<b><?php echo $this->lang->line('panduan');?> :</b>
									<?php echo $leaderd[SLANGUAGE];?>
									</div>
								</div>
								<hr>
								<div class="row">
									<div id="frmSurveyLeaderD" class="row col-9 modifValue"></div>
									<div class="col-xs-12 col-md-3">
										<div class="small-box <?php echo $box_medium;?>" >
											<div class="inner">
												  <h3><span id="counter3">0</span></h3>
												  <p><?php echo $this->lang->line('dipilih');?></p>
											</div>
											<div class="icon"><i class="ion ion-checkmark"></i></div>
										</div> <!-- .small-box -->
										
										<div class="small-box <?php echo $box_small;?>">
											<div class="widget-user-header <?php echo $box_small;?>" style="padding:5px;">
												<h5 class="title_pilihan3"><?php echo $this->lang->line('dipilih1');?> <i class="glyphicon glyphicon-ok"></i></h5>
											</div>
											<div class="box-footer no-padding">
												<div id="slotSource" class="slotSourceLD" style='border:solid 1px #F5B4FF;height:100%;' ></div>	
											</div>
										</div> <!-- .small-box -->
									</div> <!-- .col-xs-12 .col-md-3 -->
									<div class="col align-self-end" id="panel-button3">
										<span id="button3" style="display:none;float:right;padding-right:20px;"><button id="btnSubmit3" class="btn <?php echo $btn_next1;?>" /><i class="fas fa-paper-plane"></i> <?php echo $this->lang->line('lanjut3');?></button></span>
									</div>
								</div> <!-- row -->
								<div class="clearfix">&nbsp;</div>
							</form>
						</div>  <!-- .tab-pane -->

						<div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab3-tab">
							<form id="frmQopen" action="/" method="POST">
								<div class="row">
									<div class="col-12" style="padding-top: 1%;padding-left: 1%;">
									<b><?php echo $this->lang->line('panduan');?> :</b>
									<?php echo $qopen[SLANGUAGE];?>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-11 col-12" style="margin-left:1%">
										<?php echo str_replace('{nama_leader}',$nama_leader,$qopen['question'][SLANGUAGE]);?>
										<textarea class="form-control" name="qopen" id="qopen"></textarea>
									</div>
									<div class="col-12">&nbsp;&nbsp;</div>
									<div class="col align-self-end" id="panel-button4" align="center">
										<span id="button4" style="padding-right:20px;"><button id="btnSubmit4" class="btn <?php echo $btn_next1;?>" /><i class="fas fa-paper-plane"></i> <?php echo $this->lang->line('kirim');?></button></span>
									</div>
								</div> <!-- row -->
								<div class="clearfix">&nbsp;</div>
							</form>
						</div>  <!-- .tab-pane -->
												
					</div>			
				</div>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
	</div> <!-- wrapper -->

<!-- Modal -->
<div id="myWelcome" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header row" align="center">
			<h3 class="modal-title col-12"><?php echo $setting['f_page_welcome'][SLANGUAGE]['title'];?></h3>
			<br/>
			<div class="col-12">
			<p class=""><?php echo $setting['f_page_welcome'][SLANGUAGE]['content'];?></p>
			</div>
      </div>
      <div class="modal-body">
			<h3><?php echo $setting['f_page_howto'][SLANGUAGE]['title'];?></h3>
			<p><?php echo $setting['f_page_howto'][SLANGUAGE]['content'];?></p>
      </div>
      <div class="modal-footer row" style="justify-content: center;">
		<button type="button" class="btn <?php echo $btn_mulai;?>" data-dismiss="modal"><i class="fa fa-forward"></i> <?php echo $this->lang->line('mulai');?></button>
      </div>
    </div>

  </div>
</div>

<!-- pilih 10 prioritas-->
<div id="myInfoPrioritas" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" align="center" style="background: <?php echo $bg_header;?>;color: <?php echo $color_text_header;?>;font-weight: bolder;justify-content:center;">
			<h3 class="modal-title">PERHATIAN</h3>
      </div>
      <div class="modal-body" align="center">
			<p style="font-size: 110%;"><b>URUTKAN</b> prioritas nilai / perilaku yang Anda pilih, dengan mencentang kolom yang tersedia di sebelah nilai / perilaku. Di mana nomor urut 1 adalah nilai yang <b>SANGAT DOMINAN</b> Anda rasakan, hingga nomor urut 10 yaitu nilai yang <b>PALING KURANG DOMINAN</b> Anda rasakan.</p>
      </div>
      <div class="modal-footer" align="center" style="justify-content:center;">
        <button type="button" class="btn <?php echo $btn_modal;?>" data-dismiss="modal" style="background: <?php echo $bg_btn;?>;color: <?php echo $color_text_btn;?>;" >OK</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal Demograp -->
<div class="modal fade login-dialog" id="myDemograp" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php
//$c_t = microtime(true);
//$c_micro = sprintf("%06d",($c_t - floor($c_t)) * 1000000);
//$c_datetime = new DateTime( date('Y-m-d H:i:s.'.$c_micro, $c_t) );
//$yourcode = md5($sAccount.$eventId.$c_datetime->format("YmdHisu"));
?>
<script>
function setCookie(e,o,t){var i=new Date;i.setTime(i.getTime()+24*t*60*60*1e3);var n="expires="+i.toUTCString();document.cookie=e+"="+o+";"+n+";path=/"}function getCookie(e){for(var o=e+"=",t=document.cookie.split(";"),i=0;i<t.length;i++){for(var n=t[i];" "==n.charAt(0);)n=n.substring(1);if(0==n.indexOf(o))return n.substring(o.length,n.length)}return""}function checkCode(e){getCookie("tokensurveyleaderunik")||setCookie("tokensurveyleaderunik",e,7)}checkCode("<?php echo $yourcode;?>");var mycodesurvey =getCookie('tokensurveyleaderunik');
var tab_leader_current = '<?php echo str_replace("\r\n", ' ', $leaderc['judul'][SLANGUAGE]);?>';
var tab_leader_desire = '<?php echo str_replace("\r\n", ' ', $leaderd['judul'][SLANGUAGE]);?>';
var tab_qopen = '<?php echo str_replace("\r\n", ' ', $qopen['judul'][SLANGUAGE]);?>';
var urutan		= [1,2,3,4,5,6,7,8,9,10];var nilainya	= [10,9,8,7,6,5,4,3,2,1];var xcol		= 3;var temp_values = [];
function perhatian_modal(nomor) {
	Swal.fire({
		title: 'PERHATIAN',
		html: '<p style="font-size: 110%;text-align: justify;">Apakah anda <b>SUDAH YAKIN</b>?<br/><br/>Bila Anda belum yakin, silakan klik tombol <b>TIDAK YAKIN</b> untuk mengecek kembali 10 pilihan nilai / perilaku yang Anda pilih. Jika sudah selesai, maka Anda dapat langsung mengurutkan prioritas nilai / perilaku.<br/><br/>Bila Anda sudah yakin silakan klik tombol <b>YAKIN</b> dan Anda dapat langsung mengurutkan prioritas nilai / perilaku.<br/></p><p style="font-size: 110%;text-align: justify;"><b><i>Notes</i></b> :<br/><b>URUTKAN</b> prioritas nilai / perilaku yang Anda pilih, dengan mencentang kolom yang tersedia di sebelah nilai / perilaku. Di mana nomor urut 1 adalah nilai yang <b>SANGAT DOMINAN</b> Anda rasakan, hingga nomor urut 10 yaitu nilai yang <b>PALING KURANG DOMINAN</b> Anda rasakan.</p>',
		icon: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Tidak Yakin',
		confirmButtonText: 'Yakin'
	}).then((result) => {
		if(result.value) $('html, body').animate({ scrollTop: $("#counter"+nomor).offset().top   }, 1000);
	});	
}

$(document).ready(function(){
	$("#myWelcome").modal('show');
	
	$('#tab1-tab').addClass('active');
	$('#tab2').addClass('show active');

	/* get value data */
	$.getJSON('<?php echo site_url('u/fnValueDataAll/'.SLANGUAGE.'/'.$sAccount);?>', function(data){
		var personal, budaya;
		for(var c=0; c< xcol; c++){
			/* personal */
			$('#frmSurveyPersonal').append('<div id="col-sp'+c+'" class="col-md-4"></div>');
			/* Leader saat ini */
			$('#frmSurveyLeaderC').append('<div id="col-slc'+c+'" class="col-md-4"></div>');
			/* Leader yang diharapkan */
			$('#frmSurveyLeaderD').append('<div id="col-sld'+c+'" class="col-md-4">');
		}

		personal = data.personal;
		percolumn = Math.ceil(personal.length/xcol);
		var p = 0; var number = 1;
		$('ol#ol-sp'+p).attr('start',number);
		$.each(personal, function(k,v){
			var pv_html = '<div class="col-2">'+number+') </div>';
				pv_html += '<div class="col-1"><input type="checkbox" name="choose[]" class="pv'+number+' check_pv" onClick="fnCountPV(\'' + v.f_value_name + '\')"  value="'+ v.f_value_id +'_'+ v.f_value_name +'" data-nomor="'+number+'" ></div>';
				pv_html += '<label class="col-9 labelval" onclick="diklik(\'pv\','+number+')">'+v.f_value_name+'</label>';
			$('div#col-sp'+p).append('<div class="row checkbox pv">'+pv_html+'</div>'); 
			number++;
			if(((number) % (percolumn+1)) == 0) { p++; }
		});

		budaya = data.organisasi;
		percolumn1 = Math.ceil(budaya.length/xcol);
		var d = 0; var number = 1;
		$.each(shuffleArray(budaya), function(k,v){
			var lc_html = '<div class="col-2">'+number+') </div>';
				lc_html += '<div class="col-1"><input type="checkbox" name="choose[]" class="lc'+number+'" onclick="fnCountLC(\'' + v.f_value_name + '\')" value="'+ v.f_value_id +'_'+ v.f_value_name +'" data-nomor="'+number+'" ></div>';
				lc_html += '<label class="col-9 labelval" onclick="diklik(\'lc\','+number+')">'+v.f_value_name+'</label>';

			$('div#col-slc'+d).append('<div class="row checkbox lc">'+lc_html+'</div>'); 

			number++;
			if(((number) % (percolumn1+1)) == 0) { d++; }
		});

		percolumn1 = Math.ceil(budaya.length/xcol);
		var d = 0; var number = 1;
		$.each(shuffleArray(budaya), function(k,v){
			var ld_html = '<div class="col-2">'+number+') </div>';
				ld_html += '<div class="col-1"><input type="checkbox" name="choose[]" class="ld'+number+'" onclick="fnCountLD(\'' + v.f_value_name + '\')" value="'+ v.f_value_id +'_'+ v.f_value_name +'" data-nomor="'+number+'" ></div>';
				ld_html += '<label class="col-9 labelval" onclick="diklik(\'ld\','+number+')">'+v.f_value_name+'</label>';

			$('div#col-sld'+d).append('<div class="row checkbox ld">'+ld_html+'</div>'); 

			number++;
			if(((number) % (percolumn1+1)) == 0) { d++; }
		});

		$('.pv input').on('click',function(){
			var t = $(this).prop( "checked" );var dt = $(this).attr('data-nomor');
			if(t)-1===temp_values.indexOf(dt)&&temp_values.push(dt);else if(!t)for(var key in temp_values)temp_values[key]==dt&&temp_values.splice(key,1);
		});
		$('.lc input').on('click',function(){
			var t = $(this).prop( "checked" );var dt = $(this).attr('data-nomor');
			if(t)-1===temp_values.indexOf(dt)&&temp_values.push(dt);else if(!t)for(var key in temp_values)temp_values[key]==dt&&temp_values.splice(key,1);
		});
		$('.ld input').on('click',function(){
			var t = $(this).prop( "checked" );var dt = $(this).attr('data-nomor');
			if(t)-1===temp_values.indexOf(dt)&&temp_values.push(dt);else if(!t)for(var key in temp_values)temp_values[key]==dt&&temp_values.splice(key,1);
		});
	});	
	
	$('#btnSubmit1').on('click',function(e){
		e.preventDefault();
		$("#btnSubmit1").prop('disabled', true);
		$("#btnSubmit1 i").attr('class','fa fa-spinner fa-spin fa-1x fa-fw'); 
		var url = "<?php echo site_url("u/fnSaveValue/personal/".$sAccount."/".$alias."/".$eventId."/1");?>?mycode="+mycodesurvey;
		var rec = $('#frmPersonal').serialize();
		$.post(url, rec, function(f){
			if(f.status == 200) {
				temp_values = [];
				$('#tab1').removeClass('show active');$('#tab2').addClass('show active');
				$('#tab1-tab').html(tab_leader_current); 
				window.scrollTo(0, 0);
				$('#frmPersonal input[type="checkbox"]').prop('checked', false);
				$( ".slotSourcePV" ).html("");
				$('.tooltip').tooltip('hide');
				$("span#counter2").text( 0 );
				$("span#button2").hide();
				$("#button1").hide();
			} else {
				$('#btnSubmit1').removeAttr('disabled');
				$("#btnSubmit1 i").attr('class','');
			}
		},'json').fail(function(g){
			//BootstrapDialog.alert({type:BootstrapDialog.TYPE_DANGER,title:'Information',message:'Terjadi kesalahan, silahkan coba klik kembali'});
			$('#btnSubmit1').removeAttr('disabled');
			$("#btnSubmit1 i").attr('class','');
		});
		return false;
	});

	$('#btnSubmit2').on('click',function(e){
		e.preventDefault();
		$("#btnSubmit2").prop('disabled', true);
		$("#btnSubmit2 i").attr('class','fas fa-spinner fa-spin fa-1x fa-fw'); 
		var url = "<?php echo site_url("u/fnSaveValue/leaderc/".$sAccount."/".$alias."/".$eventId."/2");?>?mycode="+mycodesurvey;
		var rec = $('#frmLeaderC').serialize();
		$.post(url, rec, function(f){
			if(f.status == 200) {
				temp_values = [];
				$('#tab2').removeClass('show active');$('#tab3').addClass('show active');
				$('#tab1-tab').html(tab_leader_desire); 
				window.scrollTo(0, 0);
				$('#frmLeaderC input[type="checkbox"]').prop('checked', false);
				$( ".slotSourceLC" ).html("");
				$('.tooltip').tooltip('hide');
				$("span#counter3").text( 0 );
				$("span#button3").hide();
				$("#button2").hide();
			} else {
				$('#btnSubmit2').removeAttr('disabled');
				$("#btnSubmit2 i").attr('class','');
			}
		},'json').fail(function(g){
			//BootstrapDialog.alert({type:BootstrapDialog.TYPE_DANGER,title:'Information',message:'Terjadi kesalahan, silahkan coba klik kembali'});
			$('#btnSubmit2').removeAttr('disabled');
			$("#btnSubmit2 i").attr('class','');
		});
		return false;
	});

	$('#btnSubmit3').on('click',function(e){
		e.preventDefault();
		$("#btnSubmit3").prop('disabled', true);
		$("#btnSubmit3 i").attr('class','fas fa-spinner fa-spin fa-1x fa-fw'); 
		var url = "<?php echo site_url("u/fnSaveValue/leaderd/".$sAccount."/".$alias."/".$eventId."/3");?>?mycode="+mycodesurvey;
		var rec = $('#frmLeaderD').serialize();
		$.post(url, rec, function(f){
			if(f.status == 200) {
				temp_values = [];
				$('#tab3').removeClass('show active');$('#tab4').addClass('show active');
				$('#tab1-tab').html(tab_qopen); 
				window.scrollTo(0, 0);
				$('#frmLeaderC input[type="checkbox"]').prop('checked', false);
				$( ".slotSourceLD" ).html("");
				$('.tooltip').tooltip('hide');
				$("span#counter4").text( 0 );
				//$("span#button4").hide();
				$("#button3").hide();
			} else {
				$('#btnSubmit3').removeAttr('disabled');
				$("#btnSubmit3 i").attr('class','');
			}
		},'json').fail(function(g){
			$('#btnSubmit3').removeAttr('disabled');
			$("#btnSubmit3 i").attr('class','');
		});
		return false;
	});

	$('#btnSubmit4').on('click',function(e){
		e.preventDefault();
		$("#btnSubmit4").prop('disabled', true);
		$("#btnSubmit4 i").attr('class','fas fa-spinner fa-spin fa-1x fa-fw'); 
		var url = "<?php echo site_url("u/fnSaveFinish/qopen/".$sAccount."/".$alias."/".$eventId."/4");?>?e="+mycodesurvey;
		var rec = $('#frmQopen').serialize();
		$.post(url, rec, function(f){
			if(f.status == 200) {
				temp_values = [];
				$('.tooltip').tooltip('hide');
				setCookie("tokensurveyleaderunik",'',0);
				window.location.href='<?php echo site_url('u/fnCloseSurvey/'.SLANGUAGE.'/'.$alias);?>';
			}	else if(f.status == 300) {
				openDemograp(4);
			} else {
				swal.fire({text: f.pesan+' !!',icon: 'error',confirmButtonText:'Close',confirmButtonColor: '#FF0000'})
				$('#btnSubmit4').removeAttr('disabled');
				$("#btnSubmit4 i").attr('class','fas fa-paper-plane');
			}
		},'json').fail(function(g){
			swal.fire("Terjadi kesalahan","Silahkan coba klik kembali","error");
			$('#btnSubmit4').removeAttr('disabled');
			$("#btnSubmit4 i").attr('class','fas fa-paper-plane');
		});
		return false;
	});

});
function diklik(text,nomor){ $('.'+text+''+nomor).trigger('click'); }
function fnCountPV(txt) {
	$( ".slotSourcePV" ).html("");
	var n = $(".pv input:checked" ).length;
	$("span#counter1").text( n );
	if(n==10)
	{ 
		perhatian_modal(1);//$("#myInfoPrioritas").modal('show');
		$('.title_pilihan1').html('Silahkan urutkan prioritasnya, mulai dari yang paling dirasakan menggambarkan hingga yang kurang dirasakan menggambarkan dengan klik kotak di samping value yang ada. <i class="glyphicon glyphicon-ok"></i>');
		$("#frmSurveyPersonal input[type='checkbox']" ).not( ":checked").attr("disabled",true);
		//$('html, body').animate({ scrollTop: $("#counter1").offset().top   }, 1000);
	}
	else
	{
		$('span#button1').hide();$(".slotDestinations").html("");$("span#counter12").text( 0 ); 
		$("#frmSurveyPersonal input[type='checkbox']" ).not( ":checked").attr("disabled",false);
		$('.title_pilihan1').html('<?php echo $this->lang->line('dipilih1');?> <i class="glyphicon glyphicon-ok"></i>');
	}

	fnLoadData('.slotSourcePV','.pv');
};
function fnCountLC(txt) {
	$( ".slotSourceLC" ).html("");
	var n = $(".lc input:checked" ).length;
	$("span#counter2").text( n );
	if(n==10)
	{ 
		perhatian_modal(2);//$("#myInfoPrioritas").modal('show');
		$('.title_pilihan2').html('Silahkan urutkan prioritasnya, mulai dari yang paling dirasakan menggambarkan hingga yang kurang dirasakan menggambarkan dengan klik kotak di samping value yang ada. <i class="glyphicon glyphicon-ok"></i>');
		$("#frmSurveyLeaderC input[type='checkbox']" ).not( ":checked").attr("disabled",true);
		//$('html, body').animate({ scrollTop: $("#counter2").offset().top   }, 1000);
	}
	else
	{
		$('span#button2').hide();$(".slotDestinations").html("");$("span#counter12").text( 0 ); 
		$("#frmSurveyLeaderC input[type='checkbox']" ).not( ":checked").attr("disabled",false);
		$('.title_pilihan2').html('<?php echo $this->lang->line('dipilih1');?> <i class="glyphicon glyphicon-ok"></i>');
	}

	fnLoadData('.slotSourceLC','.lc');
};
function fnCountLD(txt) {
	$( ".slotSourceLD" ).html("");
	var n = $(".ld input:checked" ).length;
	$("span#counter3").text( n );
	if(n==10)
	{ 
		perhatian_modal(3);//$("#myInfoPrioritas").modal('show');
		$('.title_pilihan3').html('Silahkan urutkan prioritasnya, mulai dari yang paling dirasakan menggambarkan hingga yang kurang dirasakan menggambarkan dengan klik kotak di samping value yang ada. <i class="glyphicon glyphicon-ok"></i>');
		$("#frmSurveyLeaderD input[type='checkbox']" ).not( ":checked").attr("disabled",true);
		//$('html, body').animate({ scrollTop: $("#counter3").offset().top   }, 1000);
	}
	else
	{
		$('span#button3').hide();$(".slotDestinations").html("");$("span#counter13").text( 0 ); 
		$("#frmSurveyLeaderD input[type='checkbox']" ).not( ":checked").attr("disabled",false);
		$('.title_pilihan3').html('<?php echo $this->lang->line('dipilih1');?> <i class="glyphicon glyphicon-ok"></i>');
	}

	fnLoadData('.slotSourceLD','.ld');
};

var y;
function fnLoadData(txt,ck){
	var data_array = temp_values;
	//console.log(temp_values);console.log(txt);console.log(ck)
	var out = "";	var No = 1;y = 1;var vTemp = new Array();
	for (var i = 0; i < data_array.length; i++) {
		var nc = ck+data_array[i];
		var chk = $( 'input'+nc );
		var value_arr = chk.val().split("_");
		var number_arr = chk.attr("data-nomor").replace ( /[^\d.]/g, '' ); 
		out += "<div id='div"+ value_arr[0] +"' style='height:100%;padding:5px;border:1px solid #aaaaaa;text-align:left;word-wrap:break-word;color:#000;font-size:12pt;background-color:#F9F9F9;'>"+number_arr+". "+value_arr[1] + "</span>&nbsp;<input type='checkbox' id='cek"+value_arr[0]+"' onClick=\"addPrio("+value_arr[0]+",'"+txt+"')\" class='choose_priority_"+ck.replace('.','')+"' style='display: none;'>&nbsp;</div>";
		//out += "<div id='div"+ value_arr[0] +"' style='height:55px;padding:5px;border:1px solid #aaaaaa;text-align:left;word-wrap:break-word;color:#000;font-size:12pt;background-color:#F9F9F9;'>"+number_arr+". "+value_arr[1] + " ("+No+")</span>&nbsp;<input type=\"hidden\" name=\"prioritas[]\" id=\"cek"+value_arr[0]+"\" value=\'"+nilainya[No-1]+"_"+value_arr[0]+"' ></div>";
		No++;
	} 
	//console.log(txt+' '+out)
	$(txt).html(out);
	var chk1 = $( ck+" input:checked" );
	if(chk1.length == 10) {
		$(".choose_priority_"+ck.replace('.','')).show();
	} else {
		$(".choose_priority_"+ck.replace('.','')).hide();
	}
}
//function fnLoadData(txt,ck){
	//var out = "";	   
	//var chk = $( ck+" input:checked" );
	//var i;
	//var No = 1;
	//y = 1;
	//console.log(chk.length);
	//var vTemp = new Array();
	//for (i = 0; i < chk.length; i++) {
		//if (chk[i].checked) {
			
			//var value_arr = chk[i].value.split("_"); 
			////var number_arr = chk[i].getAttribute("class").replace ( /[^\d.]/g, '' ); 
			//var number_arr = chk[i].getAttribute("data-nomor").replace ( /[^\d.]/g, '' ); 
			///* RANKING */
			//out += "<div id='div"+ value_arr[0] +"' style='height:100%;padding:5px;border:1px solid #aaaaaa;text-align:left;word-wrap:break-word;color:#000;font-size:12pt;background-color:#F9F9F9;'>"+number_arr+". "+value_arr[1] + "</span>&nbsp;<input type=\"checkbox\" id=\"cek"+value_arr[0]+"\"onClick=\"addPrio("+value_arr[0]+",'"+txt+"')\" class='choose_priority_"+ck.replace('.','')+"' style=\"display: none;\">&nbsp; </div>";               
			///* NO RANKING */
			////out += "<div id='div"+ value_arr[0] +"' style='height:55px;padding:5px;border:1px solid #aaaaaa;text-align:left;word-wrap:break-word;color:#000;font-size:12pt;background-color:#F9F9F9;'>"+number_arr+". "+value_arr[1] + "</span>&nbsp;<input type=\"hidden\" name=\"prioritas[]\" id=\"cek"+value_arr[0]+"\" value=\'"+No+"_"+value_arr[0]+"' ></div>";
			//No++;
		//}
	//}
	//$(txt).html(out);
	//if(chk.length == 10) {
		//$(".choose_priority_"+ck.replace('.','')).show();
	//} else {
		//$(".choose_priority_"+ck.replace('.','')).hide();
	//}
//}

function addPrio(x,cls)
{
	var row = $(''+cls).find('a');
	if($("#cek"+x).prop( "checked" ))
	{
		$('<a id="tip'+x+'" class="rep'+urutan[y-1]+' tip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="'+urutan[y-1]+'" data-list="'+x+'"><input type="hidden" name="prioritas[]" value="'+nilainya[y-1]+'_'+x+'" class="form-control'+x+' urutan" ></a>').appendTo('#div'+x);
		y += 1;
		$('#tip'+x).tooltip('show');
		row = $(''+cls).find('a');
	}
	else
	{
		$('#tip'+x).tooltip('hide');
		var z = $('#tip'+x).attr('data-original-title');
		var u;
		for(u= parseInt(z)+1;u<=row.length;u++)
		{
			var id = $('.rep'+u).attr('id');
			var new_urut = parseInt(u) - 1;
			var re = id.replace(/[^0-9]/g, '');
			$('.form-control'+re).val(nilainya[new_urut-1]+'_'+re)
			$("#"+id).attr('class','rep'+new_urut+' tip');
			//$("#"+id).attr('data-original-title',new_urut).tooltip('fixTitle').tooltip('show');
			$("#"+id).attr('data-original-title',new_urut).tooltip('update').tooltip('show');
		}

		$('#tip'+x).remove();
		$('#input'+x).html('');
		y -=1;
		row = $(''+cls).find('a');
	}
	
	if(row.length==10)
	{
		if(cls == '.slotSourcePV')
		{
			$("#button1").show();$('html, body').animate({ scrollTop: $("#panel-button1").offset().top   }, 1000);
		}
		
		if(cls == '.slotSourceLC')
		{
			$("#button2").show();$('html, body').animate({ scrollTop: $("#panel-button2").offset().top   }, 1000);
		}

		if(cls == '.slotSourceLD')
		{
			$("#button3").show();$('html, body').animate({ scrollTop: $("#panel-button3").offset().top   }, 1000);
		}
	}
	else
	{
		$("#button1").hide();$("#button2").hide();$("#button3").hide();
		//$("#button4").hide();$("#button5").hide();
	}
}	
function openDemograp(x) {
	$.fancybox.open({
		href : '<?= site_url("c/demograp/$alias");?>?button='+x+'&surveytoken='+mycodesurvey,
		type : 'iframe',padding : 0,autoSize: false,width: 700,autoHeight: true,closeBtn: false,modal: true,
	});	
}
function fnBack() { $.get("<?= site_url("u/fnBackDemo/$alias");?>",function(){ window.location.reload(); })}
function shuffleArray(r){for(var o,a,f=r.length;f>0;)a=Math.floor(Math.random()*f),o=r[--f],r[f]=r[a],r[a]=o;return r}
function clickBtn(x){ $('#btnSubmit'+x).removeAttr('disabled');$("#btnSubmit"+x+" i").attr('class','fas fa-paper-plane');$('#btnSubmit'+x).click()}
</script>

</body>
</html>
