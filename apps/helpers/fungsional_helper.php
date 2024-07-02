<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function get_event_demograp($code)
{
	$ci = &get_instance();
	$param = array('f_code' => $code);
	$sql = $ci->db->select('f_code,f_text', false)->where($param)->get('temp_demograp');
	if ($sql->num_rows() > 0)
		return $sql->row();
	else
		return FALSE;
}

function menu_list($id = null)
{
	$ci = &get_instance();
	$ci->db->join('t_role_module b', 'b.f_module_id=a.f_module_id');
	$menu = $ci->db->get_where('t_module a', array('a.f_module_active' => 1, 'b.f_role_id' => $id));

	$result = array();
	$result1 = array();
	$result2 = array();
	if ($menu->num_rows() > 0) {
		foreach ($menu->result_array() as $k => $v) :
			$result1[$v['f_module_level']][$v['f_module_parent']][$v['f_module_id']] = array(
				'code' => $v['f_module_class'], 'name' => $v['f_module_name'],
				'icon' => $v['f_module_icon'], 'parent' => $v['f_module_parent'],
				'urut' => $v['f_module_urut'],
			);
		endforeach;

		foreach ($menu->result_array() as $k => $v) :
			$result2[$v['f_module_level']][$v['f_module_parent']][] = $v['f_module_class'];
		endforeach;

		$result['r1'] = $result1;
		$result['r2'] = $result2;
	}

	//	echo "<pre>";echo print_r($result1)."</pre><br/>";
	$html = "";
	foreach (array_sort($result1[0][0], 'urut', SORT_ASC) as $a => $b) :
		$href = ($b['code'] != '') ? site_url($b['code']) : "javascript:void(0)";
		$html .= "<li class=\"treeview " . menu($result2[1][$a], 1) . "\"><a href=\"" . $href . "\"><i class=\"" . $b['icon'] . "\"></i><span>" . $b['name'] . "</span>";
		// Cek level 1
		if (is_array($result1[1][$a]) == 1) {
			$html .= "<i class=\"fa fa-angle-left pull-right\"></i></a><ul class=\"treeview-menu\">";
			foreach (array_sort($result1[1][$a], 'urut', SORT_ASC) as $c => $d) :
				$href1 = ($d['code']) ? site_url($d['code']) : "javascript:void(0)";
				if (is_array($result1[2][$c]) == 1) {
					$active_in = menu($result2[1][$c], 1);
				} else {
					if ($ci->uri->segment(1) == $d['code']) $active_in = 'active';
					else $active_in = '';
				}

				$html .= "<li class=\"treeview " . $active_in . "\"><a href=\"" . $href1 . "\"><i class=\"" . $d['icon'] . "\"></i><span>" . $d['name'] . "</span>";
				// Cek Level 2
				if (is_array($result1[2][$c]) == 1) {
					$html .= "<i class=\"fa fa-angle-left pull-right\"></i></a><ul class=\"treeview-menu\">";
					foreach (array_sort($result1[2][$c], 'urut', SORT_ASC) as $e => $f) :
						$href2 = ($f['code']) ? site_url($f['code']) : "javascript:void(0)";
						if (is_array($result1[3][$c]) == 1) {
							$active_in1 = menu($result2[1][$e], 1);
						} else {
							if ($ci->uri->segment(1) == $f['code']) $active_in1 = 'active';
							else $active_in1 = '';
						}

						$html .= "<li class=\"treeview " . $active_in1 . "\"><a href=\"" . $href2 . "\"><i class=\"" . $f['icon'] . "\"></i><span>" . $f['name'] . "</span>";
						// Cek Level 3
						if (is_array($result1[3][$e]) == 1) {
							$html .= "<i class=\"fa fa-angle-left pull-right\"></i></a><ul class=\"treeview-menu\">";
							foreach (array_sort($result1[3][$e], 'urut', SORT_ASC) as $g => $h) :
								if ($ci->uri->segment(1) == $h['code']) $active_in2 = 'active';
								else $active_in2 = '';
								$href3 = ($h['code']) ? site_url($h['code']) : "javascript:void(0)";
								$html .= "<li class=\"treeview " . $active_in2 . "\"><a href=\"" . $href3 . "\"><i class=\"" . $h['icon'] . "\"></i><span>" . $h['name'] . "</span></a></li>";
							endforeach;
							$html .= "</ul>";
						} else {
							$html .= "</a>";
						}
						$html .= "</li>";
					endforeach;
					$html .= "</ul>";
				} else {
					$html .= "</a>";
				}
				$html .= "</li>";
			endforeach;
			$html .= "</ul>";
		} else {
			$html .= "</a>";
		}
		$html .= "</li>";
	endforeach;

	return $html;
}

