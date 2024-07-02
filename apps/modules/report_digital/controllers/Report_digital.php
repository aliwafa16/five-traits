<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
//require_once APPPATH.'third_party/Phpoffice/vendor/autoload.php';
//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//error_reporting(-1);
//ini_set('display_errors', 1);

class Report_digital extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$this->load->model('mo_report_digital');
		$this->load->model('mo_c');
		$this->load->helper('survey_helper');
	}

	public function index()
	{
		$data = array(
			'app_title' => 'Data Reports Digital Experience',
			'app_desc' => 'it all Reports'
		);
		$idAccount = sAccount;
		$search_account 			= $this->mo_report_digital->fnGetDataAccount();
		$listdemo 			= $this->mo_c->listDemo($idAccount);
		$event_account		= $this->mo_report_digital->comboDataEvent();
		$data['listdemo'] 	= $listdemo;
		// if ($listdemo['f_region'] == 1)	$data['region'] 	= $this->mo_c->comboDataRegion($idAccount);
		// if ($listdemo['f_level1'] == 1)	$data['cLevel1'] 	= $this->mo_c->comboDataLevelofposition1($idAccount);
		// if ($listdemo['f_level_of_work'] == 1)	$data['level_of_work'] 	= $this->mo_c->comboDataLevelofwork($idAccount);
		// if ($listdemo['f_masakerja'] == 1)	$data['masakerja'] 	= $this->mo_c->comboDataLengthofservice($idAccount);
		// if ($listdemo['f_gender'] == 1)	$data['gender'] 	= $this->mo_c->comboDataGender($idAccount);
		// if ($listdemo['f_age'] == 1)		$data['age_ar'] 	= $this->mo_c->comboDataAge($idAccount);
		// if ($listdemo['f_pendidikan'] == 1)	$data['pendidikan'] 	= $this->mo_c->comboDataEducation($idAccount);
		//$vars['clabel'] = $this->costumlabel( sAccount );

		$data['set_demo'] 		= $search_account;
		$data['event_account'] 	= $event_account;
		$data['side_main']	= 'report_digital';
		$data['content']	= 'vw_reports';
		$this->load->view('admin/main', $data);
	}

	public function fnReportsData()
	{
		//$data['content']	= 'vw_reports_data';
		$vars['ourSystem'] = 'ACT Consulting';
		$vars['ourSystem'] = 'ACT Consulting';
		$accountId 		= sAccount;
		$paramAccount	= array('f_account_id' => $accountId);
		$paramValid		= array('f_survey_valid' => 'yes');
		$eventId		= $this->input->get_post('event_account');

		/*---------- Informasi Account ----------*/
		$account = $this->db->where($paramAccount)->get('t_account')->row_array();
		$vars['namaAccount'] 	= $account['f_account_name'];

		/*---------- Data Search Responden ----------*/
		$paramGroup = array();	// Group yang difilter
		$paramGroupIn = array();	// Group In yang difilter
		$namaGroup = '';		// Nama Pencarian
		$IDLeader = false;

		if ($this->input->get_post('gender')) // cek Jenis Kelamin
		{
			$paramGroup['f_gender'] = $this->input->get_post('gender');
			$name = $this->db->select('f_gender_name')->where('f_gender_code', $this->input->get_post('gender'))->get('t_gender')->row_array();
			$namaGroup .= $name['f_gender_name'] . ',';
		}
		if ($this->input->get_post('age')) // cek usia
		{
			//$paramGroup['f_age'] = $this->input->get_post('age');
			$paramGroupIn['f_age'] = $this->input->get_post('age');
			$namaGroup .= $this->input->post('age_name') . ',';
		}

		if ($this->input->get_post('masakerja')) // cek masa kerja
		{
			$paramGroup['f_length_of_service'] = $this->input->get_post('masakerja');
			$namaGroup .= $this->input->post('masakerja_name') . ',';
		}

		if ($this->input->get_post('region'))	// cek region
		{
			$paramGroupIn['f_region'] = $this->input->get_post('region');
			//$regions = $this->db->select('group_concat(f_region_name) as region',false)->where_in('f_id',$paramGroupIn['f_region'])->get('table_region')->row_array();
			$namaGroup .= $this->input->post('region_name') . ',';
			//$namaGroup .= $regions['region'].',';
		}

		if ($this->input->get_post('level_of_work')) {
			//$paramGroup['f_level_of_work'] = $this->input->get_post('level_of_work');
			$paramGroupIn['f_level_of_work'] = $this->input->get_post('level_of_work');
			//$name = $this->db->select('f_levelwork_desc')->where('f_id',$this->input->get_post('level_of_work'))->get('table_level_work')->row_array();
			$namaGroup .= $this->input->post('level_of_work_name') . ',';
			//$namaGroup .= $name['f_levelwork_desc'].',';
		}

		if ($this->input->get_post('level1')) {
			$paramGroupIn['f_level1'] = $this->input->get_post('level1');
			//$name = $this->db->select('f_position_desc')->where('f_id',$this->input->get_post('level1'))->get('table_level_position1')->row_array();
			//$namaGroup .= $name['f_position_desc'].',';
			$namaGroup .= $this->input->get_post('level1_name') . ',';
		}

		if ($this->input->get_post('level2')) {
			$paramGroupIn['f_level2'] = $this->input->get_post('level2');
			//$name = $this->db->select('f_position_desc')->where('f_id',$this->input->get_post('level2'))->get('table_level_position2')->row_array();
			//$namaGroup .= $name['f_position_desc'].',';
			$namaGroup .= $this->input->get_post('level2_name') . ',';
		}

		if ($this->input->get_post('level3')) {
			$paramGroupIn['f_level3'] = $this->input->get_post('level3');
			//$name = $this->db->select('f_position_desc')->where('f_id',$this->input->get_post('level3'))->get('table_level_position3')->row_array();
			//$namaGroup .= $name['f_position_desc'].',';
			$namaGroup .= $this->input->get_post('level3_name') . ',';
		}

		if ($this->input->get_post('level4'))	// cek level 4
		{
			$paramGroupIn['f_level4'] = $this->input->get_post('level4');
			//$name = $this->db->select('f_position_desc')->where('f_id',$this->input->get_post('level4'))->get('table_level_position4')->row_array();
			$namaGroup .= $this->input->get_post('level4_name') . ',';
		}

		if ($this->input->get_post('level5'))	// cek level 5
		{
			$paramGroup['f_level5'] = $this->input->get_post('level5');
			//$name = $this->db->select('f_position_desc')->where('f_id',$this->input->get_post('level5'))->get('table_level_position5')->row_array();
			$namaGroup .= $this->input->get_post('level5_name') . ',';
		}

		if ($this->input->get_post('level6'))	// cek level 6
		{
			$paramGroup['f_level6'] = $this->input->get_post('level6');
			//$name = $this->db->select('f_position_desc')->where('f_id',$this->input->get_post('level6'))->get('table_level_position6')->row_array();
			$namaGroup .= $this->input->get_post('level6_name') . ',';
		}

		if ($this->input->get_post('level7'))	// cek level 7
		{
			$paramGroup['f_level7'] = $this->input->get_post('level7');
			//$name = $this->db->select('f_position_desc')->where('f_id',$this->input->get_post('level7'))->get('table_level_position7')->row_array();
			$namaGroup .= $this->input->get_post('level7_name') . ',';
		}

		//$countlabel = count($vars['clabel']);
		//if($countlabel > 0)		// cek customfield
		//{
		//for($i=1;$i<=$countlabel;$i++)
		//{
		//if($this->input->post('f_custom'.$i))
		//{
		////$paramGroup['f_custom'.$i] = $this->input->get_post('f_custom'.$i);
		////$namaGroup .= $this->input->get_post('f_custom'.$i.'_name').',';
		//$paramGroupIn['f_custom'.$i] = $this->input->get_post('f_custom'.$i);
		//$namaGroup .= $this->input->get_post('f_custom'.$i.'_name').',';
		//}
		//}
		//}

		$vars['namaGroup'] = trim($namaGroup, ',');

		//opn($paramGroup);die();
		/*---------- Data Responden ----------*/
		$data_survey			= $this->mo_report_digital->getTrxSurvey($eventId, $paramGroup, null);

		/*---------- Data Category ----------*/
		$variabel 				= $this->mo_report_digital->getVariabel();
		//$dimensi 				= $this->mo_report_digital->getDimensi();
		$about_item				= $this->mo_report_digital->getItem();
		//opn($about_item);

		//opn($data_survey);
		$paramGroupLeader = null;
		//opn($data_leader);
		//exit();

		/*---------- Total Responden ----------*/
		$totalResponden = count($data_survey);
		$vars['totalResponden'] = $totalResponden;
		$vars['variabel'] = $variabel;
		//$vars['dimensi'] = $dimensi;
		$vars['item'] = $about_item;

		/*---------- Data Survey ----------*/
		$sr_result = $this->mo_report_digital->fnSurveyTotal($data_survey, $about_item);
		//$sumprio = $this->mo_report_digital->olahDataSummaryQuesioner($data_survey,$variabel,$dimensi,$about_item,$totalResponden);
		$vars['sr_result'] = $sr_result;
		//$vars['sumprio'] = $sumprio;
		//opn($sr_result);die();

		$colorAll = array(0 => '#FF0000', 1 => '#FFB700', 2 => '#F2FF00', 3 => '#B3FF00', 4 => '#15C100', 5 => '#0057C1');
		$h = 0;
		for ($i = 1; $i <= 6; $i++) {
			$gsc[$h]['y'] = $sr_result['persen_scale'][$i];
			$gsc[$h]['color'] = $colorAll[$h];
			$h++;
		}

		$vars['reportAll'] = array(array('name' => 'Grafik Skala Distribusi', 'data' => $gsc));
		//$total_all = 0;
		//foreach($sr_kategori as $r) { $total_all += $r['total'];}
		//opn($total_all);
		//opn($vars);
		//die();
		//$vars['total_all'] = $total_all;
		$this->load->view('vw_reports_data', $vars);
	}

	function compCategory()
	{
		$this->db->where('f_account_id', sAccount);
		$this->db->where('f_aktif', 1);
		$sql = $this->db->get('t_company_category_value');
		if ($sql->num_rows() > 0) {
			return $sql->result_array();
		} else {
			return FALSE;
		}
	}

	function compValue()
	{
		$this->db->where('f_account_id', sAccount);
		$this->db->where('f_aktif', 1);
		$sql = $this->db->get('t_company_value');
		if ($sql->num_rows() > 0) {
			return $sql->result_array();
		} else {
			return FALSE;
		}
	}

	function masterValue()
	{
		$this->db->select('f_value_id,f_value_name_' . LANGUAGE . ' as f_value_name,f_value_category,f_value_company');
		$this->db->where('f_account_id', sAccount);
		$this->db->where('f_value_active', 1);
		$this->db->where('f_value_company is not null');
		$sql = $this->db->get('table_value');
		if ($sql->num_rows() > 0) {
			$data = array();
			foreach ($sql->result_array() as $r) :
				$data[$r['f_value_id']] = $r;
			endforeach;
			return $data;
		} else {
			return FALSE;
		}
	}

	public function fnReportsDataJson()
	{
		$this->load->library('dtable');
		$this->dtable->select('a.f_id, f_event_name, f_survey_valid, c.f_name, f_gender_name, f_age_desc, f_service_desc, f_region_name, f_levelwork_desc, i.f_name f_pendidikan_name, j.f_position_desc f_level1_name, k.f_position_desc f_level2_name, l.f_position_desc f_level3_name, m.f_position_desc f_level4_name, n.f_position_desc f_level5_name, date_format(f_survey_created_on,"%d-%m-%Y %H:%i") f_start, date_format(f_survey_updated_on,"%d-%m-%Y %H:%i") f_end');
		$this->dtable->join('t_event b', 'b.f_event_id=a.f_event_id');
		$this->dtable->join('table_leaders c', 'c.f_id=a.f_leaders');
		$this->dtable->join('table_gender d', 'd.f_gender_id=a.f_gender and d.f_account_id=' . sAccount, 'left');
		$this->dtable->join('table_age e', 'e.f_id=a.f_age and e.f_account_id=' . sAccount, 'left');
		$this->dtable->join('table_length_of_service f', 'f.f_id=a.f_length_of_service and f.f_account_id=' . sAccount, 'left');
		$this->dtable->join('table_region g', 'g.f_id=a.f_region and g.f_account_id=' . sAccount, 'left');
		$this->dtable->join('table_level_work h', 'h.f_id=a.f_level_of_work and h.f_account_id=' . sAccount, 'left');
		$this->dtable->join('table_pendidikan i', 'i.f_id=a.f_pendidikan and i.f_account_id=' . sAccount, 'left');
		$this->dtable->join('table_level_position1 j', 'j.f_id=a.f_level1 and j.f_account_id=' . sAccount, 'left');
		$this->dtable->join('table_level_position2 k', 'k.f_id=a.f_level2 and k.f_account_id=' . sAccount, 'left');
		$this->dtable->join('table_level_position3 l', 'l.f_id=a.f_level3 and l.f_account_id=' . sAccount, 'left');
		$this->dtable->join('table_level_position4 m', 'm.f_id=a.f_level4 and m.f_account_id=' . sAccount, 'left');
		$this->dtable->join('table_level_position5 n', 'n.f_id=a.f_level5 and n.f_account_id=' . sAccount, 'left');
		$this->dtable->where('a.f_account_id', sAccount);

		/* ---------- SEARCH BY GET PARAMETER --------- */
		if ($this->input->get('event_account'))  $this->dtable->where('a.f_event_id', $this->input->get('event_account'));
		if ($this->input->get('survey_valid'))  $this->dtable->where('a.f_survey_valid', $this->input->get('survey_valid'));
		if ($this->input->get('leaders'))  $this->dtable->where('a.f_leaders', $this->input->get('leaders'));
		if ($this->input->get('region'))  $this->dtable->where('a.f_region', $this->input->get('region'));
		if ($this->input->get('level1'))  $this->dtable->where('a.f_level1', $this->input->get('level1'));
		if ($this->input->get('level2'))  $this->dtable->where('a.f_level2', $this->input->get('level2'));
		if ($this->input->get('level3'))  $this->dtable->where('a.f_level3', $this->input->get('level3'));
		if ($this->input->get('level4'))  $this->dtable->where('a.f_level4', $this->input->get('level4'));
		if ($this->input->get('level5'))  $this->dtable->where('a.f_level5', $this->input->get('level5'));
		if ($this->input->get('level_of_work'))  $this->dtable->where('a.f_level_of_work', $this->input->get('level_of_work'));
		if ($this->input->get('masakerja'))  $this->dtable->where('a.f_length_of_service', $this->input->get('masakerja'));
		if ($this->input->get('gender'))  $this->dtable->where('a.f_gender', $this->input->get('gender'));
		if ($this->input->get('tipen'))  $this->dtable->where('a.f_pendidikan', $this->input->get('tipen'));
		if ($this->input->get('age'))  $this->dtable->where('a.f_age', $this->input->get('age'));
		if ($this->input->get('f_end_1'))  $this->dtable->where('a.f_survey_updated_on >=', $this->input->get('f_end_1'));
		if ($this->input->get('f_end_2')) $this->dtable->where('a.f_survey_updated_on <=', $this->input->get('f_end_2'));

		$this->dtable->from('trn_survey a');

		header('Content-Type: application/json');
		echo $this->dtable->generate();
		//echo $this->dtable->last_query();		
	}

	public function fnReportsDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_report_digital->getDataId($id);
		echo json_encode($data);
	}

	public function fnReportsDelete()
	{
		$id 	= $this->input->get_post('id');
		if ($this->mo_report_digital->deleteData($id)) {
			echo json_encode(array('msg' => true, 'pesan' => 'Sukses'));
		} else {
			echo json_encode(array('msg' => true, 'pesan' => 'Gagal'));
		}
	}

	public function fnReportsComboData()
	{
		$json['result'] = $this->mo_report_digital->remoteComboData();
		echo json_encode($json);
	}

	function fnPositionComboData($id)
	{
		$DataJson = array();
		$parent_field = 'f_id' . ($id - 1);
		if ($this->input->get('term')) $this->db->like('f_position_desc', $this->input->get('term')); // pencarian name
		if ($this->input->get('f_parents')) $this->db->where($parent_field, $this->input->get('f_parents')); // saat pencarian update
		if ($this->input->get('id')) $this->db->where('f_id', $this->input->get('id')); // saat pencarian update

		$this->db->where('f_account_id', sAccount); // pencarian Account
		$this->db->where('f_aktif', 1); // Aktif
		$table_name = 'table_level_position' . $id;
		$this->db->order_by('f_id', 'asc');
		$result = $this->db->get($table_name)->result();
		foreach ($result as $row) :
			$data['id']	= $row->f_id; // value
			$data['text']	= $row->f_position_desc; // change display 
			array_push($DataJson, $data);
		endforeach;
		$json['result'] = $DataJson;
		echo json_encode($json);
	}

	public function fnReportsExcel1()
	{
		//$this->load->helper('download');
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello World !');

		$writer = new Xlsx($spreadsheet);
		$filename = 'transaction_survey.xlsx';
		$writer->save($filename);
		$mimes = &get_mimes();
		$x = explode('.', $filename);
		$extension = end($x);
		// Only change the default MIME if we can find one
		if (isset($mimes[$extension])) {
			$mime = is_array($mimes[$extension]) ? $mimes[$extension][0] : $mimes[$extension];
		}
		//header('Content-Type: '.$mime);
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		//header('Content-Type: application/vnd.ms-excel');
		//header('Content-Disposition: attachment;filename="'. $filename ); 
		//header('Cache-Control: max-age=0');
		force_download_delete(FCPATH . $filename, NULL);
		//$writer->save('php://output');

	}

	/*
	public function fnReportsExcel()
	{
		//http://localhost/ci3110/survey_leader/reports/fnTrx_surveyExcel?event_account=1&event_account_name=Telkomsel%202020&survey_valid=yes&leaders=&leaders_name=&region=&region_name=&level1=&level1_name=&level2=&level2_name=&level3=&level3_name=&level4=&level4_name=&level5=&level5_name=&level_of_work=&level_of_work_name=&masakerja=&mk_name=&gender=&tipen=&age=&age_name=&f_end_1=&f_end_2=
		
		$idAccount = sAccount;
		$search_account 			= $this->mo_report_digital->fnGetDataAccount();
		$values_account 			= $this->mo_report_digital->comboDataValues();
		///*---------- Name Label ----------*
		$label_level1 = json_decode($search_account['f_label_level1'],true);
		$label_level2 = json_decode($search_account['f_label_level2'],true);
		$label_level3 = json_decode($search_account['f_label_level3'],true);
		$label_level4 = json_decode($search_account['f_label_level4'],true);
		$label_level5 = json_decode($search_account['f_label_level5'],true);
		$others = json_decode($search_account['f_label_others'],true);
		$label_leaders = $others['leaders'];
		$label_region = $others['region'];
		$label_work = $others['work'];
		$label_mk = $others['mk'];
		$label_gender = $others['gender'];
		$label_pendidikan = $others['education'];
		$label_age = $others['age'];

		$listdemo 			= $this->mo_c->listDemo($idAccount);
		
		$select_data = array('a.f_id', 'f_event_name', 'f_survey_valid', 'date_format(f_survey_created_on,"%d-%m-%Y %H:%i") f_start','date_format(f_survey_updated_on,"%d-%m-%Y %H:%i") f_end','f_survey_personal','f_survey_leaderc','f_survey_leaderd', 'c.f_name');
		
		if( $listdemo['f_region'] == 1 ) $select_data[] = 'f_region_name';
		if( $listdemo['f_level1'] == 1 ) $select_data[] = 'j.f_position_desc f_level1_name';
		if( $listdemo['f_level2'] == 1 ) $select_data[] = 'k.f_position_desc f_level2_name';
		if( $listdemo['f_level3'] == 1 ) $select_data[] = 'l.f_position_desc f_level3_name';
		if( $listdemo['f_level4'] == 1 ) $select_data[] = 'm.f_position_desc f_level4_name';
		if( $listdemo['f_level5'] == 1 ) $select_data[] = 'n.f_position_desc f_level5_name';
		if( $listdemo['f_level_of_work'] == 1 ) $select_data[] = 'f_levelwork_desc';
		if( $listdemo['f_masakerja'] == 1 ) $select_data[] = 'f_service_desc';
		if( $listdemo['f_gender'] == 1 ) $select_data[] = 'f_gender_name';
		if( $listdemo['f_age'] == 1 ) $select_data[] = 'f_age_desc';
		if( $listdemo['f_pendidikan'] == 1 ) $select_data[] = 'i.f_name f_pendidikan_name';
		
		//opn($select_data);
		$select_field =  join(',',$select_data);
		$this->db->select($select_field,false);
		$this->db->join('t_event b','b.f_event_id=a.f_event_id');
		$this->db->join('table_leaders c','c.f_id=a.f_leaders');
		if( $listdemo['f_gender'] == 1 ) $this->db->join('table_gender d','d.f_gender_id=a.f_gender and d.f_account_id='.sAccount,'left');
		if( $listdemo['f_age'] == 1 ) $this->db->join('table_age e','e.f_id=a.f_age and e.f_account_id='.sAccount,'left');
		if( $listdemo['f_masakerja'] == 1 ) $this->db->join('table_length_of_service f','f.f_id=a.f_length_of_service and f.f_account_id='.sAccount,'left');
		if( $listdemo['f_region'] == 1 ) $this->db->join('table_region g','g.f_id=a.f_region and g.f_account_id='.sAccount,'left');
		if( $listdemo['f_level_of_work'] == 1 ) $this->db->join('table_level_work h','h.f_id=a.f_level_of_work and h.f_account_id='.sAccount,'left');
		if( $listdemo['f_pendidikan'] == 1 ) $this->db->join('table_pendidikan i','i.f_id=a.f_pendidikan and i.f_account_id='.sAccount,'left');
		if( $listdemo['f_level1'] == 1 ) $this->db->join('table_level_position1 j','j.f_id=a.f_level1 and j.f_account_id='.sAccount,'left');
		if( $listdemo['f_level2'] == 1 ) $this->db->join('table_level_position2 k','k.f_id=a.f_level2 and k.f_account_id='.sAccount,'left');
		if( $listdemo['f_level3'] == 1 ) $this->db->join('table_level_position3 l','l.f_id=a.f_level3 and l.f_account_id='.sAccount,'left');
		if( $listdemo['f_level4'] == 1 ) $this->db->join('table_level_position4 m','m.f_id=a.f_level4 and m.f_account_id='.sAccount,'left');
		if( $listdemo['f_level5'] == 1 ) $this->db->join('table_level_position5 n','n.f_id=a.f_level5 and n.f_account_id='.sAccount,'left');
		$this->db->where('a.f_account_id',sAccount);
		
		///*---------- SEARCH BY GET PARAMETER ----------*
		if($this->input->get('event_account'))  $this->db->where('a.f_event_id',$this->input->get('event_account'));
		if($this->input->get('survey_valid'))  $this->db->where('a.f_survey_valid',$this->input->get('survey_valid'));
		if($this->input->get('leaders'))  $this->db->where('a.f_leaders',$this->input->get('leaders'));
		if($this->input->get('region'))  $this->db->where('a.f_region',$this->input->get('region'));
		if($this->input->get('level1'))  $this->db->where('a.f_level1',$this->input->get('level1'));
		if($this->input->get('level2'))  $this->db->where('a.f_level2',$this->input->get('level2'));
		if($this->input->get('level3'))  $this->db->where('a.f_level3',$this->input->get('level3'));
		if($this->input->get('level4'))  $this->db->where('a.f_level4',$this->input->get('level4'));
		if($this->input->get('level5'))  $this->db->where('a.f_level5',$this->input->get('level5'));
		if($this->input->get('level_of_work'))  $this->db->where('a.f_level_of_work',$this->input->get('level_of_work'));
		if($this->input->get('masakerja'))  $this->db->where('a.f_length_of_service',$this->input->get('masakerja'));
		if($this->input->get('gender'))  $this->db->where('a.f_gender',$this->input->get('gender'));
		if($this->input->get('tipen'))  $this->db->where('a.f_pendidikan',$this->input->get('tipen'));
		if($this->input->get('age'))  $this->db->where('a.f_age',$this->input->get('age'));
		if($this->input->get('f_end_1'))  $this->db->where('a.f_survey_updated_on >=',$this->input->get('f_end_1'));
		if($this->input->get('f_end_2')) $this->db->where('a.f_survey_updated_on <=',$this->input->get('f_end_2'));
		
		///*---------- RUN QUERY ----------*
		$sql = $this->db->get('trn_survey a');
		//echo $this->db->last_query();

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		
		///*---------- Name Header Coloumn, Row, Text ------------*
		$sheet->setCellValueByColumnAndRow(1, 1, 'No ID');$sheet->mergeCells('A1:A2');
		$sheet->setCellValueByColumnAndRow(2, 1, 'Event');$sheet->mergeCells('B1:B2');
		$sheet->setCellValueByColumnAndRow(3, 1, $label_leaders[LANGUAGE]);$sheet->mergeCells('C1:C2');
		$sheet->setCellValueByColumnAndRow(4, 1, 'Status Survey');$sheet->mergeCells('D1:D2');
		$sheet->setCellValueByColumnAndRow(5, 1, 'Start Survey');$sheet->mergeCells('E1:E2');
		$sheet->setCellValueByColumnAndRow(6, 1, 'End Survey');$sheet->mergeCells('F1:F2');
		$col_end = 7;
		if( $listdemo['f_gender'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, 1, $label_gender[LANGUAGE]);$col_end++; }
		if( $listdemo['f_age'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, 1, $label_age[LANGUAGE]);$col_end++; }
		if( $listdemo['f_masakerja'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, 1, $label_mk[LANGUAGE]);$col_end++; }
		if( $listdemo['f_region'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, 1, $label_region[LANGUAGE]);$col_end++; }
		if( $listdemo['f_level_of_work'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, 1, $label_work[LANGUAGE]);$col_end++; }
		if( $listdemo['f_pendidikan'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, 1, $label_pendidikan[LANGUAGE]);$col_end++; }
		if( $listdemo['f_level1'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, 1, $label_level1[LANGUAGE]);$col_end++; }
		if( $listdemo['f_level2'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, 1, $label_level2[LANGUAGE]);$col_end++; }
		if( $listdemo['f_level3'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, 1, $label_level3[LANGUAGE]);$col_end++; }
		if( $listdemo['f_level4'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, 1, $label_level4[LANGUAGE]);$col_end++; }
		if( $listdemo['f_level5'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, 1, $label_level5[LANGUAGE]);$col_end++; }
		$sheet->setCellValueByColumnAndRow($col_end, 1, 'Personal');
		$sheet->setCellValueByColumnAndRow($col_end+10, 1, 'Current');
		$sheet->setCellValueByColumnAndRow($col_end+20, 1, 'Desire');
		
		///*---------- Baris ke 2 ------------*
		$col_personal_values = $col_end;
		for($i=0;$i<10;$i++) { $sheet->setCellValueByColumnAndRow($col_personal_values, 2, ($i+1));$col_personal_values++; }
		$col_current_values = $col_end+10;
		for($i=0;$i<10;$i++) { $sheet->setCellValueByColumnAndRow($col_current_values, 2, ($i+1));$col_current_values++; }
		$col_desire_values = $col_end+20;
		for($i=0;$i<10;$i++) { $sheet->setCellValueByColumnAndRow($col_desire_values, 2, ($i+1));$col_desire_values++; }
		
		if($sql->num_rows()>0) {
			$baris = 3;
			foreach($sql->result_array() as $r) {
			    $sheet->setCellValueByColumnAndRow(1, $baris, $r['f_id']);
				$sheet->setCellValueByColumnAndRow(2, $baris, $r['f_event_name']);
				$sheet->setCellValueByColumnAndRow(3, $baris, $r['f_name']);
				$sheet->setCellValueByColumnAndRow(4, $baris, $r['f_survey_valid']);
				$sheet->setCellValueByColumnAndRow(5, $baris, $r['f_start']);
				$sheet->setCellValueByColumnAndRow(6, $baris, $r['f_end']);
				$col_end = 7;
				if( $listdemo['f_gender'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, $baris, $r['f_gender_name']);$col_end++; }
				if( $listdemo['f_age'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, $baris, $r['f_age_desc']);$col_end++; }
				if( $listdemo['f_masakerja'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, $baris, $r['f_service_desc']);$col_end++; }
				if( $listdemo['f_region'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, $baris, $r['f_region_name']);$col_end++; }
				if( $listdemo['f_level_of_work'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, $baris, $r['f_levelwork_desc']);$col_end++; }
				if( $listdemo['f_pendidikan'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, $baris, $r['f_pendidikan_name']);$col_end++; }
				if( $listdemo['f_level1'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, $baris, $r['f_level1_name']);$col_end++; }
				if( $listdemo['f_level2'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, $baris, $r['f_level2_name']);$col_end++; }
				if( $listdemo['f_level3'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, $baris, $r['f_level3_name']);$col_end++; }
				if( $listdemo['f_level4'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, $baris, $r['f_level4_name']);$col_end++; }
				if( $listdemo['f_level5'] == 1 ) { $sheet->setCellValueByColumnAndRow($col_end, $baris, $r['f_level5_name']);$col_end++; }
				///*---------- PREPARE VALUES ----------*
				// PERSONAL
				$_personal = json_decode($r['f_survey_personal'],true);
				$personal = array();
				foreach($_personal['choose'] as $v) {
					$vp = explode('_',$v);
					$personal[$vp[0]] = $values_account[$vp[1]];
				}
				$col_personal_values = $col_end;
				for($i=0;$i<10;$i++) {
					$name_value = '';
					if($personal[($i+1)]) $name_value = $personal[($i+1)];
					$sheet->setCellValueByColumnAndRow($col_personal_values, $baris, $name_value);
					$col_personal_values++;
				}
				// CURRENT LEADER
				$_current = json_decode($r['f_survey_leaderc'],true);
				$current = array();
				foreach($_current['choose'] as $v) {
					$vp = explode('_',$v);
					$current[$vp[0]] = $values_account[$vp[1]];
				}
				$col_current_values = $col_end+10;
				for($i=0;$i<10;$i++) { 
					$name_value = '';
					if($current[($i+1)]) $name_value = $current[($i+1)];
					$sheet->setCellValueByColumnAndRow($col_current_values, $baris, $name_value);$col_current_values++; 
				}
				// DESIRE LEADER
				$_desire = json_decode($r['f_survey_leaderd'],true);
				$desire = array();
				foreach($_current['choose'] as $v) {
					$vp = explode('_',$v);
					$desire[$vp[0]] = $values_account[$vp[1]];
				}
				$col_desire_values = $col_end+20;
				for($i=0;$i<10;$i++) { 
					$name_value = '';
					if($desire[($i+1)]) $name_value = $desire[($i+1)];
					$sheet->setCellValueByColumnAndRow($col_desire_values, $baris, $name_value);$col_desire_values++; 
				}

			    $baris++;
			}
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'transaction_survey_'.date('YmdHi').'.xlsx';
		$writer->save($filename);
		force_download_delete(FCPATH.$filename, NULL);
	}
	*/
}

/* End of file Reports.php */
/* Location: ./application/modules/Reports/controllers/Reports.php */
