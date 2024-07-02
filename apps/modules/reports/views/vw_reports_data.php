<?php
//$this->load->view('admin/header');
//$this->load->view('admin/sidebar');
?>

<style>
	.center {
		text-align: center;
	}

	.scrollbar {
		margin-left: 30px;
		float: left;
		height: 300px;
		width: 65px;
		background: #F5F5F5;
		overflow-y: scroll;
		margin-bottom: 25px;
	}

	.force-overflow {
		min-height: 450px;
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

	#style-10::-webkit-scrollbar-track {
		-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
		background-color: #F5F5F5;
		border-radius: 10px;
	}

	#style-10::-webkit-scrollbar {
		width: 10px;
		background-color: #F5F5F5;
	}

	#style-10::-webkit-scrollbar-thumb {
		background-color: #AAA;
		border-radius: 10px;
		background-image: -webkit-linear-gradient(90deg,
				rgba(0, 0, 0, .2) 25%,
				transparent 25%,
				transparent 50%,
				rgba(0, 0, 0, .2) 50%,
				rgba(0, 0, 0, .2) 75%,
				transparent 75%,
				transparent)
	}
</style>
<div class="text-center">
	<div class="reloading"><i class="fas fa-5x fa-spinner fa-spin"></i> <span class="fa-5x">Loading ...</span></div>
</div>
<div class="card card-solid card-default">
	<!-- <div class="card-header bg-light">
		<h2 class="card-title"><?php echo $ourSystem; ?></h2>
	</div>
	<div class="card-body">
		<h1 style="text-align:center"> &nbsp; <br> <?php echo $namaAccount; ?> : Overall Group <br> (<?php echo $totalResponden; ?>) </h1>
		<p style="text-align:center">Prepared by: <?php echo $ourSystem; ?> <br> <?php echo date('M d, Y'); ?></p>
	</div> -->
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
</div>

<div class="card">
	<div class="card-header bg-light">
		<h3 class="card-title">Detail Responden</h3>
	</div>
	<div class="card-body row">
		<div style="overflow-x: scroll;">
			<table class="table">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<?php foreach ($pernyataan as $key) : ?>
							<th>
								<?= $key['f_kode'] ?>
							</th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1 ?>
					<?php foreach ($responden as $key) : ?>
						<tr>
							<td><?= $i ?></td>
							<td><?= $key['f_survey_username'] ?></td>
							<?php
							$jawaban_responden = json_decode($key['f_survey'], true);
							$item_pernyataan = $jawaban_responden['item_pertanyaan'];
							foreach ($item_pernyataan as $answer) {
								echo '<td>' . $answer . '</td>';
							}
							?>
						</tr>
						<?php $i++; ?>
					<?php endforeach; ?>
					<?php ?>
					<tr>
						<th colspan="2">MEAN</th>
						<?php foreach ($mean as $key) : ?>
							<th><?= $key ?></th>
						<?php endforeach; ?>
					</tr>
					<tr>
						<th colspan="2">STDEV</th>
						<?php foreach ($stdev as $key) : ?>
							<th><?= $key ?></th>
						<?php endforeach; ?>
					</tr>
					<tr>
						<th colspan="2">LEFT</th>
						<?php foreach ($left as $key) : ?>
							<th><?= $key ?></th>
						<?php endforeach; ?>
					</tr>
					<tr>
						<th colspan="2">RIGHT</th>
						<?php foreach ($right as $key) : ?>
							<th><?= $key ?></th>
						<?php endforeach; ?>
					</tr>
				</tbody>
			</table>
		</div>

	</div>
</div>

