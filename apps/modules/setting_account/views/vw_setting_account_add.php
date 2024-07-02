<!-- load css dan js -->
<link rel="stylesheet" href="<?php echo PLUG_URL;?>select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo PLUG_URL;?>jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo PLUG_URL;?>jquery/jquery.form.min.js"></script>
<script src="<?php echo PLUG_URL;?>select2/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo PLUG_URL;?>bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="<?php echo PLUG_URL;?>inputmask/jquery.inputmask.bundle.js"></script>
<script src="<?php echo PLUG_URL;?>clipboard.min.js"></script>
<!-- end load css dan js -->

<section class="content">
	<div class="container-fluid">
		<div class="card"> <!-- start .card -->
			<div class="card-header"> <!-- start .card-header -->
				<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
					<li class="nav-item" role="presentation">
						<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Profile</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Demografy</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Link</a>
					</li>
				</ul>
			</div> <!-- end .card-header -->
			
			<div class="card-body"> <!-- start .card-body -->
			<div class="tab-content" id="pills-tabContent">
				<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
					<form name="frmSetting_account" id="frmSetting_account" method="post" class="form-horizontal">
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">No <?php echo $this->lang->line('akun_terdaftar');?></label>
						<div class="col-md-6">
							<input type="text" id="f_account_noacc" class="form-control" readonly value="<?php echo $akun['f_account_noacc'];?>">
						</div>
					</div>
	
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Name Account <span class="text-red">*</span></label>
						<div class="col-md-6"><input type="text" name="f_account_name" id="f_account_name" class="form-control" placeholder="Name Account ..." value="<?php echo $akun['username'];?>" required></div>
					</div>
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Contact <span class="text-red">*</span></label>
						<div class="col-md-6"><input type="text" name="f_account_contact" id="f_account_contact" class="form-control" placeholder="Contact ..." value="<?php echo $akun['f_account_contact'];?>" required></div>
					</div>
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Phone <span class="text-red">*</span></label>
						<div class="col-md-6"><input type="text" name="f_account_phone" id="f_account_phone" class="form-control" placeholder="Phone ..." value="<?php echo $akun['f_account_phone'];?>" required></div>
					</div>
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Email <span class="text-red">*</span></label>
						<div class="col-md-6"><input type="text" name="f_account_email" id="f_account_email" class="form-control" placeholder="Email ..." value="<?php echo $akun['f_account_email'];?>" required></div>
						<div class="col-md-3" id="msgEmail" style="padding-top:7px"></div>
					</div>
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('bahasa');?></label>
						<div class="col-md-6">
						<?php
						$bahasa = array('indonesian'=>'Indonesian','english'=>'English');
						echo form_dropdown('bahasa',$bahasa,$setting['f_language'],'id="bahasa" class="bahasa form-control select"');
						?>
						</div>
						<div class="col-md-3" id="msgEmail" style="padding-top:7px"></div>
					</div>
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Logo</label>
						<div class="col-md-6">
							  <?php 
								if($akun['f_account_logo']) $img_lg = 'uploads/'.sAccount.'/'.$akun['f_account_logo'];
								else $img_lg = ASSETS_URL.'images/noimages.jpg';
							  ?>
							<img src="<?= $img_lg;?>" width="250px">
		                    <div class="custom-file">
		                      <input type="file" class="custom-file-input" name="f_account_logo" id="f_account_logo" accept="image/*">
		                      <input type="hidden" name="f_account_logo_old" id="f_account_logo_old" value="<?= $akun['f_account_logo'];?>">
		                      <label class="custom-file-label" for="customFile">Choose Image</label>
		                    </div>
							
						</div>
					</div>
					<hr/>
					<div class="form-group row">
						<h3 class="col-md-12 card-title"><?php echo $this->lang->line('change');?> <?php echo $this->lang->line('password');?></h3>
						<label class="col-md-2" style="padding-top:7px;">New <?php echo $this->lang->line('password');?></label>
						<div class="col-md-6">
							<input type="password" name="new_password" id="new_password" class="form-control" placeholder="New <?php echo $this->lang->line('password');?> ..." data-rule-minlength="5">
						</div>
					</div>
	
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Re-Type New <?php echo $this->lang->line('password');?></label>
						<div class="col-md-6">
							<input type="password" name="rnew_password" id="rnew_password" class="form-control" placeholder="Re-Type New <?php echo $this->lang->line('password');?> ..." data-rule-equalto="#new_password">
						</div>
					</div>
	
						<div class="col-md-8" align="center" id="fnButton">
				<?php 	
					if($fAct == 'Add')	echo '<input type="submit" name="submit" value="Save" id="btnSave" class="btn btn-success" />';
		
					if($fAct == 'Edit')	echo '<input type="submit" name="submit" value="Ubah" id="btnUpdate" class="btn btn-warning" />';
				?>
						&nbsp;&nbsp;&nbsp;
						<a onClick="fnBack()" class="btn btn-danger"> Cancel</a>
						</div>
					</form>
				</div> <!-- tab1 -->

				<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
