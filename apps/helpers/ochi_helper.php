<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('array_sort') )
{
	function array_sort($array, $on, $order=SORT_ASC)
	{
	    $new_array = array();
	    $sortable_array = array();
	
	    if (count($array) > 0) {
	        foreach ($array as $k => $v) {
	            if (is_array($v)) {
	                foreach ($v as $k2 => $v2) {
	                    if ($k2 == $on) {
	                        $sortable_array[$k] = $v2;
	                    }
	                }
	            } else {
	                $sortable_array[$k] = $v;
	            }
	        }
	
	        switch ($order) {
	            case SORT_ASC:
	                asort($sortable_array);
	            break;
	            case SORT_DESC:
	                arsort($sortable_array);
	            break;
	        }
	
	        foreach ($sortable_array as $k => $v) {
	            $new_array[$k] = $array[$k];
	        }
	    }
	
	    return $new_array;
	}
}

if( ! function_exists('replacer') )
{
	function replacer(& $item, $key) 
	{
		if ($item === null) {
        $item = 0;
		}
	}
}

if( ! function_exists('persenan'))
{
	function persenan(& $item, $key, $divider)
	{
		$item = round( $item * 100 / $divider , 0) ;
	}
}

if (! function_exists('makeInt')) {
	function makeInt($angka)    {
		if ($angka < -0.0000001)    {
			return ceil($angka-0.0000001);
		}
		else    {
			return floor($angka+0.0000001);
		}
	}
}

if( ! function_exists('enambulan'))
{
	function enambulan($in) {
		$n = 180;
		$tgl = substr($in,8,2);
		$bln = substr($in,5,2);
		$thn = substr($in,0,4);
		
		$nextN = mktime(0, 0, 0, $bln, makeInt($tgl) + $n, $thn);
		$hasil = date("Y-m-d",$nextN);
		return $hasil;
	}
}

if( ! function_exists('resultPlot'))
{
	function resultPlot($val,$status = 1)
	{
		if($status == 1)
		{
			$sort = array_sort($val,'value_priot', SORT_DESC);
		}
		else
		{
			$sort = array_sort($val,'value_count', SORT_DESC);
		}
		// mengambil 10 value prioritas terbanyak
		$output = array_slice($sort, 0, 10);
		return $output;
	}
}

if( ! function_exists('resultDistribution'))
{
	function resultDistribution($val = array(),$status = 1,$responden = null)
	{
		//echo "<pre>";echo count($val)."</pre><br/>";
		//echo "<pre>";echo print_r($val)."</pre><br/>";
		/*
		 * status = 1 , maka perhitungan bobot
		 * status = 2 , maka perhitungan vote
		*/ 
		$ci =& get_instance();
		$ci->load->database();
		$color = $ci->db->get('table_color')->result_array();
		$i=0;
		foreach(array_sort($color,'f_color_id',SORT_DESC) as $r )
		{
			$nameColor[$i] = $r['f_color_name'];
			$codeColor[$i] = $r['f_color_code'];
			$idColor[$i] = $r['f_color_id'];
			$i++;
		}
				
		$po = array('name'=>'Positif','color'=>'#0E35FF');
		$li = array('name'=>'Limit','color'=>'#525252');
		$ba['name'] = 'batas';
		$po_bb = array();
		$po_vt = array();
		$li_bb = array();
		$li_vt = array();
		$ttl=0;
		foreach($codeColor as $a => $b)
		{
			foreach($val as $key => $row)
			{
				//if($row['value_status'] == 'limit')
				//{
					////$ttl += $row['value_count'];
				//}
				
				if( $row['color_code'] == $b && $row['value_status'] == 'positif' )
				{
					$po['data'][$a]['color']	= $b;
					$po['data'][$a]['y'] 		+=1;
					$po_bb[$a]					+= $row['value_bobot'];
					$po_vt[$a]					+= $row['value_count'];

				}
				//else
				//{
					//$po['data'][$a]['color'] 	= '#000';
					//$po['data'][$a]['y'] 		+=0;
					//$po_bb[$a]					+= 0;
					//$po_vt[$a]					+= 0;
				//}

				if( $row['color_code'] == $b && $row['value_status'] == 'limit' )
				{
					$ttl += $row['value_count'];
					$li['data'][$a]['color'] 	= '#000';
					$li['data'][$a]['y'] 		+=1;
					$li_bb[$a]					+= $row['value_bobot'];
					$li_vt[$a]					+= $row['value_count'];
				}
				else
				{
					$li['data'][$a]['color'] 	= '#000';
					$li['data'][$a]['y'] 		+=0;
					$li_bb[$a]					+= 0;
					$li_vt[$a]					+= 0;
				}
			} // end foreach $arr;
		} // end foreach $codeColor;		

		//echo "<pre>PO ";echo print_r($po)."</pre><br/>";
		//echo "<pre>";echo print_r($li_vt)."</pre><br/>";
				
		//for($i=0;$i<6;$i++)	{
			//foreach($val as $key => $row):
				//if( $row['color_code'] == $color[$i]['f_color_code'] && $row['value_status'] == 'positif' ) {
					//$po['data'][$i]['name']		= $row['color_name'];
					//$po['data'][$i]['color']	= $row['color_code'];
					//$po_bb[$i]					+= $row['value_bobot'];
					//$po_vt[$i]					+= $row['value_count'];
				//}
				//elseif( $row['color_code'] == $color[$i]['f_color_code'] && $row['value_status'] == 'limit')	{
					//$li['data'][$i]['name']		= $row['color_name'];
					//$li['data'][$i]['color']	= '#000000';	//$row['color_code'];
					//$li_bb[$i]					+= $row['value_bobot'];
					//$li_vt[$i]					+= $row['value_count'];

				//}
				//else { }				
			//endforeach;
		//}
		
		foreach($codeColor as $a => $b)
		{
			$po['data'][$a]['color'] 	= $b;
			$li['data'][$a]['color'] 	= '#000';
			if($status == 1)
			{
				//$po['data'][$a]['y']		= round(($po_bb[$a] * 100) / $val[0]['total_bobot'],2);
				//$li['data'][$a]['y']		= round(($li_bb[$a] * 100) / $val[0]['total_bobot'],2);
				$po['data'][$a]['y']		= round(($po_bb[$a] / $val[0]['total_bobot'])*100,1);
				$li['data'][$a]['y']		= round(($li_bb[$a] / $val[0]['total_bobot'])*100,1);

			}
			elseif($status == 2)
			{
				//echo $li_vt[$a].' - '.$val[0]['total_vote']."<br/>";
				//$po['data'][$a]['y']		= round(($po_vt[$a] * 100) / $val[0]['total_vote'],2);
				//$li['data'][$a]['y']		= round(($li_vt[$a] * 100) / $val[0]['total_vote'],2);
				$po['data'][$a]['y']		= round(($po_vt[$a] / $val[0]['total_vote'])*100,1);
				$li['data'][$a]['y']		= round(($li_vt[$a] / $val[0]['total_vote'])*100,1);
			}
			else { }
		}
		
		$sort = array_slice(array_sort($po['data'],'y',SORT_DESC),0,1);
		$y = $sort[0]['y'];
		if($y >= 0 && $y <= 35 ) { $batas = 35;}
		elseif($y >= 36 && $y <= 70 ) { $batas = 70;}
		else { $batas = 100;}
/*
		foreach($po['data'] as $k => $r):
			$ba['data'][$k]['name']			= 'white';
			$ba['data'][$k]['color']		= 'transparent';
			$ba['data'][$k]['y']		 	= ($batas-$r['y']);
		endforeach;
*/
		for($k=0;$k<6;$k++)
		{
			$selisih = ($po['data'][$k]['y']) ? $po['data'][$k]['y']:0;
			$ba['data'][$k]['name']			= $color[$k]['f_color_name'];
			$ba['data'][$k]['color']		= 'transparent';
			$ba['data'][$k]['y']		 	= ($batas-$selisih);			
		}
		
		$rslt = array();
		//array_push($rslt,$ba);
		array_push($rslt,$li);
		array_push($rslt,$po);

		//foreach($rslt as $k => $r):
			//$source[] = array(
				//'name' => $r['name'],
				//'data' => array($r['data'][0],$r['data'][1],$r['data'][2],$r['data'][3],$r['data'][4],$r['data'][5])
			//);
		//endforeach;

		//// return array
		//return $source;
		return array('kategori'=>$nameColor,'series'=>$rslt,'total' => $ttl);
	}
}

if( ! function_exists('resultValueJump'))
{
	function resultValueJump($val,$status = 1)
	{
		/*
		 * status = 1 , maka perhitungan bobot
		 * status = 2 , maka perhitungan vote
		*/
		if($status == 1)
		{
			$sort = array_sort($val,'value_bobot', SORT_DESC);
		}
		else
		{
			$sort = array_sort($val,'value_count', SORT_DESC);
		}
		// mengambil 10 value prioritas terbanyak
		$output = array_slice($sort, 0, 100);
		return $output;
	}
}

if( ! function_exists('resultValueJumpMerge'))
{
	function resultValueJumpMerge($val_cca,$val_dca,$status = 1)
	{
		// pembacaan values di dca
		$_values_jump=array();
		if($status == 1)
		{
			foreach( $val_dca as $d ):
				foreach ( $val_cca as $c ):
					// membentuk array lompatan_nilai
					if($c['value_id']==$d['value_id'] and $c['value_bobot'] < $d['value_bobot'])
					{
						$_values_jump[] = array(
							'value_id' => $d['value_id'],
							'value_name' => $d['value_name'],
							'value_count_cc' => $c['value_bobot'],
							'value_count_dc' => $d['value_bobot'],
							'value_jump'	=> intval($d['value_bobot']-$c['value_bobot'])
						);
					}
				endforeach;
			endforeach;
		}
		else
		{
			foreach( $val_dca as $d ):
				foreach ( $val_cca as $c ):
					// membentuk array lompatan_nilai
					if($c['value_id']==$d['value_id'] and $c['value_count'] < $d['value_count'])
					{
						$bobot_cc= round($c['value_bobot']/$c['value_count'],1);
						$bobot_dc= round($d['value_bobot']/$d['value_count'],1);
						$_values_jump[] = array(
							'value_id' => $c['value_id'],
							'value_name' => $c['value_name'],
							'value_count_cc' => $c['value_count'],
							'value_bobot_cc' => $bobot_cc,
							'value_count_dc' => $d['value_count'],
							'value_bobot_dc' => $bobot_dc,
							'value_jump'	=> intval($d['value_count']-$c['value_count']),
							'value_jump_bobot'	=> $bobot_dc-$bobot_cc
						);
						
					}
				endforeach;
			endforeach;			
		}

		// Sortir dari yang terbanyak
		foreach ($_values_jump as $key => $row):
			$jump[$key]  = $row['value_jump'];
		endforeach;
		
		array_multisort($jump, SORT_DESC, $_values_jump);
		
		$_values_jump = array_sort($_values_jump,'value_jump',SORT_DESC);
		// mengambil 10 value terbanyak
		$output_jump = array_slice($_values_jump, 0, 10);
		return 	$output_jump;
	}
}

if( ! function_exists('button_espoused'))
{
	function button_espoused($id, $value)
	{
		if( $value == 'yes')
		{
			$btn = '<a href="'.site_url('ochi/md_eva/fnUnsetEva/'.$id).'" class="btn btn-sm btn-warning"><i class="fa fa-minus-square"></i> Unset</a>';
		}
		else
		{
			$btn = '<a href="'.site_url('ochi/md_eva/fnSetEva/'.$id).'" class="btn btn-sm btn-primary"><i class="fa fa-check-square"></i> Set</a>';
		}
		
		return $btn;
	}
}

if (!function_exists('array_column')) {
    /**
	 * This file is part of the array_column library
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 *
	 * @copyright Copyright (c) Ben Ramsey (http://benramsey.com)
	 * @license http://opensource.org/licenses/MIT MIT
	 * 
     * Returns the values from a single column of the input array, identified by
     * the $columnKey.
     *
     * Optionally, you may provide an $indexKey to index the values in the returned
     * array by the values from the $indexKey column in the input array.
     *
     * @param array $input A multi-dimensional array (record set) from which to pull
     *                     a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the
     *                         integer key of the column you wish to retrieve, or it
     *                         may be the string key name for an associative array.
     * @param mixed $indexKey (Optional.) The column to use as the index/keys for
     *                        the returned array. This value may be the integer key
     *                        of the column, or it may be the string key name.
     * @return array
     */
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();
        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }
        if (!is_array($params[0])) {
            trigger_error(
                'array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given',
                E_USER_WARNING
            );
            return null;
        }
        if (!is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        if (isset($params[2])
            && !is_int($params[2])
            && !is_float($params[2])
            && !is_string($params[2])
            && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;
        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }
        $resultArray = array();
        foreach ($paramsInput as $row) {
            $key = $value = null;
            $keySet = $valueSet = false;
            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }
            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }
            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }
        }
        return $resultArray;
    }
}

if( ! function_exists('data_list'))
{
	function data_list($table, $id, $list,$wh = array())
	{
		$ci =& get_instance();
		$ci->load->database();
//		$ci->db->select("$id,$list",false);
		if(!is_array($wh)) $ci->db->where($wh); 
		$sql = $ci->db->get($table)->result();
		foreach($sql as $row):
			$list[$row->$id] = $row->$list;
		endforeach;
		return $list;
	}
}

function getColor($num) {
        $hash = md5('color' . $num);
        return array(hexdec(substr($hash, 0, 2)), hexdec(substr($hash, 2, 2)), hexdec(substr($hash, 4, 2)));
}

