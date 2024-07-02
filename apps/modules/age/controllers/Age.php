<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Age extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->model('mo_age');
    }

	public function index()
    {
		$data = array(
			'app_title'=>'Data Age',
			'app_desc' =>'it all Age'
		);
		
        $data['side_main']	= 'age';
        $data['content']	= 'vw_age';
        $this->load->view('admin/main', $data);
    }

	public function fnAgeDataJson()
	{
		$button = '';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnEdit($1)" class="tip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnDelete($1)" class="tip" title="Hapus"><i class="text-red glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;';

		$this->load->library('dtable');
		$this->dtable->select('f_id,f_age_desc,f_age_aktif');
		$this->dtable->where('f_account_id',$this->session->userdata('f_account_id'));
		$this->dtable->from('table_age');
		$this->dtable->add_column('Aksi',$button,'f_id');
		
		echo $this->dtable->generate();		
	}

	public function fnAgeDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_age->getDataId($id);
		echo json_encode($data);		
	}

	//Untuk Form Terpisah
	public function fnAgeAdd()
    {
		$data = array(
			'app_title'=>'Form Age',
			'app_desc' =>'it all Form Age',
			'form_header'	=>'<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        $data['side_main']	= 'age';
        $data['content']	= 'vw_age_add';
        $this->load->view('admin/main', $data);
    }

	public function fnAgeSave()
	{
		if($this->mo_age->saveData())
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
	public function fnAgeEdit($id)
    {
		$data = array(
			'app_title'=>'Form Age',
			'app_desc' =>'it all Form Age',
			'form_header'	=>'<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>$id,
		);
		
        $data['side_main']	= 'age';
        $data['content']	= 'vw_age_add';
        $this->load->view('admin/main', $data);
    }

	public function fnAgeUpdate()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_age->updateData($id))
		{
			$this->session->set_userdata('SUCMSG','Sukses Edit !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	public function fnAgeSwitch()
	{
		if($this->mo_age->switchData())
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}

	public function fnAgeDelete()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_age->deleteData($id))
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}

	public function fnAgeComboData()
	{
		$json['result'] = $this->mo_age->remoteComboData();
		echo json_encode($json);
	}

	public function fnAgeExcel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "table_age.xls";
        $judul = "table_age";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Age Desc");
		xlsWriteLabel($tablehead, $kolomhead++, "F Age Aktif");

		foreach ($this->mo_age->fnGetData() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_id);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_account_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_age_desc);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_age_aktif);

			$tablebody++;
			$nourut++;
        }

        xlsEOF();
        exit();
	}

	public function fnAgeWord()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=table_age.doc");

        $data = array(
            'table_age_data' => $this->mo_age->fnGetData(),
            'start' => 0
        );
        
        $this->load->view('vw_age_doc',$data);
    }

}

/* End of file Age.php */
/* Location: ./application/modules/Age/controllers/Age.php */ 
