<!-- load css dan js -->
<link type="text/css" rel="stylesheet" href="<?php echo PLUG_URL; ?>datatables/dataTables.bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="<?php echo PLUG_URL; ?>select2/css/select2.min.css">
<script src="<?php echo PLUG_URL; ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo PLUG_URL; ?>datatables/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="<?php echo PLUG_URL; ?>jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo PLUG_URL; ?>select2/js/select2.min.js"></script>
<style>
	div.container {
		max-width: 1200px
	}
</style>
<!-- end load css dan js -->

<section class="content">
	<div class="container-fluid">
		<!--
		<div class="card card-primary collapsed-card">
-->
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">Search</h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
				</div> <!-- /.card-tools -->
			</div> <!-- /.card-header -->
			<div class="card-body" style="display: none;">
				<?php
				//opn($region);
				$label_level1 = json_decode($set_demo['f_label_level1'], true);
				$label_level2 = json_decode($set_demo['f_label_level2'], true);
				$label_level3 = json_decode($set_demo['f_label_level3'], true);
				$label_level4 = json_decode($set_demo['f_label_level4'], true);
				$label_level5 = json_decode($set_demo['f_label_level5'], true);
				$others = json_decode($set_demo['f_label_others'], true);
				//opn($others);
				$label_leaders = $others['leaders'];
				$label_region = $others['region'];
				$label_work = $others['work'];
				$label_mk = $others['mk'];
				$label_gender = $others['gender'];
				$label_pendidikan = $others['education'];
				$label_age = $others['age'];
				?>
				<form id="frmDemo" action="#" method="POST" class="form-horizantal">
					<input type="hidden" name="account_id" id="account_id" value="<?= sAccount; ?>">
					<!-- Pilihan Leaders -->
					<div class="form-group row">
						<label class="col-md-4 labelme">Event Survey</label>
						<div class="col-md-8">
							<?php
							$event_account[''] = '--- ' . $this->lang->line('pilih') . ' ---';
							echo form_dropdown('event_account', $event_account, false, 'id="event_account" class="form-control event_account custom-select" required style="width:100%"');
							?>
							<input type="hidden" name="event_account_name" id="event_account_name" value="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 labelme">Date Survey by End</label>
						<div class="col-md-4">
							<input type="text" name="f_end_1" id="f_end_1" class="form-control" value="" placeHolder="Start">
						</div>
						<div class="col-md-4">
							<input type="text" name="f_end_2" id="f_end_2" class="form-control" value="" placeHolder="End">
						</div>
					</div>

					<div class="clearfix">&nbsp;</div>
					<div class="form-group row">
						<div class="justify-content-md-center col-12" align="center">
							<a class="btn btn-outline-primary" onClick="cari()"><i class="fas fa-search"></i> Seacrh</a> &nbsp;&nbsp;
							<!--
							<a class="btn btn-outline-danger" id="button-pptx"><i class="fas fa-file-powerpoint"></i> Pptx</a> &nbsp;&nbsp;
-->
							<a class="btn btn-outline-primary" onClick="clear_form_elements('#frmDemo')"><i class="fas fa-redo"></i> Refresh</a> &nbsp;&nbsp;
						</div>
					</div>
				</form>
			</div> <!-- /.card-body -->
		</div> <!-- /.card -->

		<div id="toPrint" class="toPrint"></div>

	</div> <!-- end .container-fluid -->
</section><!-- /.content -->

