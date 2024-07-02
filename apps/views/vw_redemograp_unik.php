<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$wrapper = '#222d32';//'#f02';
$tab_active_color = '#3c8dbc';//'#f02';
$color_content_header = '#FFF';
$btn_mulai = 'btn-info';
$box_medium = 'bg-aqua';
$box_small = 'bg-yellow';
$btn_next = 'btn-info';
$btn_next1 = 'btn-success';
//---- MODAL PRIO
$bg_header = '#00acd6';
$color_text_header = '$FFF';
$bg_btn = '#fff';
$color_text_btn = '#00acd6';
$btn_modal = 'btn-danger';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo NAME_APL." | ".$app_title;?></title>
	<link rel="shortcut icon" href="https://survey.actconsulting.co/assets/images/act.png" type="image/x-icon" />

	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="<?php echo PLUG_URL;?>fontawesome-free/css/all.min.css">
	<!-- Other style -->
	<link rel="stylesheet" href="<?php echo PLUG_URL;?>jquery-ui/jquery-ui.min.css">
	<link rel="stylesheet" href="<?php echo PLUG_URL;?>sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="<?php echo PLUG_URL;?>select2/css/select2.min.css">
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
	<script src="<?php echo PLUG_URL;?>select2/js/select2.min.js"></script>
	<script src="<?php echo PLUG_URL;?>jquery-validation/jquery.validate.min.js"></script>
	<script src="<?php echo PLUG_URL;?>jquery/jquery.form.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo ASSETS_URL;?>adminlte/js/adminlte.min.js"></script>

	<style>.nav-tabs-custom > .nav-tabs > li.active{border-top-color:#f02 }.blue-tooltip+.tooltip>.tooltip-inner{background-color:#0084FF}.blue-tooltip+.tooltip>.tooltip-arrow{border-bottom-color:#0084FF}.form-control1{background-color:#fff;background-image:none;border:1px solid #ccc;border-radius:4px;box-shadow:0 1px 1px rgba(0,0,0,.075) inset;color:#555;display:block;padding:2px 6px;transition:border-color .15s ease-in-out 0s,box-shadow .15s ease-in-out 0s;float:right}.page-title{font-weight:700}.column{width:33%;float:left}.check1{border:1px dashed #999}.form-actions{clear:left;border:1px solid #ddd;padding:10px;background:#eee;height:50px}.nav-tabs-custom ul.nav li{background-color:#ccc}.labelval{font-size:11pt;vertical-align:baseline;display:inline}.list-group-item{display: list-item;}</style>

</head>
<body class="layout-top-nav" style="height: auto; background-color: #222d32;">
	<div class="wrapper">
		<div class="clearfix">&nbsp;</div>
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="card col-8">
					<div class="card-header border-0" align="center">
						<h3 class="card-title">Demography</h3>
					</div>
					<div class="card-body">
<?php
//opn($region);
$label_level1 = json_decode($set_demo['f_label_level1'],true);
$label_level2 = json_decode($set_demo['f_label_level2'],true);
$label_level3 = json_decode($set_demo['f_label_level3'],true);
$label_level4 = json_decode($set_demo['f_label_level4'],true);
$label_level5 = json_decode($set_demo['f_label_level5'],true);
$others = json_decode($set_demo['f_label_others'],true);
//opn($others);
$label_leaders = $others['leaders'];
$label_region = $others['region'];
$label_work = $others['work'];
$label_mk = $others['mk'];
$label_gender = $others['gender'];
$label_pendidikan = $others['education'];
$label_age = $others['age'];
?>
						<form id="frmDemo" action="#" method="POST" class="form-horizantal">
							<?php //if( $listdemo['f_region'] == 1){ ?>
							<?php //} ?>
							<?php if( $listdemo['f_region'] == 1){ ?>
							<!-- Pilihan Lokasi Kerja -->
							<div class="form-group row">
								<label class="col-md-4 labelme"><?php echo $label_region[SLANGUAGE];?> <span class="text-red">*</span></label>
								<div class="col-md-8">
									<?php
									$region[''] = '--- '.$this->lang->line('pilih').' ---';
									echo form_dropdown('region',$region,false,'id="region" class="form-control region custom-select" required style="width:100%"');
									?>
									<input type="hidden" name="region_name" id="region_name" value="<?php echo $this->session->userdata('region_name');?>">
								</div>								
							</div>
							<?php } ?>

							<?php if( $listdemo['f_level1'] == 1 ){ ?>
							<div class="form-group row">
								<label class="col-md-4 labelme"><?php echo $label_level1[SLANGUAGE];?> <span class="text-red">*</span></label>
								<div class="col-md-8">
									<?php
									$cLevel1[''] = '--- '.$this->lang->line('pilih').' ---';
									echo form_dropdown('level1',$cLevel1,false,'id="level1" class="form-control level1 custom-select" required style="width:100%"');
									?>
									<input type="hidden" name="level1_name" id="level1_name" value="<?php echo $this->session->userdata('level1_name');?>">
								</div>								
							</div>
							<?php	} ?>

							<?php if( $listdemo['f_level2'] == 1 ){ ?>
							<div class="form-group row">
								<label class="col-md-4 labelme"><?php echo $label_level2[SLANGUAGE];?> <span class="text-red">*</span></label>
								<div class="col-md-8">
									<?php
									$level2 = array(''=>'--- '.$this->lang->line('pilih').' ---');
									echo form_dropdown('level2',$level2,false,'id="level2" class="form-control level2 custom-select" required style="width:100%"');
									?>
									<input type="hidden" name="level2_name" id="level2_name" value="<?php echo $this->session->userdata('level2_name');?>">
								</div>								
							</div>
							<?php	} ?>

							<?php if( $listdemo['f_level3'] == 1 ){ ?>
							<div class="form-group row">
								<label class="col-md-4 labelme"><?php echo $label_level3[SLANGUAGE];?> <span class="text-red">*</span></label>
								<div class="col-md-8">
									<?php
									$level3 = array(''=>'--- '.$this->lang->line('pilih').' ---');
									echo form_dropdown('level3',$level3,false,'id="level3" class="form-control level3 custom-select" required style="width:100%"');
									?>
									<input type="hidden" name="level3_name" id="level3_name" value="<?php echo $this->session->userdata('level3_name');?>">
								</div>								
							</div>
							<?php	} ?>

							<?php if( $listdemo['f_level4'] == 1 ){ ?>
							<div class="form-group row">
								<label class="col-md-4 labelme"><?php echo $label_level4[SLANGUAGE];?> <span class="text-red">*</span></label>
								<div class="col-md-8">
									<?php
									$level4 = array(''=>'--- '.$this->lang->line('pilih').' ---');
									echo form_dropdown('level4',$level4,false,'id="level4" class="form-control level4 custom-select" required style="width:100%"');
									?>
									<input type="hidden" name="level4_name" id="level4_name" value="<?php echo $this->session->userdata('level4_name');?>">
								</div>								
							</div>
							<?php	} ?>

							<?php if( $listdemo['f_level5'] == 1 ){ ?>
							<div class="form-group row">
								<label class="col-md-4 labelme"><?php echo $label_level5[SLANGUAGE];?> <span class="text-red">*</span></label>
								<div class="col-md-8">
									<?php
									$level5 = array(''=>'--- '.$this->lang->line('pilih').' ---');
									echo form_dropdown('level5',$level5,false,'id="level5" class="form-control level5 custom-select" required style="width:100%"');
									?>
									<input type="hidden" name="level5_name" id="level5_name" value="<?php echo $this->session->userdata('level5_name');?>">
								</div>								
							</div>
							<?php	} ?>

							<?php if( $listdemo['f_level_of_work'] == 1 ){ ?>
							<div class="form-group row">
								<label class="col-md-4 labelme"><?php echo $label_work[SLANGUAGE];?> <span class="text-red">*</span></label>
								<div class="col-md-8">
									<?php
									$level_of_work[''] = '--- '.$this->lang->line('pilih').' ---';
									echo form_dropdown('level_of_work',$level_of_work,false,'id="level_of_work" class="form-control level_of_work custom-select" required style="width:100%"');
									?>
									<input type="hidden" name="level_of_work_name" id="level_of_work_name" value="<?php echo $this->session->userdata('level_of_work_name');?>">
								</div>								
							</div>
							<?php	} ?>

							<?php if($listdemo['f_masakerja'] == 1) { ?>
							<div class="form-group row">
								<label class="col-md-4 labelme"><?php echo $label_mk[SLANGUAGE];?> <span class="text-red">*</span></label>
								<div class="col-md-8">
									<?php
									$masakerja[''] = '--- '.$this->lang->line('pilih').' ---';
									echo form_dropdown('masakerja',$masakerja,false,'id="masakerja" class="form-control masakerja custom-select" required style="width:100%"');
									?>
									<input type="hidden" name="mk_name" id="mk_name" value="<?php echo $this->session->userdata('masakerja_name');?>">
								</div>								
							</div>
							<?php }
							if($listdemo['f_gender'] == 1) { ?>
							<div class="form-group row">
								<label class="col-md-4 labelme"><?php echo $label_gender[SLANGUAGE];?> <span class="text-red">*</span></label>
								<div class="col-md-8">
									<?php
									$gender[''] ='--- '.$this->lang->line('pilih').' ---';
									echo form_dropdown('gender',$gender,false,'id="gender" class="form-control gender custom-select"  style="width: 100%" required');
									?>
								</div>								
							</div>
							<?php }
							if($listdemo['f_pendidikan'] == 1) { ?>
							<div class="form-group row">
								<label class="col-md-4 labelme"><?php echo $label_pendidikan[SLANGUAGE];?> <span class="text-red">*</span></label>
								<div class="col-md-8">
									<?php
									//$pd = array("SD"=>"SD","SMP"=>"SMP","SMA"=>"SMA","D"=>"Diploma","S"=>"Sarjana","SS"=>"Pascasarjana (S2/S3)","L"=>"Lainnya
									$pendidikan[''] = '--- '.$this->lang->line('pilih').' ---';
									echo form_dropdown('tipen',$pendidikan,false,'id="tipen" class="form-control tipen custom-select" required style="width:100%"');
									?>
								</div>								
							</div>
							<?php } ?>
							<?php if($listdemo['f_age'] == 1){ ?>
							<div class="form-group row">
								<label class="col-md-4 labelme"><?php echo $label_age[SLANGUAGE];?> <span class="text-red">*</span></label>
								<div class="col-md-8">
									<?php
									$age_ar[''] = '--- '.$this->lang->line('pilih').' ---';
									//if($this->session->userdata('age')) $age_ar[$this->session->userdata('age')] = $this->session->userdata('age_name');
									echo form_dropdown('age',$age_ar,false,'id="age" class="form-control age custom-select" required style="width:100%"');
									?>
									<input type="hidden" name="age_name" id="age_name" value="<?php echo $this->session->userdata('age_name');?>">
								</div>								
							</div>
							<?php  }?>

							<div class="clearfix">&nbsp;</div>
							<div class="form-group row">
								<div class="justify-content-md-center col-12" align="center">
									<input type="submit" name="simpan" id="simpan" value="<?php echo $this->lang->line('simpan');?>" class="btn btn-primary">
									<p><?php echo $this->lang->line('laun2');?></p>
								</div>
							</div>

						
						</form>
					</div>
				</div>
			</div>
		</div>
	</div> <!-- wrapper -->

<script type="text/javascript">
function setCookie(e,o,t){var i=new Date;i.setTime(i.getTime()+24*t*60*60*1e3);var n="expires="+i.toUTCString();document.cookie=e+"="+o+";"+n+";path=/"}function getCookie(e){for(var o=e+"=",t=document.cookie.split(";"),i=0;i<t.length;i++){for(var n=t[i];" "==n.charAt(0);)n=n.substring(1);if(0==n.indexOf(o))return n.substring(o.length,n.length)}return""}function checkCode(e){getCookie("tokensurveyleaderunik")||setCookie("tokensurveyleaderunik",e,14)}checkCode("<?php echo $yourcode;?>");var mycodesurvey =getCookie('tokensurveyleaderunik');
$(document).ready(function(){
	$('#frmDemo').validate({
		highlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('is-valid').addClass('is-invalid');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('is-invalid').addClass('is-valid');
		}		
	});

	$('#frmDemo').submit(function(e){
		var rec = $('#frmDemo').serialize();
		e.preventDefault();
		if($(this).valid()) {
			$.post("<?php echo site_url('u/saveDemo/'.$alias.'?e='.$_GET['surveytoken']);?>", rec, function(msg){
				if(msg.status == 200)
				{
					parent.clickBtn(<?= $_GET['button'];?>);
					parent.$.fancybox.close();
				}
				else
				{
					swal.fire({text: 'Gagal !!',icon: 'error',confirmButtonText:'Close',confirmButtonColor: '#FF0000'})
				}
			}, 'json');
		}
	});
	
	$("#leaders").select2({
		placeholder: "<?php echo $this->lang->line('pilih').' '.$label_leaders[SLANGUAGE];?>",
		allowClear: true,
		minimumResultsForSearch: Infinity,
	}).on("select2:select", function (e) { $('#leaders_name').val(e.params.data.text);	});	

	<?php	if( $listdemo['f_region'] == 1 ){ ?>
	$("#region").select2({
		placeholder: "<?php echo $this->lang->line('pilih').' '.$label_region[SLANGUAGE];?>",
		allowClear: true,
		minimumResultsForSearch: Infinity,
	}).on("select2:select", function (e) { $('#region_name').val(e.params.data.text);	});	
	<?php	} ?>

	<?php	if( $listdemo['f_level1'] == 1 ){ ?>
	$("#level1").select2({
		placeholder: "<?php echo $this->lang->line('pilih').' '.$label_level1[SLANGUAGE];?>",
		allowClear: true,
		minimumResultsForSearch: Infinity,
	}).on("select2:select", function (e) { $('#level1_name').val(e.params.data.text);	});	
	<?php	} ?>

	<?php	if( $listdemo['f_level2'] == 1 ){ ?>
	$("#level1").on("select2:select", function (e) {
		$("#level2").val('').trigger("change");
		$("#level2").prop("disabled", false);
	}).on("select2:unselect", function (e) {
		$("#level2").val('').trigger("change");
		$("#level2").prop("disabled", true);
	});	
	$("#level2").select2({
		placeholder: "<?php echo $this->lang->line('pilih').' '.$label_level2[SLANGUAGE];?>",
		allowClear: true,
		ajax: {
			url 			: "<?php echo site_url("c/fnPositionComboData/2/$alias");?>",
			dataType		: 'json',
			delay			: 250,
			data: function (params) {
			  return {
				term: params.term, /*/ search term */
				f_parents: $("#level1").val(),
			  };
			},
			processResults	: function(data,params) {
				return {
				        results: data.result,
					}
			},
			cache: false
		},		
		minimumResultsForSearch: Infinity,
	}).on("select2:select", function (e) { $('#level2_name').val(e.params.data.text);	});	
	$("#level2").prop("disabled", true);
	<?php	} ?>

	<?php	if( $listdemo['f_level3'] == 1 ){ ?>
	$("#level1").on("select2:unselect", function (e) {
		$("#level3").val('').trigger("change");
		$("#level3").prop("disabled", true);
	});	
	$("#level2").on("select2:select", function (e) {
		$("#level3").val('').trigger("change");
		$("#level3").prop("disabled", false);
	}).on("select2:unselect", function (e) {
		$("#level3").val('').trigger("change");
		$("#level3").prop("disabled", true);
	});	
	$("#level3").select2({
		placeholder: "<?php echo $this->lang->line('pilih').' '.$label_level3[SLANGUAGE];?>",
		allowClear: true,
		ajax: {
			url 			: "<?php echo site_url("c/fnPositionComboData/3/$alias");?>",
			dataType		: 'json',
			delay			: 250,
			data: function (params) {
			  return {
				term: params.term, /*/ search term */
				f_parents: $("#level2").val(),
			  };
			},
			processResults	: function(data,params) {
				return {
				        results: data.result,
					}
			},
			cache: false
		},		
		minimumResultsForSearch: Infinity,
	}).on("select2:select", function (e) { $('#level3_name').val(e.params.data.text);	});	
	$("#level3").prop("disabled", true);
	<?php	} ?>

	<?php	if( $listdemo['f_level4'] == 1 ){ ?>
	$("#level1").on("select2:unselect", function (e) {
		$("#level4").val('').trigger("change");
		$("#level4").prop("disabled", true);
	});	
	$("#level2").on("select2:unselect", function (e) {
		$("#level4").val('').trigger("change");
		$("#level4").prop("disabled", true);
	});	
	$("#level3").on("select2:select", function (e) {
		$("#level4").val('').trigger("change");
		$("#level4").prop("disabled", false);
	}).on("select2:unselect", function (e) {
		$("#level4").val('').trigger("change");
		$("#level4").prop("disabled", true);
	});	
	$("#level4").select2({
		placeholder: "<?php echo $this->lang->line('pilih').' '.$label_level4[SLANGUAGE];?>",
		allowClear: true,
		ajax: {
			url 			: "<?php echo site_url("c/fnPositionComboData/4/$alias");?>",
			dataType		: 'json',
			delay			: 250,
			data: function (params) {
			  return {
				term: params.term, /*/ search term */
				f_parents: $("#level3").val(),
			  };
			},
			processResults	: function(data,params) {
				return {
				        results: data.result,
					}
			},
			cache: false
		},		
		minimumResultsForSearch: Infinity,
	}).on("select2:select", function (e) { $('#level4_name').val(e.params.data.text);	});	
	$("#level4").prop("disabled", true);
	<?php	} ?>

	<?php	if( $listdemo['f_level4'] == 1 ){ ?>
	$("#level1").on("select2:unselect", function (e) {
		$("#level5").val('').trigger("change");
		$("#level5").prop("disabled", true);
	});	
	$("#level2").on("select2:unselect", function (e) {
		$("#level5").val('').trigger("change");
		$("#level5").prop("disabled", true);
	});	
	$("#level3").on("select2:unselect", function (e) {
		$("#level5").val('').trigger("change");
		$("#level5").prop("disabled", true);
	});	
	$("#level4").on("select2:select", function (e) {
		$("#level5").val('').trigger("change");
		$("#level5").prop("disabled", false);
	}).on("select2:unselect", function (e) {
		$("#level5").val('').trigger("change");
		$("#level5").prop("disabled", true);
	});	
	$("#level5").select2({
		placeholder: "<?php echo $this->lang->line('pilih').' '.$label_level5[SLANGUAGE];?>",
		allowClear: true,
		ajax: {
			url 			: "<?php echo site_url("c/fnPositionComboData/5/$alias");?>",
			dataType		: 'json',
			delay			: 250,
			data: function (params) {
			  return {
				term: params.term, /*/ search term */
				f_parents: $("#level4").val(),
			  };
			},
			processResults	: function(data,params) {
				return {
				        results: data.result,
					}
			},
			cache: false
		},		
		minimumResultsForSearch: Infinity,
	}).on("select2:select", function (e) { $('#level5_name').val(e.params.data.text);	});	
	$("#level5").prop("disabled", true);
	<?php	} ?>

	<?php	if( $listdemo['f_level_of_work'] == 1 ){ ?>
	$("#level_of_work").select2({
		placeholder: "<?php echo $this->lang->line('pilih').' '.$label_work[SLANGUAGE];?>",
		allowClear: true,
		minimumResultsForSearch: Infinity,
	}).on("select2:select", function (e) { $('#level_of_work_name').val(e.params.data.text);	});	
	<?php	} ?>

	<?php	if( $listdemo['f_masakerja'] == 1 ){ ?>
	$("#masakerja").select2({
		placeholder: "<?php echo $this->lang->line('pilih').' '.$label_mk[SLANGUAGE];?>",
		allowClear: true,
		minimumResultsForSearch: Infinity,
	}).on("select2:select", function (e) { $('#mk_name').val(e.params.data.text);	});	
	<?php	} ?>

	<?php if($listdemo['f_gender'] == 1) { ?>
	$("#gender").select2({
		placeholder: "<?php echo $this->lang->line('pilih').' '.$label_gender[SLANGUAGE];?>",
		allowClear: true,
		minimumResultsForSearch: Infinity,
	});
	<?php	} ?>

	<?php if($listdemo['f_age'] == 1) { ?>
	$("#age").select2({
		placeholder: "<?php echo $this->lang->line('pilih').' '.$label_age[SLANGUAGE];?>",
		allowClear: true,
		minimumResultsForSearch: Infinity,
	}).on("select2:select", function (e) { $('#age_name').val(e.params.data.text);	});
	<?php	} ?>

	<?php if($listdemo['f_pendidikan'] == 1) { ?>
	$("#tipen").select2({
		placeholder: "<?php echo $this->lang->line('pilih').' '.$label_pendidikan[SLANGUAGE];?>",
		allowClear: true,
		minimumResultsForSearch: Infinity,
	});
	<?php	} ?>

});	
</script>
</body>
</html>
