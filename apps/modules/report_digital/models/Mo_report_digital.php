<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Mo_report_digital extends CI_Model
{

	public $table = 'trn_survey';

	function fnSummary($f_summary_name)
	{
		return  $this->db->where('f_summary_name', $f_summary_name)->get('table_summary');
	}

	function getVariabel()
	{
		$list = array();
		$sql = $this->db->get('t_variabel');
		if ($sql) {
			foreach ($sql->result() as $r) :
				$list[$r->f_id] = $r->f_variabel_name;
			endforeach;
		}
		return $list;
	}

	function getDimensi()
	{
		$list = array();
		$sql = $this->db->get('t_dimensi')->result();
		//if($sql)
		//{
		//foreach($sql->result() as $r):
		//$list[$r->f_id] = $r->f_dimensi_name;
		//endforeach;
		//}
		return $sql;
	}

	function getItem()
	{
		$list = array();
		$this->db->where('f_variabel_id', 1);
		$sql = $this->db->get('t_item_pernyataan');
		if ($sql) {
			foreach ($sql->result() as $r) :
				$list['soal'][$r->f_id] = $r;
				$list['total_variabel'][$r->f_variabel_id]++;
				$list['total_dimensi'][$r->f_dimensi_id]++;
			endforeach;
		}
		return $list;
	}

	function getTrxSurvey($schedule, $paramGroup = null, $paramGroupIn = null)
	{
		$param = array(
			'f_event_id'		=> $schedule,
			'f_survey_valid'	=> 'yes'
		);	//ok
		if (isset($paramGroup) && count($paramGroup) > 0) {
			$this->db->where($paramGroup);
		}

		if (isset($paramGroupIn) && count($paramGroupIn) > 0) {
			foreach ($paramGroupIn as $a => $b) {
				//$this->db->where_in($a,$b); 
				foreach ($b as $c) {
					if ($c) $d[$a][] = $c;
				}
				if (count($d[$a]) > 0)	$this->db->where_in($a, $d[$a]);
			}
		}

		//$colom_select = 'f_survey_current, f_survey_desire'; 
		$all_pva =	$this->db->select('f_id, f_survey', false)->where($param)->get('trn_survey_empex')->result_array();
		//echo $this->db->last_query()."<br/>";die();
		return $all_pva;
	}

	function fnSurveyTotal($data_survey, $item)
	{
		$this->db->where('f_variabel_id', 1);
		$sql_dim = $this->getDimensi();
		$listdim = array();
		foreach ($sql_dim as $r) :
			$listdim[$r->f_id] = $r->f_dimensi_name;
		endforeach;

		$group_values = array();
		$ar = array();
		$vt = array();
		$sa = array();
		$i = 0;
		$total_responden = count($data_survey);

		$final = array();
		$responden = array();
		$tdimensi = array();
		$_stdev = array();
		foreach ($data_survey as $row) :
			$json = json_decode($row['f_survey'], true);
			// HITUNG TOTAL ALL PER DIMENSI
			foreach ($json['total_kategori'] as $a => $b)  $tdimensi[$a] += $b;
			//opn($json['pertanyaan']);
			foreach ($json['pertanyaan'] as $a => $b) {
				$ar[] = $b;
				$sa[$a] += $b;
				$_stdev[$a][] = $b;
				$responden[$row['f_id']][$a] += $b;
			}
		endforeach;

		krsort($tdimensi);
		// CARI RATA DIMENSI / INDEKS
		$rdimensi = array();
		foreach ($tdimensi as $k => $v) {
			//echo $v.br();
			$rdimensi[$k] = decimal_report(($v / ($item['total_dimensi'][$k] * $total_responden)), 2);
		}

		// CARI NILAI MINIMAL
		asort($rdimensi);
		$_vmin = array_slice($rdimensi, 0, 1, false);
		$vmin = $_vmin[0];
		// CARI NILAI MAXIMAL
		arsort($rdimensi);
		$_vmax = array_slice($rdimensi, 0, 1, false);
		$vmax = $_vmax[0];
		// CARI INTERPOLASI
		asort($rdimensi);
		$idimensi = array();
		foreach ($rdimensi as $k => $v) {
			$idimensi[$k] = decimal_report(((($v - $vmin) * (4 - 1)) / ($vmax - $vmin)) + 1, 2);
		}

		krsort($listdim);
		$table_dimensi = array();
		foreach ($listdim as $k => $v) {
			$table_dimensi[] = array(
				'id' => $k,
				'nama' => $v,
				'indeks' => $rdimensi[$k],
				'interpolasi' => $idimensi[$k],
			);
		}

		$final['total_responden'] = $total_responden;
		$final['list_dimensi'] = $listdim;
		$final['vmin'] = $vmin;
		$final['vmax'] = $vmax;
		$final['indeks'] = $rdimensi;
		$final['interpolasi'] = $idimensi;
		$final['data_table'] = $table_dimensi;


		return $final;
		//die();
		//opn($_stdev);
		//$mean = array();
		//$stdev = array();
		//$left = array();
		//$right = array();
		//foreach($sa as $a => $b) {
		//$mean[$a] = decimal_report($b/$total_responden,2);
		//$stdev[$a] = decimal_report(stand_deviation($_stdev[$a]),2);
		//$left[$a] = $mean[$a]-$stdev[$a];  
		//$right[$a] = $mean[$a]+$stdev[$a];  
		//}


		////opn($mean);
		////opn($stdev);
		////opn($left);
		////opn($right);
		////die();

		//// hitung total soal yang dipilih responden
		//$totalPilih = count($ar);
		//// menghitung count scale
		//$count_scale = array_count_values( $ar );
		//// menghitung total scale
		//$total_scale = array_sum( $ar );
		//// urutkan asc key
		//asort($count_scale);

		//foreach($count_scale as $k => $v):
		//$sum_scale[$k] = $k * $v;
		//endforeach;

		//$final['totalPilih'] = $totalPilih;
		//$final['rata'] = $count_scale;
		//$final['data_soal'] = $sa;
		//$final['data_scale'] = $sum_scale;
		//$final['total_scale'] = $total_scale;
		////$final['allScale'] = $totalPilih*6;
		////$final['persenScale'] = round(($total_scale*100)/($totalPilih*6),2);

		//foreach($sum_scale as $k => $v):
		//$persen_scale[$k] = round(($v*100)/$total_scale,2);
		//endforeach;
		//ksort($persen_scale);
		//$final['persen_scale'] = $persen_scale;

		////opn($data);
		////die();
		////foreach($kategori as $a => $b)
		////{
		////$rp[$a] = array(
		////'total' => round(($b/$total_responden),2)
		////);
		////}
		////$final = array('kategori' => $kategori);
		//// $final adalah array terakhir

		//return $final;		
	}

	function olahDataSummaryQuesioner($data, $variabel, $dimensi, $item, $responden)
	{
		// buat combo id kondisi
		$_kondisi = $variabel;
		// buat id Indikator
		foreach ($dimensi as $r) :
			$indikator[$r->f_id] = $r->f_dimensi_name;
		endforeach;
		// buat id Soal
		$soal = $item['soal'];
		foreach ($soal as $k => $v) :
			$idsoal[$v->f_id]['tanya'] = $v->f_item_name;
			$idsoal[$v->f_id]['kondisi_id'] = $v->f_variabel_id;
			$idsoal[$v->f_id]['indikator_id'] = $v->f_dimensi_id;
		//$idsoal[$v['f_soal_id']]['master_id'] = $v['f_id_soal'];
		endforeach;
		//opn($idsoal);

		$_cond = array();
		foreach ($soal as $k => $v) :
			$_cond[$v->f_id] = $v->f_variabel_id;
		endforeach;
		//opn($_cond);

		// data survey di olah nie :)
		$totalScale = 0;
		$arSoal = array();
		$clikSoal = array();
		$arr = array();
		foreach ($data as $data) :
			//$_arr = unserialize($data['f_survey_data']);
			$_arr = json_decode($data['f_survey'], true);;
			//opn($_arr['soal']);
			foreach ($_arr['soal'] as $aa => $bb) {
				//$arr[$_cond[$aa]][ $aa ] = $bb;
				$arr[$idsoal[$aa]['kondisi_id']][$idsoal[$aa]['indikator_id']][$aa] += $bb;
				$arSoal[$aa][$bb]++;
				$clikSoal[$aa]++;
			}
		endforeach;
		//opn($arr);
		//die();
		//opn($arSoal);die();
		//opn($clikSoal);
		$persen_scale = array();
		foreach ($arSoal as $a => $b) {
			foreach ($b as $c => $d) {
				//if($c) 
				$persen_scale[$a][$c] = round(($d * 100) / $clikSoal[$a], 2);
			}
		}
		//opn($persen_scale);
		//die();
		$arr1 = array();
		foreach ($arr as $a => $b) {
			$arr1['kondisi'][$a]['nama'] = $_kondisi[$a];
			$arr1['kondisi'][$a]['nama'] = $_kondisi[$a];
			$arr1['kondisi'][$a]['total_soal'] = 0;
			$arr1['kondisi'][$a]['total'] = 0;
			//$arr1['table'][$a]['kondisi_nama'] = [];
			// foreach id kondisi 
			$akumulasi_total_persen_kondisi = array();
			foreach ($b as $c => $d) {
				//$arr1['table'][$a]['kondisi_nama'] = $_kondisi[$a];
				$arr1['indikator'][$c]['nama'] = $indikator[$c];
				$arr1['indikator'][$c]['total_soal'] = 0;
				$arr1['indikator'][$c]['total'] = 0;
				$arr1['indikator'][$c]['persen'] = 0;
				// foreach id soal
				$akumulasi_total_persen_indikator = array();
				foreach ($d as $e => $f) {

					$arr1['table'][$a][$c][$e]['tanya'] = $idsoal[$e]['tanya'];
					$arr1['table'][$a][$c][$e]['totalscale'] = $f;
					$arr1['table'][$a][$c][$e]['total_vote'] = $clikSoal[$e];
					$persenscale = round(($f * 100) / ($responden * 6), 3);
					$akumulasi_total_persen_indikator[$c] += $persenscale;
					$akumulasi_total_persen_kondisi[$a] += $persenscale;
					$arr1['table'][$a][$c][$e]['persenscale'] = $persenscale;
					$scf = getStatusColorSkorEngage($persenscale);
					$arr1['table'][$a][$c][$e]['kategori_nama'] = $scf['status'];
					$arr1['table'][$a][$c][$e]['kategori_color'] = $scf['color'];
					$arr1['table'][$a][$c][$e]['kategori_fcolor'] = $scf['fcolor'];
					$gsc = array();
					foreach ($persen_scale[$e] as $_k => $_v) :
						if ($_k > 5) {
							$gsc[$e]['AE'] += $_v;
						} else if ($_k == 5) {
							$gsc[$e]['E'] += $_v;
						} else if ($_k >= 3 and $_k <= 4) {
							$gsc[$e]['DE'] += $_v;
						} else {
							$gsc[$e]['ADE'] += $_v;
						}
					endforeach;

					$arr1['table'][$a][$c][$e]['ADE'] = ($gsc[$e]['ADE']) ? $gsc[$e]['ADE'] : 0; // ACTIVELY DISENGAGE
					$arr1['table'][$a][$c][$e]['DE'] = ($gsc[$e]['DE']) ? $gsc[$e]['DE'] : 0; // PASSIVE
					$arr1['table'][$a][$c][$e]['ADEDE'] = $arr1['table'][$a][$c][$e]['ADE'] + $arr1['table'][$a][$c][$e]['DE']; // Percent Not Engaged

					$arr1['table'][$a][$c][$e]['E'] = ($gsc[$e]['E']) ? $gsc[$e]['E'] : 0; // MODERATELY ENGAGED
					$arr1['table'][$a][$c][$e]['AE'] = ($gsc[$e]['AE']) ? $gsc[$e]['AE'] : 0; // HIGHLY ENGAGED
					$arr1['table'][$a][$c][$e]['EAE'] = $arr1['table'][$a][$c][$e]['E'] + $arr1['table'][$a][$c][$e]['AE']; // Percent Highly Engaged

					$arr1['kondisi'][$a]['total'] += $f;
					$arr1['indikator'][$c]['total'] += $f;
					$arr1['kondisi'][$a]['total_soal']++;
					$arr1['indikator'][$c]['total_soal']++;

					$_apmh[$e] = array(
						array('urutan' => 1, 'nilai' => $arr1['table'][$a][$c][$e]['AE']), // HIGHLY ENGAGED 
						array('urutan' => 2, 'nilai' => $arr1['table'][$a][$c][$e]['E']),  // MODERATELY ENGAGED
						array('urutan' => 3, 'nilai' => $arr1['table'][$a][$c][$e]['DE']), // PASSIVE
						array('urutan' => 4, 'nilai' => $arr1['table'][$a][$c][$e]['ADE']), // ACTIVELY DISENGAGE
					);
					//;
					$apmh[$e] = array_values(array_sort($_apmh[$e], 'nilai', SORT_DESC));
					$_max1[$e] = $apmh[$e][0];
					$_max2[$e] = $apmh[$e][1];
					//opn($_max1[$e]);
					// KATEGORI ISSUE
					// Very Good
					if ($_max1[$e]['urutan'] == 1 && $arr1['table'][$a][$c][$e]['ADEDE'] < $arr1['table'][$a][$c][$e]['EAE']) {
						$arr1['table'][$a][$c][$e]['hidden_kategori'] = 'Very Good Condition';
						$arr1['table'][$a][$c][$e]['hidden_color'] = '#006600';
						$arr1['table'][$a][$c][$e]['hidden_fcolor'] = '#ffffff';
					} else if ($_max1[$e]['urutan'] == 2 && $arr1['table'][$a][$c][$e]['ADEDE'] < $arr1['table'][$a][$c][$e]['EAE']) {
						$arr1['table'][$a][$c][$e]['hidden_kategori'] = 'Good Condition';
						$arr1['table'][$a][$c][$e]['hidden_color'] = '#ffff00';
						$arr1['table'][$a][$c][$e]['hidden_fcolor'] = '#000';
					} else if ($_max1[$e]['urutan'] == 2 && $arr1['table'][$a][$c][$e]['ADEDE'] > $arr1['table'][$a][$c][$e]['EAE']) {
						$arr1['table'][$a][$c][$e]['hidden_kategori'] = 'Moderate Hidden Issue';
						$arr1['table'][$a][$c][$e]['hidden_color'] = '#ff6600';
						$arr1['table'][$a][$c][$e]['hidden_fcolor'] = '#000';
					} else if ($_max1[$e]['urutan'] == 3 || $_max1[$e]['urutan'] == 4 && $arr1['table'][$a][$c][$e]['ADEDE'] > $arr1['table'][$a][$c][$e]['EAE']) {
						$arr1['table'][$a][$c][$e]['hidden_kategori'] = 'Significant Hidden Issue';
						$arr1['table'][$a][$c][$e]['hidden_color'] = '#d60000';
						$arr1['table'][$a][$c][$e]['hidden_fcolor'] = '#ffffff';
					}
				}

				$total_persen_indikator = round($akumulasi_total_persen_indikator[$c] / $arr1['indikator'][$c]['total_soal'], 2);
				$scf = getStatusColorSkorEngage($total_persen_indikator);
				$arr1['indikator'][$c]['persen'] = $total_persen_indikator;
				$arr1['indikator'][$c]['kategori_nama'] = $scf['status'];
				$arr1['indikator'][$c]['kategori_color'] = $scf['color'];
				$arr1['indikator'][$c]['kategori_fcolor'] = $scf['fcolor'];
			}
			$total_persen_kondisi = round($akumulasi_total_persen_kondisi[$a] / $arr1['kondisi'][$a]['total_soal'], 2);
			$scf = getStatusColorSkorEngage($total_persen_kondisi);
			$arr1['kondisi'][$a]['persen'] = $total_persen_kondisi;
			$arr1['kondisi'][$a]['kategori_nama'] = $scf['status'];
			$arr1['kondisi'][$a]['kategori_color'] = $scf['color'];
			$arr1['kondisi'][$a]['kategori_fcolor'] = $scf['fcolor'];
		}
		//opn($arr1['table']);die();
		//opn($arr1);die();
		return $arr1;
	}

	function fnGetDataAccount()
	{
		$this->db->select('a.f_account_id, a.url, f_setting,f_page_personal,f_page_leaderc,f_page_leaderd,f_label_level1, f_label_level2, f_label_level3, f_label_level4, f_label_level5, f_label_level6, f_label_level7, f_label_others,c.f_account_name, f_language, c.f_account_logo');
		$this->db->join('users b', 'b.f_account_id=a.f_account_id');
		$this->db->join('t_account c', 'a.f_account_id=c.f_account_id');
		$this->db->where('a.f_account_id', sAccount);
		$sql = $this->db->get('survey_setting a');
		if ($sql->num_rows() > 0) {
			$f_user = $sql->row_array();
			return $f_user;
		} else {
			return false;
		}
	}

	function getDataId($id)
	{
		$sql = $this->db->get_where($this->table, array('f_id' => $id))->row_array();
		return $sql;
	}

	function comboData()
	{
		$sql = $this->db->get($this->table);
		if ($sql) {
			foreach ($sql->result() as $r) :
				$list[$r->f_id] = $r->f_id;
			endforeach;
		}
		return $list;
	}

	function comboDataEvent()
	{
		$this->db->select('f_event_id, f_event_name, date_format(f_event_start,,"%d-%m-%Y %H:%i") f_event_start, date_format(f_event_end,,"%d-%m-%Y %H:%i") f_event_end', false);
		$this->db->where('f_variabel_id', 1);
		if (sAccount != 0) {
			$this->db->where('f_account_id', sAccount);
		}
		$sql = $this->db->get('t_event');
		if ($sql) {
			foreach ($sql->result() as $r) :
				$list[$r->f_event_id] = $r->f_event_name;
			endforeach;
		}
		return $list;
	}

	function comboDataValues()
	{
		$this->db->select('f_value_id, f_value_name', false);
		$this->db->where('f_account_id', sAccount);
		$sql = $this->db->get('table_value');
		if ($sql) {
			foreach ($sql->result() as $r) :
				$list[$r->f_value_id] = $r->f_value_name;
			endforeach;
		}
		return $list;
	}

	function remoteComboData()
	{
		if ($this->input->get('term')) $this->db->like('f_id', $this->input->get('term')); // pencarian name
		if ($this->input->get('id')) $this->db->where('f_id', $this->input->get('id')); // saat pencarian update

		$this->db->limit('10');
		$result = $this->db->get($this->table)->result();
		$DataJson = array();
		foreach ($result as $row) :
			$data['id']	= $row->f_id; // value
			$data['text']	= $row->f_id; // change display 
			array_push($DataJson, $data);
		endforeach;
		return $DataJson;
	}
}

/* End of file Mo_trx_survey.php */
/* Location: ./application/modules/Trx_survey/models/Mo_trx_survey.php */
