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
				<form name="frmItem_account" id="frmItem_account" method="post" class="form-horizontal">
				<input type="hidden" name="f_id" id="f_id" value="" >
				<div class="form-group row">
					<label class="col-md-2" style="padding-top:7px;">Variabel <span class="text-red">*</span></label>
					<div class="col-md-6">
					<?php
						$mv[''] = '-- Pilih';
						ksort($mv);
						echo form_dropdown('f_variabel_id',$mv,false,'id="f_variabel_id" class="form-control select" style="width: 100%" required');
					?>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-2" style="padding-top:7px;">Dimensi <span class="text-red">*</span></label>
					<div class="col-md-6">
					<?php
						$dataTes[''] = '-- Pilih';
						echo form_dropdown('f_dimensi_id',$dataTes,false,'id="f_dimensi_id" class="form-control select" style="width: 100%" required');
					?>
					</div>
				</div>	
				<div class="form-group row">
					<label class="col-md-2" style="padding-top:7px;">Item Pernyataan <span class="text-red">*</span></label>
					<div class="col-md-6"><textarea name="f_item_name" id="f_item_name" class="form-control" placeholder="Item Pernyataan ..." rows="5" required></textarea></div>
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
	$('#frmItem_account').validate({
		highlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
		}		
	});
	

	var $f_variabel_id = $('#f_variabel_id'); 
    $f_variabel_id.select2(/*{
		placeholder: "-- Pilih ..",
		ajax: {
			url 		: "<?php echo site_url('item_account/fnItem_accountComboData');?>", // << Example
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
	}*/).on("select2:select", function (e) { 
			if(e.params.data.id)
			{
				$.getJSON('<?= site_url('item_account/fnComboDataDimensi');?>?var_id='+e.params.data.id,function(e){
					console.log(e)
					var size = Object.keys(e).length;
					if(size>0)
					{
						var options = [];
						options.push({ text: '-- Pilih ',id: ''})
						$.each(e, function (key, value) {
							options.push({
								text: value,
								id: key
							});
						})
						$("#f_dimensi_id").empty().select2({data: options});
					}
					else
					{
						swal.fire({text: 'Tidak ada Dimensi',icon: 'info',confirmButtonText:'Close',confirmButtonColor: '#FF0000'});
					}
				});					
			}
			else
			{
				$("#f_dimensi_id").empty();
			}
		});
;


	var $f_dimensi_id = $('#f_dimensi_id'); 
    $f_dimensi_id.select2(/*{
		placeholder: "-- Pilih ..",
		ajax: {
			url 		: "<?php echo site_url('item_account/fnItem_accountComboData');?>", // << Example
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
	}*/);

<?php if($fAct == 'Edit') { ;?>
	$.get("<?php echo site_url('item_account/fnItem_accountDataId?id='.$fId);?>",function(data){
		if(data)
		{
			$('#f_item_name').val(data.f_item_name);
			$('#f_variabel_id').val(data.f_variabel_id).trigger('change');
			var options = [];
			options.push({ text: data.f_dimensi_name, id: data.f_dimensi_id })
			$("#f_dimensi_id").empty().select2({data: options});
			$('#f_dimensi_id').val(data.f_dimensi_id).trigger('change');
		}
	}, "json");

	var url = "<?php echo site_url('item_account/fnItem_accountUpdate?id='.$fId);?>";
<?php } ?>

<?php if($fAct == 'Add') { ;?>
	var url = "<?php echo site_url('item_account/fnItem_accountSave');?>";
<?php } ?>

	// Menyimpan data
	$('#frmItem_account').submit(function(e){
		var oForm = $('#frmItem_account');
		var rec = $('#frmItem_account').serialize();
		// rec.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>',value:'<?php echo $this->security->get_csrf_hash();?>'});
		e.preventDefault();
		if($(this).valid()) {
			$.post(url, rec, function(msg){
				if(msg.msg)
				{
					window.location.href = "<?php echo site_url('item_account');?>";
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
	window.location.href = "<?php echo site_url('item_account');?>";
}

function formatAccount(result)
{
	if (result.loading) return result.text;
	
	var markup = "<span>"+result.text+"<br/>"+result.contact+" ("+result.phone+" - "+result.email+")</span>";
	return markup;
}
</script>