function menu($d = array(), $u)
{
	$ci = &get_instance();
	if (in_array($ci->uri->segment($u), $d, true)) return 'active';
}

function submenu($d = null, $u)
{
	$ci = &get_instance();
	if ($ci->uri->segment($u) == $d) return 'class="active"';
}

function menu1($d = array(), $u, $uri1)
{
	$ci = &get_instance();
	if (in_array($ci->uri->segment($u), $d, true)  && $ci->uri->segment(1) == $uri1) return 'active';
}

function submenu1($d = null, $u, $uri1)
{
	$ci = &get_instance();
	if ($ci->uri->segment($u) == $d && $ci->uri->segment(1) == $uri1) return 'class="active"';
}

function stand_deviation($arr)
{
	$mean = array_sum($arr) / count($arr);

	// 2. Hitung selisih dan kuadratkan
	$differencesSquared = array_map(
		function ($value) use ($mean) {
			return pow($value - $mean, 2);
		},
		$arr
	);

	// 3. Hitung jumlah total selisih kuadrat
	$sumOfDifferencesSquared = array_sum($differencesSquared);

	// 4. Hitung variansi dengan faktor pembagi n-1
	$variance = $sumOfDifferencesSquared / (count($arr) - 1);

	// 5. Hitung akar kuadrat dari variansi
	$standardDeviation = sqrt($variance);

	return $standardDeviation;
}

function code_act()
{
	$ci = &get_instance();
	$yearmonth = date('Ym');
	//$ci->db->select('f_cfl_activity_no',false);
	$ci->db->select('ifnull(max(cast(substr(f_cfl_activity_no, 8, 5) AS UNSIGNED))+1, 1)  as f_next_number', false);
	$ci->db->where('EXTRACT(year_month from f_created_on)=', $yearmonth);
	//$ci->db->order_by('f_cfl_activity_no','desc');
	//$ci->db->order_by('f_created_on','desc');
	$sql = $ci->db->get('t_cfl_activity');
	if ($sql->num_rows() > 0) {
		$r = $sql->row();
		//$no = intval(substr($r->f_cfl_activity_no,7,5)) + 1;
		$no = $r->f_next_number;
		if ($no > 0 && $no < 10)
			$return = '0000' . $no;
		elseif ($no >= 10 && $no < 100)
			$return = '000' . $no;
		elseif ($no >= 100 && $no < 1000)
			$return = '00' . $no;
		elseif ($no >= 1000 && $no < 10000)
			$return = '0' . $no;
		else
			$return = $no;

		return 'ACT' . date('ym') . $return;
	} else {
		return 'ACT' . date('ym') . '00001';
	}
}

