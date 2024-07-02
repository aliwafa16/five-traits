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
				<form name="frmGender" id="frmGender" method="post" class="form-horizontal">
				<input type="hidden" name="f_gender_id" id="f_gender_id" value="" >
				<div class="form-group row">
					<label class="col-md-2" style="padding-top:7px;">Name <span class="text-red">*</span></label>
					<div class="col-md-6"><input type="text" name="f_gender_name" id="f_gender_name" class="form-control" placeholder="Name ..." value="" required></div>
				</div>
				<hr>
				<p>INFO</p>
				<div class="form-group row">
					<label class="col-md-2" style="padding-top:7px;">Create </label>
					<div class="col-md-3"><input type="text" name="f_create_date" id="f_create_date" class="form-control" placeholder="Create ..." value="" disabled></div>
					<div class="col-md-3"><input type="text" name="f_create_by" id="f_create_by" class="form-control" placeholder="c ..." value="" disabled></div>
				</div>
				<div class="form-group row">
					<label class="col-md-2" style="padding-top:7px;">Update</label>
					<div class="col-md-3"><input type="text" name="f_update_date" id="f_update_date" class="form-control" placeholder="Update ..." value="" disabled></div>
					<div class="col-md-3"><input type="text" name="f_update_by" id="f_update_by" class="form-control" placeholder="U ..." value="" disabled></div>
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
	$('#frmGender').validate({
		highlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
		}		
	});
	
<?php if($fAct == 'Edit') { ;?>
	$.get("<?php echo site_url('gender/fnGenderDataId?id='.$fId);?>",function(data){
		if(data)
		{
			$('#f_gender_id').val(data.f_gender_id);
			$('#f_gender_name').val(data.f_gender_name);
			$('#f_account_id').val(data.f_account_id);
			$('#f_create_date').val(data.f_create_date);
			$('#f_create_by').val(data.f_create_by);
			$('#f_update_date').val(data.f_update_date);
			$('#f_update_by').val(data.f_update_by);
		}
	}, "json");

	var url = "<?php echo site_url('gender/fnGenderUpdate?id='.$fId);?>";
<?php } ?>

<?php if($fAct == 'Add') { ;?>
	var url = "<?php echo site_url('gender/fnGenderSave');?>";
<?php } ?>

	// Menyimpan data
	$('#frmGender').submit(function(e){
		var oForm = $('#frmGender');
		var rec = $('#frmGender').serialize();
		//rec.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>',value:'<?php echo $this->security->get_csrf_hash();?>'});
		e.preventDefault();
		if($(this).valid()) {
			$.post(url, rec, function(msg){
				if(msg.msg)
				{
					window.location.href = "<?php echo site_url('gender');?>";
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
	window.location.href = "<?php echo site_url('gender');?>";
}
</script>



