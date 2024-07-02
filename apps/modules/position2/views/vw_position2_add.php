<!-- load css dan js -->
<script src="<?php echo PLUG_URL;?>jquery-validation/jquery.validate.min.js"></script>
<link rel="stylesheet" href="<?php echo PLUG_URL;?>select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo PLUG_URL;?>select2/js/select2.min.js"></script>
<!-- end load css dan js -->

<section class="content">
	<div class="container-fluid">
		<div class="card"> <!-- start .card -->
			<div class="card-header"> <!-- start .card-header -->
				<?php echo $form_header;?>
			</div> <!-- end .card-header -->
			
			<div class="card-body"> <!-- start .card-body -->
				<form name="frmPosition2" id="frmPosition2" method="post" class="form-horizontal">
				<div class="form-group row">
					<label class="col-md-2" style="padding-top:7px;">Level 1 <span class="text-red">*</span></label>
					<div class="col-md-6">
						<?php echo form_dropdown('f_id1',false,false,'id="f_id1" class="form-control level1 custom-select" required style="width:100%"'); ;?>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-2" style="padding-top:7px;">Nama <span class="text-red">*</span></label>
					<div class="col-md-6"><input type="text" name="f_position_desc" id="f_position_desc" class="form-control" placeholder="Nama ..." value="" required></div>
				</div>
				<div class="form-group row">
					<label class="col-md-2" style="padding-top:7px;">Total Responden <span class="text-red">*</span></label>
					<div class="col-md-6"><input type="number" name="f_total" id="f_total" class="form-control" placeholder="Total ..." value="0" required></div>
				</div>
				<div class="form-group row">
					<label class="col-md-2" style="padding-top:7px;">Total Minimum <span class="text-red">*</span></label>
					<div class="col-md-6"><input type="number" name="f_total_min" id="f_total_min" class="form-control" placeholder="Total Minimum..." value="0" required></div>
				</div>
				<input type="hidden" name="f_aktif" id="f_aktif" value="" >	
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
	$('#frmPosition2').validate({
		highlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
		}		
	});

	var $f_id1 = $('#f_id1'); 
    $f_id1.select2({
		placeholder: "-- Pilih ..",
		ajax: {
			url 		: "<?php echo site_url('position1/fnPosition1ComboData');?>", // << Example
			dataType	: 'json',
			delay		: 250,
			processResults		: function(data,params) {
				return {
				        results: data.result,
					}
			},
			cache: true
		},
		minimumInputLength: 0,
		//escapeMarkup: function (markup) { return markup; },
		//templateResult: formatAccount,
	});
		
<?php if($fAct == 'Edit') { ;?>
	$.get("<?php echo site_url('position2/fnPosition2DataId?id='.$fId);?>",function(data){
		if(data)
		{
			var $option1 = $('<option value="'+data.f_id1+'" selected="selected">'+data.f_desc1+'</option>');
			$('#f_id1').append($option1).trigger('change');
			$('#f_position_desc').val(data.f_position_desc);
			$('#f_total').val(data.f_total);
			$('#f_total_min').val(data.f_total_min);
		}
	}, "json");

	var url = "<?php echo site_url('position2/fnPosition2Update?id='.$fId);?>";
<?php } ?>

<?php if($fAct == 'Add') { ;?>
	var url = "<?php echo site_url('position2/fnPosition2Save');?>";
<?php } ?>

	// Menyimpan data
	$('#frmPosition2').submit(function(e){
		var oForm = $('#frmPosition2');
		var rec = $('#frmPosition2').serialize();
		// rec.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>',value:'<?php echo $this->security->get_csrf_hash();?>'});
		e.preventDefault();
		if($(this).valid()) {
			$.post(url, rec, function(msg){
				if(msg.msg)
				{
					window.location.href = "<?php echo site_url('position2');?>";
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
	window.location.href = "<?php echo site_url('position2');?>";
}
</script>



