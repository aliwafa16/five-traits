<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Setting_survey extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->model('mo_setting_account');
    }

	public function index()
    {
		$sAccount = $this->session->userdata('f_account_id');
		$data = array(
			'app_title'	=>'Data Setting Survey',
			'app_desc' 	=>'it all Setting Survey',
			'setting'	=> $this->mo_setting_account->getDataId( $sAccount ),
			'fId'		=> $sAccount,
			'fAct'			=>'Edit',
		);
		
        $data['side_main']	= 'setting_survey';
        $data['content']	= 'vw_setting_account_add';
        $this->load->view('admin/main', $data);
    }

	public function fnSetting_accountDataJson()
	{
		$button = '';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnEdit($1)" class="tip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;';
		$button .= '&nbsp;&nbsp;<a href="#" onclick="fnDelete($1)" class="tip" title="Hapus"><i class="text-red glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;';

		$this->load->library('dtable');
		$this->dtable->select('f_account_id,f_account_name,f_account_contact,f_account_phone,f_account_email,f_account_noacc,f_account_logo,f_account_created_on,f_account_created_by,f_account_updated_on,f_account_updated_by,f_account_status');
		$this->dtable->from('t_account');
		$this->dtable->add_column('Aksi',$button,'f_account_id');
		
		echo $this->dtable->generate();		
	}

	public function fnSetting_accountDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_setting_account->getDataId($id);
		echo json_encode($data);		
	}
