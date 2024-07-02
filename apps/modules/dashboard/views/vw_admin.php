<link type="text/css" rel="stylesheet" href="<?php echo PLUG_URL; ?>datatables/dataTables.bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="<?php echo PLUG_URL; ?>select2/css/select2.min.css">
<script src="<?php echo PLUG_URL; ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo PLUG_URL; ?>datatables/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="<?php echo PLUG_URL; ?>jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo PLUG_URL; ?>select2/js/select2.min.js"></script>

<!-- Main content -->
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<?php if ($this->ion_auth->is_admin()) { ?>
				<div class="col-lg-3 col-6">
					<!-- small card -->
					<div class="small-box bg-info">
						<div class="inner">
							<h3><?php echo $regAccount; ?></h3>

							<p><?php echo $this->lang->line('akun_terdaftar'); ?></p>
						</div>
						<div class="icon">
							<i class="fas fa-user-tie"></i>
						</div>
					</div>
				</div>

				<div class="col-lg-3 col-6">
					<!-- small card -->
					<div class="small-box bg-warning">
						<div class="inner">
							<h3><?php echo $countEvent; ?></h3>

							<p>Event</p>
						</div>
						<div class="icon">
							<i class="fas fa-calendar-alt"></i>
						</div>
					</div>
				</div>
				<div class="clearfix">&nbsp;</div>
			<?php } ?>

			<div class="col-lg-12">
				<div class="card">
					<div class="card-body table-responsive">
						<table id="logochi" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>No</th>
									<th><?php echo $this->lang->line('akun'); ?></th>
									<th>Start Date</th>
									<th>End Date</th>
									<th class="center">PIC</th>
									<th>Event Name</th>
									<th>Survey</th>
									<!--
							  <th>Step 1</th>
							  <th>Step 2</th>
							  <th>Step 3</th>
							  <th>Step 4</th>
							  <th>Step Final</th>
-->
								</tr>
							</thead>
						</table>

					</div>
				</div>

			</div>
			<!-- /.col-md-6 -->

		</div>
		<!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script type="text/javascript">
	var oTable;
	$(document).ready(function() {
		oTable = $('#logochi').dataTable({
			"order": [
				[0, "desc"]
			],
			"processing": true,
			"serverSide": true,
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			],
			"ajax": {
				"url": "<?php echo site_url('dashboard/logEvent'); ?>",
				"type": "POST"
			},
			"columns": [{
					data: 'f_event_id',
					searchable: false,
					name: 'f_event_id',
					className: 'left',
					orderable: false,
					render: function(data, type, row, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
				{
					data: 'f_account_name',
					name: 'f_account_name'
				},
				{
					data: 'f_event_start',
					name: 'f_event_start',
					className: 'text-center',
					render: dateFormate
				},
				{
					data: 'f_event_end',
					name: 'f_event_end',
					className: 'text-center',
					render: dateFormate
				},
				{
					data: 'f_account_contact',
					name: 'f_account_contact'
				},
				{
					data: 'f_event_name',
					name: 'f_event_name'
				},
				{
					data: 'f_event_survey',
					name: 'f_event_survey',
					className: 'text-center',
					render: function(data, type, row, meta) {
						return "Link Survey <a href=\"<?= site_url('c/'); ?>" + row.f_event_kode + "\" target=\"_blank\"><i class=\"text-info fas fa-external-link-alt\"></i></a>";
					}
				}
			],
		});
		$(".dataTables_filter input").attr("placeholder", "Cari Kata disini ...");
	});
</script>