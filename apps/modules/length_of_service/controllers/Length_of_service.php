<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Length_of_service extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->model('mo_length_of_service');
    }

	public function index()
    {
		$data = array(
			'app_title'=>'Data Length of service',
			'app_desc' =>'it all Length of service'
		);
		
        $data['side_main']	= 'length_of_service';
        $data['content']	= 'vw_length_of_service';
        $this->load->view('admin/main', $data);
    }

	public function fnLength_of_serviceDataJson()
	{
		$button = '';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnEdit($1)" class="tip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnDelete($1)" class="tip" title="Hapus"><i class="text-red glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;';

		$this->load->library('dtable');
		$this->dtable->select('f_id,f_service_desc,f_service_aktif');
		$this->dtable->where('f_account_id',$this->session->userdata('f_account_id'));
		$this->dtable->from('table_length_of_service');
		$this->dtable->add_column('Aksi',$button,'f_id');
		
		echo $this->dtable->generate();		
	}

	public function fnLength_of_serviceDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_length_of_service->getDataId($id);
		echo json_encode($data);		
	}

	//Untuk Form Terpisah
	public function fnLength_of_serviceAdd()
    {
		$data = array(
			'app_title'=>'Form Length of service',
			'app_desc' =>'it all Form Length_of_service',
			'form_header'	=>'<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        $data['side_main']	= 'length_of_service';
        $data['content']	= 'vw_length_of_service_add';
        $this->load->view('admin/main', $data);
    }

	public function fnLength_of_serviceSave()
	{
		if($this->mo_length_of_service->saveData())
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
	public function fnLength_of_serviceEdit($id)
    {
		$data = array(
			'app_title'=>'Form Length_of_service',
			'app_desc' =>'it all Form Length_of_service',
			'form_header'	=>'<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>$id,
		);
		
        $data['side_main']	= 'length_of_service';
        $data['content']	= 'vw_length_of_service_add';
        $this->load->view('admin/main', $data);
    }

	public function fnLength_of_serviceUpdate()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_length_of_service->updateData($id))
		{
			$this->session->set_userdata('SUCMSG','Sukses Edit !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	public function fnLength_of_serviceSwitch()
	{
		if($this->mo_length_of_service->switchData())
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}

	public function fnLength_of_serviceDelete()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_length_of_service->deleteData($id))
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}

	public function fnLength_of_serviceComboData()
	{
		$json['result'] = $this->mo_length_of_service->remoteComboData();
		echo json_encode($json);
	}

	public function fnLength_of_serviceExcel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "table_length_of_service.xls";
        $judul = "table_length_of_service";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Service Desc");
		xlsWriteLabel($tablehead, $kolomhead++, "F Service Aktif");

		foreach ($this->mo_length_of_service->fnGetData() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_id);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_account_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_service_desc);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_service_aktif);

			$tablebody++;
			$nourut++;
        }

        xlsEOF();
        exit();
	}

	public function fnLength_of_serviceWord()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=table_length_of_service.doc");

        $data = array(
            'table_length_of_service_data' => $this->mo_length_of_service->fnGetData(),
            'start' => 0
        );
        
        $this->load->view('vw_length_of_service_doc',$data);
    }

}

/* End of file Length_of_service.php */
/* Location: ./application/modules/Length_of_service/controllers/Length_of_service.php */ 
