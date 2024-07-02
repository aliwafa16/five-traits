<!-- load css dan js -->
<script src="<?php echo PLUG_URL; ?>jquery-validation/jquery.validate.min.js"></script>
<link rel="stylesheet" href="<?php echo PLUG_URL; ?>select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo PLUG_URL; ?>select2/js/select2.min.js"></script>
<!-- end load css dan js -->

<section class="content">
	<div class="container-fluid">
		<div class="card">
			<!-- start .card -->
			<div class="card-header">
				<!-- start .card-header -->
				<?php echo $form_header; ?>
			</div> <!-- end .card-header -->

			<div class="card-body">
				<!-- start .card-body -->
				<form name="frmMaster_dimensi" id="frmMaster_dimensi" method="post" class="form-horizontal">
					<input type="hidden" name="f_id" id="f_id" value="">
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Variabel <span class="text-red">*</span></label>
						<div class="col-md-6">
							<select class="form-control" name="f_variabel_id">
								<?php if ($fId) : ?>
									<?php foreach ($variabel as $key) : ?>
										<?php if ($key['f_id'] == $resp['f_variabel_id']) : ?>
											<option value="<?= $key['f_id'] ?>" selected><?= $key['f_variabel_name'] ?></option>
										<?php else : ?>
											<option value="<?= $key['f_id'] ?>"><?= $key['f_variabel_name'] ?></option>
										<?php endif; ?>
									<?php endforeach ?>
								<?php else : ?>
									<?php foreach ($variabel as $key) : ?>
										<option value="<?= $key['f_id'] ?>"><?= $key['f_variabel_name'] ?></option>
									<?php endforeach ?>
								<?php endif; ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Dimensi <span class="text-red">*</span></label>
						<div class="col-md-6"><input type="text" name="f_dimensi_name" id="f_dimensi_name" class="form-control" placeholder="Dimensi ..." value="" required></div>
					</div>
					<div class="col-md-8" align="center" id="fnButton">
						<?php
						if ($fAct == 'Add')	echo '<input type="submit" name="submit" value="Save" id="btnSave" class="btn btn-success" />';

						if ($fAct == 'Edit')	echo '<input type="submit" name="submit" value="Ubah" id="btnUpdate" class="btn btn-warning" />';
						?>
						&nbsp;&nbsp;&nbsp;
						<a onClick="fnBack()" class="btn btn-danger"> Cancel</a>
					</div>
				</form>

			</div> <!-- end .card-body -->
			<div class="card-footer" align="right">
				<!-- start box-footer -->
				<p>Page rendered in <strong>{elapsed_time}</strong> seconds</p>
			</div> <!-- end .card-footer-->
		</div> <!-- end .card -->
	</div> <!-- end .container-fluid -->
</section><!-- /.content -->

<script>
	var oTable;
	$(document).ready(function() {
		$('#frmMaster_dimensi').validate({
			highlight: function(element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
			}
		});


		var $f_variabel_id = $('#f_variabel_id');
		$f_variabel_id.select2(
			/*{
					placeholder: "-- Pilih ..",
					ajax: {
						url 		: "<?php echo site_url('master_dimensi/fnMaster_dimensiComboData'); ?>", // << Example
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
				}*/
		);

		<?php if ($fAct == 'Edit') {; ?>
			$.get("<?php echo site_url('master_dimensi/fnMaster_dimensiDataId?id=' . $fId); ?>", function(data) {
				if (data) {
					$('#f_id').val(data.f_id);
					$('#f_dimensi_name').val(data.f_dimensi_name);
					$('#f_variabel_id').val(data.f_variabel_id);
				}
			}, "json");

			var url = "<?php echo site_url('master_dimensi/fnMaster_dimensiUpdate?id=' . $fId); ?>";
		<?php } ?>

		<?php if ($fAct == 'Add') {; ?>
			var url = "<?php echo site_url('master_dimensi/fnMaster_dimensiSave'); ?>";
		<?php } ?>

		// Menyimpan data
		$('#frmMaster_dimensi').submit(function(e) {
			var oForm = $('#frmMaster_dimensi');
			var rec = $('#frmMaster_dimensi').serialize();
			// rec.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>',value:'<?php echo $this->security->get_csrf_hash(); ?>'});
			e.preventDefault();
			if ($(this).valid()) {
				$.post(url, rec, function(msg) {
					if (msg.msg) {
						window.location.href = "<?php echo site_url('master_dimensi'); ?>";
					} else {
						swal.fire({
							text: 'Gagal !!',
							icon: 'error',
							confirmButtonText: 'Close',
							confirmButtonColor: '#FF0000'
						})
					}
				}, 'json');
			}
		});
	});

	function fnBack() {
		window.location.href = "<?php echo site_url('master_dimensi'); ?>";
	}

	function formatAccount(result) {
		if (result.loading) return result.text;

		var markup = "<span>" + result.text + "<br/>" + result.contact + " (" + result.phone + " - " + result.email + ")</span>";
		return markup;
	}
</script>