<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Item_account extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->model('mo_item_account');
    }

	public function index()
    {
		$data = array(
			'app_title'=>'Data Item Account',
			'app_desc' =>'it all Item Account'
		);
		
        $data['side_main']	= 'item_account';
        $data['content']	= 'vw_item_account';
        $this->load->view('admin/main', $data);
    }

	public function fnItem_accountDataJson()
	{
		$button = '';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnEdit($1)" class="tip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnDelete($1)" class="tip" title="Hapus"><i class="text-red glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;';

		$this->load->library('dtable');
		$this->dtable->select('a.f_id,f_item_name,a.f_variabel_id,a.f_dimensi_id,a.f_active,b.f_variabel_name,c.f_dimensi_name');
		$this->dtable->join('t_variabel b','b.f_id=a.f_variabel_id');
		$this->dtable->join('t_dimensi c','c.f_id=a.f_dimensi_id');
		$this->dtable->where('a.f_account_id',$this->session->userdata('f_account_id'));
		$this->dtable->from('t_item_account a');
		$this->dtable->add_column('Aksi',$button,'f_id');
		
		echo $this->dtable->generate();		
	}

	public function fnItem_accountDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_item_account->getDataId($id);
		echo json_encode($data);		
	}

	//Untuk Form Terpisah
	public function fnItem_accountAdd()
    {
        $this->load->model('master_variabel/mo_master_variabel','mv');
		$data = array(
			'app_title'=>'Form Item Account',
			'app_desc' =>'it all Form Item Account',
			'form_header'	=>'<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        $data['mv']	= $this->mv->comboData();
        $data['side_main']	= 'item_account';
        $data['content']	= 'vw_item_account_add';
        $this->load->view('admin/main', $data);
    }

	public function fnItem_accountSave()
	{
		if($this->mo_item_account->saveData())
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
	public function fnItem_accountEdit($id)
    {
        $this->load->model('master_variabel/mo_master_variabel','mv');
		$data = array(
			'app_title'=>'Form Item Account',
			'app_desc' =>'it all Form Item Account',
			'form_header'	=>'<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>$id,
		);
		
        $data['mv']	= $this->mv->comboData();
        $data['side_main']	= 'item_account';
        $data['content']	= 'vw_item_account_add';
        $this->load->view('admin/main', $data);
    }

	public function fnItem_accountUpdate()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_item_account->updateData($id))
		{
			$this->session->set_userdata('SUCMSG','Sukses Edit !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	public function fnStatusSwitch()
	{
		$this->db->trans_start();
		$f_value_active = ($this->input->get_post('f_active') == 0) ? 1:0;
		$this->db->where('f_id',$this->input->get_post('id'));
		$this->db->where('f_account_id',$this->session->userdata('f_account_id'));
		$sql = $this->db->update($this->mo_item_account->table,array('f_active' => $f_value_active ));
		$this->db->trans_complete();
		if($this->db->trans_status())
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}
	}
	
	public function fnItem_accountDelete()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_item_account->deleteData($id))
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}

	public function fnComboDataDimensi()
	{
		$list = array();
		$this->db->where('f_variabel_id',html_escape($this->input->get('var_id',true)));
		$sql = $this->db->get('t_dimensi');
		if($sql)
		{
			foreach($sql->result() as $r):
				$list[$r->f_id] = $r->f_dimensi_name;
			endforeach;
		}
		echo json_encode($list);
	}
	
	public function fnItem_accountComboData()
	{
		$json['result'] = $this->mo_item_account->remoteComboData();
		echo json_encode($json);
	}

	public function fnItem_accountExcel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t_item_account.xls";
        $judul = "t_item_account";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Item Name");
		xlsWriteLabel($tablehead, $kolomhead++, "F Variabel Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Dimensi Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Active");
		xlsWriteLabel($tablehead, $kolomhead++, "F Account Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Updated On");
		xlsWriteLabel($tablehead, $kolomhead++, "F Updated By");

		foreach ($this->mo_item_account->fnGetData() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_item_name);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_variabel_id);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_dimensi_id);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_active);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_account_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_updated_on);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_updated_by);

			$tablebody++;
			$nourut++;
        }

        xlsEOF();
        exit();
	}

	public function fnItem_accountWord()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t_item_account.doc");

        $data = array(
            't_item_account_data' => $this->mo_item_account->fnGetData(),
            'start' => 0
        );
        
        $this->load->view('vw_item_account_doc',$data);
    }

}

/* End of file Item_account.php */
/* Location: ./application/modules/Item_account/controllers/Item_account.php */ 
