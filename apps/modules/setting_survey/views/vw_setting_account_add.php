<!-- load css dan js -->
<script src="<?php echo PLUG_URL;?>jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo PLUG_URL;?>jquery/jquery.form.min.js"></script>
<script src="<?php echo PLUG_URL;?>ckeditor/ckeditor.js"></script>
<!-- end load css dan js -->
<?php 
$ochi = json_decode($setting['f_setting'],true); 
$f_page_personal = json_decode($setting['f_page_personal'],true);
//$f_page_personal_leader = json_decode($setting['f_page_personal_leader'],true);
//$f_page_desire_leader = json_decode($setting['f_page_desire_leader'],true);
//$f_page_current = unserialize($setting['f_page_current']);
//$f_page_desire = unserialize($setting['f_page_desire']);
//$f_page_current2 = unserialize($setting['f_page_current2']);
//$f_page_desire2 = unserialize($setting['f_page_desire2']);
//$f_page_current3 = unserialize($setting['f_page_current3']);
//$f_page_desire3 = unserialize($setting['f_page_desire3']);
$f_page_leaderc = json_decode($setting['f_page_leaderc'],true);
$f_page_leaderd = json_decode($setting['f_page_leaderd'],true);
//$f_page_terbuka = json_decode($setting['f_page_qopen'],true);

?>		

<section class="content">
	<div class="container-fluid">
		<div class="card no-border"> <!-- start .card -->
			
			<div class="card-body"> <!-- start .card-body -->
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
						<a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Indonesian</a>
					</li>
<!--
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">English</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Malaysia</a>
					</li>
-->
				</ul>
				<div class="col-md-12">&nbsp;</div>
				<form name="frmSetting" id="frmSetting" method="post" class="form-horizontal">
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal_welcome');?></h3>
<!--
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-6 .col-md-offset-4"><input type="text" name="welcome_title_indonesian" id="welcome_title_indonesian" class="form-control" placeholder="<?php echo $this->lang->line('judul');?> ..." value="<?php echo $ochi['f_page_welcome']['indonesian']['title'];?>" ></div>
							<div class="col-md-12"><br/></div>
-->
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('konten');?></label>
							<div class="col-md-10"><textarea name="welcome_content_indonesian" id="welcome_content_indonesian" placeholder="<?php echo $this->lang->line('konten');?>" rows="3" class="form-control textarea" required><?php echo $ochi['f_page_welcome']['indonesian']['content'];?></textarea></div>
						</div>

				
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal_terimakasih');?></h3>
<!--
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-6 .col-md-offset-4"><input type="text" name="thanks_title_indonesian" id="thanks_title_indonesian" class="form-control" placeholder="<?php echo $this->lang->line('judul');?> ..." value="<?php echo $ochi['f_page_thanks']['indonesian']['title'];?>" required></div>
							<div class="col-md-12"><br/></div>
-->
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('konten');?></label>
							<div class="col-md-10"><textarea name="thanks_content_indonesian" id="thanks_content_indonesian" placeholder="<?php echo $this->lang->line('konten');?>" rows="3" class="form-control textarea" required><?php echo $ochi['f_page_thanks']['indonesian']['content'];?></textarea></div>
						</div>

						<div class="form-group row">
							<h3 class="col-md-12">Demografi</h3>
<!--
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-6 .col-md-offset-4"><input type="text" name="howto_title_indonesian" id="howto_title_indonesian" class="form-control" placeholder="<?php echo $this->lang->line('judul');?> ..." value="<?php echo $ochi['f_page_howto']['indonesian']['title'];?>" ></div>
							<div class="col-md-12"><br/></div>
-->
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('konten');?></label>
							<div class="col-md-10"><textarea name="howto_content_indonesian" id="howto_content_indonesian" placeholder="<?php echo $this->lang->line('konten');?>" rows="12" class="form-control textarea" required><?php echo $ochi['f_page_howto']['indonesian']['content'];?></textarea></div>
						</div>

						<hr/>
