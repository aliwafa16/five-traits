<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mo_u extends CI_Model {

	function checkUnique()
	{
		$this->db->where('f_event_start<=',date('Y-m-d'));
		$this->db->where('f_event_end>=',date('Y-m-d'));
		//$this->db->where('b.f_respon !=','complete');
		$this->db->where('b.f_survey_valid =','no');
		$this->db->join('t_event_email b','a.f_event_id=b.f_event_id');
		$sql = $this->db->select('a.f_event_id, f_account_id, f_event_start as ed, f_event_end as dt, f_event_survey, b.f_email, b.f_nama, b.f_leaders, b.f_gender, b.f_age, b.f_length_of_service, b.f_region, b.f_level_of_work, b.f_level_1, b.f_level_2, b.f_level_3, b.f_level_4, b.f_level_5, b.f_pendidikan, b.f_custom1, b.f_custom2, b.f_custom3, b.f_nama, b.f_nik',false)->where('f_code',$this->input->get('e'))->order_by('f_event_id','desc')->get('t_event a');
		//echo $this->db->last_query();
		if($sql->num_rows() >0 )
		{
			return $sql->row();
		}
		else
		{
			return FALSE;
		}		
	}

	function checkEmail()
	{
		$this->db->join('t_event_email b','a.f_event_id=b.f_event_id');
		$sql = $this->db->select('a.f_event_id, f_account_id, f_event_start as ed, f_event_end as dt, f_event_survey, b.f_email',false)->where('f_code',$this->input->get('e'))->order_by('f_event_id','desc')->get('t_event a');
		if($sql->num_rows() >0 )
		{
			return $sql->row();
		}
		else
		{
			return FALSE;
		}		
	}

	function getDataId($id)
	{
		$this->db->select('a.f_account_id,f_ochi, f_engage, f_sfaction ,alias_url_ochi, sesi,f_page_personal, f_page_current, f_page_desire, f_page_current2, f_page_desire2, f_page_current3, f_page_desire3, f_page_leaderc, f_page_leaderd, f_page_qopen, f_account_logo, f_template, b.f_account_name, f_language');
		$this->db->join('t_account b','a.f_account_id=b.f_account_id');
		$sql = $this->db->get_where('trn_account a',array('a.f_account_id'=> $id))->row_array();
		return $sql;
	}

}

/* End of file Mo_u.php */
/* Location: ./application/models/Mo_u.php */ 
