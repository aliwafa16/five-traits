<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Work extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->model('mo_work');
    }

	public function index()
    {
		$data = array(
			'app_title'=>'Data Work',
			'app_desc' =>'it all Work'
		);
		
        $data['side_main']	= 'work';
        $data['content']	= 'vw_work';
        $this->load->view('admin/main', $data);
    }

	public function fnWorkDataJson()
	{
		$button = '';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnEdit($1)" class="tip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnDelete($1)" class="tip" title="Hapus"><i class="text-red glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;';

		$this->load->library('dtable');
		$this->dtable->select('f_id,f_levelwork_desc,f_aktif');
		$this->dtable->where('f_account_id',$this->session->userdata('f_account_id'));
		$this->dtable->from('table_level_work');
		$this->dtable->add_column('Aksi',$button,'f_id');
		
		echo $this->dtable->generate();		
	}

	public function fnWorkDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_work->getDataId($id);
		echo json_encode($data);		
	}

	//Untuk Form Terpisah
	public function fnWorkAdd()
    {
		$data = array(
			'app_title'=>'Form Work',
			'app_desc' =>'it all Form Work',
			'form_header'	=>'<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        $data['side_main']	= 'work';
        $data['content']	= 'vw_work_add';
        $this->load->view('admin/main', $data);
    }

	public function fnWorkSave()
	{
		if($this->mo_work->saveData())
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
	public function fnWorkEdit($id)
    {
		$data = array(
			'app_title'=>'Form Work',
			'app_desc' =>'it all Form Work',
			'form_header'	=>'<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>$id,
		);
		
        $data['side_main']	= 'work';
        $data['content']	= 'vw_work_add';
        $this->load->view('admin/main', $data);
    }

	public function fnWorkUpdate()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_work->updateData($id))
		{
			$this->session->set_userdata('SUCMSG','Sukses Edit !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	public function fnWorkSwitch()
	{
		if($this->mo_work->switchData())
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}

	public function fnWorkDelete()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_work->deleteData($id))
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}

	public function fnWorkComboData()
	{
		$json['result'] = $this->mo_work->remoteComboData();
		echo json_encode($json);
	}

	public function fnWorkExcel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "table_level_work.xls";
        $judul = "table_level_work";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Levelwork Desc");
		xlsWriteLabel($tablehead, $kolomhead++, "F Aktif");

		foreach ($this->mo_work->fnGetData() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_id);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_account_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_levelwork_desc);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_aktif);

			$tablebody++;
			$nourut++;
        }

        xlsEOF();
        exit();
	}

	public function fnWorkWord()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=table_level_work.doc");

        $data = array(
            'table_level_work_data' => $this->mo_work->fnGetData(),
            'start' => 0
        );
        
        $this->load->view('vw_work_doc',$data);
    }

}

/* End of file Work.php */
/* Location: ./application/modules/Work/controllers/Work.php */ 
