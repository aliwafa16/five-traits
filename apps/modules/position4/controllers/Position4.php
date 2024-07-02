<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Position4 extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->model('mo_position4');
    }

	public function index()
    {
		$data = array(
			'app_title'=>'Data Position4',
			'app_desc' =>'it all Position4'
		);
		
        $data['side_main']	= 'position4';
        $data['content']	= 'vw_position4';
        $this->load->view('admin/main', $data);
    }

	public function fnPosition4DataJson()
	{
		$button = '';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnEdit($1)" class="tip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnDelete($1)" class="tip" title="Hapus"><i class="text-red glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;';

		$this->load->library('dtable');
		$this->dtable->select('a.f_id,b.f_position_desc f_desc3,a.f_position_desc,a.f_total,a.f_total_min,a.f_aktif');
		$this->dtable->where('a.f_account_id',$this->session->userdata('f_account_id'));
		$this->dtable->join('table_level_position3 b','b.f_id=a.f_id3');
		$this->dtable->from('table_level_position4 a');
		//$this->dtable->add_column('Aksi',$button,'f_id');
		
		echo $this->dtable->generate();		
	}

	public function fnPosition4DataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_position4->getDataId($id);
		echo json_encode($data);		
	}

	//Untuk Form Terpisah
	public function fnPosition4Add()
    {
		$data = array(
			'app_title'=>'Form Position4',
			'app_desc' =>'it all Form Position4',
			'form_header'	=>'<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        $data['side_main']	= 'position4';
        $data['content']	= 'vw_position4_add';
        $this->load->view('admin/main', $data);
    }

	public function fnPosition4Save()
	{
		if($this->mo_position4->saveData())
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
	public function fnPosition4Edit($id)
    {
		$data = array(
			'app_title'=>'Form Position4',
			'app_desc' =>'it all Form Position4',
			'form_header'	=>'<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>$id,
		);
		
        $data['side_main']	= 'position4';
        $data['content']	= 'vw_position4_add';
        $this->load->view('admin/main', $data);
    }

	public function fnPosition4Update()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_position4->updateData($id))
		{
			$this->session->set_userdata('SUCMSG','Sukses Edit !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	public function fnPosition4Switch()
	{
		if($this->mo_position4->switchData())
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}

	public function fnPosition4Delete()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_position4->deleteData($id))
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}

	public function fnPosition4ComboData()
	{
		$json['result'] = $this->mo_position4->remoteComboData();
		echo json_encode($json);
	}

	public function fnPosition4Excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "table_level_position4.xls";
        $judul = "table_level_position4";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Id3");
		xlsWriteLabel($tablehead, $kolomhead++, "F Position Desc");
		xlsWriteLabel($tablehead, $kolomhead++, "F Total");
		xlsWriteLabel($tablehead, $kolomhead++, "F Aktif");

		foreach ($this->mo_position4->fnGetData() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_id);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_account_id);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_id3);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_position_desc);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_total);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_aktif);

			$tablebody++;
			$nourut++;
        }

        xlsEOF();
        exit();
	}

	public function fnPosition4Word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=table_level_position4.doc");

        $data = array(
            'table_level_position4_data' => $this->mo_position4->fnGetData(),
            'start' => 0
        );
        
        $this->load->view('vw_position4_doc',$data);
    }

}

/* End of file Position4.php */
/* Location: ./application/modules/Position4/controllers/Position4.php */ 
