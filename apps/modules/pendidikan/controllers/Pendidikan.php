<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Pendidikan extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->model('mo_pendidikan');
    }

	public function index()
    {
		$data = array(
			'app_title'=>'Data Pendidikan',
			'app_desc' =>'it all Pendidikan'
		);
		
        $data['side_main']	= 'pendidikan';
        $data['content']	= 'vw_pendidikan';
        $this->load->view('admin/main', $data);
    }

	public function fnPendidikanDataJson()
	{
		$button = '';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnEdit($1)" class="tip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnDelete($1)" class="tip" title="Hapus"><i class="text-red glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;';

		$this->load->library('dtable');
		$this->dtable->select('f_id,f_name,f_aktif');
		$this->dtable->where('f_account_id',$this->session->userdata('f_account_id'));
		$this->dtable->from('table_pendidikan');
		$this->dtable->add_column('Aksi',$button,'f_account_id');
		
		echo $this->dtable->generate();		
	}

	public function fnPendidikanDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_pendidikan->getDataId($id);
		echo json_encode($data);		
	}

	//Untuk Form Terpisah
	public function fnPendidikanAdd()
    {
		$data = array(
			'app_title'=>'Form Pendidikan',
			'app_desc' =>'it all Form Pendidikan',
			'form_header'	=>'<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        $data['side_main']	= 'pendidikan';
        $data['content']	= 'vw_pendidikan_add';
        $this->load->view('admin/main', $data);
    }

	public function fnPendidikanSave()
	{
		if($this->mo_pendidikan->saveData())
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
	public function fnPendidikanEdit($id)
    {
		$data = array(
			'app_title'=>'Form Pendidikan',
			'app_desc' =>'it all Form Pendidikan',
			'form_header'	=>'<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>$id,
		);
		
        $data['side_main']	= 'pendidikan';
        $data['content']	= 'vw_pendidikan_add';
        $this->load->view('admin/main', $data);
    }

	public function fnPendidikanUpdate()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_pendidikan->updateData($id))
		{
			$this->session->set_userdata('SUCMSG','Sukses Edit !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	public function fnPendidikanSwitch()
	{
		if($this->mo_pendidikan->switchData())
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}

	public function fnPendidikanDelete()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_pendidikan->deleteData($id))
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}

	public function fnPendidikanComboData()
	{
		$json['result'] = $this->mo_pendidikan->remoteComboData();
		echo json_encode($json);
	}

	public function fnPendidikanExcel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "table_pendidikan.xls";
        $judul = "table_pendidikan";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Name");
		xlsWriteLabel($tablehead, $kolomhead++, "F Aktif");

		foreach ($this->mo_pendidikan->fnGetData() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_id);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_account_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_name);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_aktif);

			$tablebody++;
			$nourut++;
        }

        xlsEOF();
        exit();
	}

	public function fnPendidikanWord()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=table_pendidikan.doc");

        $data = array(
            'table_pendidikan_data' => $this->mo_pendidikan->fnGetData(),
            'start' => 0
        );
        
        $this->load->view('vw_pendidikan_doc',$data);
    }

}

/* End of file Pendidikan.php */
/* Location: ./application/modules/Pendidikan/controllers/Pendidikan.php */ 
