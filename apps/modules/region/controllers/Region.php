<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Region extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->model('mo_region');
    }

	public function index()
    {
		$data = array(
			'app_title'=>'Data Region',
			'app_desc' =>'it all Region'
		);
		
        $data['side_main']	= 'region';
        $data['content']	= 'vw_region';
        $this->load->view('admin/main', $data);
    }

	public function fnRegionDataJson()
	{
		$button = '';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnEdit($1)" class="tip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnDelete($1)" class="tip" title="Hapus"><i class="text-red glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;';

		$this->load->library('dtable');
		$this->dtable->select('f_id,f_region_name,f_region_aktif');
		$this->dtable->where('f_account_id',$this->session->userdata('f_account_id'));
		$this->dtable->from('table_region');
		$this->dtable->add_column('Aksi',$button,'f_id');
		
		echo $this->dtable->generate();		
	}

	public function fnRegionDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_region->getDataId($id);
		echo json_encode($data);		
	}

	//Untuk Form Terpisah
	public function fnRegionAdd()
    {
		$data = array(
			'app_title'=>'Form Region',
			'app_desc' =>'it all Form Region',
			'form_header'	=>'<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        $data['side_main']	= 'region';
        $data['content']	= 'vw_region_add';
        $this->load->view('admin/main', $data);
    }

	public function fnRegionSave()
	{
		if($this->mo_region->saveData())
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
	public function fnRegionEdit($id)
    {
		$data = array(
			'app_title'=>'Form Region',
			'app_desc' =>'it all Form Region',
			'form_header'	=>'<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>$id,
		);
		
        $data['side_main']	= 'region';
        $data['content']	= 'vw_region_add';
        $this->load->view('admin/main', $data);
    }

	public function fnRegionUpdate()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_region->updateData($id))
		{
			$this->session->set_userdata('SUCMSG','Sukses Edit !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	public function fnRegionSwitch()
	{
		if($this->mo_region->switchData())
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}

	public function fnRegionDelete()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_region->deleteData($id))
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}

	public function fnRegionComboData()
	{
		$json['result'] = $this->mo_region->remoteComboData();
		echo json_encode($json);
	}

	public function fnRegionExcel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "table_region.xls";
        $judul = "table_region";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Region Name");
		xlsWriteLabel($tablehead, $kolomhead++, "F Region Aktif");

		foreach ($this->mo_region->fnGetData() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_id);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_account_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_region_name);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_region_aktif);

			$tablebody++;
			$nourut++;
        }

        xlsEOF();
        exit();
	}

	public function fnRegionWord()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=table_region.doc");

        $data = array(
            'table_region_data' => $this->mo_region->fnGetData(),
            'start' => 0
        );
        
        $this->load->view('vw_region_doc',$data);
    }

}

/* End of file Region.php */
/* Location: ./application/modules/Region/controllers/Region.php */ 
