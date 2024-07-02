<!-- load css dan js -->
<script src="<?php echo PLUG_URL;?>jquery-validation/jquery.validate.min.js"></script>
<!-- end load css dan js -->

<section class="content">
	<div class="container-fluid">
		<div class="card"> <!-- start .card -->
			<div class="card-header"> <!-- start .card-header -->
				<?php echo $form_header;?>
			</div> <!-- end .card-header -->
			
			<div class="card-body"> <!-- start .card-body -->
				<form name="frmTrx_survey" id="frmTrx_survey" method="post" class="form-horizontal">
				<input type="hidden" name="f_id" id="f_id" value="" >
				<div class="form-group row">
					<label class="col-md-2" style="padding-top:7px;">Event <span class="text-red">*</span></label>
					<div class="col-md-6"><input type="text" name="f_event_id" id="f_event_id" class="form-control" placeholder="Event ..." value="" required></div>
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
	$('#frmTrx_survey').validate({
		highlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
		}		
	});
	
<?php if($fAct == 'Edit') { ;?>
	$.get("<?php echo site_url('trx_survey/fnTrx_surveyDataId?id='.$fId);?>",function(data){
		if(data)
		{
			$('#f_id').val(data.f_id);
			$('#f_event_id').val(data.f_event_id);
		}
	}, "json");

	var url = "<?php echo site_url('trx_survey/fnTrx_surveyUpdate?id='.$fId);?>";
<?php } ?>

<?php if($fAct == 'Add') { ;?>
	var url = "<?php echo site_url('trx_survey/fnTrx_surveySave');?>";
<?php } ?>

	// Menyimpan data
	$('#frmTrx_survey').submit(function(e){
		var oForm = $('#frmTrx_survey');
		var rec = $('#frmTrx_survey').serialize();
		// rec.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>',value:'<?php echo $this->security->get_csrf_hash();?>'});
		e.preventDefault();
		if($(this).valid()) {
			$.post(url, rec, function(msg){
				if(msg.msg)
				{
					window.location.href = "<?php echo site_url('trx_survey');?>";
				}
				else
				{
					swal.fire({text: 'Gagal !!',icon: 'error',confirmButtonText:'Close',confirmButtonColor: '#FF0000'})
				}
			}, 'json');
		}
	});
});

function fnBack()
{
	window.location.href = "<?php echo site_url('trx_survey');?>";
}
</script>