function angkasa($x) {
$soal1 = array(
	0 => array(
		"no" => 1,
		"nama" => "Berikut ini yang menjadi perilaku utama dari <i>Pride of Indonesia</i> adalah",
		"jawab" => array(
			"a" => "Nasionalisme, menghormati, kehormatan.",
			"b" => "Nasionalisme, kehormatan, integritas.",
			"c" => "Nasionalisme, komitmen, proaktif.",
			"d" => "Nasionalisme, pelayanan prima, proaktif.",
		)
	),
	1 => array(
		"no" => 2,
		"nama" => "Berikut yang menjadi perilaku yang dilarang dari nilai <i>Pride of Indonesia</i> adalah",
		"jawab" => array(
			"a" => "Memberikan pelayanan yang buruk kepada pengguna jasa bandara.",
			"b" => "Membiarkan masalah yang sama terjadi berulang-ulang.",
			"c" => "Bekerja hanya mementingkan target jangka pendek tanpa memperhatikan target jangka panjang.",
			"d" => "Tidak memperdulikan kontribusi dari mitra kerja dan usaha.",
		)
	),
	2 => array(
		"no" => 3,
		"nama" => "Berikut ini yang merupakan definisi dari nilai <i>Entrepreneurial</i> adalah",
		"jawab" => array(
			"a" => "Mendukung pembangunan negara dan menawarkan pengalaman terbaik Indonesia kepada dunia.",
			"b" => "Selalu melihat dari sudut pandang konsumen dalam segala tindakan.",
			"c" => "Mengakui dan menghargai prestasi melalui penerapan apresiasi.",
			"d" => "Sedikit bicara dan banyak bekerja, mampu mengimplementasikan gagasan baru secara cepat.",
		)
	),
	3 => array(
		"no" => 4,
		"nama" => "Berikut ini merupakan perilaku utama dari <i>Entrepreneurial</i>, kecuali",
		"jawab" => array(
			"a" => "Proaktif.",
			"b" => "Inovatif.",
			"c" => "Daya juang tinggi.",
			"d" => "Berani mengambil risiko.",
		)
	),
	4 => array(
		"no" => 5,
		"nama" => "Berikut ini yang merupakan perilaku dari nilai <i>Entrepreneurial</i> adalah",
		"jawab" => array(
			"a" => "Membawa muatan budaya lokal ke dalam desain / arsitektur / dekorasi pada layanan ataupun produk perusahaan.",
			"b" => "Mencari penyelesaian masalah dengan cara-cara yang lebih efektif dan efisien serta menjadikan hambatan sebagai tantangan yang harus dihadapi dengan gigih.",
			"c" => "Melakukan tindakan preventif terkait keamanan dan keselamatan penerbangan.",
			"d" => "Menetapkan target jangka pendek (<i>quick win</i>) dan jangka panjang serta prioritas dari masing-masing target tersebut.",
		)
	),
	5 => array(
		"no" => 6,
		"nama" => "Berikut ini yang merupakan definisi dari nilai <i>Responsible</i> adalah",
		"jawab" => array(
			"a" => "Berkomitmen penuh untuk mencapai hasil yang terbaik.",
			"b" => "Mengidentifikasi masalah, hambatan atau peluang dan mengambil tindakan terbaik untuk kepentingan saat ini dan di masa yang akan datang.",
			"c" => "Sedikit bicara dan banyak bekerja, mampu mengimplementasikan gagasan baru secara cepat.",
			"d" => "Mencurahkan sumber daya dan perhatian yang lebih kepada tujuan tertentu.",
		)
	),
	6 => array(
		"no" => 7,
		"nama" => "Berikut ini yang menjadi perilaku utama dari <i>Responsible</i> adalah",
		"jawab" => array(
			"a" => "Komitmen, integritas, daya juang tinggi.",
			"b" => "Disiplin, komitmen, peduli.",
			"c" => "Berani mengambil risiko, konsisten, daya juang tinggi.",
			"d" => "Disiplin, peduli, konsisten.",
		)
	),
	7 => array(
		"no" => 8,
		"nama" => "Berikut yang menjadi perilaku yang dilarang dari nilai <i>Responsible</i> adalah",
		"jawab" => array(
			"a" => "Tidak adanya apresiasi maupun penghargaan atas kontribusi yang lebih dari karyawan.",
			"b" => "Memberikan pelayanan hanya pada saat pengguna jasa bandara membutuhkan.",
			"c" => "Menyelesaikan pekerjaan tidak sesuai dengan apa yang telah disepakati.",
			"d" => "Mudah menyerah dalam menghadapi permasalahan.",
		)
	),
	8 => array(
		"no" => 9,
		"nama" => "Berikut ini yang merupakan definisi dari nilai <i>Focused</i> adalah",
		"jawab" => array(
			"a" => "Berkomitmen penuh untuk mencapai hasil yang terbaik.",
			"b" => "Sedikit bicara dan banyak bekerja, mampu mengimplementasikan gagasan baru secara cepat.",
			"c" => "Menyelesaikan pekerjaan dengan tepat waktu dan mempertanggungjawabkan hasil kerja.",
			"d" => "Mencurahkan sumber daya dan perhatian yang lebih kepada tujuan tertentu.",
		)
	),
	9 => array(
		"no" => 10,
		"nama" => "Berikut ini yang menjadi perilaku utama dari <i>Focused</i> adalah",
		"jawab" => array(
			"a" => "Disiplin.",
			"b" => "Daya juang tinggi.",
			"c" => "Teliti.",
			"d" => "Komitmen.",
		)
	),
	10 => array(
		"no" => 11,
		"nama" => "Berikut ini yang menjadi perilaku yang dilarang dari nilai <i>Focused</i> adalah",
		"jawab" => array(
			"a" => "Mudah menyerah dalam menghadapi permasalahan.",
			"b" => "Lambat untuk menangkap peluang bisnis yang ada di lingkungan bandara.",
			"c" => "Menyelesaikan pekerjaan tidak sesuai dengan apa yang telah disepakati.",
			"d" => "Bekerja tanpa memperhatikan target perusahaan.",
		)
	),
	11 => array(
		"no" => 12,
		"nama" => "Berikut ini yang menjadi perilaku utama dari <i>Outstanding Service</i> adalah",
		"jawab" => array(
			"a" => "Pelayanan prima, peduli, kepuasan pelanggan.",
			"b" => "Pelayanan prima, komitmen, peduli.",
			"c" => "Pelayanan prima, proaktif, kepuasan pelanggan.",
			"d" => "Pelayanan prima, proaktif, berorientasi kepada tujuan.",
		)
	),
	12 => array(
		"no" => 13,
		"nama" => "Berikut ini yang bukan menjadi perilaku dari nilai <i>Outstanding Service</i> adalah",
		"jawab" => array(
			"a" => "Memberikan kemudahan dalam mengakses informasi.",
			"b" => "Lebih responsive terhadap kebutuhan dari unit lain dan menawarkan bantuan serta dukungan apabila dibutuhkan.",
			"c" => "Proaktif dalam memberikan pelayanan prima kepada pengguna jasa bandara.",
			"d" => "Memberikan penghargaan atas kontribusi mitra kerja dan usaha.",
		)
	),
	13 => array(
		"no" => 14,
		"nama" => "Berikut ini yang merupakan definisi dari nilai <i>Respectful</i> adalah",
		"jawab" => array(
			"a" => "Mengakui dan menghargai prestasi melalui penerapan apresiasi.",
			"b" => "Selalu peduli dalam memberikan pelayanan terbaik kepada pelanggan.",
			"c" => "Mengakui dan menghargai pekerjaan yang telah dilakukan karyawan perusahaan.",
			"d" => "Memperlakukan setiap individu dengan hormat.",
		)
	),
	14 => array(
		"no" => 15,
		"nama" => "Berikut ini yang bukan menjadi perilaku utama dari <i>Respectful</i> adalah",
		"jawab" => array(
			"a" => "Menghormati.",
			"b" => "Peduli.",
			"c" => "Menghargai.",
			"d" => "Empati.",
		)
	),
	15 => array(
		"no" => 16,
		"nama" => "Berikut ini yang menjadi perilaku dari nilai <i>Respectful</i> adalah",
		"jawab" => array(
			"a" => "Memberikan penghargaan atas kontribusi mitra kerja dan usaha.",
			"b" => "Tidak membeda-bedakan pelanggan dalam memberikan pelayanan.",
			"c" => "Memberikan imbalan dan / atau apresiasi sesuai dengan kontribusi dan pencapaian masing-masing karyawan.",
			"d" => "Lebih responsive terhadap kebutuhan dari unit lain dan menawarkan bantuan serta dukungan apabila dibutuhkan.",
		)
	),
	16 => array(
		"no" => 17,
		"nama" => "Berikut ini yang menjadi perilaku utama dari <i>Meritocratic</i> adalah",
		"jawab" => array(
			"a" => "Apresiasi, peduli, berorientasi kepada tujuan.",
			"b" => "Apresiasi, pengakuan, keadilan.",
			"c" => "Apresiasi, menghargai, peduli.",
			"d" => "Apresiasi, keadilan, kehormatan.",
		)
	),
	17 => array(
		"no" => 18,
		"nama" => "Berikut ini yang menjadi perilaku yang dilarang dari nilai <i>Meritocratic</i> adalah",
		"jawab" => array(
			"a" => "Memberikan kesempatan karir yang tinggi kepada karyawan terdekat.",
			"b" => "Menyelesaikan pekerjaan tidak sesuai dengan apa yang telah disepakati.",
			"c" => "Menghindari masalah yang terjadi di bandara akibat pihak-pihak lain.",
			"d" => "Memberikan pelayanan kepada pengguna jasa bandara dipengaruhi oleh kondisi emosional.",
		)
	)
);

$soal2 = array(
	0 => array(
		"no" => 1,
		"nama" => "Berikut ini yang termasuk contoh dalam penerapan nilai <i>Pride of Indonesia</i>",
		"jawab" => array(
			"a" => "Karyawan menjaga kualitas pelayanan sesuai dengan <i>service level guarantee.</i>",
			"b" => "Bersedia menerima kritik pelanggan untuk perbaikan.",
			"c" => "Bekerjasama dengan seniman dalam rangka mempromosikan nilai-nilai kebangsaan melalui karya seni budaya, pariwisata, dan keunggulan Indonesia lainnya.",
			"d" => "Berkonsentrasi pada pencapaian target perusahaan.",
		)
	),
	1 => array(
		"no" => 2,
		"nama" => "Berikut ini yang bukan termasuk dalam penerapan dari nilai-nilai inti <i>Pride of Indonesia</i> adalah",
		"jawab" => array(
			"a" => "Merasa bangga menjadi bangsa dan bagian dari masyarakat Indonesia.",
			"b" => "Karyawan menilai dirinya sebagai orang yang memiliki kemampuan, keberartian, berharga, dan kompeten.",
			"c" => "Berkomitmen untuk mengusahakan tercapainya kepentingan perusahaan.",
			"d" => "Mempromosikan kesenian dan budaya Indonesia secara periodik pada layanan ataupun produk perusahaan.",
		)
	),
	2 => array(
		"no" => 3,
		"nama" => "Karyawan yang berusaha mencari penyelesaian masalah dengan cara-cara yang lebih efektif dan efisien serta menjadikan hambatan sebagai tantangan yang harus dihadapi dengan gigih termasuk dalam penerapan nilai",
		"jawab" => array(
			"a" => "<i>Responsible</i>",
			"b" => "<i>Entrepreneurial</i>",
			"c" => "<i>Focused</i>",
			"d" => "<i>Outstanding Service</i>",
		)
	),
	3 => array(
		"no" => 4,
		"nama" => "Berikut ini yang bukan termasuk dalam penerapan dari nilai-nilai inti <i>Entrepreneurial</i> adalah",
		"jawab" => array(
			"a" => "Memenuhi kebutuhan pelanggan dengan layanan yang terbaik.",
			"b" => "Menghasilkan solusi-solusi yang inovatif dalam bekerja dengan berpikir di luar kebiasaan.",
			"c" => "Bekerja secara lincah serta fleksibel terhadap situasi yang tidak pasti.",
			"d" => "Mampu mengarahkan dirinya untuk menghadapi rintangan dalam situasi yang sulit dengan berfokus pada sesuatu yang ingin dicapai.",
		)
	),
	4 => array(
		"no" => 5,
		"nama" => "Berikut ini yang merupakan contoh penerapan nilai <i>Responsible</i> yaitu",
		"jawab" => array(
			"a" => "Karyawan yang menyelesaikan tugasnya tepat waktu sesuai dengan target yang telah ditetapkan.",
			"b" => "Karyawan yang berperilaku konsisten sehingga target yang ditetapkan perusahaan dapat tercapai.",
			"c" => "Karyawan yang selalu memenuhi kebutuhan pelanggan dengan layanan yang terbaik.",
			"d" => "Karyawan yang menjadikan hambatan sebagai tantangan yang harus dihadapi.",
		)
	),
	5 => array(
		"no" => 6,
		"nama" => "Berikut ini termasuk dalam penerapan dari nilai Responsible kecuali",
		"jawab" => array(
			"a" => "Berkomitmen penuh untuk mencapai hasil yang terbaik.",
			"b" => "Mengambil tindakan terbaik untuk kepentingan saat ini dan di masa yang akan datang.",
			"c" => "Disiplin dalam menyelesaikan pekerjaan.",
			"d" => "Bersikap peduli dalam rangka memberikan pelayanan terbaik pada pelanggan.",
		)
	),
	6 => array(
		"no" => 7,
		"nama" => "Karyawan yang menetapkan target jangka pendek dan jangka panjang serta prioritas dari masing-masing target tersebut termasuk dalam penerapan nilai",
		"jawab" => array(
			"a" => "<i>Responsible</i>",
			"b" => "<i>Focused</i>",
			"c" => "<i>Entrepreneurial</i>",
			"d" => "<i>Meritocratic</i>",
		)
	),
	7 => array(
		"no" => 8,
		"nama" => "Berikut ini yang bukan termasuk dalam penerapan dari nilai <i>Focused</i> adalah",
		"jawab" => array(
			"a" => "Berorientasi kepada tujuan sehingga dapat mencapai hasil yang maksimal.",
			"b" => "Menjaga kualitas pelayanan sesuai dengan <i>service level guarantee</i>.",
			"c" => "Memiliki integritas yang tinggi.",
			"d" => "Karyawan yang berperilaku konsisten dan teliti",
		)
	),
	8 => array(
		"no" => 9,
		"nama" => "Seorang karyawan yang lebih <i>responsive</i> terhadap kebutuhan dari unit lain dan menawarkan bantuan serta dukungan apabila dibutuhkan merupakan penerapan dari nilai",
		"jawab" => array(
			"a" => "<i>Meritocratic</i>",
			"b" => "<i>Focused</i>",
			"c" => "<i>Responsible</i>",
			"d" => "<i>Outstanding Service</i>",
		)
	),
	9 => array(
		"no" => 10,
		"nama" => "Berikut ini yang merupakan contoh penerapan nilai <i>Outstanding Service</i> yaitu",
		"jawab" => array(
			"a" => "Karyawan yang memberikan kemudahan dalam mengakses informasi.",
			"b" => "Karyawan yang mengutamakan kepentingan bersama.",
			"c" => "Karyawan yang melakukan business development.",
			"d" => "Karyawan yang mampu mengimplementasikan gagasan baru secara cepat.",
		)
	),
	10 => array(
		"no" => 11,
		"nama" => "Seorang karyawan yang hanya menerima pendapat yang diberikan oleh seseorang yang kedudukannya lebih tinggi maka karyawan tersebut tidak menerapkan nilai",
		"jawab" => array(
			"a" => "<i>Outstanding Service</i>",
			"b" => "<i>Respectful</i>",
			"c" => "<i>Responsible</i>",
			"d" => "<i>Focused</i>",
		)
	),
	11 => array(
		"no" => 12,
		"nama" => "Berikut ini yang bukan termasuk dalam penerapan dari nilai <i>Respectful</i> adalah",
		"jawab" => array(
			"a" => "Karyawan saling menghargai yang diwarnai oleh komunikasi yang tulus.",
			"b" => "Karyawan mampu berempati dan melihat dari sudut pandang orang lain.",
			"c" => "Karyawan melakukan tindakan preventif terkait keamanan dan keselamatan penerbangan.",
			"d" => "Karyawan menghargai perbedaan pendapat, peran, dan kontribusi dengan mengutamakan kepentingan bersama.",
		)
	),
	12 => array(
		"no" => 13,
		"nama" => "Pimpinan memberikan apresiasi sesuai dengan kontribusi dan pencapaian karyawan secara adil, hal ini termasuk dalam penerapan nilai",
		"jawab" => array(
			"a" => "<i>Respectful</i>",
			"b" => "<i>Responsible</i>",
			"c" => "<i>Outstanding service</i>",
			"d" => "<i>Meritocratic</i>",
		)
	),
	13 => array(
		"no" => 14,
		"nama" => "Berikut ini yang bukan termasuk dalam contoh perilaku nilai <i>Meritocratic</i> adalah",
		"jawab" => array(
			"a" => "Seseorang mendapatkan apresiasi atas pencapaian kinerjanya yang baik di perusahaan.",
			"b" => "Perusahaan memberikan penghargaan atas kontribusi mitra kerja dan usaha.",
			"c" => "Pimpinan memberikan kesempatan karir yang tinggi untuk seluruh karyawan.",
			"d" => "Pimpinan yang menghargai perbedaan pendapat, peran dan kontribusi karyawannya untuk kepentingan bersama.",
		)
	),
);

$soal3 = array(
	0 => array(
		"no" => 1,
		"nama" => "Pimpinan saya mampu mengarahkan bawahannya untuk memberikan kemampuan terbaik dalam menyelesaikan pekerjaan",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	1 => array(
		"no" => 2,
		"nama" => "Pimpinan saya melakukan coaching dan mentoring untuk meningkatkan kompetensi karyawan dalam menyelesaikan pekerjaan.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	2 => array(
		"no" => 3,
		"nama" => "Coaching dan mentoring dari pimpinan belum berjalan maksimal untuk pengembangan karyawan.",
		"status" => "min",
		"jawab" => array(
			6 => "Sangat Tidak Setuju",
			5 => "Tidak Setuju",
			4 => "Cenderung Tidak Setuju",
			3 => "Cenderung Setuju",
			2 => "Setuju",
			1 => "Sangat Setuju"
		)
	),
	3 => array(
		"no" => 4,
		"nama" => "Pimpinan saya memberikan apresiasi kepada bawahannya yang berprestasi secara adil dan terbuka.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	4 => array(
		"no" => 5,
		"nama" => "Pimpinan saya bersifat pasif dan cenderung hanya menyelesaikan pekerjaan rutinitas sehari - hari.",
		"status" => "min",
		"jawab" => array(
			6 => "Sangat Tidak Setuju",
			5 => "Tidak Setuju",
			4 => "Cenderung Tidak Setuju",
			3 => "Cenderung Setuju",
			2 => "Setuju",
			1 => "Sangat Setuju"
		)
	),
	5 => array(
		"no" => 6,
		"nama" => "Dalam keseharian pimpinan menunjukkan semangat kerja yang tinggi untuk pencapaian prestasi yang dapat ditiru oleh bawahannya.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	6 => array(
		"no" => 7,
		"nama" => "Pimpinan saya mendorong dan memotivasi karyawannya untuk terus belajar dan berkembang.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	7 => array(
		"no" => 8,
		"nama" => "Ide dan masukan dari pimpinan dapat menginspirasi karyawan untuk melakukan pekerjaan dengan sebaik-baiknya.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	8 => array(
		"no" => 9,
		"nama" => "Pimpinan saya tidak terlalu memikirkan tentang pengembangan kompetensi karyawan.",
		"status" => "min",
		"jawab" => array(
			6 => "Sangat Tidak Setuju",
			5 => "Tidak Setuju",
			4 => "Cenderung Tidak Setuju",
			3 => "Cenderung Setuju",
			2 => "Setuju",
			1 => "Sangat Setuju"
		)
	),
	9 => array(
		"no" => 10,
		"nama" => "Pimpinan saya memiliki keinginan untuk terus belajar dan siap menghadapi berbagai perubahan di dunia bisnis.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	10 => array(
		"no" => 11,
		"nama" => "Pimpinan saya memiliki pola pikir yang melihat kepada standar perusahaan kelas dunia sebagai dasar untuk mencapai kualitas kerja terbaik.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	11 => array(
		"no" => 12,
		"nama" => "Pimpinan saya belum siap untuk menghadapi berbagai perubahan yang ada di dunia bisnis.",
		"status" => "min",
		"jawab" => array(
			6 => "Sangat Tidak Setuju",
			5 => "Tidak Setuju",
			4 => "Cenderung Tidak Setuju",
			3 => "Cenderung Setuju",
			2 => "Setuju",
			1 => "Sangat Setuju"
		)
	),
	12 => array(
		"no" => 13,
		"nama" => "Pimpinan saya memiliki orientasi untuk melakukan inovasi untuk perbaikan perusahaan ke depan.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	13 => array(
		"no" => 14,
		"nama" => "Pimpinan saya mempunyai ide untuk penyelesaian tugas agar lebih efektif dan efesien dari yang sudah ada sebelumnya.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	14 => array(
		"no" => 15,
		"nama" => "Pimpinan saya cenderung melaksanakan pekerjaan sesuai dengan prosedur yang sudah ada tanpa memikirkan inovasi untuk perbaikan perusahaan.",
		"status" => "min",
		"jawab" => array(
			6 => "Sangat Tidak Setuju",
			5 => "Tidak Setuju",
			4 => "Cenderung Tidak Setuju",
			3 => "Cenderung Setuju",
			2 => "Setuju",
			1 => "Sangat Setuju"
		)
	),
	15 => array(
		"no" => 16,
		"nama" => "Pimpinan saya memiliki pemahaman teknis yang baik, sehingga dapat mengambil keputusan dengan tepat.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	16 => array(
		"no" => 17,
		"nama" => "Pimpinan saya tidak terlalu menguasai kondisi teknis pekerjaan di lapangan, sehingga belum dapat memberikan solusi yang tepat jika terjadi masalah.",
		"status" => "min",
		"jawab" => array(
			6 => "Sangat Tidak Setuju",
			5 => "Tidak Setuju",
			4 => "Cenderung Tidak Setuju",
			3 => "Cenderung Setuju",
			2 => "Setuju",
			1 => "Sangat Setuju"
		)
	),
	17 => array(
		"no" => 18,
		"nama" => "Dengan kemampuan teknis yang baik, pimpinan saya dapat berkontribusi secara aktif pada tugas dan tanggung jawabnya.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
);

$result = array(1 => $soal1,2 => $soal2,3 => $soal3);	
return $result[$x];
}

function kpp($x) {
$soal1 = array(
	0 => array(
		"no" => 1,
		"nama" => "Berikut ini yang merupakan definisi dari nilai Competence adalah",
		"jawab" => array(
			"a" => "Mengutamakan keselamatan dan kesehatan kerja, peduli lingkungan hidup dan pemberdayaan masyarakat sekitar.",
			"b" => "Dapat dipercaya dengan prinsip memegang teguh kejujuran, tanggung jawab, keterbukaan dan kedisiplinan.",
			"c" => "Dapat diandalkan dengan semangat menjadi yang terbaik untuk memberikan nilai tambah terhadap semua pihak.",
			"d" => "Dapat bekerjasama, menghargai perbedaan dengan menyatukan keunggulan masing-masing sebagai sebuah kekuatan yang mengutamakan kebersamaan serta kegembiraan untuk mencapai hasil yang berlipat ganda.",
		),
		"benar"=> "c",
		"kategori"=> "competence",
	),
	1 => array(
		"no" => 2,
		"nama" => "Berikut ini yang merupakan perilaku dilarang dari nilai Competence adalah",
		"jawab" => array(
			"a" => "Merasa diri paling hebat / penting.",
			"b" => "Menghindar dari tantangan.",
			"c" => "Selalu mengeluh dan merasa kurang.",
			"d" => "Sulit bekerjasama.",
		),
		"benar"=> "b",
		"kategori"=> "competence",
	),
	2 => array(
		"no" => 3,
		"nama" => "Berikut ini yang merupakan definisi dari nilai Integrity adalah",
		"jawab" => array(
			"a" => "Dapat bekerjasama, menghargai perbedaan dengan menyatukan keunggulan masing-masing sebagai sebuah kekuatan yang mengutamakan kebersamaan serta kegembiraan untuk mencapai hasil yang berlipat ganda.",
			"b" => "Dapat diandalkan dengan semangat menjadi yang terbaik untuk memberikan nilai tambah terhadap semua pihak.",
			"c" => "Mengutamakan keselamatan dan kesehatan kerja, peduli lingkungan hidup dan pemberdayaan masyarakat sekitar.",
			"d" => "Dapat dipercaya dengan prinsip memegang teguh kejujuran, tanggung jawab, keterbukaan dan kedisiplinan.",
		),
		"benar"=> "d",
		"kategori"=> "integrity",
	),
	3 => array(
		"no" => 4,
		"nama" => "Berikut ini merupakan perilaku dari nilai Integrity, kecuali",
		"jawab" => array(
			"a" => "Saling percaya satu sama lain.",
			"b" => "Disiplin dan memegang teguh komitmen.",
			"c" => "Sopan santun.",
			"d" => "Memberi keteladanan.",
		),
		"benar"=> "a",
		"kategori"=> "integrity",
	),
	4 => array(
		"no" => 5,
		"nama" => "Berikut ini yang merupakan definisi dari nilai Synergy adalah",
		"jawab" => array(
			"a" => "Mengutamakan keselamatan dan kesehatan kerja, peduli lingkungan hidup dan pemberdayaan masyarakat sekitar.",
			"b" => "Dapat diandalkan dengan semangat menjadi yang terbaik untuk memberikan nilai tambah terhadap semua pihak.",
			"c" => "Dapat dipercaya dengan prinsip memegang teguh kejujuran, tanggung jawab, keterbukaan dan kedisiplinan.",
			"d" => "Dapat bekerjasama, menghargai perbedaan dengan menyatukan keunggulan masing-masing sebagai sebuah kekuatan yang mengutamakan kebersamaan serta kegembiraan untuk mencapai hasil yang berlipat ganda.",
		),
		"benar"=> "d",
		"kategori"=> "synergy",
	),
	5 => array(
		"no" => 6,
		"nama" => "Berikut ini yang merupakan perilaku dari nilai Synergy adalah",
		"jawab" => array(
			"a" => "Bersedia menerima dan menanggapi masukan dari pihak terkait.",
			"b" => "Saling terbuka dalam penyelesaian masalah.",
			"c" => "Saling percaya satu sama lain.",
			"d" => "Peduli terhadap keselamatan, kesehatan diri & orang lain.",
		),
		"benar"=> "c",
		"kategori"=> "synergy",
	),
	6 => array(
		"no" => 7,
		"nama" => "Berikut ini yang merupakan perilaku dilarang dari nilai Synergy adalah",
		"jawab" => array(
			"a" => "Melanggar aturan dan mengabaikan keselamatan diri dan orang lain.",
			"b" => "Berpartisipasi kalau ada untungnya saja bagi dirinya.",
			"c" => "Bertindak yang menjadi contoh buruk bagi lingkungan kerjanya.",
			"d" => "Cepat puas dengan hasil kerja yang ada.",
		),
		"benar"=> "b",
		"kategori"=> "synergy",
	),
	7 => array(
		"no" => 8,
		"nama" => "Berikut ini yang merupakan definisi dari nilai Safety adalah",
		"jawab" => array(
			"a" => "Dapat diandalkan dengan semangat menjadi yang terbaik untuk memberikan nilai tambah terhadap semua pihak.",
			"b" => "Mengutamakan keselamatan dan kesehatan kerja, peduli lingkungan hidup dan pemberdayaan masyarakat sekitar.",
			"c" => "Dapat dipercaya dengan prinsip memegang teguh kejujuran, tanggung jawab, keterbukaan dan kedisiplinan.",
			"d" => "Dapat bekerjasama, menghargai perbedaan dengan menyatukan keunggulan masing-masing sebagai sebuah kekuatan yang mengutamakan kebersamaan serta kegembiraan untuk mencapai hasil yang berlipat ganda.",
		),
		"benar"=> "b",
		"kategori"=> "safety",
	),
	8 => array(
		"no" => 9,
		"nama" => "Berikut ini merupakan perilaku dari nilai Safety, kecuali",
		"jawab" => array(
			"a" => "Menyukai persaingan sehat.",
			"b" => "Merawat dan menjaga aset perusahaan.",
			"c" => "Menegur yang melanggar aturan / ketentuan.",
			"d" => "Peduli dan memberdayakan masyarakat sekitar.",
		),
		"benar"=> "a",
		"kategori"=> "safety",
	),
	9 => array(
		"no" => 10,
		"nama" => "Berikut ini yang merupakan perilaku dilarang dari nilai Safety adalah",
		"jawab" => array(
			"a" => "Mangkir / tidur di saat jam kerja.",
			"b" => "Membeberkan rahasia perusahaan.",
			"c" => "Membuang sampah sembarangan.",
			"d" => "Bekerja asal-asalan, sembarangan.",
		),
		"benar"=> "c",
		"kategori"=> "safety",
	)
);

$soal2 = array(
	//0 => array(
		//"no" => 1,
		//"nama" => "Karyawan yang bersedia menerima dan menanggapi masukan dari orang lain yang masih terkait dengan persoalan yang dihadapi termasuk dalam penerapan nilai",
		//"jawab" => array(
			//"a" => "Safety",
			//"b" => "Competence.",
			//"c" => "Synergy.",
			//"d" => "Integrity.",
		//)
	//),
	0 => array(
		"no" => 1,
		"nama" => "Karyawan yang selalu mencari ide-ide kreatif yang dapat meningkatkan produktivitas kerja merupakan contoh perilaku yang mencerminkan nilai",
		"jawab" => array(
			"a" => "Safety",
			"b" => "Competence.",
			"c" => "Synergy.",
			"d" => "Integrity.",
		),
		"benar"=> "b",
		"kategori"=> "competence",
	),
	1 => array(
		"no" => 2,
		"nama" => "Berikut ini yang termasuk contoh dalam penerapan nilai Competence",
		"jawab" => array(
			"a" => "Ketika berjumpa dengan orang lain senantiasa ramah dan murah senyum.",
			"b" => "Karyawan dapat memberikan solusi terhadap permasalahan yang terjadi di KPP.",
			"c" => "Karyawan menegur seseorang yang melanggar aturan.",
			"d" => "Karyawan secara konsisten menyelesaikan tugasnya sampai tuntas.",
		),
		"benar"=> "b",
		"kategori"=> "competence",
	),
	2 => array(
		"no" => 3,
		"nama" => "Berikut ini merupakan contoh dari penerapan nilai Competence, kecuali",
		"jawab" => array(
			"a" => "Karyawan yang berorientasi pada kemenangan bersama",
			"b" => "Karyawan yang berani menerima target kerja yang lebih tinggi",
			"c" => "Karyawan yang bersaing secara sehat",
			"d" => "Karyawan yang tidak cepat merasa puas",
		),
		"benar"=> "a",
		"kategori"=> "competence",
	),
	//3 => array(
		//"no" => 4,
		//"nama" => "Pak Wildan adalah salah seorang karyawan KPP yang selalu besikap sopan, baik terhadap atasan maupun bawahannya. Pak Wildan juga selalu memberikan keteladanan bagi karyawan lain. Sikap yang ditunjukkan oleh Pak Wildan ini merupakan contoh penerapan dari nilai",
		//"jawab" => array(
			//"a" => "Synergy.",
			//"b" => "Competence.",
			//"c" => "Safety.",
			//"d" => "Integrity.",
		//)
	//),
	//4 => array(
		//"no" => 5,
		//"nama" => "Bu Sarah adalah salah seorang karyawan KPP yang sering tidur di saat jam kerja. Bu Sarah juga selalu mengeluh saat banyak deadline. Sikap Bu Sarah tersebut tidak mencerminkan nilai",
		//"jawab" => array(
			//"a" => "Integrity.",
			//"b" => "Safety.",
			//"c" => "Competence.",
			//"d" => "Synergy.",
		//)
	//),
	3 => array(
		"no" => 4,
		"nama" => "Karyawan yang selalu mengeluh dan merasa kurang merupakan contoh perilaku yang tidak mencerminkan nilai",
		"jawab" => array(
			"a" => "Synergy.",
			"b" => "Competence.",
			"c" => "Safety.",
			"d" => "Integrity.",
		),
		"benar"=> "d",
		"kategori"=> "integrity",
	),
	4 => array(
		"no" => 5,
		"nama" => "Karyawan yang bekerja setengah hati dan bersikap menyalahkan orang lain merupakan contoh perilaku yang tidak mencerminkan nilai",
		"jawab" => array(
			"a" => "Integrity.",
			"b" => "Safety.",
			"c" => "Competence.",
			"d" => "Synergy.",
		),
		"benar"=> "a",
		"kategori"=> "integrity",
	),
	5 => array(
		"no" => 6,
		"nama" => "Berikut ini yang bukan termasuk dalam penerapan dari nilai Integrity adalah",
		"jawab" => array(
			"a" => "Karyawan yang disiplin dan memegang teguh komitmen.",
			"b" => "Bekerja dengan penuh tanggung jawab, amanah dan sepenuh hati.",
			"c" => "Saling percaya antara atasan dan bawahan.",
			"d" => "Karyawan yang jujur dalam setiap ucapan dan perbuatan.",
		),
		"benar"=> "c",
		"kategori"=> "integrity",
	),
	6 => array(
		"no" => 7,
		"nama" => "Berikut ini yang merupakan contoh penerapan nilai Synergy yaitu",
		"jawab" => array(
			"a" => "Karyawan yang peduli terhadap keselamatan, kesehatan diri & orang lain",
			"b" => "Karyawan yang membangun suasana kebersamaan dan bersahabat",
			"c" => "Karyawan yang saling terbuka dalam penyelesaian masalah",
			"d" => "Karyawan yang peduli dan memberdayakan masyarakat sekitar",
		),
		"benar"=> "b",
		"kategori"=> "synergy",
	),
	7 => array(
		"no" => 8,
		"nama" => "Seorang karyawan yang merasa dirinya paling hebat / penting dan selalu berpikir negatif maka karyawan tersebut tidak menerapkan nilai dari",
		"jawab" => array(
			"a" => "Integrity.",
			"b" => "Synergy.",
			"c" => "Competence.",
			"d" => "Safety.",
		),
		"benar"=> "b",
		"kategori"=> "synergy",
	),
	8 => array(
		"no" => 9,
		"nama" => "Berikut ini termasuk dalam penerapan dari nilai Synergy, kecuali",
		"jawab" => array(
			"a" => "Karyawan yang pro akif dan inisiatif mengambil peran dalam tim.",
			"b" => "Karyawan yang saling berkontribusi satu sama lain.",
			"c" => "Karyawan yang mengutamakan kepentingan tim.",
			"d" => "Karyawan yang memberikan manfaat unik yang tidak dimiliki pesaing.",
		),
		"benar"=> "d",
		"kategori"=> "synergy",
	),
	//9 => array(
		//"no" => 10,
		//"nama" => "Pak Ivan merupakan karyawan KPP yang ketika melihat air keran menyala karena tidak tertutup rapat maka beliau dengan sigap menutupnya. Begitu pun ketika Pak Ivan melihat lampu yang masih menyala di siang hari maka beliau mematikannya untuk penghematan. Sikap yang ditunjukkan oleh Pak Ivan merupakan penerapan dari nilai",
		//"jawab" => array(
			//"a" => "Safety.",
			//"b" => "Synergy.",
			//"c" => "Integrity.",
			//"d" => "Competence.",
		//)
	//),
	9 => array(
		"no" => 10,
		"nama" => "Karyawan yang peduli dan memberdayakan masyarakat sekitar merupakan contoh perilaku mencerminkan nilai",
		"jawab" => array(
			"a" => "Safety.",
			"b" => "Synergy.",
			"c" => "Integrity.",
			"d" => "Competence.",
		),
		"benar"=> "a",
		"kategori"=> "safety",
	),
	10 => array(
		"no" => 11,
		"nama" => "Berikut ini yang termasuk contoh dalam penerapan nilai Safety adalah",
		"jawab" => array(
			"a" => "Karyawan yang selalu mencari ide-ide kreatif yang dapat meningkatkan produktivitas kerja.",
			"b" => "Karyawan yang dapat diandalkan dengan semangat menjadi yang terbaik.",
			"c" => "Karyawan yang melaporkan potensi bahaya dan insiden sekecil apapun.",
			"d" => "Karyawan yang menerima kekuatan dan kelemahan masing-masing menjadi kekuatan tim.",
		),
		"benar"=> "c",
		"kategori"=> "safety",
	),
	//11 => array(
		//"no" => 12,
		//"nama" => "Berikut ini yang tidak mencerminkan penerapan nilai Safety adalah",
		//"jawab" => array(
			//"a" => "Karyawan yang banyak rencana, tetapi tidak ada realisasi.",
			//"b" => "Karyawan yang bekerja tidak memperhatikan aspek K3LH.",
			//"c" => "Karyawan yang bertindak menjadi contoh buruk bagi lingkungan kerjanya.",
			//"d" => "Karyawan yang memanipulasi data / berbohong.",
		//)
	//)
	11 => array(
		"no" => 12,
		"nama" => "Berikut ini yang tidak mencerminkan penerapan nilai Safety adalah",
		"jawab" => array(
			"a" => "Karyawan yang banyak rencana, tetapi tidak ada realisasi",
			"b" => "Karyawan yang bekerja dengan ceroboh",
			"c" => "Karyawan yang bekerja asal-asalan, sembarangan",
			"d" => "Karyawan yang bertindak jadi contoh buruk bagi lingkungan kerjanya.",
		),
		"benar"=> "b",
		"kategori"=> "safety",
	),
);

$soal3 = array(
		1=> 'kedisiplinan',
		2=> 'ketelitian',
		3=> 'memimpin dengan tegas',
		4=> 'optimisme',
		5=> 'menyelesaikan masalah',
		6=> 'solutif',
		7=> 'ketekunan',
		8=> 'taktik yang efektif',
		9=> 'kekeluargaan',
		10=> 'teladan',
		11=> 'cepat',
		12=> 'inovatif',
		13=> 'semangat tinggi',
		14=> 'konsisten',
		15=> 'komitmen',
		16=> 'keterbukaan',
		17=> 'bertanggung jawab',
		18=> 'strategis',
		19=> 'pantang menyerah',
		20=> 'tuntas',
		21=> 'mentaati peraturan',
		22=> 'menjaga kepercayaan',
		23=> 'tanggap',
		24=> 'hasil yang terbaik',
		25=> 'berani menerima tantangan',
		26=> 'produktif',
		27=> 'mengendalikan perubahan',
		28=> 'menghargai',
		29=> 'inisiatif',
		30=> 'mengenali resiko',
);

$soal4 = array(
	0 => array('name' => 'Saya senantiasa hadir di kantor tepat waktu.','kategori'=> 'kedisiplinan'),
	1 => array('name' => 'Saya tekun dalam menjalankan tugas dan tanggung jawab.','kategori'=> 'ketekunan'),
	2 => array('name' => 'Saya  antusias dalam menyelesaikan  setiap pekerjaan dan tanggung jawab yang diberikan.','kategori'=> 'semangat tinggi'),
	3 => array('name' => 'Ketika satu cara gagal, maka saya mencari cara lain hingga berhasil.','kategori'=> 'pantang menyerah'),
	4 => array('name' => 'Saya senang menghadapi tantangan yang diberikan dalam menyelesaikan pekerjaan.','kategori'=> 'berani menerima tantangan'),
	5 => array('name' => 'Saya memiliki ketelitian dalam menjalankan pekerjaan.','kategori'=> 'ketelitian'),
	6 => array('name' => 'Saya dapat menggunakan strategi atau cara yang efektif dalam menyelesaikan pekerjaan yang rumit dan kompleks.','kategori'=> 'taktik yang efektif'),
	7 => array('name' => 'Saya melaksanakan program sesuai dengan perencanaan yang telah dibuat.','kategori'=> 'konsisten'),
	8 => array('name' => 'Saya berkomitmen menyelesaikan setiap pekerjaan hingga tuntas.','kategori'=> 'tuntas'),
	9 => array('name' => 'Saya mampu menyelesaikan setiap tugas dengan kualitas terbaik.','kategori'=> 'produktif'),
	10 => array('name' => 'Saya selalu bersikap tegas terhadap tim.','kategori'=> 'memimpin dengan tegas'),
	11 => array('name' => 'Saya mengedepankan kekeluargaan serta kebersamaan untuk mencapai tujuan tim.','kategori'=> 'kekeluargaan'),
	12 => array('name' => 'Saya mampu memenuhi kesepakatan/janji.','kategori'=> 'komitmen'),
	13 => array('name' => 'Saya taat menjalankan peraturan perusahaan.','kategori'=> 'mentaati peraturan'),
	14 => array('name' => 'Saya suka membuat perubahan positif di lingkungan kerja.','kategori'=> 'mengendalikan perubahan'),
	15 => array('name' => 'Saya pantang menyerah dalam menghadapi kegagalan.','kategori'=> 'optimisme'),
	16 => array('name' => 'Saya berusaha memberikan contoh perilaku yang baik di lingkungan kerja saya.','kategori'=> 'teladan'),
	17 => array('name' => 'Saya bersikap terbuka dalam memberi dan menerima masukan.','kategori'=> 'keterbukaan'),
	18 => array('name' => 'Saya mengedepankan menjaga kepercayaan yang diberikan kepada saya.','kategori'=> 'menjaga kepercayaan'),
	19 => array('name' => 'Saya menghormati perbedaan di antara pegawai.','kategori'=> 'menghargai'),
	20 => array('name' => 'Ketika ada masalah, saya langsung mencari solusinya.','kategori'=> 'menyelesaikan masalah'),
	21 => array('name' => 'Saya mengerjakan tugas dengan lebih cepat.','kategori'=> 'cepat'),
	22 => array('name' => 'Saya menjalankan tugas yang diberikan dengan penuh tanggung jawab.','kategori'=> 'bertanggung jawab'),
	23 => array('name' => 'Saya peka dan peduli menghadapi keinginan rekan kerja dan atasan saya.','kategori'=> 'tanggap'),
	24 => array('name' => 'Saya berpikir dengan melihat ke masa depan.','kategori'=> 'inisiatif'),
	25 => array('name' => 'Saya menyiapkan solusi atas situasi yang akan terjadi di masa mendatang.','kategori'=> 'solutif'),
	26 => array('name' => 'Saya selalu mencari ide-ide baru untuk meningkatkan efektivitas kegiatan.','kategori'=> 'inovatif'),
	27 => array('name' => 'Saya mampu membuat perencanaan dan pengelolaan secara strategis dengan menyelaraskan strategi perusahaan sehingga mencapai target organisasi.','kategori'=> 'strategis'),
	28 => array('name' => 'Saya berorientasi memberikan kontribusi terbaik untuk perusahaan.','kategori'=> 'hasil yang terbaik'),
	29 => array('name' => 'Saya mampu mengenali risiko dalam setiap kegiatan.','kategori'=> 'mengenali resiko'),
);

$result = array(1 => $soal1,2 => $soal2,3 => $soal3,4 => $soal4);	
return $result[$x];
}

function kpp_values() {
	$val = array(
		1=> array('name' => 'kedisiplinan','kategori'=> 'tangguh'),
		2=> array('name' => 'ketelitian','kategori'=> 'cekatan'),
		3=> array('name' => 'memimpin dengan tegas','kategori'=> 'tegas'),
		4=> array('name' => 'optimisme','kategori'=> 'panutan'),
		5=> array('name' => 'menyelesaikan masalah','kategori'=> 'responsif'),
		6=> array('name' => 'solutif','kategori'=> 'solusional'),
		7=> array('name' => 'ketekunan','kategori'=> 'tangguh'),
		8=> array('name' => 'taktik yang efektif','kategori'=> 'cekatan'),
		9=> array('name' => 'kekeluargaan','kategori'=> 'tegas'),
		10=> array('name' => 'teladan','kategori'=> 'panutan'),
		11=> array('name' => 'cepat','kategori'=> 'responsif'),
		12=> array('name' => 'inovatif','kategori'=> 'solusional'),
		13=> array('name' => 'semangat tinggi','kategori'=> 'tangguh'),
		14=> array('name' => 'konsisten','kategori'=> 'cekatan'),
		15=> array('name' => 'komitmen','kategori'=> 'tegas'),
		16=> array('name' => 'keterbukaan','kategori'=> 'panutan'),
		17=> array('name' => 'bertanggung jawab','kategori'=> 'responsif'),
		18=> array('name' => 'strategis','kategori'=> 'solusional'),
		19=> array('name' => 'pantang menyerah','kategori'=> 'tangguh'),
		20=> array('name' => 'tuntas','kategori'=> 'cekatan'),
		21=> array('name' => 'mentaati peraturan','kategori'=> 'tegas'),
		22=> array('name' => 'menjaga kepercayaan','kategori'=> 'panutan'),
		23=> array('name' => 'tanggap','kategori'=> 'responsif'),
		24=> array('name' => 'hasil yang terbaik','kategori'=> 'solusional'),
		25=> array('name' => 'berani menerima tantangan','kategori'=> 'tangguh'),
		26=> array('name' => 'produktif','kategori'=> 'cekatan'),
		27=> array('name' => 'mengendalikan perubahan','kategori'=> 'tegas'),
		28=> array('name' => 'menghargai','kategori'=> 'panutan'),
		29=> array('name' => 'inisiatif','kategori'=> 'responsif'),
		30=> array('name' => 'mengenali resiko','kategori'=> 'solusional'),
	);
	
	return $val;
}

function kpp_values_old() {
	$val = array(
		1=> 'kedisiplinan',
		2=> 'ketelitian',
		3=> 'memimpin dengan tegas',
		4=> 'optimisme',
		5=> 'menyelesaikan masalah',
		6=> 'solutif',
		7=> 'ketekunan',
		8=> 'taktik yang efektif',
		9=> 'kekeluargaan',
		10=> 'teladan',
		11=> 'cepat',
		12=> 'inovatif',
		13=> 'semangat tinggi',
		14=> 'konsisten',
		15=> 'komitmen',
		16=> 'keterbukaan',
		17=> 'bertanggung jawab',
		18=> 'strategis',
		19=> 'pantang menyerah',
		20=> 'tuntas',
		21=> 'mentaati peraturan',
		22=> 'menjaga kepercayaan',
		23=> 'tanggap',
		24=> 'hasil yang terbaik',
		25=> 'berani menerima tantangan',
		26=> 'produktif',
		27=> 'mengendalikan perubahan',
		28=> 'menghargai',
		29=> 'inisiatif',
		30=> 'mengenali resiko',
	);
	
	return $val;
}

function antam($x) {
	$soal1 = array(
		//0 => array(
			//"no" => 1,
			//"nama" => "Dari pilihan berikut ini, manakah yang mewakili nilai P dari PIONEER",
			//"jawab" => array(
				//"a" => "Passion",
				//"b" => "Pride",
				//"c" => "Profesionalism",
				//"d" => "Persistance",
			//),
			//"benar"=> "c",
			//"kategori"=> "PROFESSIONALISM",
		//),
		0 => array(
			"no" => 1,
			"nama" => "Selalu menekankan pentingnya komitmen dalam menjalankan tugas untuk memberikan kontribusi terbaik bagi perusahaan, merupakan definisi dari nilai...",
			"jawab" => array(
				"a" => "<i>Contribution</i>",
				"b" => "<i>Professionalism</i>",
				"c" => "<i>Responsibility</i>",
				"d" => "<i>Pride</i>",
			),
			"benar"=> "b",
			"kategori"=> "PROFESSIONALISM",
		),
		1 => array(
			"no" => 2,
			"nama" => "Berani mengambil risiko merupakan salah satu contoh perilaku dari nilai...",
			"jawab" => array(
				"a" => "<i>Innovation</i>",
				"b" => "<i>Global Mentality</i>",
				"c" => "<i>Professionalism</i>",
				"d" => "<i>Contribution</i>",
			),
			"benar"=> "d",
			"kategori"=> "PROFESSIONALISM",
		),
		//3 => array(
			//"no" => 4,
			//"nama" => "Definisi dari nilai Integrity pada PIONEER adalah",
			//"jawab" => array(
				//"a" => "Bersikap jujur dan menjaga konsistensi antara pikiran, perkataan, dan perbuatan.",
				//"b" => "Menjunjung tinggi kebenaran, mematuhi ketentuan yang berlaku, dan terbuka terhadap kritik yang bersifat membangun.",
				//"c" => "Taat peraturan, patuh pada pimpinan, serta menjaga kesatuan hati antara pimpinan dengan karyawan demi melindungi nilai dan mencapai visi.",
				//"d" => "Mengedepankan integritas dalam melaksanakan kegiatan operasi, secara konsisten berdasarkan prinsip-prinsip GCG, standar etika, dan kode etik bisnis.",
			//),
			//"benar"=> "d",
			//"kategori"=> "INTEGRITY",
		//),
		2 => array(
			"no" => 3,
			"nama" => "Berikut ini adalah contoh perilaku dari nilai <b><i>Integrity</i></b> pada <b>PIONEER</b>, kecuali...",
			"jawab" => array(
				"a" => "Taat pada standar etika",
				"b" => "Transparan",
				"c" => "Terbuka pada ide baru",
				"d" => "Adil",
			),
			"benar"=> "c",
			"kategori"=> "INTEGRITY",
		),
		3 => array(
			"no" => 4,
			"nama" => "Melempar tanggung jawab tidak mencerminkan perilaku dari nilai...",
			"jawab" => array(
				"a" => "<i>Responsible</i>",
				"b" => "<i>Integrity</i>",
				"c" => "<i>Professionalism</i>",
				"d" => "<i>Excellence</i>",
			),
			"benar"=> "b",
			"kategori"=> "INTEGRITY",
		),
		4 => array(
			"no" => 5,
			"nama" => "Dari pilihan berikut ini, manakah yang mewakili nilai <b>\"O\"</b> dari <b>PIONEER</b>...",
			"jawab" => array(
				"a" => "<i>Global mentality</i>",
				"b" => "<i>Open mind</i>",
				"c" => "<i>Confidence</i>",
				"d" => "<i>Loyal</i>",
			),
			"benar"=> "a",
			"kategori"=> "GLOBAL MENTALITY",
		),
		//7 => array(
			//"no" => 8,
			//"nama" => "Menunjukkan sikap percaya diri, berpikir dan bertindak sesuai dengan prinsip-prinsip manajemen kelas dunia adalah definisi dari nilai",
			//"jawab" => array(
				//"a" => "Confidence",
				//"b" => "Global mentality",
				//"c" => "Excellence",
				//"d" => "Open mind",
			//),
			//"benar"=> "b",
			//"kategori"=> "GLOBAL MENTALITY",
		//),
		5 => array(
			"no" => 6,
			"nama" => "Siap menghadapi perubahan merupakan salah satu contoh perilaku dari nilai...",
			"jawab" => array(
				"a" => "<i>Adaptability</i>",
				"b" => "<i>Agility</i>",
				"c" => "<i>Open mind</i>",
				"d" => "<i>Global mentality</i>",
			),
			"benar"=> "d",
			"kategori"=> "GLOBAL MENTALITY",
		),
		6 => array(
			"no" => 7,
			"nama" => "Definisi dari nilai <b><i>Harmony</i></b> pada <b>PIONEER</b> adalah...",
			"jawab" => array(
				"a" => "Menjaga harmoni dengan semua pemegang kepentingan baik internal maupun eksternal.",
				"b" => "Bekerjasama dalam melaksanakan tugas dalam suasana harmoni dalam mencapai tujuan yang ditetapkan bersama.",
				"c" => "Menghargai perbedaan, memelihara kekompakan, dan menjaga keutuhan tim.",
				"d" => "Menjaga harmoni dengan menunjukkan sikap toleran dan bersahabat dengan siapapun.",
			),
			"benar"=> "a",
			"kategori"=> "HARMONY",
		),
		//10 => array(
			//"no" => 11,
			//"nama" => "Berikut ini adalah contoh perilaku dari nilai Harmony pada PIONEER, kecuali",
			//"jawab" => array(
				//"a" => "Peduli",
				//"b" => "Sinergis",
				//"c" => "Adil",
				//"d" => "Menghargai",
			//),
			//"benar"=> "c",
			//"kategori"=> "HARMONY",
		//),
		7 => array(
			"no" => 8,
			"nama" => "<b>Egois</b> dan <b>Apatis</b> merupakan perilaku yang tidak mencerminkan nilai...",
			"jawab" => array(
				"a" => "<i>Sinergy</i>",
				"b" => "<i>Open Mind</i>",
				"c" => "<i>Professionalism</i>",
				"d" => "<i>Harmony</i>",
			),
			"benar"=> "d",
			"kategori"=> "HARMONY",
		),
		8 => array(
			"no" => 9,
			"nama" => "Memberikan kontribusi yang <b><i>Excellence</i></b> dengan tetap melakukan perbaikan guna mencapai kinerja terbaik perusahaan merupakan definisi dari nilai...",
			"jawab" => array(
				"a" => "<i>Contribution</i>",
				"b" => "<i>Customer focus</i>",
				"c" => "<i>Professionalism</i>",
				"d" => "<i>Excellence</i>",
			),
			"benar"=> "d",
			"kategori"=> "EXCELLENCE",
		),
		9 => array(
			"no" => 10,
			"nama" => "Contoh perilaku dari nilai <b><i>Excellence</i></b> adalah",
			"jawab" => array(
				"a" => "Taat pada peraturan",
				"b" => "Melakukan perbaikan terus-menerus",
				"c" => "Bertanggung jawab",
				"d" => "Mampu beradaptasi",
			),
			"benar"=> "b",
			"kategori"=> "EXCELLENCE",
		),
		//14 => array(
			//"no" => 15,
			//"nama" => "Sikap positif merupakan perilaku dari nilai",
			//"jawab" => array(
				//"a" => "Excellence",
				//"b" => "Positivity",
				//"c" => "Open mind",
				//"d" => "Sinergy",
			//),
			//"benar"=> "a",
			//"kategori"=> "EXCELLENCE",
		//),
		//15 => array(
			//"no" => 16,
			//"nama" => "Membangun reputasi melalui proses yang sulit dan memakan waktu, disandang dengan penuh kebanggaan guna memotivasi diri untuk meraih kesuksesan, merupakan definisi dari nilai",
			//"jawab" => array(
				//"a" => "Motivation",
				//"b" => "Proud",
				//"c" => "Reputation",
				//"d" => "Being the best",
			//),
			//"benar"=> "c",
			//"kategori"=> "REPUTATION",
		//),
		10 => array(
			"no" => 11,
			"nama" => "Dari pilihan berikut ini, manakah yang mewakili nilai <b>\"R\"</b> dari <b>PIONEER</b>",
			"jawab" => array(
				"a" => "<i>Respect</i>",
				"b" => "<i>Reputation</i>",
				"c" => "<i>Responsible</i>",
				"d" => "<i>Reliable</i>",
			),
			"benar"=> "b",
			"kategori"=> "REPUTATION",
		),
		11 => array(
			"no" => 12,
			"nama" => "Bangga terhadap perusahaan merupakan perilaku dari nilai",
			"jawab" => array(
				"a" => "<i>Motivation</i>",
				"b" => "<i>Proud</i>",
				"c" => "<i>Being the best</i>",
				"d" => "<i>Reputation</i>",
			),
			"benar"=> "d",
			"kategori"=> "REPUTATION",
		),
	);	

	$soal2 = array(
		0 => array(
			"no" => 1,
			"nama" => "Pak Wildan adalah salah seorang karyawan ANTAM yang sangat gemar mengembangkan dirinya. Ketika rekan kerjanya memberikan ide-ide baru, Pak Wildan dengan senang hati menerimanya. Sikap Pak Wildan termasuk salah satu contoh penerapan nilai...",
			"jawab" => array(
				"a" => "<i>Excellence</i>",
				"b" => "<i>Global Mentality</i>",
				"c" => "<i>Profesionalism</i>",
				"d" => "<i>Reputation</i>",
			),
			"benar"=> "c",
			"kategori"=> "PROFESSIONALISM",
		),
		1 => array(
			"no" => 2,
			"nama" => "Di antara perilaku di bawah ini, manakah yang termasuk dalam penerapan nilai <b><i>Professionalism</i></b>...",
			"jawab" => array(
				"a" => "Mengembangkan kemampuan untuk beradaptasi terhadap perbedaan dan perubahan budaya (baik lokal maupun internasional).",
				"b" => "Memiliki komitmen tinggi dalam bekerja dan mensinergikan praktek-praktek terbaik dengan wawasan bisnis (<i>business acumen</i>) dan budaya perusahaan untuk memberikan kontribusi yang maksimal.",
				"c" => "Menanamkan komitmen tinggi, mental pemenang, keyakinan kuat dan sikap positif untuk melakukan yang terbaik guna mencapai kinerja terbaik.",
				"d" => "Meningkatkan posisi perusahaan di dalam percaturan bisnis nasional dan global.",
			),
			"benar"=> "b",
			"kategori"=> "PROFESSIONALISM",
		),
		//2 => array(
			//"no" => 3,
			//"nama" => "Mengambil keputusan secara tergesa-gesa, tanpa memperhatikan risiko dan manfaatnya bagi perusahaan merupakan sikap yang tidak mencerminkan nilai",
			//"jawab" => array(
				//"a" => "Integrity",
				//"b" => "Reputation",
				//"c" => "Excellence",
				//"d" => "Profesionalism",
			//),
			//"benar"=> "d",
			//"kategori"=> "PROFESSIONALISM",
		//),
		2 => array(
			"no" => 3,
			"nama" => "Karyawan yang senantiasa bekerja dengan <b>bertanggung jawab, adil, dan transparan,</b> merupakan karyawan yang menerapkan perilaku pada nilai...",
			"jawab" => array(
				"a" => "<i>Professionalism</i>",
				"b" => "<i>Integrity</i>",
				"c" => "<i>Reputation</i>",
				"d" => "<i>Excellence</i>",
			),
			"benar"=> "b",
			"kategori"=> "INTEGRITY",
		),
		3 => array(
			"no" => 4,
			"nama" => "Di antara perilaku di bawah ini, manakah yang termasuk dalam penerapan nilai <b><i>Integrity</i></b>...",
			"jawab" => array(
				"a" => "Mentaati Standar Etika, GCG, dan peraturan perundang-undangan.",
				"b" => "Membangun standar terbaik dan cara paling efektif dan efisien untuk mencapai kinerja organisasi/unjuk kerja pegawai terbaik.",
				"c" => "Menegakkan disiplin untuk menyusun dan mengimplementasikan rencana kerja secara efektif dan konsisten.",
				"d" => "Berusaha keras untuk mencapai standar yang lebih tinggi dan terbuka terhadap ide-ide baru.",
			),
			"benar"=> "a",
			"kategori"=> "INTEGRITY",
		),
		//5 => array(
			//"no" => 6,
			//"nama" => "Memanfaatkan fasilitas kantor dan melakukan manipulasi data untuk kepentingan pribadi, merupakan perilaku yang tidak mencerminkan nilai",
			//"jawab" => array(
				//"a" => "Harmony",
				//"b" => "Global Mentality",
				//"c" => "Integrity",
				//"d" => "Reputation",
			//),
			//"benar"=> "c",
			//"kategori"=> "INTEGRITY",
		//),
		4 => array(
			"no" => 5,
			"nama" => "Ibu Lucia adalah seorang karyawan ANTAM. Pada satu ketika, ia mendapatkan kesempatan untuk mewakili ANTAM pada konferensi bisnis dan studi banding di perusahaan tambang luar negeri selama dua bulan. Namun karena ia tidak merasa percaya diri dengan kemampuannya untuk mewakili ANTAM, tawaran tersebut akhirnya tidak ia ambil. Sikap Ibu Luci dalam hal ini tidak mencerminkan nilai...",
			"jawab" => array(
				"a" => "<i>Reputation</i>",
				"b" => "<i>Professionalism</i>",
				"c" => "<i>Excellence</i>",
				"d" => "<i>Global Mentality</i>",
			),
			"benar"=> "d",
			"kategori"=> "GLOBAL MENTALITY",
		),
		5 => array(
			"no" => 6,
			"nama" => "Di antara perilaku di bawah ini, manakah yang termasuk dalam penerapan nilai <b><i>Global Mentality</i></b>...",
			"jawab" => array(
				"a" => "Mengembangkan kemampuan untuk beradaptasi terhadap perbedaan dan perubahan budaya (baik lokal maupun internasional).",
				"b" => "Berusaha keras untuk mencapai standar yang lebih tinggi dan terbuka terhadap ide-ide baru.",
				"c" => "Mengembangkan diri sendiri secara optimal dan berkesinambungan untuk peningkatan kinerja/untuk kerja dan pengembangan karir.",
				"d" => "Peduli terhadap semua pemangku kepentingan, terutama pegawai, mitra strategis, dan masyarakat di sekitar wilayah operasi.",
			),
			"benar"=> "a",
			"kategori"=> "GLOBAL MENTALITY",
		),
		//8 => array(
			//"no" => 9,
			//"nama" => "Mengikuti perkembangan bisnis secara luas pada tingkat global untuk melakukan transformasi guna meningkatkan kinerja perusahaan, merupakan perilaku dari nilai",
			//"jawab" => array(
				//"a" => "Harmony",
				//"b" => "Integrity",
				//"c" => "Global Mentality",
				//"d" => "Reputation",
			//),
			//"benar"=> "c",
			//"kategori"=> "GLOBAL MENTALITY",
		//),
		//9 => array(
			//"no" => 10,
			//"nama" => "Pada suatu rapat divisi, terdapat perbedaan pendapat antar karyawannya. Sebagai pimpinan divisi, Bu Natalia berusaha untuk menemukan solusi terbaik yang dapat menguntungkan berbagai pihak sehingga kerjasama tim tetap dapat terjalin. Sikap Bu Natalia dalam hal ini menggambarkan nilai",
			//"jawab" => array(
				//"a" => "Harmony",
				//"b" => "Profesionalism",
				//"c" => "Global Mentality",
				//"d" => "Excellence",
			//),
			//"benar"=> "a",
			//"kategori"=> "HARMONY",
		//),
		6 => array(
			"no" => 7,
			"nama" => "Peduli terhadap semua pemangku kepentingan, terutama pegawai, mitra strategis, dan masyarakat di sekitar wilayah operasi, merupakan salah satu contoh penerapan nilai...",
			"jawab" => array(
				"a" => "<i>Professionalism</i>",
				"b" => "<i>Global Mentality</i>",
				"c" => "<i>Harmony</i>",
				"d" => "<i>Integrity</i>",
			),
			"benar"=> "c",
			"kategori"=> "HARMONY",
		),
		7 => array(
			"no" => 8,
			"nama" => "Di antara perilaku di bawah ini, manakah yang termasuk dalam penerapan nilai <b><i>Harmony</i></b>",
			"jawab" => array(
				"a" => "Menanamkan komitmen tinggi, mental pemenang, keyakinan kuat, dan sikap positif untuk melakukan yang terbaik guna mencapai kinerja terbaik.",
				"b" => "Membangun kerjasama dan hubungan sinergis dengan semua pemangku kepentingan baik pihak internal maupun eksternal berdasarkan prinsip menang-menang dan keadilan.",
				"c" => "Menanamkan kebanggaan sebagai insan ANTAM yang memiliki reputasi individu yang baik untuk peningkatan citra perusahaan.",
				"d" => "Mengutamakan kejujuran dan kepentingan perusahaan.",
			),
			"benar"=> "b",
			"kategori"=> "HARMONY",
		),
		8 => array(
			"no" => 9,
			"nama" => "Berikut ini merupakan contoh penerapan dari nilai <b><i>Excellence</i></b>",
			"jawab" => array(
				"a" => "Membangun standar terbaik dan cara yang paling efektif dan efisien untuk mencapai kinerja organisasi/unjuk kerja pegawai terbaik.",
				"b" => "Mengikuti perkembangan bisnis secara luas pada tingkat global untuk melakukan transformasi guna meningkatkan kinerja perusahaan.",
				"c" => "Mentaati standar Etika, <i>GCG</i>, dan peraturan perundang-undangan.",
				"d" => "Berani mengambil keputusan dan tindakan dengan mempertimbangkan risiko dan manfaatnya bagi perusahaan.",
			),
			"benar"=> "a",
			"kategori"=> "EXCELLENCE",
		),
		//13 => array(
			//"no" => 14,
			//"nama" => "Malas membuat rencana kerja, dan lalai dalam menerapkan prinsip-prinsip operasional dalam melakukan pekerjaan adalah perilaku yang tidak mencerminkan nilai",
			//"jawab" => array(
				//"a" => "Reputation",
				//"b" => "Excellence",
				//"c" => "Professionalism",
				//"d" => "Integrity",
			//),
			//"benar"=> "b",
			//"kategori"=> "EXCELLENCE",
		//),
		9 => array(
			"no" => 10,
			"nama" => "Menanamkan komitmen tinggi, mental pemenang, keyakinan kuat, dan sikap positif untuk melakukan yang terbaik guna mencapai kinerja terbaik adalah salah satu perilaku yang menggambarkan nilai...",
			"jawab" => array(
				"a" => "<i>Excellence</i>",
				"b" => "<i>Integrity</i>",
				"c" => "<i>Harmony</i>",
				"d" => "<i>Reputation</i>",
			),
			"benar"=> "a",
			"kategori"=> "EXCELLENCE",
		),
		//15 => array(
			//"no" => 16,
			//"nama" => "Meningkatkan posisi perusahaan di dalam percaturan bisnis nasional dan global., merupakan salah satu penerapan perilaku",
			//"jawab" => array(
				//"a" => "Integrity",
				//"b" => "Reputation",
				//"c" => "Excellence",
				//"d" => "Harmony",
			//),
			//"benar"=> "c",
			//"kategori"=> "REPUTATION",
		//),
		10 => array(
			"no" => 11,
			"nama" => "Berikut ini yang merupakan contoh penerapan nilai <b><i>Reputation</i></b>...",
			"jawab" => array(
				"a" => "Menanamkan komitmen tinggi, mental pemenang, keyakinan kuat, dan sikap positif untuk melakukan yang terbaik guna mencapai kinerja terbaik.",
				"b" => "Membangun, meningkatkan, dan memelihara citra perusahaan di tingkat nasional dan global.",
				"c" => "Membangun mental global (cara berpikir, kompetensi, rasa percaya diri, dan cara bertindak) sesuai dengan <i>business acumen kelas dunia</i>.",
				"d" => "Mengembangkan kemampuan untuk beradaptasi terhadap perbedaan dan perubahan budaya (baik lokal maupun internasional).",
			),
			"benar"=> "b",
			"kategori"=> "REPUTATION",
		),
		11 => array(
			"no" => 12,
			"nama" => "Ibu Endah senantiasa menunjukkan citra dan reputasi yang baik sebagai karyawan ANTAM. Dalam setiap kesempatan, ia selalu menyampaikan kepada teman dan kerabatnya, bahwa ia merasa bangga menjadi salah satu karyawan yang bekerja di ANTAM. Sikap Ibu Endah dalam hal ini mencerminkan penerapan nilai",
			"jawab" => array(
				"a" => "<i>Professionalism</i>",
				"b" => "<i>Integrity</i>",
				"c" => "<i>Reputation</i>",
				"d" => "<i>Excellence</i>",
			),
			"benar"=> "d",
			"kategori"=> "REPUTATION",
		),
	);	
	$result = array(1 => $soal1,2 => $soal2);	
	return $result[$x];
}

function angkasa_old($x) {
$soal1 = array(
	0 => array(
		"no" => 1,
		"nama" => "Berikut ini yang merupakan definisi dari nilai <i>Pride of Indonesia</i> adalah",
		"jawab" => array(
			"a" => "Sedikit bicara dan banyak bekerja, mampu mengimplementasikan gagasan baru secara cepat.",
			"b" => "Berkomitmen penuh untuk mencapai hasil yang terbaik.",
			"c" => "Mendukung pembangunan Negara dan menawarkan pengalaman terbaik Indonesia kepada dunia.",
			"d" => "Mencurahkan sumber daya dan perhatian yang lebih kepada tujuan tertentu.",
		)
	),
	1 => array(
		"no" => 2,
		"nama" => "Berikut ini yang menjadi perilaku utama dari <i>Pride of Indonesia</i> adalah",
		"jawab" => array(
			"a" => "Nasionalisme, menghormati, kehormatan.",
			"b" => "Nasionalisme, kehormatan, integritas.",
			"c" => "Nasionalisme, komitmen, proaktif.",
			"d" => "Nasionalisme, pelayanan prima, proaktif.",
		)
	),
	2 => array(
		"no" => 3,
		"nama" => "Berikut yang bukan menjadi perilaku yang dilarang dari nilai <i>Pride of Indonesia</i> adalah",
		"jawab" => array(
			"a" => "Lambat untuk menangkap peluang bisnis yang ada di lingkungan bandara.",
			"b" => "Membanggakan budaya dari luar untuk dijadikan kegiatan promosi.",
			"c" => "Memberikan pelayanan yang buruk kepada pengguna jasa bandara.",
			"d" => "Pasif dalam melakukan kegiatan promosi untuk mendukung potensi pariwisata dan keunggulan Indonesia lainnya.",
		)
	),
	3 => array(
		"no" => 4,
		"nama" => "Berikut ini yang merupakan definisi dari nilai <i>Entrepreneurial</i> adalah",
		"jawab" => array(
			"a" => "Mendukung pembangunan negara dan menawarkan pengalaman terbaik Indonesia kepada dunia.",
			"b" => "Selalu melihat dari sudut pandang konsumen dalam segala tindakan.",
			"c" => "Mengakui dan menghargai prestasi melalui penerapan apresiasi.",
			"d" => "Sedikit bicara dan banyak bekerja, mampu mengimplementasikan gagasan baru secara cepat.",
		)
	),
	4 => array(
		"no" => 5,
		"nama" => "Berikut ini merupakan perilaku utama dari <i>Entrepreneurial</i>, kecuali",
		"jawab" => array(
			"a" => "Proaktif.",
			"b" => "Inovatif.",
			"c" => "Daya juang tinggi.",
			"d" => "Berani mengambil risiko.",
		)
	),
	5 => array(
		"no" => 6,
		"nama" => "Berikut ini yang merupakan perilaku dari nilai <i>Entrepreneurial</i> adalah",
		"jawab" => array(
			"a" => "Membawa muatan budaya lokal ke dalam desain / arsitektur / dekorasi pada layanan ataupun produk perusahaan.",
			"b" => "Mencari penyelesaian masalah dengan cara-cara yang lebih efektif dan efisien serta menjadikan hambatan sebagai tantangan yang harus dihadapi dengan gigih.",
			"c" => "Melakukan tindakan preventif terkait keamanan dan keselamatan penerbangan.",
			"d" => "Menetapkan target jangka pendek (<i>quick win</i>) dan jangka panjang serta prioritas dari masing-masing target tersebut.",
		)
	),
	6 => array(
		"no" => 7,
		"nama" => "Berikut ini yang merupakan definisi dari nilai <i>Responsible</i> adalah",
		"jawab" => array(
			"a" => "Berkomitmen penuh untuk mencapai hasil yang terbaik.",
			"b" => "Mengidentifikasi masalah, hambatan atau peluang dan mengambil tindakan terbaik untuk kepentingan saat ini dan di masa yang akan datang.",
			"c" => "Sedikit bicara dan banyak bekerja, mampu mengimplementasikan gagasan baru secara cepat.",
			"d" => "Mencurahkan sumber daya dan perhatian yang lebih kepada tujuan tertentu.",
		)
	),
	7 => array(
		"no" => 8,
		"nama" => "Berikut ini yang menjadi perilaku utama dari <i>Responsible</i> adalah",
		"jawab" => array(
			"a" => "Komitmen, integritas, daya juang tinggi.",
			"b" => "Disiplin, komitmen, peduli.",
			"c" => "Berani mengambil risiko, konsisten, daya juang tinggi.",
			"d" => "Disiplin, peduli, konsisten.",
		)
	),
	8 => array(
		"no" => 9,
		"nama" => "Berikut yang bukan menjadi perilaku yang dilarang dari nilai <i>Responsible</i> adalah",
		"jawab" => array(
			"a" => "Menyelesaikan pekerjaan tidak sesuai dengan apa yang telah disepakati.",
			"b" => "Menampung kritik-kritik dan keluhan dari para pengguna jasa bandara tanpa ada tindak lanjut.",
			"c" => "Merasa puas dengan kualitas pelayanan yang dimiliki saat ini.",
			"d" => "Menghindari masalah yang terjadi di bandara akibat pihak-pihak lain.",
		)
	),
	9 => array(
		"no" => 10,
		"nama" => "Berikut ini yang merupakan definisi dari nilai <i>Focused</i> adalah",
		"jawab" => array(
			"a" => "Berkomitmen penuh untuk mencapai hasil yang terbaik.",
			"b" => "Sedikit bicara dan banyak bekerja, mampu mengimplementasikan gagasan baru secara cepat.",
			"c" => "Menyelesaikan pekerjaan dengan tepat waktu dan mempertanggungjawabkan hasil kerja.",
			"d" => "Mencurahkan sumber daya dan perhatian yang lebih kepada tujuan tertentu.",
		)
	),
	10 => array(
		"no" => 11,
		"nama" => "Berikut ini yang menjadi perilaku utama dari <i>Focused</i> adalah",
		"jawab" => array(
			"a" => "Disiplin.",
			"b" => "Daya juang tinggi.",
			"c" => "Teliti.",
			"d" => "Komitmen.",
		)
	),
	11 => array(
		"no" => 12,
		"nama" => "Berikut ini yang menjadi perilaku yang dilarang dari nilai <i>Focused</i> adalah",
		"jawab" => array(
			"a" => "Mudah menyerah dalam menghadapi permasalahan.",
			"b" => "Lambat untuk menangkap peluang bisnis yang ada di lingkungan bandara.",
			"c" => "Menyelesaikan pekerjaan tidak sesuai dengan apa yang telah disepakati.",
			"d" => "Bekerja tanpa memperhatikan target perusahaan.",
		)
	),
	12 => array(
		"no" => 13,
		"nama" => "Berikut ini yang merupakan definisi dari nilai <i>Outstanding Service</i> adalah",
		"jawab" => array(
			"a" => "Mencurahkan sumber daya dan perhatian yang lebih kepada tujuan tertentu.",
			"b" => "Memperlakukan setiap individu dengan hormat.",
			"c" => "Bekerja secara lincah serta fleksibel terhadap situasi yang tidak pasti.",
			"d" => "Selalu melihat dari sudut pandang konsumen dalam segala tindakan.",
		)
	),
	13 => array(
		"no" => 14,
		"nama" => "Berikut ini yang menjadi perilaku utama dari <i>Outstanding Service</i> adalah",
		"jawab" => array(
			"a" => "Pelayanan prima, peduli, kepuasan pelanggan.",
			"b" => "Pelayanan prima, komitmen, peduli.",
			"c" => "Pelayanan prima, proaktif, kepuasan pelanggan.",
			"d" => "Pelayanan prima, proaktif, berorientasi kepada tujuan.",
		)
	),
	14 => array(
		"no" => 15,
		"nama" => "Berikut ini yang bukan menjadi perilaku dari nilai <i>Outstanding Service</i> adalah",
		"jawab" => array(
			"a" => "Memberikan kemudahan dalam mengakses informasi.",
			"b" => "Lebih responsive terhadap kebutuhan dari unit lain dan menawarkan bantuan serta dukungan apabila dibutuhkan.",
			"c" => "Proaktif dalam memberikan pelayanan prima kepada pengguna jasa bandara.",
			"d" => "Memberikan penghargaan atas kontribusi mitra kerja dan usaha.",
		)
	),
	15 => array(
		"no" => 16,
		"nama" => "Berikut ini yang merupakan definisi dari nilai <i>Respectful</i> adalah",
		"jawab" => array(
			"a" => "Mengakui dan menghargai prestasi melalui penerapan apresiasi.",
			"b" => "Selalu peduli dalam memberikan pelayanan terbaik kepada pelanggan.",
			"c" => "Mengakui dan menghargai pekerjaan yang telah dilakukan karyawan perusahaan.",
			"d" => "Memperlakukan setiap individu dengan hormat.",
		)
	),
	16 => array(
		"no" => 17,
		"nama" => "Berikut ini yang bukan menjadi perilaku utama dari <i>Respectful</i> adalah",
		"jawab" => array(
			"a" => "Menghormati.",
			"b" => "Peduli.",
			"c" => "Menghargai.",
			"d" => "Empati.",
		)
	),
	17 => array(
		"no" => 18,
		"nama" => "Berikut ini yang menjadi perilaku dari nilai <i>Respectful</i> adalah",
		"jawab" => array(
			"a" => "Memberikan penghargaan atas kontribusi mitra kerja dan usaha.",
			"b" => "Tidak membeda-bedakan pelanggan dalam memberikan pelayanan.",
			"c" => "Memberikan imbalan dan / atau apresiasi sesuai dengan kontribusi dan pencapaian masing-masing karyawan.",
			"d" => "Lebih responsive terhadap kebutuhan dari unit lain dan menawarkan bantuan serta dukungan apabila dibutuhkan.",
		)
	),
	18 => array(
		"no" => 19,
		"nama" => "Berikut ini yang merupakan definisi dari nilai <i>Meritocratic</i> adalah",
		"jawab" => array(
			"a" => "Mengakui dan menghargai prestasi melalui penerapan apresiasi.",
			"b" => "Memperlakukan setiap individu dengan hormat.",
			"c" => "Selalu melihat dari sudut pandang konsumen dalam segala tindakan.",
			"d" => "Sedikit bicara dan banyak bekerja, mampu mengimplementasikan gagasan baru secara cepat.",
		)
	),
	19 => array(
		"no" => 20,
		"nama" => "Berikut ini yang menjadi perilaku utama dari <i>Meritocratic</i> adalah",
		"jawab" => array(
			"a" => "Apresiasi, peduli, berorientasi kepada tujuan.",
			"b" => "Apresiasi, pengakuan, keadilan.",
			"c" => "Apresiasi, menghargai, peduli.",
			"d" => "Apresiasi, keadilan, kehormatan.",
		)
	),
	20 => array(
		"no" => 21,
		"nama" => "Berikut ini yang menjadi perilaku yang dilarang dari nilai <i>Meritocratic</i> adalah",
		"jawab" => array(
			"a" => "Memberikan kesempatan karir yang tinggi kepada karyawan terdekat.",
			"b" => "Menyelesaikan pekerjaan tidak sesuai dengan apa yang telah disepakati.",
			"c" => "Menghindari masalah yang terjadi di bandara akibat pihak-pihak lain.",
			"d" => "Memberikan pelayanan kepada pengguna jasa bandara dipengaruhi oleh kondisi emosional.",
		)
	)
);

$soal2 = array(
	0 => array(
		"no" => 1,
		"nama" => "Karyawan yang membawa muatan budaya lokal ke dalam desain / arsitektur pada layanan ataupun produk perusahaan termasuk dalam penerapan nilai",
		"jawab" => array(
			"a" => "<i>Meritocratic</i>",
			"b" => "<i>Respectful</i>",
			"c" => "<i>Outstanding Service</i>",
			"d" => "<i>Pride of Indonesia</i>",
		)
	),
	1 => array(
		"no" => 2,
		"nama" => "Berikut ini yang termasuk contoh dalam penerapan nilai <i>Pride of Indonesia</i>",
		"jawab" => array(
			"a" => "Karyawan menjaga kualitas pelayanan sesuai dengan <i>service level guarantee.</i>",
			"b" => "Bersedia menerima kritik pelanggan untuk perbaikan.",
			"c" => "Bekerjasama dengan seniman dalam rangka mempromosikan nilai-nilai kebangsaan melalui karya seni budaya, pariwisata, dan keunggulan Indonesia lainnya.",
			"d" => "Berkonsentrasi pada pencapaian target perusahaan.",
		)
	),
	2 => array(
		"no" => 3,
		"nama" => "Berikut ini yang bukan termasuk dalam penerapan dari nilai-nilai inti <i>Pride of Indonesia</i> adalah",
		"jawab" => array(
			"a" => "Merasa bangga menjadi bangsa dan bagian dari masyarakat Indonesia.",
			"b" => "Karyawan menilai dirinya sebagai orang yang memiliki kemampuan, keberartian, berharga, dan kompeten.",
			"c" => "Berkomitmen untuk mengusahakan tercapainya kepentingan perusahaan.",
			"d" => "Mempromosikan kesenian dan budaya Indonesia secara periodik pada layanan ataupun produk perusahaan.",
		)
	),
	3 => array(
		"no" => 4,
		"nama" => "Karyawan yang berusaha mencari penyelesaian masalah dengan cara-cara yang lebih efektif dan efisien serta menjadikan hambatan sebagai tantangan yang harus dihadapi dengan gigih termasuk dalam penerapan nilai",
		"jawab" => array(
			"a" => "<i>Responsible</i>",
			"b" => "<i>Entrepreneurial</i>",
			"c" => "<i>Focused</i>",
			"d" => "<i>Outstanding Service</i>",
		)
	),
	4 => array(
		"no" => 5,
		"nama" => "Berikut ini yang termasuk contoh dalam penerapan nilai <i>Entrepreneurial</i>",
		"jawab" => array(
			"a" => "Berusaha menyediakan fasilitas dan pelayanan yang handal termasuk penyelesaian masalah yang menjadi keluhan pengguna jasa bandara.",
			"b" => "Karyawan berusaha untuk menyempurnakan bisnis yang ada untuk menciptakan lingkungan usaha yang menarik dan fokus kepada perspektif pelanggan.",
			"c" => "Bersikap proaktif dalam memberikan pelayanan prima kepada pengguna jasa bandara.",
			"d" => "Memberikan kesempatan karir yang sama kepada semua karyawan.",
		)
	),
	5 => array(
		"no" => 6,
		"nama" => "Berikut ini yang bukan termasuk dalam penerapan dari nilai-nilai inti <i>Entrepreneurial</i> adalah",
		"jawab" => array(
			"a" => "Memenuhi kebutuhan pelanggan dengan layanan yang terbaik.",
			"b" => "Menghasilkan solusi-solusi yang inovatif dalam bekerja dengan berpikir di luar kebiasaan.",
			"c" => "Bekerja secara lincah serta fleksibel terhadap situasi yang tidak pasti.",
			"d" => "Mampu mengarahkan dirinya untuk menghadapi rintangan dalam situasi yang sulit dengan berfokus pada sesuatu yang ingin dicapai.",
		)
	),
	6 => array(
		"no" => 7,
		"nama" => "Berikut ini yang merupakan contoh penerapan nilai <i>Responsible</i> yaitu",
		"jawab" => array(
			"a" => "Karyawan yang menyelesaikan tugasnya tepat waktu sesuai dengan target yang telah ditetapkan.",
			"b" => "Karyawan yang berperilaku konsisten sehingga target yang ditetapkan perusahaan dapat tercapai.",
			"c" => "Karyawan yang selalu memenuhi kebutuhan pelanggan dengan layanan yang terbaik.",
			"d" => "Karyawan yang menjadikan hambatan sebagai tantangan yang harus dihadapi.",
		)
	),
	7 => array(
		"no" => 8,
		"nama" => "Seorang karyawan yang menampung kritik dan keluhan dari pengguna jasa bandara namun tidak melakukan tindak lanjutnya maka karyawan tersebut tidak menerapkan nilai dari",
		"jawab" => array(
			"a" => "<i>Responsible</i>",
			"b" => "<i>Focused</i>",
			"c" => "<i>Respectful</i>",
			"d" => "<i>Outstanding Service</i>",
		)
	),
	8 => array(
		"no" => 9,
		"nama" => "Berikut ini termasuk dalam penerapan dari nilai Responsible kecuali",
		"jawab" => array(
			"a" => "Berkomitmen penuh untuk mencapai hasil yang terbaik.",
			"b" => "Mengambil tindakan terbaik untuk kepentingan saat ini dan di masa yang akan datang.",
			"c" => "Disiplin dalam menyelesaikan pekerjaan.",
			"d" => "Bersikap peduli dalam rangka memberikan pelayanan terbaik pada pelanggan.",
		)
	),
	9 => array(
		"no" => 10,
		"nama" => "Karyawan yang menetapkan target jangka pendek dan jangka panjang serta prioritas dari masing-masing target tersebut termasuk dalam penerapan nilai",
		"jawab" => array(
			"a" => "<i>Responsible</i>",
			"b" => "<i>Focused</i>",
			"c" => "<i>Entrepreneurial</i>",
			"d" => "<i>Meritocratic</i>",
		)
	),
	10 => array(
		"no" => 11,
		"nama" => "Berikut ini yang termasuk contoh dalam penerapan nilai <i>Focused</i>",
		"jawab" => array(
			"a" => "Menjaga kualitas pelayanan sesuai dengan <i>service level guarantee</i>.",
			"b" => "Menyelesaikan pekerjaan tugas tepat waktu sesuai dengan SOP dan target yang telah ditetapkan.",
			"c" => "Karyawan berani mengambil risiko dengan penuh perhitungan.",
			"d" => "Melakukan tindakan preventif terkait keamanan dan keselamatan penerbangan.",
		)
	),
	11 => array(
		"no" => 12,
		"nama" => "Berikut ini yang bukan termasuk dalam penerapan dari nilai <i>Focused</i> adalah",
		"jawab" => array(
			"a" => "Berorientasi kepada tujuan sehingga dapat mencapai hasil yang maksimal.",
			"b" => "Menjaga kualitas pelayanan sesuai dengan <i>service level guarantee</i>.",
			"c" => "Memiliki integritas yang tinggi.",
			"d" => "Karyawan yang berperilaku konsisten dan teliti",
		)
	),
	12 => array(
		"no" => 13,
		"nama" => "Seorang karyawan yang lebih <i>responsive</i> terhadap kebutuhan dari unit lain dan menawarkan bantuan serta dukungan apabila dibutuhkan merupakan penerapan dari nilai",
		"jawab" => array(
			"a" => "<i>Meritocratic</i>",
			"b" => "<i>Focused</i>",
			"c" => "<i>Responsible</i>",
			"d" => "<i>Outstanding Service</i>",
		)
	),
	13 => array(
		"no" => 14,
		"nama" => "Berikut ini yang merupakan contoh penerapan nilai <i>Outstanding Service</i> yaitu",
		"jawab" => array(
			"a" => "Karyawan yang memberikan kemudahan dalam mengakses informasi.",
			"b" => "Karyawan yang mengutamakan kepentingan bersama.",
			"c" => "Karyawan yang melakukan business development.",
			"d" => "Karyawan yang mampu mengimplementasikan gagasan baru secara cepat.",
		)
	),
	14 => array(
		"no" => 15,
		"nama" => "Berikut ini termasuk dalam penerapan dari nilai Outstanding Service kecuali",
		"jawab" => array(
			"a" => "Bersikap proaktif dalam memberikan pelayanan prima kepada pengguna jasa bandara.",
			"b" => "Selalu melihat dari sudut pandang konsumen dalam segala tindakan.",
			"c" => "Selalu berusaha untuk memberikan pelayanan melebihi harapan pelanggan.",
			"d" => "Menyediakan fasilitas dan pelayanan yang handal termasuk penyelesaian masalah yang menjadi keluhan pengguna jasa bandara.",
		)
	),
	15 => array(
		"no" => 16,
		"nama" => "Seorang karyawan yang hanya menerima pendapat yang diberikan oleh seseorang yang kedudukannya lebih tinggi maka karyawan tersebut tidak menerapkan nilai",
		"jawab" => array(
			"a" => "<i>Outstanding Service</i>",
			"b" => "<i>Respectful</i>",
			"c" => "<i>Responsible</i>",
			"d" => "<i>Focused</i>",
		)
	),
	16 => array(
		"no" => 17,
		"nama" => "Berikut ini yang merupakan contoh penerapan nilai <i>Respectful</i> adalah",
		"jawab" => array(
			"a" => "Memberikan kesempatan karir yang sama kepada seluruh karyawan.",
			"b" => "Memberikan apresiasi sesuai dengan kontribusi dan pencapaian masing-masing karyawan.",
			"c" => "Menerima kritik pelanggan untuk perbaikan.",
			"d" => "Mempromosikan kesenian dan budaya Indonesia secara periodik pada layanan ataupun produk perusahaan.",
		)
	),
	17 => array(
		"no" => 18,
		"nama" => "Berikut ini yang bukan termasuk dalam penerapan dari nilai <i>Respectful</i> adalah",
		"jawab" => array(
			"a" => "Karyawan saling menghargai yang diwarnai oleh komunikasi yang tulus.",
			"b" => "Karyawan mampu berempati dan melihat dari sudut pandang orang lain.",
			"c" => "Karyawan melakukan tindakan preventif terkait keamanan dan keselamatan penerbangan.",
			"d" => "Karyawan menghargai perbedaan pendapat, peran, dan kontribusi dengan mengutamakan kepentingan bersama.",
		)
	),
	18 => array(
		"no" => 19,
		"nama" => "Pimpinan memberikan apresiasi sesuai dengan kontribusi dan pencapaian karyawan secara adil, hal ini termasuk dalam penerapan nilai",
		"jawab" => array(
			"a" => "<i>Respectful</i>",
			"b" => "<i>Responsible</i>",
			"c" => "<i>Outstanding service</i>",
			"d" => "<i>Meritocratic</i>",
		)
	),
	19 => array(
		"no" => 20,
		"nama" => "Berikut ini yang bukan termasuk dalam contoh perilaku nilai <i>Meritocratic</i> adalah",
		"jawab" => array(
			"a" => "Seseorang mendapatkan apresiasi atas pencapaian kinerjanya yang baik di perusahaan.",
			"b" => "Perusahaan memberikan penghargaan atas kontribusi mitra kerja dan usaha.",
			"c" => "Pimpinan memberikan kesempatan karir yang tinggi untuk seluruh karyawan.",
			"d" => "Pimpinan yang menghargai perbedaan pendapat, peran dan kontribusi karyawannya untuk kepentingan bersama.",
		)
	),
	20 => array(
		"no" => 21,
		"nama" => "Pimpinan memberikan penghargaan yang bertujuan agar karyawan menjadi senang, giat, semangat dan lebih rajin dalam bekerja termasuk dalam penerapan perilaku utama dalam <i>Meritocratic</i> yakni",
		"jawab" => array(
			"a" => "Peduli",
			"b" => "Apresiasi",
			"c" => "Pengakuan",
			"d" => "Keadilan",
		)
	)
);

$soal3 = array(
	0 => array(
		"no" => 1,
		"nama" => "Pimpinan saya mampu mengarahkan bawahannya untuk memberikan kemampuan terbaik dalam menyelesaikan pekerjaan",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	1 => array(
		"no" => 2,
		"nama" => "Pimpinan saya melakukan coaching dan mentoring untuk meningkatkan kompetensi karyawan dalam menyelesaikan pekerjaan.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	2 => array(
		"no" => 3,
		"nama" => "Coaching dan mentoring dari pimpinan belum berjalan maksimal untuk pengembangan karyawan.",
		"status" => "min",
		"jawab" => array(
			6 => "Sangat Tidak Setuju",
			5 => "Tidak Setuju",
			4 => "Cenderung Tidak Setuju",
			3 => "Cenderung Setuju",
			2 => "Setuju",
			1 => "Sangat Setuju"
		)
	),
	3 => array(
		"no" => 4,
		"nama" => "Pimpinan saya memberikan apresiasi kepada bawahannya yang berprestasi secara adil dan terbuka.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	4 => array(
		"no" => 5,
		"nama" => "Pimpinan saya bersifat pasif dan cenderung hanya menyelesaikan pekerjaan rutinitas sehari - hari.",
		"status" => "min",
		"jawab" => array(
			6 => "Sangat Tidak Setuju",
			5 => "Tidak Setuju",
			4 => "Cenderung Tidak Setuju",
			3 => "Cenderung Setuju",
			2 => "Setuju",
			1 => "Sangat Setuju"
		)
	),
	5 => array(
		"no" => 6,
		"nama" => "Dalam keseharian pimpinan menunjukkan semangat kerja yang tinggi untuk pencapaian prestasi yang dapat ditiru oleh bawahannya.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	6 => array(
		"no" => 7,
		"nama" => "Pimpinan saya mendorong dan memotivasi karyawannya untuk terus belajar dan berkembang.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	7 => array(
		"no" => 8,
		"nama" => "Ide dan masukan dari pimpinan dapat menginspirasi karyawan untuk melakukan pekerjaan dengan sebaik-baiknya.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	8 => array(
		"no" => 9,
		"nama" => "Pimpinan saya tidak terlalu memikirkan tentang pengembangan kompetensi karyawan.",
		"status" => "min",
		"jawab" => array(
			6 => "Sangat Tidak Setuju",
			5 => "Tidak Setuju",
			4 => "Cenderung Tidak Setuju",
			3 => "Cenderung Setuju",
			2 => "Setuju",
			1 => "Sangat Setuju"
		)
	),
	9 => array(
		"no" => 10,
		"nama" => "Pimpinan saya memiliki keinginan untuk terus belajar dan siap menghadapi berbagai perubahan di dunia bisnis.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	10 => array(
		"no" => 11,
		"nama" => "Pimpinan saya memiliki pola pikir yang melihat kepada standar perusahaan kelas dunia sebagai dasar untuk mencapai kualitas kerja terbaik.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	11 => array(
		"no" => 12,
		"nama" => "Pimpinan saya belum siap untuk menghadapi berbagai perubahan yang ada di dunia bisnis.",
		"status" => "min",
		"jawab" => array(
			6 => "Sangat Tidak Setuju",
			5 => "Tidak Setuju",
			4 => "Cenderung Tidak Setuju",
			3 => "Cenderung Setuju",
			2 => "Setuju",
			1 => "Sangat Setuju"
		)
	),
	12 => array(
		"no" => 13,
		"nama" => "Pimpinan saya memiliki orientasi untuk melakukan inovasi untuk perbaikan perusahaan ke depan.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	13 => array(
		"no" => 14,
		"nama" => "Pimpinan saya mempunyai ide untuk penyelesaian tugas agar lebih efektif dan efesien dari yang sudah ada sebelumnya.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	14 => array(
		"no" => 15,
		"nama" => "Pimpinan saya cenderung melaksanakan pekerjaan sesuai dengan prosedur yang sudah ada tanpa memikirkan inovasi untuk perbaikan perusahaan.",
		"status" => "min",
		"jawab" => array(
			6 => "Sangat Tidak Setuju",
			5 => "Tidak Setuju",
			4 => "Cenderung Tidak Setuju",
			3 => "Cenderung Setuju",
			2 => "Setuju",
			1 => "Sangat Setuju"
		)
	),
	15 => array(
		"no" => 16,
		"nama" => "Pimpinan saya memiliki pemahaman teknis yang baik, sehingga dapat mengambil keputusan dengan tepat.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
	16 => array(
		"no" => 17,
		"nama" => "Pimpinan saya tidak terlalu menguasai kondisi teknis pekerjaan di lapangan, sehingga belum dapat memberikan solusi yang tepat jika terjadi masalah.",
		"status" => "min",
		"jawab" => array(
			6 => "Sangat Tidak Setuju",
			5 => "Tidak Setuju",
			4 => "Cenderung Tidak Setuju",
			3 => "Cenderung Setuju",
			2 => "Setuju",
			1 => "Sangat Setuju"
		)
	),
	17 => array(
		"no" => 18,
		"nama" => "Dengan kemampuan teknis yang baik, pimpinan saya dapat berkontribusi secara aktif pada tugas dan tanggung jawabnya.",
		"status" => "plus",
		"jawab" => array(
			1 => "Sangat Tidak Setuju",
			2 => "Tidak Setuju",
			3 => "Cenderung Tidak Setuju",
			4 => "Cenderung Setuju",
			5 => "Setuju",
			6 => "Sangat Setuju"
		)
	),
);

$result = array(1 => $soal1,2 => $soal2,3 => $soal3);	
return $result[$x];
}

function soalBRI() {
$soal = array(
	0 => array(
		"no" => 1,
		"nama" => "Saya mengetahui siapa yang menjadi Change Agent di unit kerja saya",
		"jawab" => array(
			"1" => "Sangat Tidak Setuju",
			"2" => "Tidak Setuju",
			"3" => "Setuju",
			"4" => "Sangat Setuju",
		)
	),
	1 => array(
		"no" => 2,
		"nama" => "Change Agent di unit kerja saya sudah menjalankan nilai-nilai Budaya Kerja BRI dan menjadi role model",
		"jawab" => array(
			"1" => "Sangat Tidak Setuju",
			"2" => "Tidak Setuju",
			"3" => "Setuju",
			"4" => "Sangat Setuju",
		)
	),
	2 => array(
		"no" => 3,
		"nama" => "Change Agent di unit kerja saya aktif dalam mendukung program Budaya Kerja BRI (seperti : BRI Excellence Award, lomba-lomba Budaya Kerja, dll)",
		"jawab" => array(
			"1" => "Sangat Tidak Setuju",
			"2" => "Tidak Setuju",
			"3" => "Setuju",
			"4" => "Sangat Setuju",
		)
	),
	3 => array(
		"no" => 4,
		"nama" => "Change Agent di unit kerja saya menjunjung tinggi nilai-nilai Good Corporate Governance (GCG) dan menghindari konflik kepentingan",
		"jawab" => array(
			"1" => "Sangat Tidak Setuju",
			"2" => "Tidak Setuju",
			"3" => "Setuju",
			"4" => "Sangat Setuju",
		)
	),
	4 => array(
		"no" => 5,
		"nama" => "Change Agent di unit kerja saya merupakan orang  yang mampu memotivasi tim atau rekan-rekan di unit kerjanya",
		"jawab" => array(
			"1" => "Sangat Tidak Setuju",
			"2" => "Tidak Setuju",
			"3" => "Setuju",
			"4" => "Sangat Setuju",
		)
	),
);
return $soal;	
}
?>