function code_purchase()
{
	$ci = &get_instance();
	$yearmonth = date('Ym');
	$ci->db->select('substr(f_purchase_no,7,6) as f_purchase_no', false);
	$ci->db->where('EXTRACT(year_month from f_created_on)=', $yearmonth);
	$ci->db->order_by('f_created_on', 'desc');
	$ci->db->order_by('f_purchase_no', 'desc');
	$sql = $ci->db->get('t_purchase');
	if ($sql->num_rows() > 0) {
		$r = $sql->row();
		$no = intval($r->f_purchase_no) + 1;
		if ($no > 0 && $no < 10)
			$return = '0000' . $no;
		elseif ($no >= 10 && $no < 100)
			$return = '000' . $no;
		elseif ($no >= 100 && $no < 1000)
			$return = '00' . $no;
		elseif ($no >= 1000 && $no < 10000)
			$return = '0' . $no;
		else
			$return = $no;

		return 'PO' . date('ym') . $return;
	} else {
		return 'PO' . date('ym') . '00001';
	}
}

// Jika Action Plan tidak ada maka akan muncul
function btn_visit_spontan($id)
{
	//SELECT f_cfl_activity_id FROM `t_cfl_activity` where f_cfl_id=5 and f_cfl_status is null
	$ci = &get_instance();
	$ci->db->where('f_cfl_id', $id);
	$ci->db->where('f_cfl_status is null');
	$sql = $ci->db->get('t_cfl_activity');
	if ($sql->num_rows() > 0) {
		return "";
	} else {
		return "<a href=\"" . site_url('listfile/activity/fnActivityVisitS') . "\"class=\"btn btn-sm btn-warning\"><i class=\"fa fa-plus\"></i> Tambah</a>";
	}
}

function array_sort($array, $on, $order = SORT_ASC)
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

function my_array_merge($array1, $array2)
{
	$result = array();
	foreach ($array1 as $key => $value) {
		$result[$key] = array_merge($value, $array2[$key]);
	}
	return $result;
}