/*
	//Untuk Form Terpisah
	public function fnSetting_accountAdd()
    {
		$data = array(
			'app_title'=>'Form Setting_account',
			'app_desc' =>'it all Form Setting_account',
			'form_header'	=>'<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        $data['side_main']	= 'setting_account';
        $data['content']	= 'vw_setting_account_add';
        $this->load->view('admin/main', $data);
    }

	public function fnSetting_accountSave()
	{
		if($this->mo_setting_account->saveData())
		{
			$this->session->set_userdata('SUCMSG','Sukses Tambah !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}
*/
	//Untuk Form Terpisah
	public function fnSetting_accountEdit($id)
    {
		$data = array(
			'app_title'=>'Form Setting_account',
			'app_desc' =>'it all Form Setting_account',
			'form_header'	=>'<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>$id,
		);
		
        $data['side_main']	= 'setting_account';
        $data['content']	= 'vw_setting_account_add';
        $this->load->view('admin/main', $data);
    }

	public function fnSetting_accountUpdate()
	{
		$id 	= sAccount;
		//opn($_POST);
		if($this->mo_setting_account->updateData($id))
		{
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	public function fnSetting_accountUpdateDemo()
	{
		$this->db->trans_start();
		//opn($_POST);
		$list_demo = array(
			'f_gender' 			=> $this->input->post('f_gender'),
			'f_age'				=> $this->input->post('f_age'),
			'f_masakerja' 		=> $this->input->post('f_masakerja'),
			'f_region'  		=> $this->input->post('f_region'),
			'f_level_of_work' 	=> $this->input->post('f_level_of_work'),
			'f_level1'  		=> $this->input->post('f_level1'),
			'f_level2'  		=> $this->input->post('f_level2'),
			'f_level3'  		=> $this->input->post('f_level3'),
			'f_level4'  		=> $this->input->post('f_level4'),
			'f_level5'  		=> $this->input->post('f_level5'),
			//'f_custom1' 		=> $this->input->post('f_custom1'),
			//'f_custom2' 		=> $this->input->post('f_custom2'),
			//'f_custom3' 		=> $this->input->post('f_custom3'),
			//'f_custom4' 		=> $this->input->post('f_custom4'),
			//'f_custom5' 		=> $this->input->post('f_custom5'),
			//'f_custom6' 		=> $this->input->post('f_custom6'),
			//'f_custom7' 		=> $this->input->post('f_custom7'),
			//'f_custom8' 		=> $this->input->post('f_custom8'),
			//'f_custom9' 		=> $this->input->post('f_custom9'),
			//'f_custom10' 		=> $this->input->post('f_custom10'),		
			'f_pendidikan' 		=> $this->input->post('f_pendidikan')		
		);
		$this->db->where('f_account_id',sAccount);
		$this->db->update('t_list_demo',$list_demo);
		//echo $this->db->last_query().br();

		$others = array(
			'leaders' => array(
						'indonesian' => $this->input->post('f_label_leaders_indonesian'),
						'english' => $this->input->post('f_label_leaders_english'),
						'malaysia' => $this->input->post('f_label_leaders_malaysia'),
				),  
			'gender' => array(
						'indonesian' => $this->input->post('f_label_gender_indonesian'),
						'english' => $this->input->post('f_label_gender_english'),
						'malaysia' => $this->input->post('f_label_gender_malaysia'),
				),  
			'age' => array(
						'indonesian' => $this->input->post('f_label_age_indonesian'),
						'english' => $this->input->post('f_label_age_english'),
						'malaysia' => $this->input->post('f_label_age_malaysia'),
				),  
			'mk' => array(
						'indonesian' => $this->input->post('f_label_mk_indonesian'),
						'english' => $this->input->post('f_label_mk_english'),
						'malaysia' => $this->input->post('f_label_mk_malaysia'),
				),  
			'region' => array(
						'indonesian' => $this->input->post('f_label_region_indonesian'),
						'english' => $this->input->post('f_label_region_english'),
						'malaysia' => $this->input->post('f_label_region_malaysia'),
				),  
			'work' => array(
						'indonesian' => $this->input->post('f_label_work_indonesian'),
						'english' => $this->input->post('f_label_work_english'),
						'malaysia' => $this->input->post('f_label_work_malaysia'),
				),  
			'education' => array(
						'indonesian' => $this->input->post('f_label_edu_indonesian'),
						'english' => $this->input->post('f_label_edu_english'),
						'malaysia' => $this->input->post('f_label_edu_malaysia'),
				),  
		);

		$data = array(
				'f_label_level1' => json_encode(array(
						'indonesian' => $this->input->post('f_label_level1_indonesian'),
						'english' => $this->input->post('f_label_level1_english'),
						'malaysia' => $this->input->post('f_label_level1_malaysia'),
				)),
				'f_label_level2' => json_encode(array(
						'indonesian' => $this->input->post('f_label_level2_indonesian'),
						'english' => $this->input->post('f_label_level2_english'),
						'malaysia' => $this->input->post('f_label_level2_malaysia'),
				)),
				'f_label_level3' => json_encode(array(
						'indonesian' => $this->input->post('f_label_level3_indonesian'),
						'english' => $this->input->post('f_label_level3_english'),
						'malaysia' => $this->input->post('f_label_level3_malaysia'),
				)),
				'f_label_level4' => json_encode(array(
						'indonesian' => $this->input->post('f_label_level4_indonesian'),
						'english' => $this->input->post('f_label_level4_english'),
						'malaysia' => $this->input->post('f_label_level4_malaysia'),
				)),
				'f_label_level5' => json_encode(array(
						'indonesian' => $this->input->post('f_label_level5_indonesian'),
						'english' => $this->input->post('f_label_level5_english'),
						'malaysia' => $this->input->post('f_label_level5_malaysia'),
				)),
				'f_label_level6' => json_encode(array(
						'indonesian' => $this->input->post('f_label_level6_indonesian'),
						'english' => $this->input->post('f_label_level6_english'),
						'malaysia' => $this->input->post('f_label_level6_malaysia'),
				)),
				'f_label_level7' => json_encode(array(
						'indonesian' => $this->input->post('f_label_level7_indonesian'),
						'english' => $this->input->post('f_label_level7_english'),
						'malaysia' => $this->input->post('f_label_level7_malaysia'),
				)),
				'f_label_others' => json_encode($others),
				'f_page_updated_on' => date('Y-m-d H:i:s'),
				'f_page_updated_by' => sUsername,
		);
		$this->db->where('f_account_id',sAccount);
		$this->db->update('survey_setting',$data);
		//echo $this->db->last_query().br();

		$this->db->trans_complete();
		if($this->db->trans_status()) echo json_encode(array('msg'=>true));
		else echo json_encode(array('msg'=>false));
	}
/*
	public function fnSetting_accountDelete()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_setting_account->deleteData($id))
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Sukses'));
		}
		else
		{
			echo json_encode(array('msg'=> true,'pesan'=> 'Gagal'));
		}		
	}
*/
	public function fnSetting_accountComboData()
	{
		$json['result'] = $this->mo_setting_account->remoteComboData();
		echo json_encode($json);
	}

	public function fnSetting_accountExcel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t_account.xls";
        $judul = "t_account";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Account Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Account Name");
		xlsWriteLabel($tablehead, $kolomhead++, "F Account Contact");
		xlsWriteLabel($tablehead, $kolomhead++, "F Account Phone");
		xlsWriteLabel($tablehead, $kolomhead++, "F Account Email");
		xlsWriteLabel($tablehead, $kolomhead++, "F Account Noacc");
		xlsWriteLabel($tablehead, $kolomhead++, "F Account Logo");
		xlsWriteLabel($tablehead, $kolomhead++, "F Account Created On");
		xlsWriteLabel($tablehead, $kolomhead++, "F Account Created By");
		xlsWriteLabel($tablehead, $kolomhead++, "F Account Updated On");
		xlsWriteLabel($tablehead, $kolomhead++, "F Account Updated By");
		xlsWriteLabel($tablehead, $kolomhead++, "F Account Status");

		foreach ($this->mo_setting_account->fnGetData() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_account_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_account_name);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_account_contact);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_account_phone);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_account_email);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_account_noacc);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_account_logo);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_account_created_on);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_account_created_by);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_account_updated_on);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_account_updated_by);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_account_status);

			$tablebody++;
			$nourut++;
        }

        xlsEOF();
        exit();
	}

	public function fnSetting_accountWord()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t_account.doc");

        $data = array(
            't_account_data' => $this->mo_setting_account->fnGetData(),
            'start' => 0
        );
        
        $this->load->view('vw_setting_account_doc',$data);
    }

	public function fnSettingUpdateURL()
	{
		$id 	= sAccount;

		if(!$this->mo_setting_account->cekUrl($id))
		{
			if($this->mo_setting_account->updateDataUrl($id))
			{
				echo json_encode(array('msg'=>true,'eStatus'=> 'ok'));
			}
			else
			{
				echo json_encode(array('msg'=>false,'eStatus'=> 'Gagal'));
			}		
		}
		else
		{
			echo json_encode(array('msg'=>false,'eStatus'=> 'ShortLink sudah ada'));
		}		
	}
	
	public function fnSettingCekEmail($id)
	{
		$this->db->where('f_account_id !=',$id);
		$this->db->where('f_account_email',$this->input->get_post('email'));
		$sql = $this->db->get('t_account');
		if($sql->num_rows()>0)
		{
			//echo "E#Sudah Ada";
			echo json_encode(array('status' => 500 ,'pesan' => 'Sudah ada'));
		}
		else
		{
			echo json_encode(array('status' => 200 ,'pesan' => 'OK'));
			//echo "S#Ok";
		}
	}

	public function fnSettingCekUrl($id)
	{
		$this->db->where('f_account_id !=',$id);
		$this->db->where('url',$this->input->get_post('alias_url'));
		$sql = $this->db->get('survey_setting');
		if($sql->num_rows()>0)
		{
			echo "E#Sudah Ada";
		}
		else
		{
			echo "S#Ok";
		}
	}

}

/* End of file Setting_account.php */
/* Location: ./application/modules/Setting_account/controllers/Setting_account.php */ 
