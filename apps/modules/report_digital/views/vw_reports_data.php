<?php
//$this->load->view('admin/header');
//$this->load->view('admin/sidebar');
?>

<style>
	.center {
		text-align: center;
	}

	.reloading {
		position: fixed;
		z-index: 999;
		height: 2em;
		width: 15em;
		overflow: show;
		margin: auto;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0
	}

	.reloading:before {
		content: '';
		display: block;
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));
		background: -webkit-radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8))
	}
</style>
<div class="text-center">
	<div class="reloading"><i class="fas fa-5x fa-spinner fa-spin"></i> <span class="fa-5x">Loading ...</span></div>
</div>
<div class="card card-solid card-default">
	<div class="card-header bg-light">
		<h2 class="card-title"><?php echo $ourSystem; ?></h2>
	</div>
	<div class="card-body">
		<h1 style="text-align:center"> &nbsp; <br> <?php echo $namaAccount; ?> : Overall Group <br> (<?php echo $totalResponden; ?>) </h1>
		<p style="text-align:center">Prepared by: <?php echo $ourSystem; ?> <br> <?php echo date('M d, Y'); ?></p>
	</div>
</div>

<div class="page-break"></div>

<div class="card" id="entropi_table">
	<div class="card-header bg-light">
		<h3 class="card-title">Total Score (<?php echo $totalResponden . ' Responden'; ?>)</h3>
	</div>
	<div class="card-body row">
		<div class="col-12 mb-5" id="grafik_polar"></div>
		<br />
		<hr>
		<table class="table tabled-bordered">
			<thead>
				<tr>
					<th width="50%">Dimensi</th>
					<th class="center" width="25%">Indeks</th>
					<th class="center" width="25%">Interpolasi</th>
				</tr>
			</thead>
			<tbody>
				<?php
				//opn($item);
				//opn($sr_result['data_table']);
				//$total_variabel_soal = $item['total_variabel'];
				//$variabel_total = $sr_result['variabel_total'];
				//opn($total_variabel_soal);
				//opn($variabel_total);
				$tota_all_variabel = 0;
				$data_kategori = array();
				$data_series = array();
				$i = 0;
				foreach ($sr_result['data_table'] as $b) {
					echo "<tr>";
					echo "<td>" . $b['nama'] . "</td>";
					echo "<td class='center'>" . $b['indeks'] . "</td>";
					echo "<td class='center'>" . $b['interpolasi'] . "</td>";
					echo "</tr>";
					$data_kategori[$i] = $b['nama'];
					$data_series[$i] = $b['interpolasi'];
					$i++;
				}
				?>
			</tbody>
		</table>
	</div>
</div> <!-- card -->

<script src="<?php echo PLUG_URL; ?>highcharts/highcharts.js"></script>
<script src="<?php echo PLUG_URL; ?>highcharts/highcharts-more.js"></script>
<script src="<?php echo PLUG_URL; ?>highcharts/modules/exporting.js" type="text/javascript"></script>
<script src="<?php echo PLUG_URL; ?>highcharts/modules/export-data.js" type="text/javascript"></script>
<script src="<?php echo PLUG_URL; ?>jquery/jquery.json-2.3.min.js" type="text/javascript"></script>
<!--
<script src="<?php echo PLUG_URL; ?>iCheck/icheck.min.js"></script>
-->

<script type="text/javascript">
	// Menyembunyikan sidebar $("body").toggleClass("sidebar-collapse");
	var charts = new Array();
	var options, optionsPlot, optionSpider, optionStacked, optionStacked1;
	var dataPlot1, dataPlot2, dataPlot3, data1, data2, data3 = new Array();

	$(document).ready(function() {
		$('#grafik_polar').highcharts({
			chart: {
				polar: true,
				type: 'line'
			},
			title: {
				text: 'RESULT',
			},
			pane: {
				size: '80%'
			},
			xAxis: {
				categories: <?php echo json_encode($data_kategori); ?>,
				tickmarkPlacement: 'on',
				lineWidth: 0
			},
			yAxis: {
				gridLineInterpolation: 'polygon',
				lineWidth: 0,
				tickInterval: 1,
				min: 0
			},
			tooltip: {
				shared: true,
				pointFormat: '<span style="color:{series.color}"><b>{point.y:,.0f}</b>'
			},
			legend: {
				enabled: false,
				align: 'right',
				verticalAlign: 'top',
				y: 70,
				layout: 'vertical'
			},
			series: [{
				data: <?php echo json_encode($data_series, JSON_NUMERIC_CHECK); ?>,
				pointPlacement: 'on'
			}],
			credits: {
				enabled: false
			},
		});



		/*---------- Chart POSITIVE ENERGY INDEX ----------*/
		//$('html, body').animate({ scrollTop: $("div.toPrint").offset().top   }, 500);
		$('.reloading').remove();
	});
</script>