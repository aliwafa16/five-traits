<!-- load css dan js -->
<link rel="stylesheet" href="<?php echo PLUG_URL; ?>select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo PLUG_URL; ?>select2/js/select2.min.js"></script>
<script src="<?php echo PLUG_URL; ?>jquery-validation/jquery.validate.min.js"></script>
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
				<form name="frmReg_account" id="frmReg_account" method="post" class="form-horizontal">
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Nama Company <span class="text-red">*</span></label>
						<div class="col-md-6"><input type="text" name="f_account_name" id="f_account_name" class="form-control" placeholder="Nama Company ..." value="" required></div>
					</div>
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Contact <span class="text-red">*</span></label>
						<div class="col-md-6"><input type="text" name="f_account_contact" id="f_account_contact" class="form-control" placeholder="Contact ..." value="" required></div>
					</div>
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Email <span class="text-red">*</span></label>
						<div class="col-md-6"><input type="email" name="email" id="email" class="form-control" placeholder="Email ..." value="" required data-rule-email="true"></div>
					</div>
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Password <span class="text-red rpass">*</span></label>
						<div class="col-md-6"><input type="password" name="password" id="password" class="form-control" placeholder="Password ..." value="" required></div>
					</div>
					<div class="form-group row">
						<label class="col-md-2" style="padding-top:7px;">Phone <span class="text-red">*</span></label>
						<div class="col-md-6"><input type="text" name="phone" id="phone" class="form-control" placeholder="Phone ..." value="" required></div>
					</div>
					<!--
				<div class="form-group row">
					<label class="col-md-2" style="padding-top:7px;">Role <span class="text-red">*</span></label>
					<div class="col-md-6">
						<select name="group_id" id="group_id" class="form-control custom-select" required>
							<option value="">-- Role --</option>
							<option value="1">Admin</option>
							<option value="2">Member</option>
						</select>
					</div>
				</div>	
-->
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
		$('#frmReg_account').validate({
			highlight: function(element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
			}
		});

		<?php if ($fAct == 'Edit') {; ?>
			$.get("<?php echo site_url('reg_account/fnReg_accountDataAccountId?id=' . $fId); ?>", function(data) {
				console.log(data)
				if (data) {
					$('.rpass').hide();
					$('#password').removeAttr('required');
					// $('#username').val(data.username);
					$('#f_account_name').val(data.username);
					$('#f_account_contact').val(data.f_account_contact);
					$('#email').val(data.email);
					$('#phone').val(data.phone);

				}
			}, "json");

			var url = "<?php echo site_url('reg_account/fnReg_accountUpdate?id=' . $fId); ?>";
		<?php } ?>

		<?php if ($fAct == 'Add') {; ?>
			var url = "<?php echo site_url('reg_account/fnReg_accountSave'); ?>";
		<?php } ?>

		// Menyimpan data
		$('#frmReg_account').submit(function(e) {
			var oForm = $('#frmReg_account');
			var rec = $('#frmReg_account').serialize();
			// rec.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>',value:'<?php echo $this->security->get_csrf_hash(); ?>'});
			e.preventDefault();
			if ($(this).valid()) {
				$.post(url, rec, function(msg) {
					if (msg.msg) {
						window.location.href = "<?php echo site_url('reg_account'); ?>";
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

	function formatAccount(result) {
		if (result.loading) return result.text;

		var markup = "<span>" + result.text + "<br/>" + result.kota + " - " + result.provinsi + "</span>";
		return markup;
	}

	function fnBack() {
		window.location.href = "<?php echo site_url('reg_account'); ?>";
	}
</script>