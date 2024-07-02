<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Position5 extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->model('mo_position5');
    }

	public function index()
    {
		$data = array(
			'app_title'=>'Data Position5',
			'app_desc' =>'it all Position5'
		);
		
        $data['side_main']	= 'position5';
        $data['content']	= 'vw_position5';
        $this->load->view('admin/main', $data);
    }

	public function fnPosition5DataJson()
	{
		$button = '';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnEdit($1)" class="tip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnDelete($1)" class="tip" title="Hapus"><i class="text-red glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;';

		$this->load->library('dtable');
		$this->dtable->select('a.f_id,b.f_position_desc f_desc4,a.f_position_desc,a.f_total,a.f_total_min,a.f_aktif');
		$this->dtable->where('a.f_account_id',$this->session->userdata('f_account_id'));
		$this->dtable->join('table_level_position4 b','b.f_id=a.f_id4');
		$this->dtable->from('table_level_position5 a');
		//$this->dtable->add_column('Aksi',$button,'f_id');
		
		echo $this->dtable->generate();		
	}

	public function fnPosition5DataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_position5->getDataId($id);
		echo json_encode($data);		
	}

	//Untuk Form Terpisah
	public function fnPosition5Add()
    {
		$data = array(
			'app_title'=>'Form Position5',
			'app_desc' =>'it all Form Position5',
			'form_header'	=>'<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        $data['side_main']	= 'position5';
        $data['content']	= 'vw_position5_add';
        $this->load->view('admin/main', $data);
    }

	public function fnPosition5Save()
	{
		if($this->mo_position5->saveData())
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
	public function fnPosition5Edit($id)
    {
		$data = array(
			'app_title'=>'Form Position5',
			'app_desc' =>'it all Form Position5',
			'form_header'	=>'<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>$id,
		);
		
        $data['side_main']	= 'position5';
        $data['content']	= 'vw_position5_add';
        $this->load->view('admin/main', $data);
    }

	public function fnPosition5Update()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_position5->updateData($id))
		{
			$this->session->set_userdata('SUCMSG','Sukses Edit !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	public function fnPosition5Switch()
	{
		if($this->mo_position5->switchData())
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}

	public function fnPosition5Delete()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_position5->deleteData($id))
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}

	public function fnPosition5ComboData()
	{
		$json['result'] = $this->mo_position5->remoteComboData();
		echo json_encode($json);
	}

	public function fnPosition5Excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "table_level_position5.xls";
        $judul = "table_level_position5";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Id4");
		xlsWriteLabel($tablehead, $kolomhead++, "F Position Desc");
		xlsWriteLabel($tablehead, $kolomhead++, "F Total");
		xlsWriteLabel($tablehead, $kolomhead++, "F Aktif");

		foreach ($this->mo_position5->fnGetData() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_id);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_account_id);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_id4);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_position_desc);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_total);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_aktif);

			$tablebody++;
			$nourut++;
        }

        xlsEOF();
        exit();
	}

	public function fnPosition5Word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=table_level_position5.doc");

        $data = array(
            'table_level_position5_data' => $this->mo_position5->fnGetData(),
            'start' => 0
        );
        
        $this->load->view('vw_position5_doc',$data);
    }

}

/* End of file Position5.php */
/* Location: ./application/modules/Position5/controllers/Position5.php */ 
