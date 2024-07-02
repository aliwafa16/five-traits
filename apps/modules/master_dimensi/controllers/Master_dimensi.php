<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Master_dimensi extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$this->load->model('mo_master_dimensi');
	}

	public function index()
	{
		$data = array(
			'app_title' => 'Data Master Dimensi',
			'app_desc' => 'it all Master Dimensi'
		);

		$data['side_main']	= 'master_dimensi';
		$data['content']	= 'vw_master_dimensi';
		$this->load->view('admin/main', $data);
	}

	public function fnMaster_dimensiDataJson()
	{
		$button = '';
		//$button .= '&nbsp;&nbsp;<a href="#" onclick="fnEdit($1)" class="tip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;';
		//$button .= '&nbsp;&nbsp;<a href="#" onclick="fnDelete($1)" class="tip" title="Hapus"><i class="text-red glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;';

		$this->load->library('dtable');
		$this->dtable->select('a.f_id,a.f_dimensi_name,a.f_variabel_id,b.f_variabel_name');
		$this->dtable->join('t_variabel b', 'b.f_id=a.f_variabel_id');
		$this->dtable->from('t_dimensi a');
		//$this->dtable->add_column('Aksi',$button,'f_id');

		echo $this->dtable->generate();
	}

	public function fnMaster_dimensiDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_master_dimensi->getDataId($id);
		echo json_encode($data);
	}

	//Untuk Form Terpisah
	public function fnMaster_dimensiAdd()
	{
		$data = array(
			'app_title' => 'Form Master Dimensi',
			'app_desc' => 'it all Form Master Dimensi',
			'form_header'	=> '<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=> 'Add',
			'variabel' => $this->db->get('t_variabel')->result_array(),
		);

		$data['side_main']	= 'master_dimensi';
		$data['content']	= 'vw_master_dimensi_add';
		$this->load->view('admin/main', $data);
	}

	public function fnMaster_dimensiSave()
	{
		if ($this->mo_master_dimensi->saveData()) {
			$this->session->set_userdata('SUCMSG', 'Sukses Tambah !!!');
			echo json_encode(array('msg' => true));
		} else {
			echo json_encode(array('msg' => false));
		}
	}

	//Untuk Form Terpisah
	public function fnMaster_dimensiEdit($id)
	{
		$data = array(
			'app_title' => 'Form Master Dimensi',
			'app_desc' => 'it all Form Master Dimensi',
			'form_header'	=> '<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=> 'Edit',
			'fId'			=> $id,
			'variabel' => $this->db->get('t_variabel')->result_array(),
			'resp' => $this->mo_master_dimensi->getDataId($id),
		);

		$data['side_main']	= 'master_dimensi';
		$data['content']	= 'vw_master_dimensi_add';
		$this->load->view('admin/main', $data);
	}

	public function fnMaster_dimensiUpdate()
	{
		$id 	= $this->input->get_post('id');
		if ($this->mo_master_dimensi->updateData($id)) {
			$this->session->set_userdata('SUCMSG', 'Sukses Edit !!!');
			echo json_encode(array('msg' => true));
		} else {
			echo json_encode(array('msg' => false));
		}
	}

	public function fnMaster_dimensiDelete()
	{
		echo json_encode(array('msg' => true, 'pesan' => 'Gagal'));
		die();
		//$id 	= $this->input->get_post('id');
		//if($this->mo_master_dimensi->deleteData($id))
		//{
		//echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		//}
		//else
		//{
		//echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		//}		
	}

	public function fnMaster_dimensiComboData()
	{
		$json['result'] = $this->mo_master_dimensi->remoteComboData();
		echo json_encode($json);
	}

	public function fnMaster_dimensiExcel()
	{
		$this->load->helper('exportexcel');
		$namaFile = "t_dimensi.xls";
		$judul = "t_dimensi";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Dimensi Name");
		xlsWriteLabel($tablehead, $kolomhead++, "F Variabel Id");

		foreach ($this->mo_master_dimensi->fnGetData() as $data) {
			$kolombody = 0;

			//ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
			xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_dimensi_name);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_variabel_id);

			$tablebody++;
			$nourut++;
		}

		xlsEOF();
		exit();
	}

	public function fnMaster_dimensiWord()
	{
		header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment;Filename=t_dimensi.doc");

		$data = array(
			't_dimensi_data' => $this->mo_master_dimensi->fnGetData(),
			'start' => 0
		);

		$this->load->view('vw_master_dimensi_doc', $data);
	}
}

/* End of file Master_dimensi.php */
/* Location: ./application/modules/Master_dimensi/controllers/Master_dimensi.php */
