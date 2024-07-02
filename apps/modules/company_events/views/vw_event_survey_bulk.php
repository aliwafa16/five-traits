<!-- load css dan js -->
<link type="text/css" rel="stylesheet" href="<?php echo PLUG_URL;?>fancybox/source/jquery.fancybox.css"/>
<link type="text/css" rel="stylesheet" href="<?php echo PLUG_URL;?>bootstrap-colorpicker/css/bootstrap-colorpicker.min.css"/>
<link type="text/css" rel="stylesheet" href="<?php echo PLUG_URL;?>datatables/dataTables.bootstrap.min.css" />
<script src="<?php echo PLUG_URL;?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo PLUG_URL;?>datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo PLUG_URL;?>jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo PLUG_URL;?>jquery/jquery.form.min.js"></script>
<script src="<?php echo PLUG_URL;?>bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo PLUG_URL;?>ckeditor/ckeditor.js"></script>
<script src="<?php echo PLUG_URL;?>fancybox/source/jquery.fancybox.js"></script>
<script type="text/javascript" src="<?php echo PLUG_URL;?>bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- end load css dan js -->

<section class="content">
	<div class="container-fluid">
		<div class="card"> <!-- start .card -->
			<div class="card-header"> <!-- start .card-header -->
				<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
					<li class="nav-item" role="presentation">
						<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Data Email/Responden</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Template Email Responden</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-leader" role="tab" aria-controls="pills-leader" aria-selected="false">Template Email Leader</a>
					</li>
				</ul>
			</div> <!-- end .card-header -->
			
			<div class="card-body"> <!-- start .card-body -->
			<div class="tab-content" id="pills-tabContent">
				<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
					<form name="frmUpload" id="frmUpload" method="post" class="form-horizontal">
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Leaders <span class="text-red">*</span></label>
						<div class="col-md-4">
						<?php
						echo form_dropdown('fleaders',$leaders,false,'id="fleaders" class="fleaders form-control select"');
						?>
						</div>
						<div class="col-md-4">
		                    <div class="custom-file">
		                      <input type="file" class="custom-file-input" name="file" id="file" accept="application/vnd.ms-excel">
		                      <label class="custom-file-label" for="customFile">Choose Excel 97-2003</label>
		                    </div>
						</div>
						<div class="col-md-2" align="center">
						<?php 	
							echo '<input type="submit" name="submit" value="Upload" id="btnSave" class="btn btn-success" />';
						?>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-12 col-xs-12">
							<ul class="text-warning" style="font-size:12pt;">
								<li>Berikut template excel untuk upload file <a class="btn btn-info btn-sm" href="<?= base_url('import_data_email_invitation.xls');?>"><i class="fa fa-download"></i> Download</a></li>
							</ul>	
						</div>	
					</div>	
					</form>
					<hr/>
					<div class="col-12" align="center">
						<button class="btn btn-primary" id="sendmail"><i class="fas fa-paper-plane"></i> <?php echo strtoupper($this->lang->line('kirim'));?> FIRST SEND EMAIL</button>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button class="btn btn-info" id="sendmailreminder"><i class="fas fa-paper-plane"></i> <?php echo strtoupper($this->lang->line('kirim'));?> REMINDER EMAIL</button>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button class="btn btn-primary" onClick="oTable.ajax.reload();"><i class="fas fa-sync-alt"></i> REFRESH TABLE</button>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button class="btn btn-danger" onClick="deleteAll();"><i class="far fa-trash-alt"></i> HAPUS SEMUA EMAIL</button>
					</div>
					
					<hr/>
					<table id="table_email" class="table datares">
						<thead>
							<tr>				
								<th>Survey Leaders</th>				
								<th>Email</th>				
								<th>Nama</th>				
								<th>NIK</th>				
								<th>Unik Link</th>				
								<th>Sent</th>				
								<th>Date</th>				
								<th>Respon</th>		
								<th>Survey</th>		
								<th>Date</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
					
				</div> <!-- tab1 -->

				<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

					<form name="frmTemplate_email" id="frmTemplate_email" method="post" class="form-horizontal">
						<div class="form-group row">
							<label class="col-md-2" style="padding-top:7px;">SUBJECT</label>
							<div class="col-md-6"><input type="text" name="f_subject_name" id="f_subject_name" class="form-control" placeholder="Subject ..." value="<?php echo $result_template['f_subject'];?>" ></div>
						</div>
						<div class="form-group row">
							<label class="col-md-2" style="padding-top:7px;">HEADER</label>
							<div class="col-md-6 input-group">
								<input type="text" name="f_header_name" id="f_header_name" class="form-control" placeholder="HEADER ..." value="<?php echo $result_template['f_header'];?>" >
								<div class="col-md-1 input-group-append my-header formcolorpicker colorpicker-component" >
									<input type="hidden" class="form-control" name="header_color" id="header_color" value="<?php echo $result_template['f_header_color'];//: '#558ae5';?>"/>
									<span class="input-group-text colorpicker-input-addon"><i class="fas fa-square"></i></span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2" style="padding-top:7px;">BODY</label>
							<div class="col-md-12"><textarea name="f_tmp_text" id="f_tmp_text" placeholder="BODY" rows="3" class="form-control textarea"><?php echo $result_template['f_body'];?></textarea></div>
						</div>
						<div class="form-group row">
							<label class="col-md-1" style="padding-top:7px;">BUTTON</label>
							<div class="col-md-6 input-group">
								<input type="text" name="f_button_name" id="f_button_name" class="form-control" placeholder="BUTTON ..." value="<?php echo $result_template['f_button'];?>" >
								<div class="col-md-1 input-group-append my-button formcolorpicker colorpicker-component" data-color="<?php echo ($result_template['f_button_color']) ? $result_template['f_button_color']: '#558ae5';?>">
									<input type="hidden" class="form-control" name="button_color" id="button_color" value="<?php echo $result_template['f_button_color'];?>"/>
									<span class="input-group-text  colorpicker-input-addon"><i class="fas fa-square"></i></span>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12" align="center" id="fnButton">
								<input type="submit" name="submit" value="<?php echo $this->lang->line('simpan');?>" id="btnSaveTemp" class="btn btn-success" />
								&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="submit" name="submit" value="<?php echo $this->lang->line('pview');?>" id="btnPreview" class="btn btn-info" />
								<div class="pull-right" id="template_update">
									UPDATE ON : <?php echo $result_template['f_update_on'];?>
								</div>
							</div>
						</div>
					</form>

					
				</div> <!-- tab2 -->
				
				<div class="tab-pane fade" id="pills-leader" role="tabpanel" aria-labelledby="pills-leader-tab">

					<form name="frmTemplate_emailLeader" id="frmTemplate_emailLeader" method="post" class="form-horizontal">
						<div class="form-group row">
							<label class="col-md-2" style="padding-top:7px;">SUBJECT</label>
							<div class="col-md-6"><input type="text" name="f_subject_name_leader" id="f_subject_name_leader" class="form-control" placeholder="Subject ..." value="<?php echo $result_template_leader['f_subject'];?>" ></div>
						</div>
						<div class="form-group row">
							<label class="col-md-2" style="padding-top:7px;">HEADER</label>
							<div class="col-md-6 input-group">
								<input type="text" name="f_header_name_leader" id="f_header_name_leader" class="form-control" placeholder="HEADER ..." value="<?php echo $result_template_leader['f_header'];?>" >
								<div class="col-md-1 input-group-append my-header formcolorpicker colorpicker-component" >
									<input type="hidden" class="form-control" name="header_color_leader" id="header_color_leader" value="<?php echo $result_template_leader['f_header_color'];//: '#558ae5';?>"/>
									<span class="input-group-text colorpicker-input-addon"><i class="fas fa-square"></i></span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2" style="padding-top:7px;">BODY</label>
							<div class="col-md-12"><textarea name="f_tmp_text_leader" id="f_tmp_text_leader" placeholder="BODY" rows="3" class="form-control textarea"><?php echo $result_template_leader['f_body'];?></textarea></div>
						</div>
						<div class="form-group row">
							<label class="col-md-1" style="padding-top:7px;">BUTTON</label>
							<div class="col-md-6 input-group">
								<input type="text" name="f_button_name_leader" id="f_button_name_leader" class="form-control" placeholder="BUTTON ..." value="<?php echo $result_template_leader['f_button'];?>" >
								<div class="col-md-1 input-group-append my-button formcolorpicker colorpicker-component" data-color="<?php echo ($result_template_leader['f_button_color']) ? $result_template_leader['f_button_color']: '#558ae5';?>">
									<input type="hidden" class="form-control" name="button_color_leader" id="button_color_leader" value="<?php echo $result_template_leader['f_button_color'];?>"/>
									<span class="input-group-text  colorpicker-input-addon"><i class="fas fa-square"></i></span>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12" align="center" id="fnButton">
								<input type="submit" name="submit_leader" value="<?php echo $this->lang->line('simpan');?>" id="btnSaveTempLeader" class="btn btn-success" />
								&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="submit" name="submit_leader" value="<?php echo $this->lang->line('pview');?>" id="btnPreviewLeader" class="btn btn-info" />
								<div class="pull-right" id="template_update">
									UPDATE ON : <?php echo $result_template_leader['f_update_on'];?>
								</div>
							</div>
						</div>
					</form>

					
				</div> <!-- tab2 -->

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
var toolbgrup = [{"name":"basicstyles"},{"name":"paragraph","groups":["list"]},{"name":"styles"},{ "name": 'colors' },];
var toolb = [
	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
	{ name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
	{ name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
	{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
	{ name: 'insert', items: ['Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak',  ] },
	'/',
	{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'TabSpace','Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },
	{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
	{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
];
var f_tmp_text = CKEDITOR.replace('f_tmp_text',{
	language: 'id', uiColor: '#3c8dbc', height:'250px'//, toolbar: toolb,
	//removeButtons: 'Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
});
var f_tmp_text_leader = CKEDITOR.replace('f_tmp_text_leader',{
	language: 'id', uiColor: '#3c8dbc', height:'250px'//, toolbar: toolb,
	//removeButtons: 'Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
});
$(document).ready(function(){
	bsCustomFileInput.init();
	$('.formcolorpicker').each(function () {
		//$('.my-header, .my-button').colorpicker({
		$(this).colorpicker({
			//fallbackColor: '#ffffff',
			//fallbackFormat: 'hex'		
		});
		$(this).on('colorpickerChange', function(event) {
		  $(this).find('.fa-square').css('color', event.color.toString());
		});
	});
	$('#frmSetting_account').validate({
		highlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
		}		
	});

	oTable = $('#table_email').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": {
            "url": "<?php echo site_url('company_events/fnEventDataJsonEmail/'.$id);?>",
            "type": "POST"
        },
		"columns": [
			  { data: 'name_leaders', name: 'name_leaders' },
			  { data: 'f_email', name: 'f_email' },
			  { data: 'f_nama', name: 'f_nama' },
			  { data: 'f_nik', name: 'f_nik' },
			  { data: 'f_code', name: 'f_code', orderable: false , searchable: false, className: "center",
				  render : function(data, type, row, meta) {
					  var nonya = meta.row + meta.settings._iDisplayStart + 1;
					  var ulink = "";
					  //if(row.f_send_email != 'delivered' || row.f_survey_valid == 'no') {
					  if(row.f_survey_valid == 'no') {
						  ulink += "<a href='<?php echo base_url('u');?>?e="+data+"' target='_blank' class='tip' title='link survey'><i class='fas fa-user-tag'></i></a>";
						  ulink += "&nbsp;&nbsp;&nbsp;<a href='javascript:void(0);' onClick=\"sendThis('"+row.f_code+"',"+nonya+")\" class='tip send_"+nonya+"' title='kirim ini aja'><i class='text-muted fas fa-paper-plane'></i></a>";
						  ulink += "&nbsp;&nbsp;&nbsp;<a href='javascript:void(0);' onClick=\"deleteThis('"+row.f_code+"',"+nonya+")\" class='tip delete_send_"+nonya+"' title='hapus ini aja'><i class='text-danger far fa-trash-alt'></i></a>";
					  }
					  return ulink;
				  }
			  },
			  { data: 'f_send_email', name: 'f_send_email' },
			  { data: 'f_send_date', name: 'f_send_date' },
			  { data: 'f_respon', name: 'f_respon' },
			  { data: 'f_survey_valid', name: 'f_survey_valid' },
			  { data: 'f_survey_date', name: 'f_survey_date' },
		]
	});
	$(".dataTables_filter input").attr("placeholder","Cari Kata disini ...");	
	var url = "<?php echo site_url('company_events/fnSaveExcel/'.$id);?>";
	// Menyimpan data 
	$('#btnSave').click(function(e){
		e.preventDefault();
		$('#frmUpload').ajaxSubmit({
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
					oTable.ajax.reload();
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

	$('#btnSaveTemp').click(function(e){
		e.preventDefault();
		for (instance in CKEDITOR.instances)
		{
	        CKEDITOR.instances[instance].updateElement();
	    }
	    var urlTmp = "<?php echo site_url('company_events/fnSaveTemplate/'.$id);?>";
		$('#frmTemplate_email').ajaxSubmit({
			type : 'POST',
			beforeSubmit : function() {
				$('.card-body').append('<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
			},
			dataType : 'json',
			url : urlTmp,
			success : function(msg) {
				if(msg.msg)
				{
					swal.fire({text: 'Sukses !!',icon: 'info',confirmButtonText:'Close',confirmButtonColor: '#1E90FF'})
					$("#template_update").text('UPDATE ON :'+msg.tanggal);
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

	$('#btnSaveTempLeader').click(function(e){
		e.preventDefault();
		for (instance in CKEDITOR.instances)
		{
	        CKEDITOR.instances[instance].updateElement();
	    }
	    var urlTmp = "<?php echo site_url('company_events/fnSaveTemplateLeader/'.$id);?>";
		$('#frmTemplate_emailLeader').ajaxSubmit({
			type : 'POST',
			beforeSubmit : function() {
				$('.card-body').append('<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
			},
			dataType : 'json',
			url : urlTmp,
			success : function(msg) {
				if(msg.msg)
				{
					swal.fire({text: 'Sukses !!',icon: 'info',confirmButtonText:'Close',confirmButtonColor: '#1E90FF'})
					$("#template_update").text('UPDATE ON :'+msg.tanggal);
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

	$('#btnPreview').click(function(e)	{
		e.preventDefault();
		for (instance in CKEDITOR.instances)
		{
	        CKEDITOR.instances[instance].updateElement();
	    }
	    var rec = $('#frmTemplate_email').serialize();
		console.log(rec);
		$.fancybox.open({
	        href: '<?php echo site_url('company_events/fnPreviewTemplate');?>?'+rec,
	        type: 'iframe',
	        autoSize: false,
	        width: 850,
	        autoHeight: true,
	        closeBtn: true,
	        modal: false,
	        padding:5,
	    });
	});

	$('#btnPreviewLeader').click(function(e)	{
		e.preventDefault();
		for (instance in CKEDITOR.instances)
		{
	        CKEDITOR.instances[instance].updateElement();
	    }
	    var rec = $('#frmTemplate_emailLeader').serialize();
		console.log(rec);
		$.fancybox.open({
	        href: '<?php echo site_url('company_events/fnPreviewTemplateLeader');?>?'+rec,
	        type: 'iframe',
	        autoSize: false,
	        width: 850,
	        autoHeight: true,
	        closeBtn: true,
	        modal: false,
	        padding:5,
	    });
	});
	
	$("#sendmail").click(function(){
		$("#sendmail").prop('disabled', true);
		$("#sendmail i").attr('class','fa fa-cog fa-spin fa-1x fa-fw'); 
		//$("#sendmail").text(' PROSES . . .'); 
		$.getJSON('<?php echo site_url('company_events/sendEmail/'.$id);?>',function(e){
			oTable.ajax.reload();
			$('.overlay').remove()
			swal.fire({text: e.respom+' !!',icon: 'info',confirmButtonText:'Close',confirmButtonColor: '#1E90FF'})
			$("#sendmail").removeAttr('disabled');;
			$("#sendmail i").attr('class','fa fa-send'); 
			//$("#sendmail").text(' SEND EMAIL / REMINDER');
		});
	});

	$("#sendmailreminder").click(function(){
		$("#sendmailreminder").prop('disabled', true);
		$("#sendmailreminder i").attr('class','fa fa-cog fa-spin fa-1x fa-fw'); 
		//$("#sendmail").text(' PROSES . . .'); 
		$.getJSON('<?php echo site_url('company_events/sendEmailReminder/'.$id);?>',function(e){
			oTable.ajax.reload();
			$('.overlay').remove()
			swal.fire({text: e.respom+' !!',icon: 'info',confirmButtonText:'Close',confirmButtonColor: '#1E90FF'})
			$("#sendmailreminder").removeAttr('disabled');;
			$("#sendmailreminder i").attr('class','fa fa-send'); 
			//$("#sendmail").text(' SEND EMAIL / REMINDER');
		});
	});
	
});

function deleteAll()
{
	BootstrapDialog.confirm('Yakin ingin dihapus ?', function(result){
		var urlUpdate='<?php echo site_url('company_events/fnDeleteAllEmail/'.$id);?>';
		if(result)
		{
			$.getJSON(urlUpdate,function(html){
				if(html.status == 200 ) { oTable.ajax.reload();} 
				else
				{
					swal.fire({text: html.pesan+' !!',icon: 'error',confirmButtonText:'Close',confirmButtonColor: '#FF0000'})
				}
				$('.overlay').remove() 
			});
		}	
	}).setType(BootstrapDialog.TYPE_DANGER);
}

function sendThis(ref,x)
{
	var urlUpdate='<?php echo site_url('company_events/sendAlone/'.$id);?>';
	$('.send_'+x).hide();
	$.getJSON(urlUpdate+'?fcode='+ref,function(e){
		
		if(e.status == 200 ) { oTable.ajax.reload();} 
		else
		{
			swal.fire({text: e.respon+' !!',icon: 'error',confirmButtonText:'Close',confirmButtonColor: '#FF0000'})
			$('.send_'+x).show();
			$('.overlay').remove()
		} 
	});
}

function deleteThis(ref,x)
{
	var urlUpdate='<?php echo site_url('company_events/fnDeleteOneEmail/'.$id);?>';
	$('.delete_send_'+x).hide();
	$.getJSON(urlUpdate+'?fcode='+ref,function(e){
		
		if(e.status == 200 ) { oTable.ajax.reload();} 
		else
		{
			infoDialog.realize();
			swal.fire({text: e.respon+' !!',icon: 'error',confirmButtonText:'Close',confirmButtonColor: '#FF0000'})
			$('.delete_send_'+x).show();
		} 
	});
}

function fnBack()
{
	window.location.href = "<?php echo site_url('setting_account');?>";
}
</script>