<div class="card">
	<div class="card-header bg-light">
		<h3 class="card-title">Demografi Responden</h3>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Nomor</th>
							<th>Kriteria</th>
							<th>Jumlah</th>
							<th>%</th>
						</tr>
						<tr>
							<th colspan="4">Jenis Kelamin</th>
						</tr>
						<?php $i = 1;
						foreach ($gender as $key) {
							echo '<tr>
									<td>' . $i . '</td>
									<td>' . $key['name'] . '</td>
									<td>' . $key['y'] . '</td>
									<td>' . $key['persentase'] . '</td>
								</tr>';

							$i++;
						} ?>
						<tr>
							<th colspan="4">Usia</th>
						</tr>
						<?php $i = 1;
						foreach ($umur as $key) {
							echo '<tr>
									<td>' . $i . '</td>
									<td>' . $key['name'] . '</td>
									<td>' . $key['y'] . '</td>
									<td>' . $key['persentase'] . '</td>
								</tr>';

							$i++;
						} ?>
						<tr>
							<th colspan="4">Pekerjaan</th>
						</tr>
						<?php $i = 1;
						foreach ($pekerjaan as $key) {
							echo '<tr>
									<td>' . $i . '</td>
									<td>' . $key['name'] . '</td>
									<td>' . $key['y'] . '</td>
									<td>' . $key['persentase'] . '</td>
								</tr>';

							$i++;
						} ?>
						<tr>
							<th colspan="4">Pendapatan</th>
						</tr>
						<?php $i = 1;
						foreach ($pendapatan as $key) {
							echo '<tr>
									<td>' . $i . '</td>
									<td>' . $key['name'] . '</td>
									<td>' . $key['y'] . '</td>
									<td>' . $key['persentase'] . '</td>
								</tr>';

							$i++;
						} ?>
					</thead>
				</table>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-6">
						<figure class=" highcharts-figure">
							<div id="jenis_kelamin"></div>
						</figure>
					</div>
					<div class="col-md-6">
						<figure class=" highcharts-figure">
							<div id="umur"></div>
						</figure>
					</div>
					<div class="col-md-6">
						<figure class=" highcharts-figure">
							<div id="pendapatan"></div>
						</figure>
					</div>
					<div class="col-md-6">
						<figure class=" highcharts-figure">
							<div id="pekerjaan"></div>
						</figure>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

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


		// Data retrieved from https://netmarketshare.com/
		// Make monochrome colors
		const colors = Highcharts.getOptions().colors.map((c, i) =>
			// Start out with a darkened base color (negative brighten), and end
			// up with a much brighter color
			Highcharts.color(Highcharts.getOptions().colors[0])
			.brighten((i - 3) / 7)
			.get()
		);

		// Build the chart
		Highcharts.chart('jenis_kelamin', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'Grafik Jenis Kelamin',
				align: 'left'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			accessibility: {
				point: {
					valueSuffix: '%'
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					colors,
					borderRadius: 5,
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
						distance: -50,
						filter: {
							property: 'percentage',
							operator: '>',
							value: 4
						}
					}
				}
			},
			series: [{
				name: 'Share',
				data: <?php echo json_encode($gender, JSON_NUMERIC_CHECK); ?>,
			}]
		});

		Highcharts.chart('umur', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'Grafik Umur',
				align: 'left'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			accessibility: {
				point: {
					valueSuffix: '%'
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					colors,
					borderRadius: 5,
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
						distance: -50,
						filter: {
							property: 'percentage',
							operator: '>',
							value: 4
						}
					}
				}
			},
			series: [{
				name: 'Share',
				data: <?php echo json_encode($umur, JSON_NUMERIC_CHECK); ?>,
			}]
		});

		Highcharts.chart('pendapatan', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'Grafik Pendapatan',
				align: 'left'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			accessibility: {
				point: {
					valueSuffix: '%'
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					colors,
					borderRadius: 5,
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
						distance: -50,
						filter: {
							property: 'percentage',
							operator: '>',
							value: 4
						}
					}
				}
			},
			series: [{
				name: 'Share',
				data: <?php echo json_encode($pendapatan, JSON_NUMERIC_CHECK); ?>,
			}]
		});

		Highcharts.chart('pekerjaan', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'Grafik Pekerjaan',
				align: 'left'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			accessibility: {
				point: {
					valueSuffix: '%'
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					colors,
					borderRadius: 5,
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
						distance: -50,
						filter: {
							property: 'percentage',
							operator: '>',
							value: 4
						}
					}
				}
			},
			series: [{
				name: 'Share',
				data: <?php echo json_encode($pekerjaan, JSON_NUMERIC_CHECK); ?>,
			}]
		});

		/*---------- Chart POSITIVE ENERGY INDEX ----------*/
		//$('html, body').animate({ scrollTop: $("div.toPrint").offset().top   }, 500);
		$('.reloading').remove();
	});
</script>