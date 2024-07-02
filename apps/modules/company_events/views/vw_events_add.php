<!-- load css dan js -->
<script src="<?php echo PLUG_URL; ?>jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo PLUG_URL; ?>bs-custom-file-input/bs-custom-file-input.min.js"></script>
<link rel="stylesheet" href="<?php echo PLUG_URL; ?>select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo PLUG_URL; ?>select2/js/select2.min.js"></script>
<link rel="stylesheet" href="<?php echo PLUG_URL; ?>datetimepicker/jquery-ui-timepicker-addon.min.css" type="text/css" />
<script type="text/javascript" src="<?php echo PLUG_URL; ?>datetimepicker/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="<?php echo PLUG_URL; ?>datetimepicker/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
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
				<form name="frmEvents" id="frmEvents" method="post" class="form-horizontal">
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Account <span class="text-red">*</span></label>
						<div class="col-md-6">
							<?php
							$dataTes = false;
							echo form_dropdown('f_account_id', $dataTes, false, 'id="f_account_id" class="form-control select" style="width: 100%" required');
							?>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Name Survey<span class="text-red">*</span></label>
						<div class="col-md-6"><input type="text" name="f_event_name" id="f_event_name" class="form-control" placeholder="Name ..." value="" required></div>
					</div>
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Start <span class="text-red">*</span></label>
						<div class="col-md-4"><input type="text" name="f_event_start" id="f_event_start" class="form-control" placeholder="Start ..." value="" required></div>
						<div class="col-md-2"><input type="text" name="f_event_start_time" id="f_event_start_time" class="form-control" placeholder="Time Start ..." value="06:00" required></div>
					</div>
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">End <span class="text-red">*</span></label>
						<div class="col-md-4"><input type="text" name="f_event_end" id="f_event_end" class="form-control" placeholder="End ..." value="" required></div>
						<div class="col-md-2"><input type="text" name="f_event_end_time" id="f_event_end_time" class="form-control" placeholder="Time End ..." value="23:59" required></div>
					</div>
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Min Responden <span class="text-red">*</span></label>
						<div class="col-md-6"><input type="text" name="f_event_min_respon" id="f_event_min_respon" class="form-control" placeholder="Min Responden ..." value="" required></div>
					</div>
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Create</label>
						<div class="col-md-3"><input type="text" name="f_event_created_on" id="f_event_created_on" class="form-control" placeholder="Create ..." value="" disabled></div>
						<div class="col-md-3"><input type="text" name="f_event_created_by" id="f_event_created_by" class="form-control" placeholder="..." value="" disabled></div>
					</div>
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Update</label>
						<div class="col-md-3"><input type="text" name="f_event_updated_on" id="f_event_updated_on" class="form-control" placeholder="Update ..." value="" disabled></div>
						<div class="col-md-3"><input type="text" name="f_event_updated_by" id="f_event_updated_by" class="form-control" placeholder="..." value="" disabled></div>
					</div>


					<div class="col-md-8" align="center" id="fnButton">
						<?php
						if ($fAct == 'Add')	echo '<input type="submit" name="submit" value="Save" id="btnSave" class="btn btn-success" />';

						if ($fAct == 'Edit')	echo '<input type="submit" name="submit" value="Ubah" id="btnUpdate" class="btn btn-warning" />';

						if ($fAct == 'Edit') echo '<input type="hidden" name="f_event_kode" id="f_event_kode" class="form-control">'
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
		bsCustomFileInput.init();
		$('#frmEvents').validate({
			highlight: function(element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
			}
		});

		var $f_account_id = $('#f_account_id');
		$f_account_id.select2({
			placeholder: "-- Pilih ..",
			ajax: {
				url: "<?php echo site_url('reg_account/fnReg_accountComboData'); ?>", // << Example
				dataType: 'json',
				delay: 250,
				processResults: function(data, params) {
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

		<?php if ($fAct == 'Edit') {; ?>
			$.get("<?php echo site_url('company_events/fnEventsDataId?id=' . $fId); ?>", function(data) {
				console.log(data)
				if (data) {
					$('#f_event_name').val(data.f_event_name);
					$('#f_event_start').val(data.f_event_start);
					$('#f_event_start_time').val(data.f_event_start_time);
					$('#f_event_end').val(data.f_event_end);
					$('#f_event_end_time').val(data.f_event_end_time);


					var $option1 = $('<option value="' + data.f_account_id + '" selected="selected">' + data.f_account_name + '</option>');
					$('#f_account_id').append($option1).trigger('change');


					$('#f_event_min_respon').val(data.f_event_min_respon);
					$('#f_event_created_on').val(data.f_event_created_on);
					$('#f_event_created_by').val(data.f_event_created_by);
					$('#f_event_updated_on').val(data.f_event_updated_on);
					$('#f_event_updated_by').val(data.f_event_updated_by);
					$('#f_event_kode').val(data.f_event_kode);



					if (data.f_jenis == 'Utilitarian') {
						$('#inlineRadioUtilitarian').prop('checked', true)
					}


					if (data.f_jenis == 'Premium') {
						$('#inlineRadioPremium').prop('checked', true)
					}


					let variabel_id = `#inlineRadio${data.f_variabel_id}`;
					$(variabel_id).prop('checked', true);
				}
			}, "json");

			var url = "<?php echo site_url('company_events/fnEventsUpdate?id=' . $fId); ?>";
		<?php } ?>

		<?php if ($fAct == 'Add') {; ?>
			var url = "<?php echo site_url('company_events/fnEventsSave'); ?>";
		<?php } ?>

		$('#f_event_start').datepicker({
			dateFormat: "yy-mm-dd",
			regional: "id",
			changeMonth: true,
			changeYear: true,
			yearRange: "-100:+1",
			onClose: function(selectedDate) {
				$("#f_event_end").datepicker("option", "minDate", selectedDate);
			}
		});
		$('#f_event_start_time').timepicker();

		$('#f_event_end').datepicker({
			dateFormat: "yy-mm-dd",
			regional: "id",
			changeMonth: true,
			changeYear: true,
			yearRange: "-100:+1",
			onClose: function(selectedDate) {
				$("#f_event_start").datepicker("option", "maxDate", selectedDate);
			}
		});
		$('#f_event_end_time').timepicker();

		// Menyimpan data
		$('#frmEvents').submit(function(e) {
			var oForm = $('#frmEvents');
			var rec = $('#frmEvents').serialize();
			// rec.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>',value:'<?php echo $this->security->get_csrf_hash(); ?>'});
			e.preventDefault();
			if ($(this).valid()) {
				$.post(url, rec, function(msg) {
					if (msg.msg) {
						window.location.href = "<?php echo site_url('company_events'); ?>";
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
		window.location.href = "<?php echo site_url('events'); ?>";
	}

	function formatAccount(result) {
		if (result.loading) return result.text;

		var markup = "<span>" + result.text + "<br/>" + result.contact + " (" + result.phone + " - " + result.email + ")</span>";
		return markup;
	}
</script>