<!--
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal');?> Personal Pimpinan</h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-10"><textarea name="f_page_personal_leader_judul_indonesian" id="f_page_personal_leader_judul_indonesian" placeholder="<?php echo $this->lang->line('judul');?> Personal" rows="3" class="form-control textarea" required><?php echo $f_page_personal_leader['judul']['indonesian'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('panduan');?></label>
							<div class="col-md-10"><textarea name="f_page_personal_leader_indonesian" id="f_page_personal_leader_indonesian" placeholder="<?php echo $this->lang->line('hal');?> Personal" rows="3" class="form-control textarea" required><?php echo $f_page_personal_leader['indonesian'];?></textarea></div>
						</div>
						<hr/>
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal');?> Personal Pimpinan Desire</h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-10"><textarea name="f_page_desire_leader_judul_indonesian" id="f_page_desire_leader_judul_indonesian" placeholder="<?php echo $this->lang->line('judul');?> Personal" rows="3" class="form-control textarea" required><?php echo $f_page_desire_leader['judul']['indonesian'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('panduan');?></label>
							<div class="col-md-10"><textarea name="f_page_desire_leader_indonesian" id="f_page_desire_leader_indonesian" placeholder="<?php echo $this->lang->line('hal');?> Personal" rows="3" class="form-control textarea" required><?php echo $f_page_desire_leader['indonesian'];?></textarea></div>
						</div>
						<hr/>
-->
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal');?> BAGIAN A</h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-10"><textarea name="f_page_personal_judul_indonesian" id="f_page_personal_judul_indonesian" placeholder="<?php echo $this->lang->line('judul');?> Personal" rows="3" class="form-control textarea" required><?php echo $f_page_personal['judul']['indonesian'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('panduan');?></label>
							<div class="col-md-10"><textarea name="f_page_personal_indonesian" id="f_page_personal_indonesian" placeholder="<?php echo $this->lang->line('hal');?> Personal" rows="3" class="form-control textarea" required><?php echo $f_page_personal['indonesian'];?></textarea></div>
						</div>
						<hr/>
--
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal');?>  BAGIAN B</h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-10"><textarea name="f_page_leaderc_judul_indonesian" id="f_page_leaderc_judul_indonesian" placeholder="<?php echo $this->lang->line('judul');?> Pimpinan Current" rows="3" class="form-control textarea" required><?php echo $f_page_leaderc['judul']['indonesian'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('panduan');?></label>
							<div class="col-md-10"><textarea name="f_page_leaderc_indonesian" id="f_page_leaderc_indonesian" placeholder="<?php echo $this->lang->line('hal');?> Pimpinan Current" rows="3" class="form-control textarea" required><?php echo $f_page_leaderc['indonesian'];?></textarea></div>					
						</div>
						<hr/>
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal');?>  BAGIAN C</h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-10"><textarea name="f_page_leaderd_judul_indonesian" id="f_page_leaderd_judul_indonesian" placeholder="<?php echo $this->lang->line('judul');?> Pimpinan Desire" rows="3" class="form-control textarea" required><?php echo $f_page_leaderd['judul']['indonesian'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('panduan');?></label>
							<div class="col-md-10"><textarea name="f_page_leaderd_indonesian" id="f_page_leaderd_indonesian" placeholder="<?php echo $this->lang->line('hal');?> Pimpinan Desire" rows="4" class="form-control textarea" required><?php echo $f_page_leaderd['indonesian'];?></textarea></div>
						</div>
						<hr/>