function seo_title($s)
{
	$c = array(' ');
	$d = array('-', '/', '\\', ',', '.', '#', ':', ';', '\'', '"', '[', ']', '{', '}', ')', '(', '|', '`', '~', '!', '@', '%', '$', '^', '&', '*', '=', '?', '+');

	$s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d

	$s = strtolower(str_replace($c, '-', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
	return $s;
}

function tgl_indo($tgl)
{
	$tanggal = substr($tgl, 8, 2);
	$bulan = getBulan(substr($tgl, 5, 2));
	$tahun = substr($tgl, 0, 4);
	return $tanggal . ' ' . $bulan . ' ' . $tahun;
}

function tgl_indo1($tgl)
{
	$tanggal = substr($tgl, 8, 2);
	$bulan = substr($tgl, 5, 2);
	$tahun = substr($tgl, 0, 4);
	return $tanggal . '-' . $bulan . '-' . $tahun;
}

function getBulan($bln)
{
	switch ($bln) {
		case 1:
			return "Januari";
			break;
		case 2:
			return "Februari";
			break;
		case 3:
			return "Maret";
			break;
		case 4:
			return "April";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Juni";
			break;
		case 7:
			return "Juli";
			break;
		case 8:
			return "Agustus";
			break;
		case 9:
			return "September";
			break;
		case 10:
			return "Oktober";
			break;
		case 11:
			return "November";
			break;
		case 12:
			return "Desember";
			break;
	}
}

function tahun_list($kosong = 0, $dari = -10, $sampai = 1)
{
	$CI = &get_instance();
	$CI->lang->load('calendar');

	if ($kosong) $result[0] = 'Semua tahun';

	$y = date("Y");
	for ($i = $dari; $i <= $sampai; $i++) {
		$result[$y + $i] = $y + $i;
	}

	return $result;
}

function bulan_list($kosong = 0)
{
	$CI = &get_instance();
	$CI->lang->load('calendar');

	if ($kosong) $result[0] = 'Semua bulan';
	$result['1']	= $CI->lang->line('cal_january');
	$result['2']	= $CI->lang->line('cal_february');
	$result['3']	= $CI->lang->line('cal_march');
	$result['4']	= $CI->lang->line('cal_april');
	$result['5']	= $CI->lang->line('cal_may');
	$result['6']	= $CI->lang->line('cal_june');
	$result['7']	= $CI->lang->line('cal_july');
	$result['8']	= $CI->lang->line('cal_august');
	$result['9']	= $CI->lang->line('cal_september');
	$result['10']	= $CI->lang->line('cal_october');
	$result['11']	= $CI->lang->line('cal_november');
	$result['12']	= $CI->lang->line('cal_december');

	return $result;
}

function format_tanggal_order($val)
{
	$tahun	= substr($val, 0, 4);
	$bulan	= substr($val, 5, 2);
	$tgl	= substr($val, 8, 2);
	$combine = $tgl . "/" . $bulan . "/" . $tahun;
	return $combine;
}

function decimal_report($angka, $koma = 0)
{
	$nomor = number_format(round($angka, $koma), $koma, ".", ",");
	return $nomor;
}

function formatMoney($number, $fractional = TRUE)
{
	if ($fractional) {
		$number = sprintf('%.0f', $number);
	}
	while (true) {
		$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
		if ($replaced != $number) {
			$number = $replaced;
		} else {
			break;
		}
	}
	return $number;
}

function cek_pesan()
{
	$ci = &get_instance();
	$ci->db->select('a.f_cfl_id,f_account_name,f_training_category, b.f_ctl_comment_id, b.f_ctl_comment_text, date_format(b.f_ctl_comment_date,"%d %b %Y %H:%i") waktu, b.f_ctl_comment_read, (select f_user_name from t_user where f_user_id=b.f_ctl_comment_cro) cro', false);
	if ($ci->session->userdata('sLevel') == 3) $ci->db->where('a.f_cfl_cro_id', $ci->session->userdata('sId'));
	if ($ci->session->userdata('member')) $ci->db->or_where_in('a.f_cfl_cro_id', $ci->session->userdata('member'));
	$ci->db->not_like('b.f_ctl_comment_read', '#' . $ci->session->userdata('sId') . '#');
	$ci->db->join('t_cfl_comment b', 'b.f_ctl_id=a.f_cfl_id');
	$ci->db->join('t_accounts c', 'c.f_account_id=a.f_account_id');
	$ci->db->join('t_training_category d', 'd.f_training_category_id=a.f_training_category_id', 'left');
	$ci->db->order_by('b.f_ctl_comment_date', 'desc');
	$sql = $ci->db->get('t_cfl_master a');
	//echo $ci->db->last_query();
	if ($sql->num_rows() > 0) {
		$html = "<li class=\"dropdown messages-menu\">
					<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
						<i class=\"fa fa-envelope-o\"></i>
						<span class=\"label label-warning\">" . $sql->num_rows() . "</span>
					</a>
					<ul class=\"dropdown-menu\">
						<li class=\"header\">Kamu punya " . $sql->num_rows() . " Pesan</li>
						<li>
							<!-- inner menu: contains the actual data -->
							<ul class=\"menu\">";

		foreach ($sql->result() as $a) {
			$html .= "<li id=\"listpesan" . $a->f_ctl_comment_id . "\"><!-- start message -->
						<a href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"" . $a->f_account_name . " - " . $a->f_training_category . "\" data-placement=\"bottom\" onClick=\"viewPesan(" . $a->f_cfl_id . "," . $a->f_ctl_comment_id . ")\">
							<div class=\"pull-right\">
								<small><i class=\"fa fa-clock-o\"></i> " . $a->waktu . "</small>
							</div>											
							<h5>
								" . $a->cro . "
							</h5>
							<p>" . $a->f_ctl_comment_text . "</p>
						</a>
						<a href=\"#\" class=\"btn btn-default btn-xs\" onClick=\"hapusPesan(" . $a->f_ctl_comment_id . ")\">Tandai sudah baca</a>
						<br/>
					</li> <!-- end message -->";
		}

		$html .= "	</ul>
				</li>";
		$html .= "	</ul>
				</li>";
		return $html;
	} else {
		return FALSE;
	}
}

function comboDataUser()
{
	$ci = &get_instance();
	$sql = $ci->db->get('t_user');
	if ($sql) {
		foreach ($sql->result() as $r) :
			$list[$r->f_user_id] = $r->f_user_name;
		endforeach;
	}
	return $list;
}

function opn($x)
{
	echo "<pre>";
	echo print_r($x) . "</pre><br/>";
}

function getStatusColorSkorEngage($x)
{
	// 006600 (HIJAU) 91-100
	// ffff00 (KUNING) 61-90
	// ff6600 (ORANGE) 31-60
	// d60000 (MERAH) 0-30
	$list = array('status' => 'Actively', 'color' => '#d60000', 'fcolor' => '#ffffff');
	if ($x > 90)
		$list = array('status' => 'Highly', 'color' => '#006600', 'fcolor' => '#ffffff');
	elseif ($x > 60 && $x < 91)
		$list = array('status' => 'Moderately', 'color' => '#ffff00', 'fcolor' => '#000');
	elseif ($x > 30 && $x < 61)
		$list = array('status' => 'Passive', 'color' => '#ff6600', 'fcolor' => '#ffffff');

	return $list;
}

function generateCode($characters)
{
	/* list all possible characters, similar looking characters and vowels have been removed */
	$possible = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$code = '';
	$i = 0;
	while ($i < $characters) {
		$code .= substr($possible, mt_rand(0, strlen($possible) - 1), 1);
		$i++;
	}
	return $code;
}

function force_download_delete($filename = '', $data = '', $set_mime = FALSE)
{
	if ($filename === '' or $data === '') {
		return;
	} elseif ($data === NULL) {
		if (!@is_file($filename) or ($filesize = @filesize($filename)) === FALSE) {
			return;
		}

		$filepath = $filename;
		$filename = explode('/', str_replace('/', '/', $filename));
		$filename = end($filename);
	} else {
		$filesize = strlen($data);
	}

	// Set the default MIME type to send
	$mime = 'application/octet-stream';

	$x = explode('.', $filename);
	$extension = end($x);

	if ($set_mime === TRUE) {
		if (count($x) === 1 or $extension === '') {
			/* If we're going to detect the MIME type,
			 * we'll need a file extension.
			 */
			return;
		}

		// Load the mime types
		$mimes = &get_mimes();

		// Only change the default MIME if we can find one
		if (isset($mimes[$extension])) {
			$mime = is_array($mimes[$extension]) ? $mimes[$extension][0] : $mimes[$extension];
		}
	}

	/* It was reported that browsers on Android 2.1 (and possibly older as well)
	 * need to have the filename extension upper-cased in order to be able to
	 * download it.
	 *
	 * Reference: http://digiblog.de/2011/04/19/android-and-the-download-file-headers/
	 */
	if (count($x) !== 1 && isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/Android\s(1|2\.[01])/', $_SERVER['HTTP_USER_AGENT'])) {
		$x[count($x) - 1] = strtoupper($extension);
		$filename = implode('.', $x);
	}

	if ($data === NULL && ($fp = @fopen($filepath, 'rb')) === FALSE) {
		return;
	}

	// Clean output buffer
	if (ob_get_level() !== 0 && @ob_end_clean() === FALSE) {
		@ob_clean();
	}

	// Generate the server headers
	header('Content-Type: ' . $mime);
	header('Content-Disposition: attachment; filename="' . $filename . '"');
	header('Expires: 0');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: ' . $filesize);
	header('Cache-Control: private, no-transform, no-store, must-revalidate');

	// If we have raw data - just dump it
	if ($data !== NULL) {
		exit($data);
	}

	// Flush 1MB chunks of data
	while (!feof($fp) && ($data = fread($fp, 1048576)) !== FALSE) {
		echo $data;
	}

	fclose($fp);
	unlink($filename);
	exit;
}