<script>
	$("body").addClass("sidebar-collapse");
	var oTable;
	$(document).ready(function() {

		$("#event_account").select2({
			placeholder: "<?php echo $this->lang->line('pilih') . ' Event Survey'; ?>",
			allowClear: true,
			minimumResultsForSearch: Infinity,
		}).on("select2:select", function(e) {
			$('#event_account_name').val(e.params.data.text);
		});

		$("#survey_valid").select2({
			placeholder: "<?php echo $this->lang->line('pilih') . ' Status Survey'; ?>",
			allowClear: true,
			minimumResultsForSearch: Infinity,
		});


		<?php if ($listdemo['f_region'] == 1) { ?>
			$("#region").select2({
				placeholder: "<?php echo $this->lang->line('pilih') . ' ' . $label_region[LANGUAGE]; ?>",
				allowClear: true,
				minimumResultsForSearch: Infinity,
			}).on("select2:select", function(e) {
				$('#region_name').val(e.params.data.text);
			});
		<?php	} ?>

		<?php if ($listdemo['f_level1'] == 1) { ?>
			$("#level1").select2({
				placeholder: "<?php echo $this->lang->line('pilih') . ' ' . $label_level1[LANGUAGE]; ?>",
				allowClear: true,
				minimumResultsForSearch: Infinity,
			}).on("select2:select", function(e) {
				$('#level1_name').val(e.params.data.text);
			});
		<?php	} ?>

		<?php if ($listdemo['f_level2'] == 1) { ?>
			$("#level2").select2({
				placeholder: "<?php echo $this->lang->line('pilih') . ' ' . $label_level2[LANGUAGE]; ?>",
				allowClear: true,
				ajax: {
					url: "<?php echo site_url("trx_survey/fnPositionComboData/2"); ?>",
					dataType: 'json',
					delay: 250,
					data: function(params) {
						return {
							term: params.term,
							/*/ search term */
							f_parents: $("#level1").val(),
						};
					},
					processResults: function(data, params) {
						return {
							results: data.result,
						}
					},
					cache: false
				},
				minimumResultsForSearch: Infinity,
			}).on("select2:select", function(e) {
				$('#level2_name').val(e.params.data.text);
			});
		<?php	} ?>

		<?php if ($listdemo['f_level3'] == 1) { ?>
			$("#level3").select2({
				placeholder: "<?php echo $this->lang->line('pilih') . ' ' . $label_level3[LANGUAGE]; ?>",
				allowClear: true,
				ajax: {
					url: "<?php echo site_url("trx_survey/fnPositionComboData/3"); ?>",
					dataType: 'json',
					delay: 250,
					data: function(params) {
						return {
							term: params.term,
							/*/ search term */
							f_parents: $("#level2").val(),
						};
					},
					processResults: function(data, params) {
						return {
							results: data.result,
						}
					},
					cache: false
				},
				minimumResultsForSearch: Infinity,
			}).on("select2:select", function(e) {
				$('#level3_name').val(e.params.data.text);
			});
		<?php	} ?>

		<?php if ($listdemo['f_level4'] == 1) { ?>
			$("#level4").select2({
				placeholder: "<?php echo $this->lang->line('pilih') . ' ' . $label_level4[LANGUAGE]; ?>",
				allowClear: true,
				ajax: {
					url: "<?php echo site_url("trx_survey/fnPositionComboData/4"); ?>",
					dataType: 'json',
					delay: 250,
					data: function(params) {
						return {
							term: params.term,
							/*/ search term */
							f_parents: $("#level3").val(),
						};
					},
					processResults: function(data, params) {
						return {
							results: data.result,
						}
					},
					cache: false
				},
				minimumResultsForSearch: Infinity,
			}).on("select2:select", function(e) {
				$('#level4_name').val(e.params.data.text);
			});
		<?php	} ?>

		<?php if ($listdemo['f_level5'] == 1) { ?>
			$("#level5").select2({
				placeholder: "<?php echo $this->lang->line('pilih') . ' ' . $label_level5[LANGUAGE]; ?>",
				allowClear: true,
				ajax: {
					url: "<?php echo site_url("trx_survey/fnPositionComboData/5"); ?>",
					dataType: 'json',
					delay: 250,
					data: function(params) {
						return {
							term: params.term,
							/*/ search term */
							f_parents: $("#level4").val(),
						};
					},
					processResults: function(data, params) {
						return {
							results: data.result,
						}
					},
					cache: false
				},
				minimumResultsForSearch: Infinity,
			}).on("select2:select", function(e) {
				$('#level5_name').val(e.params.data.text);
			});
		<?php	} ?>

		<?php if ($listdemo['f_level_of_work'] == 1) { ?>
			$("#level_of_work").select2({
				placeholder: "<?php echo $this->lang->line('pilih') . ' ' . $label_work[LANGUAGE]; ?>",
				allowClear: true,
				minimumResultsForSearch: Infinity,
			}).on("select2:select", function(e) {
				$('#level_of_work_name').val(e.params.data.text);
			});
		<?php	} ?>

		<?php if ($listdemo['f_masakerja'] == 1) { ?>
			$("#masakerja").select2({
				placeholder: "<?php echo $this->lang->line('pilih') . ' ' . $label_mk[LANGUAGE]; ?>",
				allowClear: true,
				minimumResultsForSearch: Infinity,
			}).on("select2:select", function(e) {
				$('#mk_name').val(e.params.data.text);
			});
		<?php	} ?>

		<?php if ($listdemo['f_gender'] == 1) { ?>
			$("#gender").select2({
				placeholder: "<?php echo $this->lang->line('pilih') . ' ' . $label_gender[LANGUAGE]; ?>",
				allowClear: true,
				minimumResultsForSearch: Infinity,
			});
		<?php	} ?>

		<?php if ($listdemo['f_age'] == 1) { ?>
			$("#age").select2({
				placeholder: "<?php echo $this->lang->line('pilih') . ' ' . $label_age[LANGUAGE]; ?>",
				allowClear: true,
				minimumResultsForSearch: Infinity,
			}).on("select2:select", function(e) {
				$('#age_name').val(e.params.data.text);
			});
		<?php	} ?>

		<?php if ($listdemo['f_pendidikan'] == 1) { ?>
			$("#tipen").select2({
				placeholder: "<?php echo $this->lang->line('pilih') . ' ' . $label_pendidikan[LANGUAGE]; ?>",
				allowClear: true,
				minimumResultsForSearch: Infinity,
			});
		<?php	} ?>

		$('#f_end_1').datepicker({
			dateFormat: "yy-mm-dd",
			regional: "id",
			changeMonth: true,
			changeYear: true,
			yearRange: "-100:+0",
			onClose: function(selectedDate) {
				$("#f_end_2").datepicker("option", "minDate", selectedDate);
			}
		});

		$('#f_end_2').datepicker({
			dateFormat: "yy-mm-dd",
			regional: "id",
			changeMonth: true,
			changeYear: true,
			yearRange: "-100:+0",
			onClose: function(selectedDate) {
				$("#f_end_1").datepicker("option", "maxDate", selectedDate);
			}
		});

		$('#button-pptx').click(function() {
			var event_id = $("#event_account").val();
			if (event_id) {
				var gdata = $("#frmDemo").serialize()
				var url = '<?php echo site_url('pptx/') ?>';
				var data = typeof data == 'string' ? data : gdata;
				var inputs = '';
				$.each(data.split('&'), function() {
					var pair = this.split('=');
					inputs += '<input type="hidden" name="' + pair[0].replace("%5B%5D", "[]") + '" value="' + pair[1] + '" />';
				});
				//send request
				$('<form action="' + url + '" method="GET">' + inputs + '</form>')
					.appendTo('body').submit().remove();
			} else {
				swal.fire({
					text: 'Harap pilih event !!!',
					icon: 'info',
					confirmButtonText: 'Close'
				})
			}
		});
	});

	function cari() {
		var r = $("#frmDemo").serialize();
		var ea = $("#event_account").val();
		var Url = '<?php echo site_url('report_premium/fnReportsData'); ?>?' + r;
		console.log(Url)
		if (ea != '') {
			$('#toPrint').addClass('overlay');
			$('#toPrint').load(Url);
		} else {
			swal.fire('Pilih Event Account', '', 'info');
		}
	}

	function clear_form_elements(ele) {
		$('#frmDemo input').val('');
		$('.custom-select').val('').trigger('change');
	}
</script>