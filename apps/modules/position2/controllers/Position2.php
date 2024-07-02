<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Position2 extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->model('mo_position2');
    }

	public function index()
    {
		$data = array(
			'app_title'=>'Data Position2',
			'app_desc' =>'it all Position2'
		);
		
        $data['side_main']	= 'position2';
        $data['content']	= 'vw_position2';
        $this->load->view('admin/main', $data);
    }

	public function fnPosition2DataJson()
	{
		$button = '';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnEdit($1)" class="tip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnDelete($1)" class="tip" title="Hapus"><i class="text-red glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;';

		$this->load->library('dtable');
		$this->dtable->select('a.f_id,b.f_position_desc f_desc1,a.f_position_desc,a.f_total,a.f_total_min,a.f_aktif');
		$this->dtable->where('a.f_account_id',$this->session->userdata('f_account_id'));
		$this->dtable->join('table_level_position1 b','b.f_id=a.f_id1');
		$this->dtable->from('table_level_position2 a');
		$this->dtable->add_column('Aksi',$button,'f_id');
		
		echo $this->dtable->generate();		
	}

	public function fnPosition2DataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_position2->getDataId($id);
		echo json_encode($data);		
	}

	//Untuk Form Terpisah
	public function fnPosition2Add()
    {
		$data = array(
			'app_title'=>'Form Position2',
			'app_desc' =>'it all Form Position2',
			'form_header'	=>'<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        $data['side_main']	= 'position2';
        $data['content']	= 'vw_position2_add';
        $this->load->view('admin/main', $data);
    }

	public function fnPosition2Save()
	{
		if($this->mo_position2->saveData())
		{
			$this->session->set_userdata('SUCMSG','Sukses Tambah !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	//Untuk Form Terpisah
	public function fnPosition2Edit($id)
    {
		$data = array(
			'app_title'=>'Form Position2',
			'app_desc' =>'it all Form Position2',
			'form_header'	=>'<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>$id,
		);
		
        $data['side_main']	= 'position2';
        $data['content']	= 'vw_position2_add';
        $this->load->view('admin/main', $data);
    }

	public function fnPosition2Update()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_position2->updateData($id))
		{
			$this->session->set_userdata('SUCMSG','Sukses Edit !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	public function fnPosition2Switch()
	{
		if($this->mo_position2->switchData())
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}

	public function fnPosition2Delete()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_position2->deleteData($id))
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}

	public function fnPosition2ComboData()
	{
		$json['result'] = $this->mo_position2->remoteComboData();
		echo json_encode($json);
	}

	public function fnPosition2Excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "table_level_position2.xls";
        $judul = "table_level_position2";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Id1");
		xlsWriteLabel($tablehead, $kolomhead++, "F Position Desc");
		xlsWriteLabel($tablehead, $kolomhead++, "F Total");
		xlsWriteLabel($tablehead, $kolomhead++, "F Total Min");
		xlsWriteLabel($tablehead, $kolomhead++, "F Aktif");

		foreach ($this->mo_position2->fnGetData() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_id);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_account_id);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_id1);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_position_desc);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_total);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_total_min);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_aktif);

			$tablebody++;
			$nourut++;
        }

        xlsEOF();
        exit();
	}

	public function fnPosition2Word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=table_level_position2.doc");

        $data = array(
            'table_level_position2_data' => $this->mo_position2->fnGetData(),
            'start' => 0
        );
        
        $this->load->view('vw_position2_doc',$data);
    }

}

/* End of file Position2.php */
/* Location: ./application/modules/Position2/controllers/Position2.php */ 