<?php
//opn($setting['f_label_level1']);
$others = json_decode($setting['f_label_others'],true);
$leaders = $others['leaders'];
$gender = $others['gender'];
$age = $others['age'];
$mk = $others['mk'];
$region = $others['region'];
$jabat = $others['work'];
$pendidikan = $others['education'];
$level1 = json_decode($setting['f_label_level1'],true);
$level2 = json_decode($setting['f_label_level2'],true);
$level3 = json_decode($setting['f_label_level3'],true);
$level4 = json_decode($setting['f_label_level4'],true);
$level5 = json_decode($setting['f_label_level5'],true);
?>
					<form name="frmDemo" id="frmDemo" method="post" class="form-horizontal">
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Pengisian Demograp</label>
						<div class="col-md-6">
						<?php
						$ldemo = array(1=>'Isi',2=>'Tidak Isi',3=>'Tidak Isi. Ambil dari Unik link',);
						$vdemo = ($setting['f_demo_view']) ? $setting['f_demo_view']:1;
						echo form_dropdown('f_demo_view',$ldemo,$vdemo,'id="f_demo_view" class="f_demo_view form-control custom-select"');
						?>
						</div>
					</div>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Desc</th>
								<th>Active <input type="checkbox" id="ckall"></th>
								<th>Indonesian</th>
								<th>English</th>
								<th>Malaysia</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $this->lang->line('leaders');?></td>
								<td style="text-align: center;">
									&nbsp;
								</td>
								<td>
									<input type="text" name="f_label_leaders_indonesian" id="f_label_leaders_indonesian" class="form-control" placeholder="<?php echo $this->lang->line('leaders');?> ..." aria-describedby="value_indonesian" value="<?php echo $leaders['indonesian'];?>">
								</td>
								<td>
									<input type="text" name="f_label_leaders_english" id="f_label_leaders_english" class="form-control" placeholder="<?php echo $this->lang->line('leaders');?>..." aria-describedby="value_english" value="<?php echo $leaders['english'];?>">
								</td>
								<td>
									<input type="text" name="f_label_leaders_malaysia" id="f_label_leaders_malaysia" class="form-control" placeholder="<?php echo $this->lang->line('leaders');?>..." aria-describedby="value_malaysia" value="<?php echo $leaders['malaysia'];?>">
								</td>
							</tr>
							<tr>
								<td><?php echo $this->lang->line('gender');?></td>
								<td style="text-align: center;">
									<input type="checkbox" name="f_gender" id="f_gender" class="ck" value="1" <?php if($listdemo['f_gender'] == 1) { echo "checked";} ?>>
								</td>
								<td>
									<input type="text" name="f_label_gender_indonesian" id="f_label_gender_indonesian" class="form-control" placeholder="<?php echo $this->lang->line('gender');?> ..." aria-describedby="value_indonesian" value="<?php echo $gender['indonesian'];?>">
								</td>
								<td>
									<input type="text" name="f_label_gender_english" id="f_label_gender_english" class="form-control" placeholder="<?php echo $this->lang->line('gender');?>..." aria-describedby="value_english" value="<?php echo $gender['english'];?>">
								</td>
								<td>
									<input type="text" name="f_label_gender_malaysia" id="f_label_gender_malaysia" class="form-control" placeholder="<?php echo $this->lang->line('gender');?>..." aria-describedby="value_malaysia" value="<?php echo $gender['malaysia'];?>">
								</td>
							</tr>
							<tr>
								<td><?php echo $this->lang->line('usia');?></td>
								<td style="text-align: center;">
									<input type="checkbox" name="f_age" id="f_age" class="ck" value="1" <?php if($listdemo['f_age'] == 1) { echo "checked";} ?>>
								</td>
								<td>
									<input type="text" name="f_label_age_indonesian" id="f_label_age_indonesian" class="form-control" placeholder="<?php echo $this->lang->line('usia');?> ..." aria-describedby="value_indonesian" value="<?php echo $age['indonesian'];?>">
								</td>
								<td>
									<input type="text" name="f_label_age_english" id="f_label_age_english" class="form-control" placeholder="<?php echo $this->lang->line('usia');?>..." aria-describedby="value_english" value="<?php echo $age['english'];?>">
								</td>
								<td>
									<input type="text" name="f_label_age_malaysia" id="f_label_age_malaysia" class="form-control" placeholder="<?php echo $this->lang->line('usia');?>..." aria-describedby="value_malaysia" value="<?php echo $age['malaysia'];?>">
								</td>
							</tr>
							<tr>
								<td><?php echo $this->lang->line('mkerja');?></td>
								<td style="text-align: center;">
									<input type="checkbox" name="f_masakerja" id="f_masakerja" class="ck" value="1" <?php if($listdemo['f_masakerja'] == 1) { echo "checked";} ?>>
								</td>
								<td>
									<input type="text" name="f_label_mk_indonesian" id="f_label_mk_indonesian" class="form-control" placeholder="<?php echo $this->lang->line('mkerja');?> ..." aria-describedby="value_indonesian" value="<?php echo $mk['indonesian'];?>">
								</td>
								<td>
									<input type="text" name="f_label_mk_english" id="f_label_mk_english" class="form-control" placeholder="<?php echo $this->lang->line('mkerja');?>..." aria-describedby="value_english" value="<?php echo $mk['english'];?>">
								</td>
								<td>
									<input type="text" name="f_label_mk_malaysia" id="f_label_mk_malaysia" class="form-control" placeholder="<?php echo $this->lang->line('mkerja');?>..." aria-describedby="value_malaysia" value="<?php echo $mk['malaysia'];?>">
								</td>
							</tr>
							<tr>
								<td><?php echo $this->lang->line('region');?></td>
								<td style="text-align: center;">
									<input type="checkbox" name="f_region" id="f_region" class="ck" value="1" <?php if($listdemo['f_region'] == 1) { echo "checked";} ?>>
								</td>
								<td>
									<input type="text" name="f_label_region_indonesian" id="f_label_region_indonesian" class="form-control" placeholder="<?php echo $this->lang->line('region');?> ..." aria-describedby="value_indonesian" value="<?php echo $region['indonesian'];?>">
								</td>
								<td>
									<input type="text" name="f_label_region_english" id="f_label_region_english" class="form-control" placeholder="<?php echo $this->lang->line('region');?>..." aria-describedby="value_english" value="<?php echo $region['english'];?>">
								</td>
								<td>
									<input type="text" name="f_label_region_malaysia" id="f_label_region_malaysia" class="form-control" placeholder="<?php echo $this->lang->line('region');?>..." aria-describedby="value_malaysia" value="<?php echo $region['malaysia'];?>">
								</td>
							</tr>
							<tr>
								<td><?php echo $this->lang->line('tkerja');?></td>
								<td style="text-align: center;">
									<input type="checkbox" name="f_level_of_work" id="f_level_of_work" class="ck" value="1" <?php if($listdemo['f_level_of_work'] == 1) { echo "checked";} ?>>
								</td>
								<td>
									<input type="text" name="f_label_work_indonesian" id="f_label_work_indonesian" class="form-control" placeholder="<?php echo $this->lang->line('tkerja');?> ..." aria-describedby="value_indonesian" value="<?php echo $jabat['indonesian'];?>">
								</td>
								<td>
									<input type="text" name="f_label_work_english" id="f_label_work_english" class="form-control" placeholder="<?php echo $this->lang->line('tkerja');?>..." aria-describedby="value_english" value="<?php echo $jabat['english'];?>">
								</td>
								<td>
									<input type="text" name="f_label_work_malaysia" id="f_label_mk_malaysia" class="form-control" placeholder="<?php echo $this->lang->line('tkerja');?>..." aria-describedby="value_malaysia" value="<?php echo $jabat['malaysia'];?>">
								</td>
							</tr>
							<tr>
								<td><?php echo $this->lang->line('pendidikan');?></td>
								<td style="text-align: center;">
									<input type="checkbox" name="f_pendidikan" id="f_pendidikan" class="ck" value="1" <?php if($listdemo['f_pendidikan'] == 1) { echo "checked";} ?>>
								</td>
								<td>
									<input type="text" name="f_label_edu_indonesian" id="f_label_edu_indonesian" class="form-control" placeholder="<?php echo $this->lang->line('pendidikan');?> ..." aria-describedby="value_indonesian" value="<?php echo $pendidikan['indonesian'];?>">
								</td>
								<td>
									<input type="text" name="f_label_edu_english" id="f_label_edu_english" class="form-control" placeholder="<?php echo $this->lang->line('pendidikan');?>..." aria-describedby="value_english" value="<?php echo $pendidikan['english'];?>">
								</td>
								<td>
									<input type="text" name="f_label_edu_malaysia" id="f_label_edu_malaysia" class="form-control" placeholder="<?php echo $this->lang->line('pendidikan');?>..." aria-describedby="value_malaysia" value="<?php echo $pendidikan['malaysia'];?>">
								</td>
							</tr>
							<tr>
								<td><?php echo $this->lang->line('level');?> 1</td>
								<td style="text-align: center;">
									<input type="checkbox" name="f_level1" id="f_level1" class="ck" value="1" <?php if($listdemo['f_level1'] == 1) { echo "checked";} ?>>
								</td>
								<td>
									<input type="text" name="f_label_level1_indonesian" id="f_label_level1_indonesian" class="form-control" placeholder="<?php echo $this->lang->line('level');?> 1 ..." aria-describedby="value_indonesian" value="<?php echo $level1['indonesian'];?>">
								</td>
								<td>
									<input type="text" name="f_label_level1_english" id="f_label_level1_english" class="form-control" placeholder="<?php echo $this->lang->line('level');?> 1 ..." aria-describedby="value_english" value="<?php echo $level1['english'];?>">
								</td>
								<td>
									<input type="text" name="f_label_level1_malaysia" id="f_label_level1_malaysia" class="form-control" placeholder="<?php echo $this->lang->line('level');?> 1 ..." aria-describedby="value_malaysia" value="<?php echo $level1['malaysia'];?>">
								</td>
							</tr>
							<tr>
								<td><?php echo $this->lang->line('level');?> 2</td>
								<td style="text-align: center;">
									<input type="checkbox" name="f_level2" id="f_level2" class="ck" value="1" <?php if($listdemo['f_level2'] == 1) { echo "checked";} ?>>
								</td>
								<td>
									<input type="text" name="f_label_level2_indonesian" id="f_label_level2_indonesian" class="form-control" placeholder="<?php echo $this->lang->line('level');?> 2 ..." aria-describedby="value_indonesian" value="<?php echo $level2['indonesian'];?>">
								</td>
								<td>
									<input type="text" name="f_label_level2_english" id="f_label_level2_english" class="form-control" placeholder="<?php echo $this->lang->line('level');?> 2 ..." aria-describedby="value_english" value="<?php echo $level2['english'];?>">
								</td>
								<td>
									<input type="text" name="f_label_level2_malaysia" id="f_label_level2_malaysia" class="form-control" placeholder="<?php echo $this->lang->line('level');?> 2 ..." aria-describedby="value_malaysia" value="<?php echo $level2['malaysia'];?>">
								</td>
							</tr>
							<tr>
								<td><?php echo $this->lang->line('level');?> 3</td>
								<td style="text-align: center;">
									<input type="checkbox" name="f_level3" id="f_level3" class="ck" value="1" <?php if($listdemo['f_level3'] == 1) { echo "checked";} ?>>
								</td>
								<td>
									<input type="text" name="f_label_level3_indonesian" id="f_label_level3_indonesian" class="form-control" placeholder="<?php echo $this->lang->line('level');?> 3 ..." aria-describedby="value_indonesian" value="<?php echo $level3['indonesian'];?>">
								</td>
								<td>
									<input type="text" name="f_label_level3_english" id="f_label_level3_english" class="form-control" placeholder="<?php echo $this->lang->line('level');?> 3 ..." aria-describedby="value_english" value="<?php echo $level3['english'];?>">
								</td>
								<td>
									<input type="text" name="f_label_level3_malaysia" id="f_label_level3_malaysia" class="form-control" placeholder="<?php echo $this->lang->line('level');?> 3 ..." aria-describedby="value_malaysia" value="<?php echo $level3['malaysia'];?>">
								</td>
							</tr>
							<tr>
								<td><?php echo $this->lang->line('level');?> 4</td>
								<td style="text-align: center;">
									<input type="checkbox" name="f_level4" id="f_level4" class="ck" value="1" <?php if($listdemo['f_level4'] == 1) { echo "checked";} ?>>
								</td>
								<td>
									<input type="text" name="f_label_level4_indonesian" id="f_label_level4_indonesian" class="form-control" placeholder="<?php echo $this->lang->line('level');?> 4 ..." aria-describedby="value_indonesian" value="<?php echo $level4['indonesian'];?>">
								</td>
								<td>
									<input type="text" name="f_label_level4_english" id="f_label_level4_english" class="form-control" placeholder="<?php echo $this->lang->line('level');?> 4 ..." aria-describedby="value_english" value="<?php echo $level4['english'];?>">
								</td>
								<td>
									<input type="text" name="f_label_level4_malaysia" id="f_label_level4_malaysia" class="form-control" placeholder="<?php echo $this->lang->line('level');?> 4 ..." aria-describedby="value_malaysia" value="<?php echo $level4['malaysia'];?>">
								</td>
							</tr>
							<tr>
								<td><?php echo $this->lang->line('level');?> 5</td>
								<td style="text-align: center;">
									<input type="checkbox" name="f_level5" id="f_level5" class="ck" value="1" <?php if($listdemo['f_level5'] == 1) { echo "checked";} ?>>
								</td>
								<td>
									<input type="text" name="f_label_level5_indonesian" id="f_label_level5_indonesian" class="form-control" placeholder="<?php echo $this->lang->line('level');?> 5 ..." aria-describedby="value_indonesian" value="<?php echo $level5['indonesian'];?>">
								</td>
								<td>
									<input type="text" name="f_label_level5_english" id="f_label_level5_english" class="form-control" placeholder="<?php echo $this->lang->line('level');?> 5 ..." aria-describedby="value_english" value="<?php echo $level5['english'];?>">
								</td>
								<td>
									<input type="text" name="f_label_level5_malaysia" id="f_label_level5_malaysia" class="form-control" placeholder="<?php echo $this->lang->line('level');?> 5 ..." aria-describedby="value_malaysia" value="<?php echo $level5['malaysia'];?>">
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<th colspan='5' style="text-align: center;"><input type="submit" name="submit" value="Ubah" id="btnSaveDemo" class="btn btn-success" /></th>
							</tr>
						</tfoot>
					</table>
					</form>
				</div> <!-- tab2 -->
				
				<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
					<form name="frmShortURL" id="frmShortURL" method="post" class="form-horizontal">
						<div class="form-group">
							<h3 class="col-md-10">URL Launcher</h3>
							<div class="col-md-6">
								<div id="aliasUrl" class="input-group">
								  <span class="input-group-addon">
									<?= site_url('c/');?>
								  </span>
								  <input type="text" name="alias_url" id="alias_url" class="form-control" placeholder="Alias Url ..." value="<?php echo $setting['url'];?>" data-rule-required="true" data-rule-alphanumeric="true" >
								  <span class="input-group-btn">
										<button type="button" id="copy" class="btn btn-default" data-clipboard-text="<?= site_url('c/');?><?php echo $setting['url'];?>" data-placement="bottom" title="Copied!">
										<img width="13" alt="Copy to clipboard" src="assets/images/clippy.svg" class="clippy" >
										</button>
								  </span>
								</div>
								<span>* <?php echo $this->lang->line('hanya_kn');?></span>
							</div>
							<div class="col-md-2" id="msgUrl" style="padding-top:7px">
							</div>
						</div>

						<div class="checkbox">
							<label class="col-md-12">
								<input type="checkbox" name="sesi" id="sesi" value="1" <?php if($setting['sesi'] == 1) { echo 'checked';} ?> > <?php echo $this->lang->line('session_y');?>
							</label>
						</div>
						<br/>	
						
						<div class="col-md-8" align="center" id="">
							<button class="btn btn-sm btn-success" id="btnSaveUrl"><?php echo $this->lang->line('simpan').' '.$this->lang->line('change');?></button>
						</div>
					</form>	
				</div> <!-- tab3 -->
			</div>  <!-- tab-content -->

			</div> <!-- end .card-body -->
			<div class="card-footer" align="right"> <!-- start box-footer -->
			  <p>Page rendered in <strong>{elapsed_time}</strong> seconds</p>
			</div> <!-- end .card-footer-->
		</div> <!-- end .card -->
	</div> <!-- end .container-fluid -->
