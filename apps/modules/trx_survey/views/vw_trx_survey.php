<!-- load css dan js -->
<link type="text/css" rel="stylesheet" href="<?php echo PLUG_URL; ?>datatables/dataTables.bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo PLUG_URL; ?>select2/css/select2.min.css">
<script src="<?php echo PLUG_URL; ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo PLUG_URL; ?>datatables/dataTables.bootstrap.min.js"></script>
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
			<div class="card-body" style="display: non;">
				<?php
				//opn($region);
				// $label_level1 = json_decode($set_demo['f_label_level1'], true);
				// $label_level2 = json_decode($set_demo['f_label_level2'], true);
				// $label_level3 = json_decode($set_demo['f_label_level3'], true);
				// $label_level4 = json_decode($set_demo['f_label_level4'], true);
				// $label_level5 = json_decode($set_demo['f_label_level5'], true);
				// $others = json_decode($set_demo['f_label_others'], true);
				//opn($others);
				// $label_leaders = $others['leaders'];
				// $label_region = $others['region'];
				// $label_work = $others['work'];
				// $label_mk = $others['mk'];
				// $label_gender = $others['gender'];
				// $label_pendidikan = $others['education'];
				// $label_age = $others['age'];
				?>
				<form id="frmDemo" action="#" method="POST" class="form-horizantal">
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
							<a class="btn btn-outline-primary" onClick="clear_form_elements('#frmDemo')"><i class="fas fa-redo"></i> Refresh</a> &nbsp;&nbsp;
							<a class="btn btn-outline-primary" onClick="eksport()"><i class="fas fa-book"></i> Eksport</a> &nbsp;&nbsp;

							<!-- <a class="btn btn-outline-success" onClick="filexls(1)"><i class="fas fa-file-excel"></i> Export Data All</a> &nbsp;&nbsp;
							<a class="btn btn-outline-success" onClick="filexls(2)"><i class="fas fa-list-ol"></i> Export Count Data</a> &nbsp;&nbsp; -->

						</div>
					</div>


				</form>


			</div> <!-- /.card-body -->
		</div> <!-- /.card -->

		<div class="card">
			<!-- start .box -->
			<div class="card-body table-responsive">
				<!-- start .card-body -->
				<table id="tableTrx_survey" class="table datares nowrap" style="width:100%">
					<thead>
						<tr>
							<th>
								No
								<div class="btn-group">
									<button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false"></button>
									<div class="dropdown-menu" style="">
										<a class="dropdown-item" href="javascript:void(0)" onClick="cekAll()">Check</a>
										<a class="dropdown-item" href="javascript:void(0)" onClick="unCek()">UnCheck</a>
										<a class="dropdown-item" href="javascript:void(0)" onClick="delCek()">Delete Checked</a>
									</div>
								</div>
							</th>
							<th>Event</th>
							<th>Name</th>
							<th>Email</th>
							<!-- <th>HP</th>
							<th>Umur</th>
							<th>Gender</th>
							<th>Pekerjaan</th>
							<th>Pendapatan</th> -->
							<th>Valid</th>
							<th>Start</th>
							<th>End</th>
							<th>Action</th>
						</tr>
					</thead>
				</table>
			</div> <!-- end .card-body -->
			<div class="card-footer" align="right">
				<!-- start card-footer -->
				<p>Page rendered in <strong>{elapsed_time}</strong> seconds</p>
			</div> <!-- end .card-footer-->
		</div> <!-- end .card -->
	</div> <!-- end .container-fluid -->
</section><!-- /.content -->