<!--
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal');?> Pertanyaan Terbuka</h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-10"><textarea name="f_page_terbuka_judul_indonesian" id="f_page_terbuka_judul_indonesian" placeholder="<?php echo $this->lang->line('judul');?> Pertanyaan Terbuka" rows="3" class="form-control textarea" required><?php echo $f_page_terbuka['judul']['indonesian'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('panduan');?></label>
							<div class="col-md-10"><textarea name="f_page_terbuka_indonesian" id="f_page_terbuka_indonesian" placeholder="<?php echo $this->lang->line('hal');?> Pertanyaan Terbuka" rows="4" class="form-control textarea" required><?php echo $f_page_terbuka['indonesian'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;">Pertanyaan</label>
							<div class="col-md-10"><textarea name="f_page_terbuka_tanya_indonesian" id="f_page_terbuka_tanya_indonesian" placeholder="" rows="4" class="form-control textarea" required><?php echo $f_page_terbuka['question']['indonesian'];?></textarea></div>
						</div>
					</div> <!-- tab-pane indonesian -->

<!--					
					<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal_welcome');?></h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-6 .col-md-offset-4"><input type="text" name="welcome_title_english" id="welcome_title_english" class="form-control" placeholder="<?php echo $this->lang->line('judul');?> ..." value="<?php echo $ochi['f_page_welcome']['english']['title'];?>" ></div>
							<div class="col-md-12"><br/></div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('konten');?></label>
							<div class="col-md-10"><textarea name="welcome_content_english" id="welcome_content_english" placeholder="<?php echo $this->lang->line('konten');?>" rows="3" class="form-control textarea" required><?php echo $ochi['f_page_welcome']['english']['content'];?></textarea></div>
						</div>

						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal_bagaimana');?></h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-6 .col-md-offset-4"><input type="text" name="howto_title_english" id="howto_title_english" class="form-control" placeholder="<?php echo $this->lang->line('judul');?> ..." value="<?php echo $ochi['f_page_howto']['english']['title'];?>" ></div>
							<div class="col-md-12"><br/></div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('konten');?></label>
							<div class="col-md-10"><textarea name="howto_content_english" id="howto_content_english" placeholder="<?php echo $this->lang->line('konten');?>" rows="12" class="form-control textarea" required><?php echo $ochi['f_page_howto']['english']['content'];?></textarea></div>
						</div>
				
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal_terimakasih');?></h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-6 .col-md-offset-4"><input type="text" name="thanks_title_english" id="thanks_title_english" class="form-control" placeholder="<?php echo $this->lang->line('judul');?> ..." value="<?php echo $ochi['f_page_thanks']['english']['title'];?>" required></div>
							<div class="col-md-12"><br/></div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('konten');?></label>
							<div class="col-md-10"><textarea name="thanks_content_english" id="thanks_content_english" placeholder="<?php echo $this->lang->line('konten');?>" rows="3" class="form-control textarea" required><?php echo $ochi['f_page_thanks']['english']['content'];?></textarea></div>
						</div>
						<hr/>
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal');?> Personal Pimpinan</h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-10"><textarea name="f_page_personal_leader_judul_english" id="f_page_personal_leader_judul_english" placeholder="<?php echo $this->lang->line('judul');?> Personal" rows="3" class="form-control textarea" required><?php echo $f_page_personal_leader['judul']['english'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('panduan');?></label>
							<div class="col-md-10"><textarea name="f_page_personal_leader_english" id="f_page_personal_leader_english" placeholder="<?php echo $this->lang->line('hal');?> Personal" rows="3" class="form-control textarea" required><?php echo $f_page_personal_leader['english'];?></textarea></div>
						</div>
						<hr/>
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal');?> Personal Pimpinan Desire</h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-10"><textarea name="f_page_desire_leader_judul_english" id="f_page_desire_leader_judul_english" placeholder="<?php echo $this->lang->line('judul');?> Personal" rows="3" class="form-control textarea" required><?php echo $f_page_desire_leader['judul']['english'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('panduan');?></label>
							<div class="col-md-10"><textarea name="f_page_desire_leader_english" id="f_page_desire_leader_english" placeholder="<?php echo $this->lang->line('hal');?> Personal" rows="3" class="form-control textarea" required><?php echo $f_page_desire_leader['english'];?></textarea></div>
						</div>
						<hr/>
<!--
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal');?> Personal</h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-10"><textarea name="f_page_personal_judul_english" id="f_page_personal_judul_english" placeholder="<?php echo $this->lang->line('judul');?> Personal" rows="3" class="form-control textarea" required><?php echo $f_page_personal['judul']['english'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('panduan');?></label>
							<div class="col-md-10"><textarea name="f_page_personal_english" id="f_page_personal_english" placeholder="<?php echo $this->lang->line('hal');?> Personal" rows="3" class="form-control textarea" required><?php echo $f_page_personal['english'];?></textarea></div>
						</div>
						<hr/>
--
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal');?> Pimpinan Current</h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-10"><textarea name="f_page_leaderc_judul_english" id="f_page_leaderc_judul_english" placeholder="<?php echo $this->lang->line('judul');?> Pimpinan Current" rows="3" class="form-control textarea" required><?php echo $f_page_leaderc['judul']['english'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('panduan');?></label>
							<div class="col-md-10"><textarea name="f_page_leaderc_english" id="f_page_leaderc_english" placeholder="<?php echo $this->lang->line('hal');?> Pimpinan Current" rows="3" class="form-control textarea" required><?php echo $f_page_leaderc['english'];?></textarea></div>					
						</div>
						<hr/>
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal');?> Pimpinan Desire</h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-10"><textarea name="f_page_leaderd_judul_english" id="f_page_leaderd_judul_english" placeholder="<?php echo $this->lang->line('judul');?> Pimpinan Desire" rows="3" class="form-control textarea" required><?php echo $f_page_leaderd['judul']['english'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('panduan');?></label>
							<div class="col-md-10"><textarea name="f_page_leaderd_english" id="f_page_leaderd_english" placeholder="<?php echo $this->lang->line('hal');?> Pimpinan Desire" rows="4" class="form-control textarea" required><?php echo $f_page_leaderd['english'];?></textarea></div>
						</div>
						<hr/>
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal');?> Pertanyaan Terbuka</h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-10"><textarea name="f_page_terbuka_judul_english" id="f_page_terbuka_judul_english" placeholder="<?php echo $this->lang->line('judul');?> Pertanyaan Terbuka" rows="3" class="form-control textarea" required><?php echo $f_page_terbuka['judul']['english'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('panduan');?></label>
							<div class="col-md-10"><textarea name="f_page_terbuka_english" id="f_page_terbuka_english" placeholder="<?php echo $this->lang->line('hal');?> Pertanyaan Terbuka" rows="4" class="form-control textarea" required><?php echo $f_page_terbuka['english'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;">Pertanyaan</label>
							<div class="col-md-10"><textarea name="f_page_terbuka_tanya_english" id="f_page_terbuka_tanya_english" placeholder="" rows="4" class="form-control textarea" required><?php echo $f_page_terbuka['question']['english'];?></textarea></div>
						</div>
					</div> <!-- tab-pane english-->
<!--					
					<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal_welcome');?></h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-6 .col-md-offset-4"><input type="text" name="welcome_title_malaysia" id="welcome_title_malaysia" class="form-control" placeholder="<?php echo $this->lang->line('judul');?> ..." value="<?php echo $ochi['f_page_welcome']['malaysia']['title'];?>" ></div>
							<div class="col-md-12"><br/></div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('konten');?></label>
							<div class="col-md-10"><textarea name="welcome_content_malaysia" id="welcome_content_malaysia" placeholder="<?php echo $this->lang->line('konten');?>" rows="3" class="form-control textarea" required><?php echo $ochi['f_page_welcome']['malaysia']['content'];?></textarea></div>
						</div>

						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal_bagaimana');?></h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-6 .col-md-offset-4"><input type="text" name="howto_title_malaysia" id="howto_title_malaysia" class="form-control" placeholder="<?php echo $this->lang->line('judul');?> ..." value="<?php echo $ochi['f_page_howto']['malaysia']['title'];?>" ></div>
							<div class="col-md-12"><br/></div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('konten');?></label>
							<div class="col-md-10"><textarea name="howto_content_malaysia" id="howto_content_malaysia" placeholder="<?php echo $this->lang->line('konten');?>" rows="12" class="form-control textarea" required><?php echo $ochi['f_page_howto']['malaysia']['content'];?></textarea></div>
						</div>
				
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal_terimakasih');?></h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-6 .col-md-offset-4"><input type="text" name="thanks_title_malaysia" id="thanks_title_malaysia" class="form-control" placeholder="<?php echo $this->lang->line('judul');?> ..." value="<?php echo $ochi['f_page_thanks']['malaysia']['title'];?>" required></div>
							<div class="col-md-12"><br/></div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('konten');?></label>
							<div class="col-md-10"><textarea name="thanks_content_malaysia" id="thanks_content_malaysia" placeholder="<?php echo $this->lang->line('konten');?>" rows="3" class="form-control textarea" required><?php echo $ochi['f_page_thanks']['malaysia']['content'];?></textarea></div>
						</div>
						<hr/>
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal');?> Personal Pimpinan</h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-10"><textarea name="f_page_personal_leader_judul_malaysia" id="f_page_personal_leader_judul_malaysia" placeholder="<?php echo $this->lang->line('judul');?> Personal" rows="3" class="form-control textarea" required><?php echo $f_page_personal_leader['judul']['malaysia'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('panduan');?></label>
							<div class="col-md-10"><textarea name="f_page_personal_leader_malaysia" id="f_page_personal_leader_malaysia" placeholder="<?php echo $this->lang->line('hal');?> Personal" rows="3" class="form-control textarea" required><?php echo $f_page_personal_leader['malaysia'];?></textarea></div>
						</div>
						<hr/>
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal');?> Personal Pimpinan Desire</h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-10"><textarea name="f_page_desire_leader_judul_malaysia" id="f_page_desire_leader_judul_malaysia" placeholder="<?php echo $this->lang->line('judul');?> Personal" rows="3" class="form-control textarea" required><?php echo $f_page_desire_leader['judul']['malaysia'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('panduan');?></label>
							<div class="col-md-10"><textarea name="f_page_desire_leader_malaysia" id="f_page_desire_leader_malaysia" placeholder="<?php echo $this->lang->line('hal');?> Personal" rows="3" class="form-control textarea" required><?php echo $f_page_desire_leader['malaysia'];?></textarea></div>
						</div>
						<hr/>
<!--
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal');?> Personal</h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-10"><textarea name="f_page_personal_judul_malaysia" id="f_page_personal_judul_malaysia" placeholder="<?php echo $this->lang->line('judul');?> Personal" rows="3" class="form-control textarea" required><?php echo $f_page_personal['judul']['malaysia'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('panduan');?></label>
							<div class="col-md-10"><textarea name="f_page_personal_malaysia" id="f_page_personal_malaysia" placeholder="<?php echo $this->lang->line('hal');?> Personal" rows="3" class="form-control textarea" required><?php echo $f_page_personal['malaysia'];?></textarea></div>
						</div>
						<hr/>
--
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal');?> Pimpinan Current</h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-10"><textarea name="f_page_leaderc_judul_malaysia" id="f_page_leaderc_judul_malaysia" placeholder="<?php echo $this->lang->line('judul');?> Pimpinan Current" rows="3" class="form-control textarea" required><?php echo $f_page_leaderc['judul']['malaysia'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('panduan');?></label>
							<div class="col-md-10"><textarea name="f_page_leaderc_malaysia" id="f_page_leaderc_malaysia" placeholder="<?php echo $this->lang->line('hal');?> Pimpinan Current" rows="3" class="form-control textarea" required><?php echo $f_page_leaderc['malaysia'];?></textarea></div>					
						</div>
						<hr/>
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal');?> Pimpinan Desire</h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-10"><textarea name="f_page_leaderd_judul_malaysia" id="f_page_leaderd_judul_malaysia" placeholder="<?php echo $this->lang->line('judul');?> Pimpinan Desire" rows="3" class="form-control textarea" required><?php echo $f_page_leaderd['judul']['malaysia'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('panduan');?></label>
							<div class="col-md-10"><textarea name="f_page_leaderd_malaysia" id="f_page_leaderd_malaysia" placeholder="<?php echo $this->lang->line('hal');?> Pimpinan Desire" rows="4" class="form-control textarea" required><?php echo $f_page_leaderd['malaysia'];?></textarea></div>
						</div>
						<hr/>
						<div class="form-group row">
							<h3 class="col-md-12"><?php echo $this->lang->line('hal');?> Pertanyaan Terbuka</h3>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('judul');?></label>
							<div class="col-md-10"><textarea name="f_page_terbuka_judul_malaysia" id="f_page_terbuka_judul_malaysia" placeholder="<?php echo $this->lang->line('judul');?> Pertanyaan Terbuka" rows="3" class="form-control textarea" required><?php echo $f_page_terbuka['judul']['malaysia'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;"><?php echo $this->lang->line('panduan');?></label>
							<div class="col-md-10"><textarea name="f_page_terbuka_malaysia" id="f_page_terbuka_malaysia" placeholder="<?php echo $this->lang->line('hal');?> Pertanyaan Terbuka" rows="4" class="form-control textarea" required><?php echo $f_page_terbuka['malaysia'];?></textarea></div>
							<div class="col-md-12">&nbsp;</div>
							<label class="col-md-2" style="padding-top:7px;">Pertanyaan</label>
							<div class="col-md-10"><textarea name="f_page_terbuka_tanya_malaysia" id="f_page_terbuka_tanya_malaysia" placeholder="" rows="4" class="form-control textarea" required><?php echo $f_page_terbuka['question']['malaysia'];?></textarea></div>
						</div>
					</div> <!-- tab-pane -->
					
					<div class="col-md-12">&nbsp;</div>
					<div class="col-md-12" align="center" id="fnButton">
			<?php 	
				if($fAct == 'Add')	echo '<input type="submit" name="submit" value="Save" id="btnSave" class="btn btn-success" />';
	
				if($fAct == 'Edit')	echo '<input type="submit" name="submit" value="Save Changes" id="btnUpdate" class="btn btn-success" />';
			?>
					</div>
				</form>
				</div>

			</div> <!-- end .card-body -->
		</div> <!-- end .card -->
	</div> <!-- end .container-fluid -->
</section><!-- /.content -->

<script>
var oTable;
//var toolb = [{"name":"basicstyles"},{"name":"paragraph","groups":["list"]},{"name":"styles"},{ "name": 'colors' },];
var toolb = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },'/',
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];
var rmButton = 	'Flash,Source,Save,NewPage,Print,Templates,Replace,Find,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,BidiLtr,BidiRtl,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,About,Maximize,ShowBlocks,Language,CreateDiv,Blockquote,CopyFormatting,RemoveFormat,Strike,Subscript,Superscript,Iframe,Video';
var welcome_content_indonesian = CKEDITOR.replace('welcome_content_indonesian',{
	language: 'id', height:'750px', toolbarGroups: toolb, removeButtons: rmButton 
});

var welcome_content_english = CKEDITOR.replace('welcome_content_english',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var welcome_content_malaysia = CKEDITOR.replace('welcome_content_malaysia',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});

var howto_content_indonesian = CKEDITOR.replace('howto_content_indonesian',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var howto_content_english = CKEDITOR.replace('howto_content_english',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var howto_content_malaysia = CKEDITOR.replace('howto_content_malaysia',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});

var thanks_content_indonesian = CKEDITOR.replace('thanks_content_indonesian',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var thanks_content_english = CKEDITOR.replace('thanks_content_english',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var thanks_content_malaysia = CKEDITOR.replace('thanks_content_malaysia',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});

//var f_page_personal_leader_judul_indonesian = CKEDITOR.replace('f_page_personal_leader_judul_indonesian',{
	//language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
//});
//var f_page_personal_leader_indonesian = CKEDITOR.replace('f_page_personal_leader_indonesian',{
	//language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
//});
//var f_page_desire_leader_judul_indonesian = CKEDITOR.replace('f_page_desire_leader_judul_indonesian',{
	//language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
//});
//var f_page_desire_leader_indonesian = CKEDITOR.replace('f_page_desire_leader_indonesian',{
	//language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
//});

var f_page_personal_leader_judul_english = CKEDITOR.replace('f_page_personal_leader_judul_english',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_personal_leader_english = CKEDITOR.replace('f_page_personal_leader_english',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_desire_leader_judul_english = CKEDITOR.replace('f_page_desire_leader_judul_english',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_desire_leader_english = CKEDITOR.replace('f_page_desire_leader_english',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});

var f_page_personal_leader_judul_malaysia = CKEDITOR.replace('f_page_personal_leader_judul_malaysia',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_personal_leader_malaysia = CKEDITOR.replace('f_page_personal_leader_malaysia',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_desire_leader_judul_malaysia = CKEDITOR.replace('f_page_desire_leader_judul_malaysia',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_desire_leader_malaysia = CKEDITOR.replace('f_page_desire_leader_malaysia',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_personal_leader_judul_indonesian = CKEDITOR.replace('f_page_personal_judul_indonesian',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_personal_indonesian = CKEDITOR.replace('f_page_personal_indonesian',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
//var f_page_personal_judul_english = CKEDITOR.replace('f_page_personal_judul_english',{
	//language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
//});
//var f_page_personal_english = CKEDITOR.replace('f_page_personal_english',{
	//language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
//});
//var f_page_personal_judul_malaysia = CKEDITOR.replace('f_page_personal_judul_malaysia',{
	//language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
//});
//var f_page_personal_malaysia = CKEDITOR.replace('f_page_personal_malaysia',{
	//language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
//});
var f_page_leaderc_judul_indonesian = CKEDITOR.replace('f_page_leaderc_judul_indonesian',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_leaderc_indonesian = CKEDITOR.replace('f_page_leaderc_indonesian',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_leaderc_judul_english = CKEDITOR.replace('f_page_leaderc_judul_english',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_leaderc_english = CKEDITOR.replace('f_page_leaderc_english',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_leaderc_judul_malaysia = CKEDITOR.replace('f_page_leaderc_judul_malaysia',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_leaderc_malaysia = CKEDITOR.replace('f_page_leaderc_malaysia',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});

var f_page_leaderd_judul_indonesian = CKEDITOR.replace('f_page_leaderd_judul_indonesian',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_leaderd_indonesian = CKEDITOR.replace('f_page_leaderd_indonesian',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_leaderd_judul_english = CKEDITOR.replace('f_page_leaderd_judul_english',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_leaderd_english = CKEDITOR.replace('f_page_leaderd_english',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_leaderd_judul_malaysia = CKEDITOR.replace('f_page_leaderd_judul_malaysia',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_leaderd_malaysia = CKEDITOR.replace('f_page_leaderd_malaysia',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});

//var f_page_terbuka_judul_indonesian = CKEDITOR.replace('f_page_terbuka_judul_indonesian',{
	//language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
//});
//var f_page_terbuka_indonesian = CKEDITOR.replace('f_page_terbuka_indonesian',{
	//language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
//});
//var f_page_terbuka_tanya_indonesian = CKEDITOR.replace('f_page_terbuka_tanya_indonesian',{
	//language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
//});

var f_page_terbuka_judul_english = CKEDITOR.replace('f_page_terbuka_judul_english',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_terbuka_english = CKEDITOR.replace('f_page_terbuka_english',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_terbuka_tanya_english = CKEDITOR.replace('f_page_terbuka_tanya_english',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});

var f_page_terbuka_judul_malaysia = CKEDITOR.replace('f_page_terbuka_judul_malaysia',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_terbuka_malaysia = CKEDITOR.replace('f_page_terbuka_malaysia',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});
var f_page_terbuka_tanya_malaysia = CKEDITOR.replace('f_page_terbuka_tanya_malaysia',{
	language: 'id', height:'125px', toolbarGroups: toolb, removeButtons: rmButton 
});

$(document).ready(function(){
	var url = "<?php echo site_url('setting_survey/fnSetting_accountUpdate');?>";
	$('#frmSetting').validate({
		highlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('is-valid').addClass('is-invalid');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('is-invalid').addClass('is-valid');
		},
		submitHandler: function (form) {
			var rec = $('#frmSetting').serialize();
			$.post(url, rec, function(data){
				if(data.msg == true)
				{
					swal.fire({text: 'Success !!',icon: 'success',confirmButtonText:'Close'})
				}
				else
				{
					swal.fire({text: 'Gagal !!',icon: 'error',confirmButtonText:'Close',confirmButtonColor: '#FF0000'})
				}
			}, 'json');
			return false;
		}		
	});

	jQuery.validator.addMethod("alphanumeric", function(value, element) {
		return this.optional(element) || value == value.match(/^[a-z0-9A-Z#.]+$/);
	},"Only Characters, Numbers & Hash Allowed."); 
	CKEDITOR.instances['welcome_content_indonesian'].on('change', function() { CKEDITOR.instances['welcome_content_indonesian'].updateElement() });
	//CKEDITOR.instances['welcome_content_english'].on('change', function() { CKEDITOR.instances['welcome_content_english'].updateElement() });
	//CKEDITOR.instances['welcome_content_malaysia'].on('change', function() { CKEDITOR.instances['welcome_content_malaysia'].updateElement() });

	//CKEDITOR.instances['howto_content_indonesian'].on('change', function() { CKEDITOR.instances['howto_content_indonesian'].updateElement() });
	//CKEDITOR.instances['howto_content_english'].on('change', function() { CKEDITOR.instances['howto_content_english'].updateElement() });
	//CKEDITOR.instances['howto_content_malaysia'].on('change', function() { CKEDITOR.instances['howto_content_malaysia'].updateElement() });

	CKEDITOR.instances['thanks_content_indonesian'].on('change', function() { CKEDITOR.instances['thanks_content_indonesian'].updateElement() });
	//CKEDITOR.instances['thanks_content_english'].on('change', function() { CKEDITOR.instances['thanks_content_english'].updateElement() });
	//CKEDITOR.instances['thanks_content_malaysia'].on('change', function() { CKEDITOR.instances['thanks_content_malaysia'].updateElement() });

	// personal pimpinan
	//CKEDITOR.instances['f_page_personal_leader_judul_indonesian'].on('change', function() { CKEDITOR.instances['f_page_personal_leader_judul_indonesian'].updateElement() });
	//CKEDITOR.instances['f_page_personal_leader_judul_english'].on('change', function() { CKEDITOR.instances['f_page_personal_leader_judul_english'].updateElement() });
	//CKEDITOR.instances['f_page_personal_leader_judul_malaysia'].on('change', function() { CKEDITOR.instances['f_page_personal_leader_judul_malaysia'].updateElement() });
	//CKEDITOR.instances['f_page_personal_leader_indonesian'].on('change', function() { CKEDITOR.instances['f_page_personal_leader_indonesian'].updateElement() });
	//CKEDITOR.instances['f_page_personal_leader_english'].on('change', function() { CKEDITOR.instances['f_page_personal_leader_english'].updateElement() });
	//CKEDITOR.instances['f_page_personal_leader_malaysia'].on('change', function() { CKEDITOR.instances['f_page_personal_leader_malaysia'].updateElement() });

	// personal pimpinan desire
	//CKEDITOR.instances['f_page_desire_leader_judul_indonesian'].on('change', function() { CKEDITOR.instances['f_page_desire_leader_judul_indonesian'].updateElement() });
	//CKEDITOR.instances['f_page_desire_leader_judul_english'].on('change', function() { CKEDITOR.instances['f_page_desire_leader_judul_english'].updateElement() });
	//CKEDITOR.instances['f_page_desire_leader_judul_malaysia'].on('change', function() { CKEDITOR.instances['f_page_desire_leader_judul_malaysia'].updateElement() });
	//CKEDITOR.instances['f_page_desire_leader_indonesian'].on('change', function() { CKEDITOR.instances['f_page_desire_leader_indonesian'].updateElement() });
	//CKEDITOR.instances['f_page_desire_leader_english'].on('change', function() { CKEDITOR.instances['f_page_desire_leader_english'].updateElement() });
	//CKEDITOR.instances['f_page_desire_leader_malaysia'].on('change', function() { CKEDITOR.instances['f_page_desire_leader_malaysia'].updateElement() });

	// personal
	CKEDITOR.instances['f_page_personal_judul_indonesian'].on('change', function() { CKEDITOR.instances['f_page_personal_judul_indonesian'].updateElement() });
	//CKEDITOR.instances['f_page_personal_judul_english'].on('change', function() { CKEDITOR.instances['f_page_personal_judul_english'].updateElement() });
	//CKEDITOR.instances['f_page_personal_judul_malaysia'].on('change', function() { CKEDITOR.instances['f_page_personal_judul_malaysia'].updateElement() });
	CKEDITOR.instances['f_page_personal_indonesian'].on('change', function() { CKEDITOR.instances['f_page_personal_indonesian'].updateElement() });
	//CKEDITOR.instances['f_page_personal_english'].on('change', function() { CKEDITOR.instances['f_page_personal_english'].updateElement() });
	//CKEDITOR.instances['f_page_personal_malaysia'].on('change', function() { CKEDITOR.instances['f_page_personal_malaysia'].updateElement() });

	// leaderc
	CKEDITOR.instances['f_page_leaderc_judul_indonesian'].on('change', function() { CKEDITOR.instances['f_page_leaderc_judul_indonesian'].updateElement() });
	//CKEDITOR.instances['f_page_leaderc_judul_english'].on('change', function() { CKEDITOR.instances['f_page_leaderc_judul_english'].updateElement() });
	//CKEDITOR.instances['f_page_leaderc_judul_malaysia'].on('change', function() { CKEDITOR.instances['f_page_leaderc_judul_malaysia'].updateElement() });
	CKEDITOR.instances['f_page_leaderc_indonesian'].on('change', function() { CKEDITOR.instances['f_page_leaderc_indonesian'].updateElement() });
	//CKEDITOR.instances['f_page_leaderc_english'].on('change', function() { CKEDITOR.instances['f_page_leaderc_english'].updateElement() });
	//CKEDITOR.instances['f_page_leaderc_malaysia'].on('change', function() { CKEDITOR.instances['f_page_leaderc_malaysia'].updateElement() });
	// leaderd
	CKEDITOR.instances['f_page_leaderd_judul_indonesian'].on('change', function() { CKEDITOR.instances['f_page_leaderd_judul_indonesian'].updateElement() });
	//CKEDITOR.instances['f_page_leaderd_judul_english'].on('change', function() { CKEDITOR.instances['f_page_leaderd_judul_english'].updateElement() });
	//CKEDITOR.instances['f_page_leaderd_judul_malaysia'].on('change', function() { CKEDITOR.instances['f_page_leaderd_judul_malaysia'].updateElement() });
	CKEDITOR.instances['f_page_leaderd_indonesian'].on('change', function() { CKEDITOR.instances['f_page_leaderd_indonesian'].updateElement() });
	//CKEDITOR.instances['f_page_leaderd_english'].on('change', function() { CKEDITOR.instances['f_page_leaderd_english'].updateElement() });
	//CKEDITOR.instances['f_page_leaderd_malaysia'].on('change', function() { CKEDITOR.instances['f_page_leaderd_malaysia'].updateElement() });
	// pertanyaan terbuka
	//CKEDITOR.instances['f_page_terbuka_judul_indonesian'].on('change', function() { CKEDITOR.instances['f_page_terbuka_judul_indonesian'].updateElement() });
	//CKEDITOR.instances['f_page_terbuka_indonesian'].on('change', function() { CKEDITOR.instances['f_page_terbuka_indonesian'].updateElement() });
	//CKEDITOR.instances['f_page_terbuka_tanya_indonesian'].on('change', function() { CKEDITOR.instances['f_page_terbuka_tanya_indonesian'].updateElement() });
	//CKEDITOR.instances['f_page_terbuka_judul_english'].on('change', function() { CKEDITOR.instances['f_page_terbuka_judul_english'].updateElement() });
	//CKEDITOR.instances['f_page_terbuka_english'].on('change', function() { CKEDITOR.instances['f_page_terbuka_english'].updateElement() });
	//CKEDITOR.instances['f_page_terbuka_tanya_english'].on('change', function() { CKEDITOR.instances['f_page_terbuka_tanya_english'].updateElement() });
	//CKEDITOR.instances['f_page_terbuka_judul_malaysia'].on('change', function() { CKEDITOR.instances['f_page_terbuka_judul_malaysia'].updateElement() });
	//CKEDITOR.instances['f_page_terbuka_malaysia'].on('change', function() { CKEDITOR.instances['f_page_terbuka_malaysia'].updateElement() });
	//CKEDITOR.instances['f_page_terbuka_tanya_malaysia'].on('change', function() { CKEDITOR.instances['f_page_terbuka_tanya_malaysia'].updateElement() });
	
	
	//$('#frmSetting').submit(function(e){
		//e.preventDefault();
		
	//});
});

</script>	
