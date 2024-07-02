<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Trx_survey extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$this->load->model('mo_trx_survey');
		$this->load->model('mo_c');
	}

	public function index()
	{
		$data = array(
			'app_title' => 'Data Transaksi Survey',
			'app_desc' => 'it all Transaksi Survey'
		);
		$idAccount = sAccount;
		$search_account 			= $this->mo_trx_survey->fnGetDataAccount();
		$listdemo 			= $this->mo_c->listDemo($idAccount);
		$event_account		= $this->mo_trx_survey->comboDataEvent();
		$data['listdemo'] 	= $listdemo;
		// if( $listdemo['f_region'] == 1 )	$data['region'] 	= $this->mo_c->comboDataRegion($idAccount);
		// if( $listdemo['f_level1'] == 1 )	$data['cLevel1'] 	= $this->mo_c->comboDataLevelofposition1($idAccount);
		// if( $listdemo['f_level_of_work'] == 1 )	$data['level_of_work'] 	= $this->mo_c->comboDataLevelofwork($idAccount);
		// if( $listdemo['f_masakerja'] == 1 )	$data['masakerja'] 	= $this->mo_c->comboDataLengthofservice($idAccount);
		// if( $listdemo['f_gender'] == 1 )	$data['gender'] 	= $this->mo_c->comboDataGender($idAccount);
		// if( $listdemo['f_age'] == 1 )		$data['age_ar'] 	= $this->mo_c->comboDataAge($idAccount);
		// if( $listdemo['f_pendidikan'] == 1 )	$data['pendidikan'] 	= $this->mo_c->comboDataEducation($idAccount);

		$data['set_demo'] 		= $search_account;
		$data['event_account'] 	= $event_account;
		$data['side_main']	= 'ta_trx_survey';
		$data['content']	= 'vw_trx_survey';
		$this->load->view('admin/main', $data);
	}

	public function fnTrx_surveyDataJson()
	{
		//error_reporting(-1);
		//ini_set('display_errors', 1);
		$this->load->library('dtable');
		//$this->dtable->select('a.f_id, f_event_name, f_survey_valid, f_gender_name, f_age_desc, f_service_desc, f_region_name, f_levelwork_desc, i.f_name f_pendidikan_name, j.f_position_desc f_level1_name, k.f_position_desc f_level2_name, l.f_position_desc f_level3_name, m.f_position_desc f_level4_name, n.f_position_desc f_level5_name, date_format(f_survey_created_on,"%d-%m-%Y %H:%i") f_start, date_format(f_survey_updated_on,"%d-%m-%Y %H:%i") f_end');
		$this->dtable->select('a.f_id, f_event_name, f_survey_username, f_survey_email, f_survey_password, f_survey_valid, date_format(f_survey_created_on,"%d-%m-%Y %H:%i") f_start, date_format(f_survey_updated_on,"%d-%m-%Y %H:%i") f_end', false);
		$this->dtable->join('t_event b', 'b.f_event_id=a.f_event_id');
		// $this->dtable->join('table_gender d', 'd.f_gender_id=a.f_jenis_kelamin', 'left');
		// $this->dtable->join('table_age e', 'e.f_id=a.f_umur', 'left');
		// $this->dtable->join('table_pekerjaan f', 'f.f_id=a.f_pekerjaan', 'left');
		// $this->dtable->join('table_pendapatan g', 'g.f_id=a.f_pendapatan', 'left');




		// $this->dtable->join('table_gender d', 'd.f_gender_id=a.f_gender and d.f_account_id=' . sAccount, 'left');
		// $this->dtable->join('table_age e', 'e.f_id=a.f_age and e.f_account_id=' . sAccount, 'left');
		//$this->dtable->join('table_length_of_service f','f.f_id=a.f_length_of_service and f.f_account_id='.sAccount,'left');
		//$this->dtable->join('table_region g','g.f_id=a.f_region and g.f_account_id='.sAccount,'left');
		//$this->dtable->join('table_level_work h','h.f_id=a.f_level_of_work and h.f_account_id='.sAccount,'left');
		//$this->dtable->join('table_pendidikan i','i.f_id=a.f_pendidikan and i.f_account_id='.sAccount,'left');
		//$this->dtable->join('table_level_position1 j','j.f_id=a.f_level1 and j.f_account_id='.sAccount,'left');
		//$this->dtable->join('table_level_position2 k','k.f_id=a.f_level2 and k.f_account_id='.sAccount,'left');
		//$this->dtable->join('table_level_position3 l','l.f_id=a.f_level3 and l.f_account_id='.sAccount,'left');
		//$this->dtable->join('table_level_position4 m','m.f_id=a.f_level4 and m.f_account_id='.sAccount,'left');
		//$this->dtable->join('table_level_position5 n','n.f_id=a.f_level5 and n.f_account_id='.sAccount,'left');
		//$this->dtable->where('a.f_account_id',sAccount);

		/* ---------- SEARCH BY GET PARAMETER --------- */
		if ($this->input->get('event_account'))  $this->dtable->where('a.f_event_id', $this->input->get('event_account'));
		if ($this->input->get('survey_valid'))  $this->dtable->where('a.f_survey_valid', $this->input->get('survey_valid'));
		//if($this->input->get('region'))  $this->dtable->where('a.f_region',$this->input->get('region'));
		//if($this->input->get('level1'))  $this->dtable->where('a.f_level1',$this->input->get('level1'));
		//if($this->input->get('level2'))  $this->dtable->where('a.f_level2',$this->input->get('level2'));
		//if($this->input->get('level3'))  $this->dtable->where('a.f_level3',$this->input->get('level3'));
		//if($this->input->get('level4'))  $this->dtable->where('a.f_level4',$this->input->get('level4'));
		//if($this->input->get('level5'))  $this->dtable->where('a.f_level5',$this->input->get('level5'));
		//if($this->input->get('level_of_work'))  $this->dtable->where('a.f_level_of_work',$this->input->get('level_of_work'));
		//if($this->input->get('masakerja'))  $this->dtable->where('a.f_length_of_service',$this->input->get('masakerja'));
		//if($this->input->get('gender'))  $this->dtable->where('a.f_gender',$this->input->get('gender'));
		//if($this->input->get('tipen'))  $this->dtable->where('a.f_pendidikan',$this->input->get('tipen'));
		//if($this->input->get('age'))  $this->dtable->where('a.f_age',$this->input->get('age'));
		if (sAccount != 0) {
			$this->dtable->where('b.f_account_id', sAccount);
		}
		if ($this->input->get('f_end_1'))  $this->dtable->where('a.f_survey_updated_on >=', $this->input->get('f_end_1'));
		if ($this->input->get('f_end_2')) $this->dtable->where('a.f_survey_updated_on <=', $this->input->get('f_end_2'));

		$this->dtable->from('trn_survey_empex a');

		header('Content-Type: application/json');

		echo $this->dtable->generate();
		//echo $this->dtable->last_query();		
	}

	public function fnTrx_surveyDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_trx_survey->getDataId($id);
		echo json_encode($data);
	}

	function fnTrx_surveyDeleteCheck()
	{
		$this->db->trans_start();
		$this->db->where_in('f_id', $this->input->post('id'))
			->where('f_account_id', sAccount)
			->delete('trn_survey');
		$this->db->trans_complete();
		if ($this->db->trans_status()) {
			echo json_encode(array('status' => 200));
		} else {
			echo json_encode(array('status' => 500));
		}
	}

	public function fnTrx_surveyDelete()
	{
		$id 	= $this->input->get_post('id');
		if ($this->mo_trx_survey->deleteData($id)) {
			echo json_encode(array('msg' => true, 'pesan' => 'Sukses'));
		} else {
			echo json_encode(array('msg' => true, 'pesan' => 'Gagal'));
		}
	}

	public function fnTrx_surveyComboData()
	{
		$json['result'] = $this->mo_trx_survey->remoteComboData();
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

	public function fnTrx_surveyExcel1()
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
	public function fnTrx_surveyExcel()
	{
		//http://localhost/ci3110/survey_leader/trx_survey/fnTrx_surveyExcel?event_account=1&event_account_name=Telkomsel%202020&survey_valid=yes&leaders=&leaders_name=&region=&region_name=&level1=&level1_name=&level2=&level2_name=&level3=&level3_name=&level4=&level4_name=&level5=&level5_name=&level_of_work=&level_of_work_name=&masakerja=&mk_name=&gender=&tipen=&age=&age_name=&f_end_1=&f_end_2=
		
		$idAccount = sAccount;
		$search_account 			= $this->mo_trx_survey->fnGetDataAccount();
		$values_account 			= $this->mo_trx_survey->comboDataValues();
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
		
		///*---------- Baris ke 2 ------------ //
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
				///---------- PREPARE VALUES ----------
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
	public function fnTrx_surveyExcelold()
	{
		$this->load->helper('exportexcel');
		$namaFile = "trn_survey.xls";
		$judul = "trn_survey";
		$tablehead = 0;
		$tablebody = 1;
		$nourut = 1;
		//penulisan header
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Disposition: attachment;filename=" . $namaFile . "");
		header("Content-Transfer-Encoding: binary ");

		xlsBOF();

		$kolomhead = 0;
		xlsWriteLabel($tablehead, $kolomhead++, "No");
		xlsWriteLabel($tablehead, $kolomhead++, "F Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Account Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Event Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Survey Username");
		xlsWriteLabel($tablehead, $kolomhead++, "F Survey Password");
		xlsWriteLabel($tablehead, $kolomhead++, "F Survey Demographic");
		xlsWriteLabel($tablehead, $kolomhead++, "F Survey Personal");
		xlsWriteLabel($tablehead, $kolomhead++, "F Survey Leaderc");
		xlsWriteLabel($tablehead, $kolomhead++, "F Survey Leaderd");
		xlsWriteLabel($tablehead, $kolomhead++, "F Survey Valid");
		xlsWriteLabel($tablehead, $kolomhead++, "F Leaders");
		xlsWriteLabel($tablehead, $kolomhead++, "F Gender");
		xlsWriteLabel($tablehead, $kolomhead++, "F Age");
		xlsWriteLabel($tablehead, $kolomhead++, "F Length Of Service");
		xlsWriteLabel($tablehead, $kolomhead++, "F Region");
		xlsWriteLabel($tablehead, $kolomhead++, "F Level Of Work");
		xlsWriteLabel($tablehead, $kolomhead++, "F Pendidikan");
		xlsWriteLabel($tablehead, $kolomhead++, "F Level1");
		xlsWriteLabel($tablehead, $kolomhead++, "F Level2");
		xlsWriteLabel($tablehead, $kolomhead++, "F Level3");
		xlsWriteLabel($tablehead, $kolomhead++, "F Level4");
		xlsWriteLabel($tablehead, $kolomhead++, "F Level5");
		xlsWriteLabel($tablehead, $kolomhead++, "F Level6");
		xlsWriteLabel($tablehead, $kolomhead++, "F Level7");
		xlsWriteLabel($tablehead, $kolomhead++, "F Custom1");
		xlsWriteLabel($tablehead, $kolomhead++, "F Custom2");
		xlsWriteLabel($tablehead, $kolomhead++, "F Custom3");
		xlsWriteLabel($tablehead, $kolomhead++, "F Custom4");
		xlsWriteLabel($tablehead, $kolomhead++, "F Custom5");
		xlsWriteLabel($tablehead, $kolomhead++, "F Custom6");
		xlsWriteLabel($tablehead, $kolomhead++, "F Custom7");
		xlsWriteLabel($tablehead, $kolomhead++, "F Custom8");
		xlsWriteLabel($tablehead, $kolomhead++, "F Custom9");
		xlsWriteLabel($tablehead, $kolomhead++, "F Demographic Data");
		xlsWriteLabel($tablehead, $kolomhead++, "F Template");
		xlsWriteLabel($tablehead, $kolomhead++, "F Survey Created On");
		xlsWriteLabel($tablehead, $kolomhead++, "F Survey Created By");
		xlsWriteLabel($tablehead, $kolomhead++, "F Survey Updated On");
		xlsWriteLabel($tablehead, $kolomhead++, "F Survey Updated By");
		xlsWriteLabel($tablehead, $kolomhead++, "F Ip Address");

		foreach ($this->mo_trx_survey->fnGetData() as $data) {
			$kolombody = 0;

			//ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
			xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_id);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_account_id);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_event_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_survey_username);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_survey_password);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_survey_demographic);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_survey_personal);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_survey_leaderc);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_survey_leaderd);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_survey_valid);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_leaders);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_gender);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_age);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_length_of_service);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_region);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_level_of_work);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_pendidikan);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_level1);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_level2);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_level3);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_level4);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_level5);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_level6);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_level7);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_custom1);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_custom2);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_custom3);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_custom4);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_custom5);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_custom6);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_custom7);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_custom8);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_custom9);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_demographic_data);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_template);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_survey_created_on);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_survey_created_by);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_survey_updated_on);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_survey_updated_by);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_ip_address);

			$tablebody++;
			$nourut++;
		}

		xlsEOF();
		exit();
	}

	function export($id_account = null)
	{
		if ($id_account) {
			$this->db->where('trn_survey_empex.f_event_id', $id_account);
		}

		$this->db->select('trn_survey_empex.*, t_event.f_event_name');
		$this->db->from('trn_survey_empex');
		$this->db->join('t_event', 't_event.f_event_id=trn_survey_empex.f_event_id');
		$this->db->order_by('trn_survey_empex.f_id', 'DESC');
		$data = $this->db->get()->result_array();


		$master_pertanyaan = $this->db->get_where('t_item_pernyataan')->result_array();

		$master_kategori = $this->db->get_where('t_variabel')->result_array();


		$spreadsheet = new Spreadsheet;
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'Nama')
			->setCellValue('B1', 'Email')
			->setCellValue('C1', 'Event');

		$k = 0;
		$kolomAwal = 4;
		for ($i = 1; $i <= count($master_pertanyaan); $i++) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow($kolomAwal, 1, 'pertanyaan_' . $master_pertanyaan[$k]['f_id']);
			$kolomAwal++;
			$k++;
		}



		$kolom = 2;
		$nomor = 1;
		$columnNumber = 4; // Example number
		foreach ($data as $d) {
			$survey = json_decode($d['f_survey'], true);
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $kolom, $d['f_survey_username'])
				->setCellValue('B' . $kolom, $d['f_survey_email'])
				->setCellValue('C' . $kolom, $d['f_event_name']);


			$kolomAwalDistribusiJawaban = 4;
			foreach ($survey['distribusi_jawaban'] as $key_jawaban => $value_jawaban) {
				$spreadsheet->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow($kolomAwalDistribusiJawaban, $kolom, $value_jawaban['value']);
				$kolomAwalDistribusiJawaban++;
			}

			$kolomAwalJawabanPerkategori = 54;
			foreach ($survey['jawaban_perkategori'] as $key_jawaban => $value_jawaban) {
				$spreadsheet->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow($kolomAwalJawabanPerkategori, 1, $value_jawaban['name']);
				$spreadsheet->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow($kolomAwalJawabanPerkategori, $kolom, $value_jawaban['value']);
				$kolomAwalJawabanPerkategori++;
			}
			// $columnNumber++;

			// ->setCellValue('C' . $kolom, $d['f_survey_email']);
			// ->setCellValue('D' . $kolom, $d['f_event_name']);
			$kolom++;
			$nomor++;


			// var_dump($survey);
		}
		// die;




		foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {

			$spreadsheet->setActiveSheetIndex($spreadsheet->getIndex($worksheet));
			$sheet = $spreadsheet->getActiveSheet();
			$cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(true);
			/** @var PHPExcel_Cell $cell */
			foreach ($cellIterator as $cell) {
				$sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
			}
		}


		$writer = new Xlsx($spreadsheet);

		$filename = 'Emotional_intelegence_export_' . date('Ymdhs') . '.xlsx';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		// die;
		$writer->save('php://output');
	}


	// Function to convert column number to letter
	function getColumnLetter($columnNumber)
	{
		$columnLetter = '';
		while ($columnNumber > 0) {
			$modulo = ($columnNumber - 1) % 26;
			$columnLetter = chr(65 + $modulo) . $columnLetter;
			$columnNumber = (int)(($columnNumber - $modulo) / 26);
		}
		return $columnLetter;
	}
}

/* End of file Trx_survey.php */
/* Location: ./application/modules/Trx_survey/controllers/Trx_survey.php */
