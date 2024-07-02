<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
//require_once APPPATH.'third_party/Mailgun/vendor/autoload.php';
//require_once APPPATH.'third_party/mailgun/Mailgun.php';
//use Mailgun\Mailgun;

class Company_events extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		if (!$this->ion_auth->is_admin()) redirect($this->agent->referrer());
		$this->load->model('mo_events');
	}

	public function index()
	{
		$data = array(
			'app_title' => 'Data Company Events',
			'app_desc' => 'it all Company Events'
		);

		$data['side_main']	= 'company_events';
		$data['content']	= 'vw_events';
		$this->load->view('admin/main', $data);
	}

	public function fnEventsDataJson()
	{
		$button = '';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnEdit($1)" class="tip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnDelete($1)" class="tip" title="Hapus"><i class="text-red glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;';

		$this->load->library('dtable');
		$this->dtable->select('f_event_id, f_event_name, f_event_start, f_event_start_time, f_event_end, f_event_end_time, f_account_name, f_account_contact, f_account_phone,f_account_email, f_event_survey, f_event_min_respon');
		$this->dtable->join('t_account b', 'b.f_account_id=t_event.f_account_id');
		// $this->dtable->join('t_variabel c', 'c.f_id=t_event.f_variabel_id');
		//$this->dtable->where('b.f_account_id', sAccount);
		$this->dtable->order_by('f_event_id', 'desc');
		$this->dtable->from('t_event');
		$this->dtable->add_column('Aksi', $button, 'f_event_id');

		echo $this->dtable->generate();
	}

	public function fnEventsDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_events->getDataId($id);
		echo json_encode($data);
	}

	//Untuk Form Terpisah
	public function fnEventsAdd()
	{

		$data = array(
			'app_title' => 'Form Company Events',
			'app_desc' => 'it all Form Company Events',
			'form_header'	=> '<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=> 'Add',
			'variabel' => $this->db->get('t_variabel')->result_array()
		);

		$data['side_main']	= 'company_events';
		$data['content']	= 'vw_events_add';
		$this->load->view('admin/main', $data);
	}

	public function fnEventsSave()
	{
		if ($this->mo_events->saveData()) {
			$this->session->set_userdata('SUCMSG', 'Sukses Tambah !!!');
			echo json_encode(array('msg' => true));
		} else {
			echo json_encode(array('msg' => false));
		}
	}

	//Untuk Form Terpisah
	public function fnEventsEdit($id)
	{
		$data = array(
			'app_title' => 'Form Company Events',
			'app_desc' => 'it all Form Company Events',
			'form_header'	=> '<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=> 'Edit',
			'fId'			=> $id,
			'variabel' => $this->db->get('t_variabel')->result_array()
		);

		$data['side_main']	= 'company_events';
		$data['content']	= 'vw_events_add';
		$this->load->view('admin/main', $data);
	}

	public function fnEventsUpdate()
	{
		$id 	= $this->input->get_post('id');
		if ($this->mo_events->updateData($id)) {
			$this->session->set_userdata('SUCMSG', 'Sukses Edit !!!');
			echo json_encode(array('msg' => true));
		} else {
			echo json_encode(array('msg' => false));
		}
	}

	public function fnEventsDelete()
	{
		$id 	= $this->input->get_post('id');
		if ($this->mo_events->deleteData($id)) {
			echo json_encode(array('msg' => true, 'pesan' => 'Sukses'));
		} else {
			echo json_encode(array('msg' => true, 'pesan' => 'Gagal'));
		}
	}

	public function fnEventsComboData()
	{
		$json['result'] = $this->mo_events->remoteComboData();
		echo json_encode($json);
	}

	public function fnEventsExcel()
	{
		$this->load->helper('exportexcel');
		$namaFile = "t_event.xls";
		$judul = "t_event";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Event Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Event Name");
		xlsWriteLabel($tablehead, $kolomhead++, "F Event Start");
		xlsWriteLabel($tablehead, $kolomhead++, "F Event End");
		xlsWriteLabel($tablehead, $kolomhead++, "F Event Status");
		xlsWriteLabel($tablehead, $kolomhead++, "F Event Survey");
		xlsWriteLabel($tablehead, $kolomhead++, "F Account Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Event Click");
		xlsWriteLabel($tablehead, $kolomhead++, "F Event Kode");
		xlsWriteLabel($tablehead, $kolomhead++, "F Event Type");
		xlsWriteLabel($tablehead, $kolomhead++, "F Event Min Respon");
		xlsWriteLabel($tablehead, $kolomhead++, "F Event Respon");
		xlsWriteLabel($tablehead, $kolomhead++, "F Event Created On");
		xlsWriteLabel($tablehead, $kolomhead++, "F Event Created By");
		xlsWriteLabel($tablehead, $kolomhead++, "F Event Updated On");
		xlsWriteLabel($tablehead, $kolomhead++, "F Event Updated By");
		xlsWriteLabel($tablehead, $kolomhead++, "F Training Schedule Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Trainer Id");

		foreach ($this->mo_events->fnGetData() as $data) {
			$kolombody = 0;

			//ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
			xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_event_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_event_name);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_event_start);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_event_end);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_event_status);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_event_survey);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_account_id);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_event_click);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_event_kode);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_event_type);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_event_min_respon);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_event_respon);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_event_created_on);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_event_created_by);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_event_updated_on);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_event_updated_by);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_training_schedule_id);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_trainer_id);

			$tablebody++;
			$nourut++;
		}

		xlsEOF();
		exit();
	}

	public function fnEventsWord()
	{
		header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment;Filename=t_event.doc");

		$data = array(
			't_event_data' => $this->mo_events->fnGetData(),
			'start' => 0
		);

		$this->load->view('vw_events_doc', $data);
	}

	/*--------------------- EMAIL INVITATION -----------------------------*/
	public function fnEventEmailBulk($id)
	{
		//error_reporting(-1);
		//ini_set('display_errors', 1);
		$data = array(
			'app_title' => 'Data ' . $this->lang->line('undangan_email'),
			'app_desc' => $this->lang->line('semua') . ' ' . strtolower($this->lang->line('undangan_email'))
		);

		$data['id']	= $id;
		$data['side_main']	= 'company_events';
		$data['result_template'] = $this->mo_events->getDataTemplate($id);
		$data['result_template_leader'] = $this->mo_events->getDataTemplateLeader($id);
		$data['leaders'] 	= $this->mo_events->comboDataLeaders();
		$data['content']	= 'vw_event_survey_bulk';
		$this->load->view('admin/main', $data);
	}

	public function fnEventDataJsonEmail($id)
	{
		$this->load->library('dtable');
		$this->dtable->select('f_email, f_nama, f_nik, f_code, f_send_email, f_send_date, f_respon, f_survey_valid, f_survey_date,b.f_name as name_leaders', false);
		$this->dtable->where('f_event_id', $id);
		$this->dtable->join('table_leaders b', 'b.f_id=a.f_leaders');
		$this->dtable->from('t_event_email a');
		echo $this->dtable->generate();
	}

	public function fnSaveExcel($id)
	{
		$this->load->helper('email');
		$file   = explode('.', $_FILES['file']['name']);
		$length = count($file);
		if ($file[$length - 1] == 'xlsx' || $file[$length - 1] == 'xls') {
			$this->load->library('excel_reader');
			$this->excel_reader->read($_FILES['file']['tmp_name']);
			$worksheet1 = $this->excel_reader->sheets[0];
			//$worksheet2 = $this->excel_reader->sheets[1];
			$user = $this->session->userdata('sId');
			//echo $worksheet1['numRows'];
			$total = 0;
			for ($i = 2; $i <= $worksheet1['numRows']; $i++) {
				$cells = $worksheet1['cells'][$i];
				$email = strtolower(trim($cells[1]));
				//$code = password_hash($email, PASSWORD_DEFAULT);
				if (valid_email($email)) {
					$id_leaders = $this->input->get_post('fleaders');
					$code = base64_encode(serialize($id . "_" . $email . "_" . $id_leaders));
					$data_insert = array(
						'f_leaders' => $id_leaders,
						'f_event_id' => $id,
						'f_email' => $email,
						'f_code' => $code,
						'f_send_email' => 'no',
						'f_respon' => 'no',
						'f_resend' => 0,
						'f_nama' => $cells[2],
						'f_nik' => $cells[3],
						'f_gender' => $cells[4],
						'f_age' => $cells[5],
						'f_length_of_service' => $cells[6],
						'f_level_of_work' => $cells[7],
						'f_region' => $cells[8],
						'f_level_1' => $cells[9],
						'f_level_2' => $cells[10],
						'f_level_3' => $cells[11],
						'f_level_4' => $cells[12],
						'f_level_5' => $cells[13],
						'f_pendidikan' => $cells[14]
					);
					//opn($data_insert);
					$insert_query = $this->db->insert_string('t_event_email', $data_insert);
					$insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
					//echo $insert_query.br();
					if ($email) {
						$this->db->query($insert_query);
						$total++;
					}
				}
			}
			if ($total > 0)	echo json_encode(array('msg' => true));
			else	echo json_encode(array('msg' => false, 'status' => 'Gagal input'));
		} else {
			echo json_encode(array('msg' => false, 'status' => 'Bukan Excel'));
		}
	}

	function sendEmail($id)
	{
		//error_reporting(-1);
		//ini_set('display_errors', 1);
		$link = $this->mo_events->getDataId($id);
		$result = $this->mo_events->getDataTemplate($id);
		$this->db->where('f_send_email', 'no');
		$email = $this->mo_events->getDataEmail($id);
		if ($email) {
			$datanail = array();
			$maxblast = 900;
			$count = count($email);
			$core = ceil($count / $maxblast);

			$date_trx = date('Y-m-d H:i:s');
			$date_trx = new DateTime($date_trx);
			//$date_trx->add(new DateInterval('PT1M')); // schedule 1 menit
			$date_trx->add(new DateInterval('PT1H07M')); // khusus telkom
			$_date = $date_trx->format('Y-m-d H:i:s');
			$deliverytime = $date_trx->format('D, d M Y H:i:s O');

			// TEMPLATE
			$data['result'] = $result;
			$account_plus = array(40343, 40361, 40521);
			//if($link['f_account_id'] == 40343) $html = $this->load->view('vw_event_email_template_mailgun_40343',$data,true);
			if (in_array($link['f_account_id'], $account_plus))	$html = $this->load->view('tmp/vw_event_email_template_mailgun_' . $link['f_account_id'], $data, true);
			else $html = $this->load->view('vw_event_email_template_mailgun', $data, true);

			//echo $count."<br/>"; 
			//echo ceil($count/$bagi)."<br/>"; 
			if ($email) {
				$a = 0;
				$b = 1;
				foreach ($email as $c => $d) :
					// create to send
					$datanail[$a]['to'][] = $d['f_email'];
					// create parameter to replace
					$datanail[$a]['var'][$d['f_email']] = array('codelink' => $d['f_code']);
					//create schedule send
					$datanail[$a]['sending_hours'] = $deliverytime;
					$b++;
					if ($b % $maxblast == 0) {
						//$jam+=1;
						$jam += 50;
						//echo "$a $jam\n";
						$date_c = new DateTime($_date);
						//$date_c->add(new DateInterval("PT".$jam."H30M")); // schedule 1 jam 30 Menit
						$date_c->add(new DateInterval("PT" . $jam . "M")); // schedule 1 jam
						$deliverytime = $date_c->format('D, d M Y H:i:s O');
						$a += 1;
					}
				endforeach;

				/* PROSES MAILGUN DIMULAI */
				//$mgClient = new Mailgun('key-ddb363d2425d6e08d26c65af79ec45f1');
				$domain = "actconsulting.id";

				for ($i = 0; $i < count($datanail); $i++) {
					$vrecipient[$i] = json_encode($datanail[$i]['var']);
					//$result_email = $mgClient->sendMessage($domain, array(
					//'from'    => 'ACT Consulting <assessment@actconsulting.co>',
					//'to'      => $datanail[$i]['to'],
					//'subject' => $result['f_subject'],
					//'html'	=> $html,
					//'o:deliverytime' => $datanail[$i]['sending_hours'],
					//'recipient-variables' => $vrecipient[$i]
					//));			
				}
				echo json_encode(array('status' => 'ok', 'respom' => 'Send email'));
			} else {
				echo json_encode(array('status' => 'no', 'respom' => 'No send email'));
			}
			//echo count($datanail)."<br/>"; 
			//echo "<pre>";echo print_r($email)."</pre><br/>";
			//echo "<pre>";echo print_r($datanail)."</pre><br/>";
			//echo "<pre>";echo json_encode($datanail['var'])."</pre><br/>";
			//$vrecipient = json_encode($datanail['var']);
			//$data['result'] = $result;
			//$html = $this->load->view('vw_event_email_template_mailgun',$data,true);
		} else {
			echo json_encode(array('status' => 'no', 'respom' => 'Tak ada data'));
		}
	}

	function sendEmailReminder($id)
	{
		$link = $this->mo_events->getDataId($id);
		$result = $this->mo_events->getDataTemplate($id);
		$this->db->where('f_survey_valid', 'no');
		$email = $this->mo_events->getDataEmail($id);
		if ($email) {
			$datanail = array();
			$maxblast = 500;
			$count = count($email);
			$core = ceil($count / $maxblast);

			$date_trx = date('Y-m-d H:i:s');
			$date_trx = new DateTime($date_trx);
			$date_trx->add(new DateInterval('PT1M')); // schedule 1
			$_date = $date_trx->format('Y-m-d H:i:s');
			$deliverytime = $date_trx->format('D, d M Y H:i:s O');

			// TEMPLATE
			$data['result'] = $result;
			$account_plus = array(40343, 40361, 40521);
			//if($link['f_account_id'] == 40343) $html = $this->load->view('vw_event_email_template_mailgun_40343',$data,true);
			if (in_array($link['f_account_id'], $account_plus))	$html = $this->load->view('tmp/vw_event_email_template_mailgun_' . $link['f_account_id'], $data, true);
			else $html = $this->load->view('vw_event_email_template_mailgun', $data, true);

			//echo $count."<br/>"; 
			//echo ceil($count/$bagi)."<br/>"; 
			$a = 0;
			$b = 1;
			foreach ($email as $c => $d) :
				// create to send
				$datanail[$a]['to'][] = $d['f_email'];
				// create parameter to replace
				$datanail[$a]['var'][$d['f_email']] = array('codelink' => $d['f_code']);
				//create schedule send
				$datanail[$a]['sending_hours'] = $deliverytime;
				$b++;
				if ($b % $maxblast == 0) {
					$jam += 1;
					//echo "$a $jam\n";
					$date_c = new DateTime($_date);
					$date_c->add(new DateInterval("PT" . $jam . "H30M")); // schedule 1 jam 30 Menit
					$deliverytime = $date_c->format('D, d M Y H:i:s O');
					$a += 1;
				}
			endforeach;

			/* PROSES MAILGUN DIMULAI */
			//$mgClient = new Mailgun('key-ddb363d2425d6e08d26c65af79ec45f1');
			$domain = "actconsulting.id";

			for ($i = 0; $i < count($datanail); $i++) {
				$vrecipient[$i] = json_encode($datanail[$i]['var']);
				//$result_email = $mgClient->sendMessage($domain, array(
				//'from'    => 'ACT Consulting <assessment@actconsulting.co>',
				//'to'      => $datanail[$i]['to'],
				//'subject' => $result['f_subject'],
				//'html'	=> $html,
				//'o:deliverytime' => $datanail[$i]['sending_hours'],
				//'recipient-variables' => $vrecipient[$i]
				//));			
			}
			echo json_encode(array('status' => 'ok', 'respom' => 'Send email'));
			//echo count($datanail)."<br/>"; 
			//echo "<pre>";echo print_r($email)."</pre><br/>";
			//echo "<pre>";echo print_r($datanail)."</pre><br/>";
			//echo "<pre>";echo json_encode($datanail['var'])."</pre><br/>";
			//$vrecipient = json_encode($datanail['var']);
			//$data['result'] = $result;
			//$html = $this->load->view('vw_event_email_template_mailgun',$data,true);
		} else {
			echo json_encode(array('status' => 'no', 'respom' => 'Tak ada data'));
		}
	}

	function sendAlone($id)
	{
		$link = $this->mo_events->getDataId($id);
		$result = $this->mo_events->getDataTemplate($id);
		$this->db->where('f_code', $this->input->get_post('fcode'));
		$this->db->where('f_survey_valid', 'no');
		$email = $this->mo_events->getDataEmail($id);
		if ($email) {
			$datanail = array();
			$maxblast = 2;
			$count = count($email);
			$core = ceil($count / $maxblast);

			$date_trx = date('Y-m-d H:i:s');
			$date_trx = new DateTime($date_trx);
			$date_trx->add(new DateInterval('PT5M')); // schedule 1 hari 1 jam
			$_date = $date_trx->format('Y-m-d H:i:s');
			$deliverytime = $date_trx->format('D, d M Y H:i:s O');

			// TEMPLATE
			$data['result'] = $result;
			$account_plus = array(40343, 40361, 40521);
			if (in_array($link['f_account_id'], $account_plus))	$html = $this->load->view('tmp/vw_event_email_template_mailgun_' . $link['f_account_id'], $data, true);
			else $html = $this->load->view('vw_event_email_template_mailgun', $data, true);

			if ($email) {
				$a = 0;
				$b = 1;
				foreach ($email as $c => $d) :
					// create to send
					$emailnya = $d['f_email'];
					//$emailnya = 'mustopa.amin@esq165.co.id';
					$datanail[$a]['to'][] = $emailnya;
					// create parameter to replace
					$datanail[$a]['var'][$emailnya] = array('codelink' => $d['f_code']);
					//create schedule send
					$datanail[$a]['sending_hours'] = $deliverytime;
					$b++;
					if ($b % $maxblast == 0) {
						$jam += 1;
						//echo "$a $jam\n";
						$date_c = new DateTime($_date);
						$date_c->add(new DateInterval("PT" . $jam . "H30M")); // schedule 1 jam 30 Menit
						$deliverytime = $date_c->format('D, d M Y H:i:s O');
						$a += 1;
					}
				endforeach;

				/* PROSES MAILGUN DIMULAI */
				//$mgClient = new Mailgun('key-ddb363d2425d6e08d26c65af79ec45f1');
				$domain = "actconsulting.id";

				//for($i=0;$i<count($datanail);$i++)
				//{
				$i = 0;
				$vrecipient[$i] = json_encode($datanail[$i]['var']);
				//$result_email = $mgClient->sendMessage($domain, array(
				//'from'    => 'ACT Consulting <assessment@actconsulting.id>',
				//'to'      => $datanail[$i]['to'],
				//'subject' => $result['f_subject'],
				//'html'	=> $html,
				//'o:deliverytime' => $datanail[$i]['sending_hours'],
				//'recipient-variables' => $vrecipient[$i]
				//));
				//echo "<pre>";echo print_r($result_email)."</pre><br/>";
				//}
				if ($result_email->http_response_code == 200)
					echo json_encode(array('status' => 200, 'respon' => 'Send email'));
				else
					echo json_encode(array('status' => 500, 'respon' => 'No send email'));
			} else {
				echo json_encode(array('status' => 500, 'respon' => 'No found email'));
			}
		} else {
			echo json_encode(array('status' => 500, 'respon' => 'Tak ada data'));
		}
	}

	function fnDeleteAllEmail($id)
	{
		//error_reporting(-1);
		//ini_set('display_errors', 1);
		$this->db->trans_start();
		$this->db->where('f_event_id', $id);
		//echo $this->mo_events->table;
		$this->db->delete($this->mo_events->table . '_email');
		//echo $this->db->last_query();
		$this->db->trans_complete();
		if ($this->db->trans_status()) echo json_encode(array('status' => 200));
		else echo json_encode(array('status' => 500, 'pesan' => 'Terjadi Kesalahan'));
	}

	function fnDeleteOneEmail($id)
	{
		//error_reporting(-1);
		//ini_set('display_errors', 1);
		$this->db->trans_start();
		$this->db->where('f_code', $this->input->get_post('fcode'));
		$this->db->where('f_event_id', $id);
		//echo $this->mo_events->table;
		$this->db->delete($this->mo_events->table . '_email');
		//echo $this->db->last_query();
		$this->db->trans_complete();
		if ($this->db->trans_status()) echo json_encode(array('status' => 200));
		else echo json_encode(array('status' => 500, 'pesan' => 'Terjadi Kesalahan'));
	}

	public function fnSaveTemplate($id)
	{
		$data = array(
			'f_subject' => $this->input->post('f_subject_name'),
			'f_header' => $this->input->post('f_header_name'),
			'f_header_color' => $this->input->post('header_color'),
			'f_body' => $this->input->post('f_tmp_text'),
			'f_button' => $this->input->post('f_button_name'),
			'f_button_color' => $this->input->post('button_color'),
			'f_update_on' => date('Y-m-d H:i:s'),
		);
		$this->db->where('f_event_id', $id);
		$sql = $this->db->update('t_event_template', $data);
		if ($sql)
			echo json_encode(array('msg' => true, 'tanggal' => $data['f_update_on']));
		else
			echo json_encode(array('msg' => false));
	}

	public function fnSaveTemplateLeader($id)
	{
		$data = array(
			'f_subject' => $this->input->post('f_subject_name_leader'),
			'f_header' => $this->input->post('f_header_name_leader'),
			'f_header_color' => $this->input->post('header_color_leader'),
			'f_body' => $this->input->post('f_tmp_text_leader'),
			'f_button' => $this->input->post('f_button_name_leader'),
			'f_button_color' => $this->input->post('button_color_leader'),
			'f_update_on' => date('Y-m-d H:i:s'),
		);
		$this->db->where('f_event_id', $id);
		$sql = $this->db->update('t_event_template_leader', $data);
		if ($sql)
			echo json_encode(array('msg' => true, 'tanggal' => $data['f_update_on']));
		else
			echo json_encode(array('msg' => false));
	}

	function fnPreviewTemplate()
	{
		$result = array(
			'f_subject' => $_GET['f_subject_name'],
			'f_header' => $_GET['f_header_name'],
			'f_header_color' => $_GET['header_color'],
			'f_body' => $_GET['f_tmp_text'],
			'f_button' => $_GET['f_button_name'],
			'f_button_color' => $_GET['button_color'],
		);
		$data['result'] = $result;
		$this->load->view('vw_event_email_template_mailgun', $data);
	}

	function fnPreviewTemplateLeader()
	{
		$result = array(
			'f_subject' => $_GET['f_subject_name_leader'],
			'f_header' => $_GET['f_header_name_leader'],
			'f_header_color' => $_GET['header_color_leader'],
			'f_body' => $_GET['f_tmp_text_leader'],
			'f_button' => $_GET['f_button_name_leader'],
			'f_button_color' => $_GET['button_color_leader'],
		);
		$data['result'] = $result;
		$this->load->view('vw_event_email_template_mailgun', $data);
	}
}

/* End of file Events.php */
/* Location: ./application/modules/Events/controllers/Events.php */
