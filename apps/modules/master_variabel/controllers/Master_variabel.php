<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Master_variabel extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
	  	if(!$this->ion_auth->is_admin()) redirect($this->agent->referrer());
        $this->load->model('mo_master_variabel');
    }

	public function index()
    {
		$data = array(
			'app_title'=>'Data Master Variabel',
			'app_desc' =>'it all Master Variabel'
		);
		
        $data['side_main']	= 'master_variabel';
        $data['content']	= 'vw_master_variabel';
        $this->load->view('admin/main', $data);
    }

	public function fnMaster_variabelDataJson()
	{
		$button = '';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnEdit($1)" class="tip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnDelete($1)" class="tip" title="Hapus"><i class="text-red glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;';

		$this->load->library('dtable');
		$this->dtable->select('f_id,f_variabel_name');
		$this->dtable->from('t_variabel');
		$this->dtable->add_column('Aksi',$button,'f_id');
		
		echo $this->dtable->generate();		
	}

	public function fnMaster_variabelDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_master_variabel->getDataId($id);
		echo json_encode($data);		
	}

	//Untuk Form Terpisah
	public function fnMaster_variabelAdd()
    {
		$data = array(
			'app_title'=>'Form Master Variabel',
			'app_desc' =>'it all Form Master Variabel',
			'form_header'	=>'<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        $data['side_main']	= 'master_variabel';
        $data['content']	= 'vw_master_variabel_add';
        $this->load->view('admin/main', $data);
    }

	public function fnMaster_variabelSave()
	{
		if($this->mo_master_variabel->saveData())
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
	public function fnMaster_variabelEdit($id)
    {
		$data = array(
			'app_title'=>'Form Master Variabel',
			'app_desc' =>'it all Form Master Variabel',
			'form_header'	=>'<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>$id,
		);
		
        $data['side_main']	= 'master_variabel';
        $data['content']	= 'vw_master_variabel_add';
        $this->load->view('admin/main', $data);
    }

	public function fnMaster_variabelUpdate()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_master_variabel->updateData($id))
		{
			$this->session->set_userdata('SUCMSG','Sukses Edit !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	public function fnMaster_variabelDelete()
	{
		echo json_encode(array('msg'=>false));die();
		//$id 	= $this->input->get_post('id');
		//if($this->mo_master_variabel->deleteData($id))
		//{
			//echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		//}
		//else
		//{
			//echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		//}		
	}

	public function fnMaster_variabelComboData()
	{
		$json['result'] = $this->mo_master_variabel->remoteComboData();
		echo json_encode($json);
	}

	public function fnMaster_variabelExcel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t_variabel.xls";
        $judul = "t_variabel";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Variabel Name");
		xlsWriteLabel($tablehead, $kolomhead++, "F Created On");

		foreach ($this->mo_master_variabel->fnGetData() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_variabel_name);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_created_on);

			$tablebody++;
			$nourut++;
        }

        xlsEOF();
        exit();
	}

	public function fnMaster_variabelWord()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t_variabel.doc");

        $data = array(
            't_variabel_data' => $this->mo_master_variabel->fnGetData(),
            'start' => 0
        );
        
        $this->load->view('vw_master_variabel_doc',$data);
    }

}

/* End of file Master_variabel.php */
/* Location: ./application/modules/Master_variabel/controllers/Master_variabel.php */ 
