<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Reg_account extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		if (!$this->ion_auth->is_admin()) redirect($this->agent->referrer());
		$this->load->model('mo_reg_account');
	}

	public function index()
	{
		$data = array(
			'app_title' => 'Data Reg Account',
			'app_desc' => 'it all Reg Account'
		);

		$data['side_main']	= 'reg_account';
		$data['content']	= 'vw_reg_account';
		$this->load->view('admin/main', $data);
	}

	public function fnReg_accountDataJson()
	{
		$button = '';
		//$button .= '&nbsp;&nbsp;<a href="#" onclick="fnEdit($1)" class="tip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;';
		//$button .= '&nbsp;&nbsp;<a href="#" onclick="fnDelete($1)" class="tip" title="Hapus"><i class="text-red glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;';

		$this->load->library('dtable');
		$this->dtable->select('a.id,username,email,active,phone,f_account_id');
		$this->dtable->where('f_account_id >', 0);
		$this->dtable->from('users a');
		//$this->dtable->add_column('Aksi',$button,'id');

		echo $this->dtable->generate();
	}

	public function fnReg_accountDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_reg_account->getDataId($id);
		echo json_encode($data);
	}

	public function fnReg_accountDataAccountId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_reg_account->getDataAccountId($id);
		echo json_encode($data);
	}

	//Untuk Form Terpisah
	public function fnReg_accountAdd()
	{
		$data = array(
			'app_title' => 'Form Reg Account',
			'app_desc' => 'it all Form Reg Account',
			'form_header'	=> '<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=> 'Add',
		);

		$data['side_main']	= 'reg_account';
		$data['content']	= 'vw_reg_account_add';
		$this->load->view('admin/main', $data);
	}

	public function fnReg_accountSave()
	{
		if ($this->mo_reg_account->saveData()) {
			$this->session->set_userdata('SUCMSG', 'Sukses Tambah !!!');
			echo json_encode(array('msg' => true));
		} else {
			echo json_encode(array('msg' => false));
		}
	}

	function fnReg_accountSave2()
	{
		$db = $this->load->database('appesq', TRUE);
		$vData = array(
			'f_account_name' => $_POST['f_account_name'],
			'f_account_leader' => $_POST['f_account_leader'],
			'f_account_business_type' => $_POST['f_account_business_type'],
			'f_address' => $_POST['f_address'],
			'f_account_tlp' => $_POST['f_account_tlp'],
			'f_account_fax' => $_POST['f_account_fax'],
			'f_account_website' => $_POST['f_account_website'],
			'f_city_id' => $_POST['f_city_id'],
			'f_postal_code' => $_POST['f_postal_code'],
			'f_country' => $_POST['f_country'],
			'f_account_created_on' => date('Y-m-d h:i:s'),
			'f_account_created_by' => $this->session->userdata('sUsername'),
		);
		$vResult = $db->insert('t_accounts', $vData);
		if ($vResult) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false, 'msg' => 'Some errors occured.'));
		}
	}

	//Untuk Form Terpisah
	public function fnReg_accountEdit($id)
	{
		$data = array(
			'app_title' => 'Form Reg Account',
			'app_desc' => 'it all Form Reg Account',
			'form_header'	=> '<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=> 'Edit',
			'fId'			=> $id,
		);

		$data['side_main']	= 'reg_account';
		$data['content']	= 'vw_reg_account_add';
		$this->load->view('admin/main', $data);
	}

	public function fnReg_accountUpdate()
	{
		$id 	= $this->input->get_post('id');
		if ($this->mo_reg_account->updateData($id)) {
			$this->session->set_userdata('SUCMSG', 'Sukses Edit !!!');
			echo json_encode(array('msg' => true));
		} else {
			echo json_encode(array('msg' => false));
		}
	}

	public function fnReg_accountDelete()
	{
		$id 	= $this->input->get_post('id');
		if ($this->mo_reg_account->deleteData($id)) {
			echo json_encode(array('msg' => true, 'pesan' => 'Sukses'));
		} else {
			echo json_encode(array('msg' => true, 'pesan' => 'Gagal'));
		}
	}

	public function fnReg_accountComboData()
	{
		$json['result'] = $this->mo_reg_account->remoteComboData();
		echo json_encode($json);
	}

	public function fnReg_accountExcel()
	{
		$this->load->helper('exportexcel');
		$namaFile = "users.xls";
		$judul = "users";
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
		xlsWriteLabel($tablehead, $kolomhead++, "Id");
		xlsWriteLabel($tablehead, $kolomhead++, "Ip Address");
		xlsWriteLabel($tablehead, $kolomhead++, "Username");
		xlsWriteLabel($tablehead, $kolomhead++, "Password");
		xlsWriteLabel($tablehead, $kolomhead++, "Email");
		xlsWriteLabel($tablehead, $kolomhead++, "Activation Selector");
		xlsWriteLabel($tablehead, $kolomhead++, "Activation Code");
		xlsWriteLabel($tablehead, $kolomhead++, "Forgotten Password Selector");
		xlsWriteLabel($tablehead, $kolomhead++, "Forgotten Password Code");
		xlsWriteLabel($tablehead, $kolomhead++, "Forgotten Password Time");
		xlsWriteLabel($tablehead, $kolomhead++, "Remember Selector");
		xlsWriteLabel($tablehead, $kolomhead++, "Remember Code");
		xlsWriteLabel($tablehead, $kolomhead++, "Created On");
		xlsWriteLabel($tablehead, $kolomhead++, "Last Login");
		xlsWriteLabel($tablehead, $kolomhead++, "Active");
		xlsWriteLabel($tablehead, $kolomhead++, "First Name");
		xlsWriteLabel($tablehead, $kolomhead++, "Last Name");
		xlsWriteLabel($tablehead, $kolomhead++, "Company");
		xlsWriteLabel($tablehead, $kolomhead++, "Phone");

		foreach ($this->mo_reg_account->fnGetData() as $data) {
			$kolombody = 0;

			//ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
			xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->id);
			xlsWriteLabel($tablebody, $kolombody++, $data->ip_address);
			xlsWriteLabel($tablebody, $kolombody++, $data->username);
			xlsWriteLabel($tablebody, $kolombody++, $data->password);
			xlsWriteLabel($tablebody, $kolombody++, $data->email);
			xlsWriteLabel($tablebody, $kolombody++, $data->activation_selector);
			xlsWriteLabel($tablebody, $kolombody++, $data->activation_code);
			xlsWriteLabel($tablebody, $kolombody++, $data->forgotten_password_selector);
			xlsWriteLabel($tablebody, $kolombody++, $data->forgotten_password_code);
			xlsWriteNumber($tablebody, $kolombody++, $data->forgotten_password_time);
			xlsWriteLabel($tablebody, $kolombody++, $data->remember_selector);
			xlsWriteLabel($tablebody, $kolombody++, $data->remember_code);
			xlsWriteNumber($tablebody, $kolombody++, $data->created_on);
			xlsWriteNumber($tablebody, $kolombody++, $data->last_login);
			xlsWriteLabel($tablebody, $kolombody++, $data->active);
			xlsWriteLabel($tablebody, $kolombody++, $data->first_name);
			xlsWriteLabel($tablebody, $kolombody++, $data->last_name);
			xlsWriteLabel($tablebody, $kolombody++, $data->company);
			xlsWriteLabel($tablebody, $kolombody++, $data->phone);

			$tablebody++;
			$nourut++;
		}

		xlsEOF();
		exit();
	}

	public function fnReg_accountWord()
	{
		header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment;Filename=users.doc");

		$data = array(
			'users_data' => $this->mo_reg_account->fnGetData(),
			'start' => 0
		);

		$this->load->view('vw_reg_account_doc', $data);
	}

	public function remoteAccountLive()
	{
		$db = $this->load->database('appesq', TRUE);
		if ($this->input->get('term')) $db->like('a.f_account_name', $this->input->get_post('term')); // pencarian name
		$db->select('a.f_account_id,a.f_account_name,a.f_account_leader,a.f_account_tlp,b.f_city_name,c.f_province_name', false);
		$db->join('t_city b', 'a.f_city_id=b.f_city_id', 'left outer');
		$db->join('t_province c', 'c.f_province_id=b.f_province_id', 'left outer');

		if (is_array($this->input->get('id'))) $db->where_not_in('a.f_account_id', $this->input->get('id'));

		$db->limit(15);
		$sql = $db->get('t_accounts a')->result();
		$Data = array();
		foreach ($sql as $vRow) :
			$list['id'] 		= $vRow->f_account_id;
			$list['text']		= $vRow->f_account_name;
			$list['kota']		= ($vRow->f_city_name) ? $vRow->f_city_name : '-';
			$list['provinsi']	= ($vRow->f_province_name) ? $vRow->f_province_name : '-';
			$list['leader']		= ($vRow->f_account_leader) ? $vRow->f_account_leader : '-';
			$list['tlp']		= ($vRow->f_account_tlp) ? $vRow->f_account_tlp : '-';
			array_push($Data, $list);
		endforeach;
		$json['result'] = $Data;
		echo json_encode($json);
	}
}

/* End of file Reg_account.php */
/* Location: ./application/modules/Reg_account/controllers/Reg_account.php */
