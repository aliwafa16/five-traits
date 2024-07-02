<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Mo_setting_account extends CI_Model {

	public $table = 't_account';
	public $table1 = 'survey_setting';
		
    function fnGetData()
    {
        $this->db->order_by('f_account_id', 'DESC');
        return $this->db->get($this->table1)->result();		
	}

	function getDataId($id)
	{
		$sql = $this->db->get_where($this->table1,array('f_account_id'=> $id))->row_array();
		return $sql;
	}

	function getDataAccountId($id)
	{
		$this->db->select('a.*,b.username');
		$this->db->join('users b','b.f_account_id=a.f_account_id');
		$sql = $this->db->get_where('t_account a',array('a.f_account_id'=> $id))->row_array();
		return $sql;
	}
	
	function getDataListDemo($id)
	{
		$this->db->select('f_account_id, f_gender, f_age, f_masakerja, f_region, f_level_of_work, f_level1, f_level2, f_level3, f_level4, f_level5, f_level6, f_level7, f_custom1, f_custom2, f_custom3, f_custom4, f_custom5, f_custom6, f_custom7, f_custom8, f_custom9, f_custom10, f_pendidikan');
		$sql = $this->db->get_where('t_list_demo',array('f_account_id'=> $id))->row_array();
		return $sql;		
	}

	//function getDataListLaun($id)
	//{
		//$this->db->select('f_account_id, f_ochi, f_engage, f_saticfs');
		//$sql = $this->db->get_where('t_list_launcher',array('f_account_id'=> $id))->row_array();
		//return $sql;		
	//}

	function cekUrl($id)
	{
		$this->db->where('f_account_id !=',$id);
		$this->db->where('url',$this->input->get_post('alias_url'));
		$sql = $this->db->get('survey_setting');
		if($sql->num_rows()>0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function saveData()
	{
		$data = array(
				'f_account_id' => $this->input->post('f_account_id'),
				'f_account_name' => $this->input->post('f_account_name'),
				'f_account_contact' => $this->input->post('f_account_contact'),
				'f_account_phone' => $this->input->post('f_account_phone'),
				'f_account_email' => $this->input->post('f_account_email'),
				'f_account_logo' => $this->input->post('f_account_logo'),
				'f_account_status' => $this->input->post('f_account_status'),
		);
		$sql = $this->db->insert($this->table,$data);
		return $sql;
	}

	function updateData($id)
	{
		$page_welcome =array(
			'title'=> $this->input->post('welcome_title'),'content'=> $this->input->post('welcome_content'),
			'indonesian'=> array('title'=> $this->input->post('welcome_title_indonesian'),'content'=> $this->input->post('welcome_content_indonesian')),
			//'english'=> array('title'=> $this->input->post('welcome_title_english'),'content'=> $this->input->post('welcome_content_english')),
			//'malaysia'=> array('title'=> $this->input->post('welcome_title_malaysia'),'content'=> $this->input->post('welcome_content_malaysia')),
		);
		$page_howto	  =array(
			'title'=> $this->input->post('howto_title'),'content'=> $this->input->post('howto_content'),
			'indonesian'=> array('title'=> $this->input->post('howto_title_indonesian'),'content'=> $this->input->post('howto_content_indonesian')),
			//'english'=> array('title'=> $this->input->post('howto_title_english'),'content'=> $this->input->post('howto_content_english')),
			//'malaysia'=> array('title'=> $this->input->post('howto_title_malaysia'),'content'=> $this->input->post('howto_content_malaysia')),
			);
		$page_thanks  =array(
			'title'=> $this->input->post('thanks_title'),'content'=> $this->input->post('thanks_content'),
			'indonesian'=> array('title'=> $this->input->post('thanks_title_indonesian'),'content'=> $this->input->post('thanks_content_indonesian')),
			//'english'=> array('title'=> $this->input->post('thanks_title_english'),'content'=> $this->input->post('thanks_content_english')),
			//'malaysia'=> array('title'=> $this->input->post('thanks_title_malaysia'),'content'=> $this->input->post('thanks_content_malaysia')),
		);
		
		$ochi = array(
				'f_page_welcome' => $page_welcome,
				'f_page_howto' => $page_howto,
				'f_page_thanks' => $page_thanks,			
		);
	
		//$f_page_personal_leader = array(
			//'judul' => array(
				//'indonesian'=> $this->input->post('f_page_personal_leader_judul_indonesian'),
				////'english'=>$this->input->post('f_page_personal_leader_judul_english'),
				////'malaysia'=>$this->input->post('f_page_personal_leader_judul_malaysia')
			//),
			//'indonesian'=> $this->input->post('f_page_personal_leader_indonesian'),
			////'english'=>$this->input->post('f_page_personal_leader_english'),
			////'malaysia'=>$this->input->post('f_page_personal_leader_malaysia')
		//);
		//$f_page_desire_leader = array(
			//'judul' => array(
				//'indonesian'=> $this->input->post('f_page_desire_leader_judul_indonesian'),
				////'english'=>$this->input->post('f_page_desire_leader_judul_english'),
				////'malaysia'=>$this->input->post('f_page_desire_leader_judul_malaysia')
			//),
			//'indonesian'=> $this->input->post('f_page_desire_leader_indonesian'),
			////'english'=>$this->input->post('f_page_desire_leader_english'),
			////'malaysia'=>$this->input->post('f_page_desire_leader_malaysia')
		//);
		$f_page_personal = array(
			'judul' => array(
				'indonesian'=> $this->input->post('f_page_personal_judul_indonesian'),
				//'english'=>$this->input->post('f_page_personal_judul_english'),
				//'malaysia'=>$this->input->post('f_page_personal_judul_malaysia')
			),
			'indonesian'=> $this->input->post('f_page_personal_indonesian'),
			//'english'=>$this->input->post('f_page_personal_english'),
			//'malaysia'=>$this->input->post('f_page_personal_malaysia')
		);
		//$f_page_current = array(
			//'judul' => array(
				//'indonesian'=> $this->input->post('f_page_current_judul_indonesian'),
				//'english'=>$this->input->post('f_page_current_judul_english'),
				//'malaysia'=>$this->input->post('f_page_current_judul_malaysia')
			//),
			//'indonesian'=> $this->input->post('f_page_current_indonesian'),
			//'english'=> $this->input->post('f_page_current_english'),
			//'malaysia'=> $this->input->post('f_page_current_malaysia')
		//);
		//$f_page_desire = array(
			//'judul' => array(
				//'indonesian'=> $this->input->post('f_page_desire_judul_indonesian'),
				//'english'=>$this->input->post('f_page_desire_judul_english'),
				//'malaysia'=>$this->input->post('f_page_desire_judul_malaysia')
			//),
			//'indonesian'=> $this->input->post('f_page_desire_indonesian'),
			//'english'=> $this->input->post('f_page_desire_english'),
			//'malaysia'=> $this->input->post('f_page_desire_malaysia'),
		//);
		//$f_page_current2 = array(
			//'judul' => array(
				//'indonesian'=> $this->input->post('f_page_current2_judul_indonesian'),
				//'english'=>$this->input->post('f_page_current2_judul_english'),
				//'malaysia'=>$this->input->post('f_page_current2_judul_malaysia')
			//),
			//'indonesian'=> $this->input->post('f_page_current2_indonesian'),
			//'english'=> $this->input->post('f_page_current2_english'),
			//'malaysia'=> $this->input->post('f_page_current2_malaysia'),
		//);
		//$f_page_desire2 = array(
			//'judul' => array(
				//'indonesian'=> $this->input->post('f_page_desire2_judul_indonesian'),
				//'english'=>$this->input->post('f_page_desire2_judul_english'),
				//'malaysia'=>$this->input->post('f_page_desire2_judul_malaysia')
			//),
			//'indonesian'=> $this->input->post('f_page_desire2_indonesian'),
			//'english'=> $this->input->post('f_page_desire2_english'),
			//'malaysia'=> $this->input->post('f_page_desire2_malaysia'),
		//);
		//$f_page_current3 = array(
			//'judul' => array(
				//'indonesian'=> $this->input->post('f_page_current3_judul_indonesian'),
				//'english'=>$this->input->post('f_page_current3_judul_english'),
				//'malaysia'=>$this->input->post('f_page_current3_judul_malaysia')
			//),
			//'indonesian'=> $this->input->post('f_page_current3_indonesian'),
			//'english'=> $this->input->post('f_page_current3_english'),
			//'malaysia'=> $this->input->post('f_page_current3_malaysia'),
		//);
		//$f_page_desire3 = array(
			//'judul' => array(
				//'indonesian'=> $this->input->post('f_page_desire3_judul_indonesian'),
				//'english'=>$this->input->post('f_page_desire3_judul_english'),
				//'malaysia'=>$this->input->post('f_page_desire3_judul_malaysia')
			//),
			//'indonesian'=> $this->input->post('f_page_desire3_indonesian'),
			//'english'=> $this->input->post('f_page_desire3_english'),
			//'malaysia'=> $this->input->post('f_page_desire3_malaysia'),
		//);
		$f_page_leaderc = array(
			'judul' => array(
				'indonesian'=> $this->input->post('f_page_leaderc_judul_indonesian'),
				//'english'=>$this->input->post('f_page_leaderc_judul_english'),
				//'malaysia'=>$this->input->post('f_page_leaderc_judul_malaysia')
			),
			'indonesian'=> $this->input->post('f_page_leaderc_indonesian'),
			//'english'=> $this->input->post('f_page_leaderc_english'),
			//'malaysia'=> $this->input->post('f_page_leaderc_malaysia'),
		);
		$f_page_leaderd = array(
			'judul' => array(
				'indonesian'=> $this->input->post('f_page_leaderd_judul_indonesian'),
				//'english'=>$this->input->post('f_page_leaderd_judul_english'),
				//'malaysia'=>$this->input->post('f_page_leaderd_judul_malaysia')
			),
			'indonesian'=> $this->input->post('f_page_leaderd_indonesian'),
			//'english'=> $this->input->post('f_page_leaderd_english'),
			//'malaysia'=> $this->input->post('f_page_leaderd_malaysia'),
		);

		//$f_page_qopen = array(
			//'judul' => array(
				//'indonesian'=> $this->input->post('f_page_terbuka_judul_indonesian'),
				//'english'=>$this->input->post('f_page_terbuka_judul_english'),
				//'malaysia'=>$this->input->post('f_page_terbuka_judul_malaysia')
			//),
			//'indonesian'=> $this->input->post('f_page_terbuka_indonesian'),
			//'english'=> $this->input->post('f_page_terbuka_english'),
			//'malaysia'=> $this->input->post('f_page_terbuka_malaysia'),
			//'question' => array(
				//'indonesian' => $this->input->post('f_page_terbuka_tanya_indonesian'),
				//'english' => $this->input->post('f_page_terbuka_tanya_english'),
				//'malaysia' => $this->input->post('f_page_terbuka_tanya_malaysia'),
			//),
		//);

		$data = array(
				'f_setting' => json_encode($ochi),
				//'f_page_personal_leader' => json_encode($f_page_personal_leader),
				//'f_page_desire_leader' => json_encode($f_page_desire_leader),
				//'f_page_qopen' => json_encode($f_page_qopen),
				'f_page_personal' => json_encode($f_page_personal),
				//'f_page_current' => json_encode($f_page_current),
				//'f_page_desire' => json_encode($f_page_desire),
				//'f_page_current2' => json_encode($f_page_current2),
				//'f_page_desire2' => json_encode($f_page_desire2),
				//'f_page_current3' => json_encode($f_page_current3),
				//'f_page_desire3' => json_encode($f_page_desire3),
				'f_page_leaderc' => json_encode($f_page_leaderc),
				'f_page_leaderd' => json_encode($f_page_leaderd),
				'f_page_updated_on' => date('Y-m-d H:i:s'),
				'f_page_updated_by' => sUsername,
		);
		
		//opn($data);
		
		$this->db->where('f_account_id',$id);
		$sql = $this->db->update('survey_setting',$data);
		//echo $this->db->last_query();
		return $sql;		
	}

	function updateDataUrl($id)
	{
		$data['url'] = $this->input->post('alias_url');
		$data['sesi'] = ($this->input->post('sesi')) ?	1:0;
		$this->db->where('f_account_id',$id);
		$sql = $this->db->update($this->table1,$data);
		return $sql;		
	}
	

	function deleteData($id)
	{
		$this->db->where('f_account_id',$id);
		$sql = $this->db->delete($this->table);
		return $sql;		
	}
	
	function comboData()
	{
		$sql = $this->db->get($this->table);
		if($sql)
		{
			foreach($sql->result() as $r):
				$list[$r->f_account_id] = $r->f_account_id;
			endforeach;
		}
		return $list;
	}

	function remoteComboData()
	{
		if($this->input->get('term')) $this->db->like('f_account_id',$this->input->get('term')); // pencarian name
		if($this->input->get('id')) $this->db->where('f_account_id',$this->input->get('id')); // saat pencarian update
		
		$this->db->limit('10');
		$result = $this->db->get($this->table)->result();
		$DataJson = array();
		foreach($result as $row):
			$data['id']	= $row->f_account_id; // value
			$data['text']	= $row->f_account_id; // change display 
			array_push($DataJson,$data);
		endforeach;
		return $DataJson;
	}
}

/* End of file Mo_setting_account.php */
/* Location: ./application/modules/Setting_account/models/Mo_setting_account.php */	

	


