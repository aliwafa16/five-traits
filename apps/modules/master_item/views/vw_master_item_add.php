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
				<form name="frmMaster_item" id="frmMaster_item" method="post" class="form-horizontal">
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
				<div class="pilihan" class="table-responsive">
					<a class="btn btn-sm btn-primary" onClick="addRow()"><i class="fa fa-plus"></i> Add</a>
					<br/>
					<table id="tablePilihan" class="table datares table-bordered" style="max-width:100%;width:68%">
						<tr>
							<th>Value</th>
							<th>Keterangan</th>
							<th>#</th>
						</tr>
						<?php if($fAct =='Add') { ?>
						<tr>
							<td>
								<input type="text" name="value[]" id="value" class="form-control val1" placeholder="Value ..." required >
							</td>
							<td>
								<input type="text" name="keterangan[]" id="keterangan" class="form-control ket1" placeholder="Keterangan ..." required >
							</td>
							<td></td>
						</tr>
						<?php } ?>
					</table>						
				</div>
				<div class="form-group row">
					<label class="col-md-2" style="padding-top:7px;">Type <span class="text-red">*</span></label>
					<div class="col-md-6">
					<?php
						$dataTes = array(0=>'Favo',1=>'UnFavo');
						echo form_dropdown('f_type',$dataTes,0,'id="f_type" class="form-control select" style="width: 100%" required');
					?>
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
	
			</div> <!-- end .card-body -->
			<div class="card-footer" align="right"> <!-- start box-footer -->
			  <p>Page rendered in <strong>{elapsed_time}</strong> seconds</p>
			</div> <!-- end .card-footer-->
		</div> <!-- end .card -->
	</div> <!-- end .container-fluid -->
</section><!-- /.content -->

<script>
var oTable = $("#tablePilihan");
$(document).ready(function(){
	$('#frmMaster_item').validate({
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
			url 		: "<?php echo site_url('master_item/fnMaster_itemComboData');?>", // << Example
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
				$.getJSON('<?= site_url('master_item/fnComboDataDimensi');?>?var_id='+e.params.data.id,function(e){
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


	var $f_dimensi_id = $('#f_dimensi_id'); 
    $f_dimensi_id.select2(/*{
		placeholder: "-- Pilih ..",
		ajax: {
			url 		: "<?php echo site_url('master_item/fnMaster_itemComboData');?>", // << Example
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
	$.get("<?php echo site_url('master_item/fnMaster_itemDataId?id='.$fId);?>",function(data){
		if(data)
		{
			$('#f_id').val(data.f_id);
			$('#f_item_name').val(data.f_item_name);
			$('#f_variabel_id').val(data.f_variabel_id).trigger('change');
			var options = [];
			options.push({ text: data.f_dimensi_name, id: data.f_dimensi_id })
			$("#f_dimensi_id").empty().select2({data: options});
			$('#f_dimensi_id').val(data.f_dimensi_id).trigger('change');
			$('#f_type').val(data.f_type).trigger('change');

			var no = 1;
			$.each(data.f_item_array,function(a,b){
				var valu = "<input type=\"text\" name=\"value[]\" id=\"value\" class=\"form-control value"+no+"\" placeholder=\"Value ...\" value=\""+b.value+"\"  required>";
				var kete = "<input type=\"text\" name=\"keterangan[]\" id=\"keterangan\" class=\"form-control ket"+no+"\" placeholder=\"Keterangan ...\" value=\""+b.keterangan+"\"  required>";
				var sampah = '<a class="tip" title="Hapus" onClick="hideRow('+no+')"><i class="text-red far fa-trash-alt"></i></a>';
				oTable.children().append("<tr id='row"+no+"'><td>"+valu+"</td><td>"+kete+"</td><td class=\"center\">"+sampah+"</td></tr>");
				no++;
			});
		}
	}, "json");

	var url = "<?php echo site_url('master_item/fnMaster_itemUpdate?id='.$fId);?>";
<?php } ?>

<?php if($fAct == 'Add') { ;?>
	var url = "<?php echo site_url('master_item/fnMaster_itemSave');?>";
<?php } ?>

	// Menyimpan data
	$('#frmMaster_item').submit(function(e){
		var oForm = $('#frmMaster_item');
		var rec = $('#frmMaster_item').serialize();
		// rec.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>',value:'<?php echo $this->security->get_csrf_hash();?>'});
		e.preventDefault();
		if($(this).valid()) {
			$.post(url, rec, function(msg){
				if(msg.msg)
				{
					window.location.href = "<?php echo site_url('master_item');?>";
				}
				else
				{
					swal.fire({text: 'Gagal !!',icon: 'error',confirmButtonText:'Close',confirmButtonColor: '#FF0000'})
				}
			}, 'json');
		}
	});
});

function addRow()
{
	var lastRow = oTable.find("tr").length;
	var nextRow = lastRow;// - 1;
	var emptyrows = 0;
	for (i=1; i<lastRow; i++) {
		if ($(".val"+i).val() == '' || $(".ket"+i).val() == '') {
			emptyrows += 1;
		}
	}
	
	if (emptyrows == 0 )
	{
		var valu = "<input type=\"text\" name=\"value[]\" id=\"value\" class=\"form-control value"+lastRow+"\" placeholder=\"Value ...\" value=\"\"  required>";
		var kete = "<input type=\"text\" name=\"keterangan[]\" id=\"keterangan\" class=\"form-control ket"+lastRow+"\" placeholder=\"Keterangan ...\" value=\"\"  required>";
		var sampah = '<a class="tip" title="Hapus" onClick="hideRow('+lastRow+')"><i class="text-red far fa-trash-alt"></i></a>';
		oTable.children().append("<tr id='row"+lastRow+"'><td>"+valu+"</td><td>"+kete+"</td><td class=\"center\">"+sampah+"</td></tr>");
	}
	else
	{
		swal.fire({text: "Silahkan mengisi data pada baris yang tersedia terlebih dahulu, sebelum menambah baris.",icon: 'error',confirmButtonText:'Close',confirmButtonColor: '#FF0000'});
	}
}

function hideRow(x)
{
	$("#tablePilihan tr#row"+x).html('');
}
function fnBack()
{
	window.location.href = "<?php echo site_url('master_item');?>";
}

function formatAccount(result)
{
	if (result.loading) return result.text;
	
	var markup = "<span>"+result.text+"<br/>"+result.contact+" ("+result.phone+" - "+result.email+")</span>";
	return markup;
}
</script>



