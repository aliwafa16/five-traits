<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Gender extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->model('mo_gender');
    }

	public function index()
    {
		$data = array(
			'app_title'=>'Data Gender',
			'app_desc' =>'it all Gender'
		);
		
        $data['side_main']	= 'gender';
        $data['content']	= 'vw_gender';
        $this->load->view('admin/main', $data);
    }

	public function fnGenderDataJson()
	{
		$button = '';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnEdit($1)" class="tip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnDelete($1)" class="tip" title="Hapus"><i class="text-red glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;';

		$this->load->library('dtable');
		$this->dtable->select('f_gender_id,f_gender_name');
		$this->dtable->where('f_account_id',$this->session->userdata('f_account_id'));
		$this->dtable->from('table_gender');
		$this->dtable->add_column('Aksi',$button,'f_gender_id');
		
		echo $this->dtable->generate();		
	}

	public function fnGenderDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_gender->getDataId($id);
		echo json_encode($data);		
	}

	//Untuk Form Terpisah
	public function fnGenderAdd()
    {
		$data = array(
			'app_title'=>'Form Gender',
			'app_desc' =>'it all Form Gender',
			'form_header'	=>'<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        $data['side_main']	= 'gender';
        $data['content']	= 'vw_gender_add';
        $this->load->view('admin/main', $data);
    }

	public function fnGenderSave()
	{
		if($this->mo_gender->saveData())
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
	public function fnGenderEdit($id)
    {
		$data = array(
			'app_title'=>'Form Gender',
			'app_desc' =>'it all Form Gender',
			'form_header'	=>'<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>$id,
		);
		
        $data['side_main']	= 'gender';
        $data['content']	= 'vw_gender_add';
        $this->load->view('admin/main', $data);
    }

	public function fnGenderUpdate()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_gender->updateData($id))
		{
			$this->session->set_userdata('SUCMSG','Sukses Edit !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	public function fnGenderDelete()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_gender->deleteData($id))
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}

	public function fnGenderComboData()
	{
		$json['result'] = $this->mo_gender->remoteComboData();
		echo json_encode($json);
	}

	public function fnGenderExcel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "table_gender.xls";
        $judul = "table_gender";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Gender Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Gender Name");
		xlsWriteLabel($tablehead, $kolomhead++, "F Account Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Create Date");
		xlsWriteLabel($tablehead, $kolomhead++, "F Create By");
		xlsWriteLabel($tablehead, $kolomhead++, "F Update Date");
		xlsWriteLabel($tablehead, $kolomhead++, "F Update By");

		foreach ($this->mo_gender->fnGetData() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_gender_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_gender_name);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_account_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_create_date);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_create_by);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_update_date);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_update_by);

			$tablebody++;
			$nourut++;
        }

        xlsEOF();
        exit();
	}

	public function fnGenderWord()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=table_gender.doc");

        $data = array(
            'table_gender_data' => $this->mo_gender->fnGetData(),
            'start' => 0
        );
        
        $this->load->view('vw_gender_doc',$data);
    }

}

/* End of file Gender.php */
/* Location: ./application/modules/Gender/controllers/Gender.php */ 
