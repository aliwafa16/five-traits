<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Master_item extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$this->load->model('mo_master_item');
	}

	public function index()
	{
		$data = array(
			'app_title' => 'Data Master Item',
			'app_desc' => 'it all Master Item'
		);

		$data['side_main']	= 'master_item';
		$data['content']	= 'vw_master_item';
		$this->load->view('admin/main', $data);
	}

	public function fnMaster_itemDataJson()
	{
		$button = '';
		//$button .= '&nbsp;&nbsp;<a href="#" onclick="fnEdit($1)" class="tip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;';
		//$button .= '&nbsp;&nbsp;<a href="#" onclick="fnDelete($1)" class="tip" title="Hapus"><i class="text-red glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;';

		$this->load->library('dtable');
		$this->dtable->select('a.f_id,f_item,f_variabel_id, b.f_variabel_name');
		$this->dtable->join('t_variabel b', 'b.f_id=a.f_variabel_id');
		// $this->dtable->join('t_dimensi c','c.f_id=a.f_dimensi_id');
		$this->dtable->from('t_item_pernyataan a');
		//$this->dtable->add_column('Aksi',$button,'f_id');

		echo $this->dtable->generate();
	}

	public function fnMaster_itemDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_master_item->getDataId($id);
		echo json_encode($data);
	}

	//Untuk Form Terpisah
	public function fnMaster_itemAdd()
	{
		$this->load->model('master_variabel/mo_master_variabel', 'mv');
		$data = array(
			'app_title' => 'Form Master Item',
			'app_desc' => 'it all Form Master Item',
			'form_header'	=> '<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=> 'Add',
		);

		$data['mv']	= $this->mv->comboData();
		$data['side_main']	= 'master_item';
		$data['content']	= 'vw_master_item_add';
		$this->load->view('admin/main', $data);
	}

	public function fnMaster_itemSave()
	{
		if ($this->mo_master_item->saveData()) {
			$this->session->set_userdata('SUCMSG', 'Sukses Tambah !!!');
			echo json_encode(array('msg' => true));
		} else {
			echo json_encode(array('msg' => false));
		}
	}

	//Untuk Form Terpisah
	public function fnMaster_itemEdit($id)
	{
		$this->load->model('master_variabel/mo_master_variabel', 'mv');
		$data = array(
			'app_title' => 'Form Master Item',
			'app_desc' => 'it all Form Master Item',
			'form_header'	=> '<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=> 'Edit',
			'fId'			=> $id,
		);

		$data['mv']	= $this->mv->comboData();
		$data['side_main']	= 'master_item';
		$data['content']	= 'vw_master_item_add';
		$this->load->view('admin/main', $data);
	}

	public function fnMaster_itemUpdate()
	{
		$id 	= $this->input->get_post('id');
		if ($this->mo_master_item->updateData($id)) {
			$this->session->set_userdata('SUCMSG', 'Sukses Edit !!!');
			echo json_encode(array('msg' => true));
		} else {
			echo json_encode(array('msg' => false));
		}
	}

	public function fnMaster_itemStatus()
	{
		$id 	= $this->input->get_post('id');
		$st 	= $this->input->get_post('status');

		if ($st == 1)
			$data['f_type'] = 0;
		else
			$data['f_type'] = 1;

		$this->db->where('f_id', $id);
		$sql = $this->db->update('t_item_pernyataan', $data);
		if ($sql) {
			echo TRUE;
		} else {
			echo FALSE;
		}
	}

	public function fnMaster_itemDelete()
	{
		echo json_encode(array('msg' => true, 'pesan' => 'Gagal'));
		die();
		//$id 	= $this->input->get_post('id');
		//if($this->mo_master_item->deleteData($id))
		//{
		//echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		//}
		//else
		//{
		//echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		//}		
	}

	public function fnComboDataDimensi()
	{
		$list = array();
		$this->db->where('f_variabel_id', html_escape($this->input->get('var_id', true)));
		$sql = $this->db->get('t_dimensi');
		if ($sql) {
			foreach ($sql->result() as $r) :
				$list[$r->f_id] = $r->f_dimensi_name;
			endforeach;
		}
		echo json_encode($list);
	}

	public function fnMaster_itemComboData()
	{
		$json['result'] = $this->mo_master_item->remoteComboData();
		echo json_encode($json);
	}

	public function fnMaster_itemExcel()
	{
		$this->load->helper('exportexcel');
		$namaFile = "t_item_pernyataan.xls";
		$judul = "t_item_pernyataan";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Item Name");
		xlsWriteLabel($tablehead, $kolomhead++, "F Variabel Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Dimensi Id");

		foreach ($this->mo_master_item->fnGetData() as $data) {
			$kolombody = 0;

			//ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
			xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_item_name);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_variabel_id);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_dimensi_id);

			$tablebody++;
			$nourut++;
		}

		xlsEOF();
		exit();
	}

	public function fnMaster_itemWord()
	{
		header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment;Filename=t_item_pernyataan.doc");

		$data = array(
			't_item_pernyataan_data' => $this->mo_master_item->fnGetData(),
			'start' => 0
		);

		$this->load->view('vw_master_item_doc', $data);
	}
}

/* End of file Master_item.php */
/* Location: ./application/modules/Master_item/controllers/Master_item.php */