</section><!-- /.content -->

<script>
var oTable;
$(document).ready(function(){
	bsCustomFileInput.init();
	$('#frmSetting_account').validate({
		highlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
		}		
	});
	
	var url = "<?php echo site_url('setting_account/fnSetting_accountUpdate');?>";
	// Menyimpan data
	$('#btnUpdate').click(function(e){
		e.preventDefault();
		$('#frmSetting_account').ajaxSubmit({
			type : 'POST',
			beforeSubmit : function() {
				$('.card-body').append('<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
			},
			dataType : 'json',
			url : url,
			success : function(msg) {
				if(msg.msg)
				{
					swal.fire({text: 'Sukses !!',icon: 'info',confirmButtonText:'Close',confirmButtonColor: '#1E90FF'})
					window.location.reload();
				}
				else
				{
					swal.fire({text: 'Gagal !!',icon: 'error',confirmButtonText:'Close',confirmButtonColor: '#FF0000'})
				}
			},
			error : function(e) {
				$('.overlay').remove();
			}
		});
	});
	
	$('#ckall').on('click',function(){
		$(this).is(':checked') ? $('.ck').prop("checked", true) : $('.ck').prop("checked", false);
	});

	$('#btnSaveDemo').click(function(e){
		e.preventDefault();
		$('#frmDemo').ajaxSubmit({
			type : 'POST',
			beforeSubmit : function() {
				$('.card-body').append('<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
			},
			dataType : 'json',
			url : '<?= site_url('setting_account/fnSetting_accountUpdateDemo');?>',
			success : function(msg) {
				if(msg.msg)
				{
					swal.fire({text: 'Sukses !!',icon: 'info',confirmButtonText:'Close',confirmButtonColor: '#1E90FF'})
				}
				else
				{
					swal.fire({text: 'Gagal !!',icon: 'error',confirmButtonText:'Close',confirmButtonColor: '#FF0000'})
				}
				$('.overlay').remove();
			},
			error : function(e) {
				$('.overlay').remove();
			}
		});
	});

	$('#frmShortURL').validate({
		highlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
		},
	});

	$('#btnSaveUrl').click(function(e){
		e.preventDefault();
		var urlSU = "<?= site_url('setting_account/fnSettingUpdateURL');?>";
		$('.card-body').append('<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
		var rec = $('#frmShortURL').serialize();
		$.post(urlSU, rec, function(data){
			if(data.msg == true)
			{
				swal.fire({text: 'Update ShortLink Sukses !!',icon: 'info',confirmButtonText:'Close',confirmButtonColor: '#1E90FF'})
				$("#msgUrl").html('');
				var aUrl = $("#alias_url");
				var cUrl = '<?= site_url('c/');?>'+aUrl.val();
				$("#copy").attr('data-clipboard-text',cUrl);
			}
			else
			{
				swal.fire({text: data.eStatus+' !!',icon: 'error',confirmButtonText:'Close',confirmButtonColor: '#FF0000'})
			}
			$('.overlay').remove();
		}, 'json');
		return false;
	});

	$("#f_account_email").on("keyup",function(){
		var emailCek = "<?php echo site_url();?>setting_account/fnSettingCekEmail/<?php echo sAccount;?>";
		var logEmail = $(this).val();
		$.post(emailCek,{email:logEmail},function(msg){
			//var rsl = msg.split("#");
			//console.log(rsl[0])
			if(msg.status == 200)
			{
				$("#msgEmail").html("<span class='text-green'>"+msg.pesan+"</span>");
				$("#f_account_email").removeClass('is-invalid');
				$("#f_account_email").addClass('is-valid');
			}
			else
			{
				$("#msgEmail").html("<span class='text-red'>"+msg.pesan+"</span>");
				$("#f_account_email").removeClass('is-valid');
				$("#f_account_email").addClass('is-invalid');
			}
		},'json');
	});


	$("#alias_url").on("keyup",function(){
		var urlCek = "<?php echo site_url();?>setting_account/fnSettingCekUrl/<?php echo sAccount;?>";
		var urlAlias = $(this).val();
		$.post(urlCek,{alias_url:urlAlias},function(msg){
			var rsl = msg.split("#");
			if(rsl[0] == 'S')
			{
				$("#msgUrl").html("<span class='text-green'><i class=\"fa fa-check\"></i> "+rsl[1]+"</span>");
				$("#aliasUrl").removeClass('has-error');
			}
			else
			{
				$("#msgUrl").html("<span class='text-red'><i class=\"fa fa-times\"></i> "+rsl[1]+"</span>");
				$("#aliasUrl").addClass('has-error');
			}
		});
	});


});

var clipboard = new Clipboard('#copy');
clipboard.on('success', function(e) {
	$('#copy').tooltip('show').mouseleave(function() {
		//$(this).tooltip('destroy');
	});	
});

function fnBack()
{
	window.location.href = "<?php echo site_url('setting_account');?>";
}
</script>