<script>
	$("body").toggleClass("sidebar-collapse");
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

		oTable = $('#tableTrx_survey').DataTable({
			"order": [
				[0, "desc"]
			],
			"scrollX": true,
			//"responsive": true,
			"processing": true,
			"serverSide": true,
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			],
			"ajax": {
				"url": "<?php echo site_url('trx_survey/fnTrx_surveyDataJson'); ?>",
				"type": "POST"
			},
			"columns": [{
					data: 'f_id',
					searchable: false,
					name: 'f_id',
					className: 'left',
					orderable: false,
					render: function(data, type, row, meta) {
						$button = '&nbsp;&nbsp;<input type="checkbox" name="f_id" id="f_id" value="' + data + '">&nbsp;&nbsp;';
						return meta.row + meta.settings._iDisplayStart + 1 + ' ' + $button;
					}
				},
				{
					data: 'f_event_name',
					name: 'f_event_name'
				},
				{
					data: 'f_survey_username',
					name: 'f_survey_username'
				},
				{
					data: 'f_survey_email',
					name: 'f_survey_email'
				},
				// {
				// 	data: 'f_no_telp',
				// 	name: 'f_no_telp'
				// },
				// {
				// 	data: 'f_age_desc',
				// 	name: 'f_age_desc'
				// },
				// {
				// 	data: 'f_gender_name',
				// 	name: 'f_gender_name',
				// 	className: 'text-center',
				// 	searchable: false
				// },
				// {
				// 	data: 'f_pekerjaan_desc',
				// 	name: 'f_pekerjaan_desc',
				// 	className: 'text-center',
				// 	searchable: false
				// },
				// {
				// 	data: 'f_pendapatan_desc',
				// 	name: 'f_pendapatan_desc',
				// 	className: 'text-center',
				// 	searchable: false
				// },
				{
					data: 'f_survey_valid',
					name: 'f_survey_valid'
				},
				{
					data: 'f_start',
					name: 'f_start'
				},
				{
					data: 'f_end',
					name: 'f_end'
				},
				{
					data: 'f_id',
					searchable: false,
					name: 'f_id',
					className: 'text-center',
					orderable: false,
					render: function(data, type, row, meta) {
						var button = "";
						button += `&nbsp;<a href='<?= base_url('c/finish/') ?>${row['f_survey_password']}' target='__blank' class='tip' title='Report'><i class='far fa-window-maximize'></i></a>&nbsp;&nbsp;`;
						button += "&nbsp;<a href='javascript:void(0)'  class='tip' title='Hapus' onclick='fnDelete(" + data + ")'><i class='text-red far fa-trash-alt'></i></a>&nbsp;";
						return button;
					}
				},
			],
		});
		$(".dataTables_filter input").attr("placeholder", "Cari Kata disini ...");

	});

	function cari() {
		var r = $("#frmDemo").serialize();
		var Url = '<?php echo site_url('trx_survey/fnTrx_surveyDataJson'); ?>?' + r;
		oTable.ajax.url(Url).load();
	}

	function filexls() {
		var r = $("#frmDemo").serialize();
		var Url = '<?php echo site_url('trx_survey/fnTrx_surveyExcel'); ?>?' + r;
		window.location.href = Url;
	}

	function clear_form_elements(ele) {
		$('#frmDemo input').val('');
		$('.custom-select').val('').trigger('change');
		oTable.ajax.reload();
	}

	function cekAll() {
		$('#tableTrx_survey input[type="checkbox"]').prop('checked', true)
	}

	function unCek() {
		$('#tableTrx_survey input[type="checkbox"]').prop('checked', false)
	}

	function delCek() {
		var a = $('#tableTrx_survey input:checked[type="checkbox"]');
		if (a.length > 0) {
			var fid = new Array;
			for (i = 0; i < a.length; i++) {
				fid[i] = a[i].value;
			}
			//		console.log(fid)
			Swal.fire({
				title: 'Konfirmasi',
				text: 'Yakin ingin dihapus ?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, hapus!'
			}).then((result) => {
				var urlUpdate = '<?php echo site_url('trx_survey/fnTrx_surveyDeleteCheck'); ?>'
				if (result) {
					$.post(urlUpdate, {
						id: fid
					}, function(html) {
						if (html.status == 200) {
							oTable.ajax.reload();
						} else {
							swal.fire({
								html: '<center>Terjadi kesalahan !!</center>',
								icon: 'error',
								confirmButtonText: 'Close',
								confirmButtonColor: '#FF0000'
							});
						}
					});
				}
			});
		} else {
			swal.fire({
				html: '<center>Silahkan, Cek baris dahulu  !!</center>',
				icon: 'error',
				confirmButtonText: 'Close',
				confirmButtonColor: '#FF0000'
			});
		}

	}

	function fnDelete(idRow) {
		Swal.fire({
			title: 'Konfirmasi',
			text: 'Yakin ingin dihapus ?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, hapus!'
		}).then((result) => {
			var urlUpdate = '<?php echo site_url('trx_survey/fnTrx_surveyDelete'); ?>';
			if (result.value) {
				$.post(urlUpdate, {
					id: idRow,
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				}, function(html) {
					if (html.msg) {
						oTable.ajax.reload();
					} else {
						swal.fire({
							text: html.pesan,
							icon: 'error',
							confirmButtonText: 'Close',
							confirmButtonColor: '#FF0000'
						});
					}
				}, 'json');
			}
		});
	}


	function eksport() {
		let id_account = $('#event_account').val();
		if (id_account !== '') {
			var Url = '<?php echo site_url('trx_survey/export/'); ?>' + id_account
			window.location.href = Url;
		} else {
			swal.fire({
				html: '<center>Silahkan, Pilih event  !!</center>',
				icon: 'error',
				confirmButtonText: 'Close',
				confirmButtonColor: '#FF0000'
			});
		}


	}
</script>