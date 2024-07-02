<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Mo_trx_survey extends CI_Model
{

	public $table = 'trn_survey_empex';

	function fnGetDataAccount()
	{
		$this->db->select('a.f_account_id, a.url, f_setting,f_page_personal,f_page_leaderc,f_page_leaderd,f_label_level1, f_label_level2, f_label_level3, f_label_level4, f_label_level5, f_label_level6, f_label_level7, f_label_others,c.f_account_name, f_language, c.f_account_logo');
		$this->db->join('users b', 'b.f_account_id=a.f_account_id');
		$this->db->join('t_account c', 'a.f_account_id=c.f_account_id');
		$this->db->where('a.f_account_id', sAccount);
		$sql = $this->db->get('survey_setting a');
		if ($sql->num_rows() > 0) {
			$f_user = $sql->row_array();
			return $f_user;
		} else {
			return false;
		}
	}

	function getDataId($id)
	{
		$sql = $this->db->get_where($this->table, array('f_id' => $id))->row_array();
		return $sql;
	}

	function comboData()
	{
		$sql = $this->db->get($this->table);
		if ($sql) {
			foreach ($sql->result() as $r) :
				$list[$r->f_id] = $r->f_id;
			endforeach;
		}
		return $list;
	}

	function deleteData($id)
	{
		$this->db->trans_start();
		$this->db->where('f_id', $id);
		$this->db->where('f_account_id', $this->session->userdata('f_account_id'));
		$this->db->delete($this->table);

		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	function comboDataEvent()
	{
		$this->db->select('f_event_id, f_event_name, date_format(f_event_start,,"%d-%m-%Y %H:%i") f_event_start, date_format(f_event_end,,"%d-%m-%Y %H:%i") f_event_end', false);
		//$this->db->where('f_event_survey',1);

		if (sAccount != 0) {
			$this->db->where('f_account_id', sAccount);
		}
		$sql = $this->db->get('t_event');
		if ($sql) {
			foreach ($sql->result() as $r) :
				$list[$r->f_event_id] = $r->f_event_name;
			endforeach;
		}
		return $list;
	}

	function remoteComboData()
	{
		if ($this->input->get('term')) $this->db->like('f_id', $this->input->get('term')); // pencarian name
		if ($this->input->get('id')) $this->db->where('f_id', $this->input->get('id')); // saat pencarian update

		$this->db->limit('10');
		$result = $this->db->get($this->table)->result();
		$DataJson = array();
		foreach ($result as $row) :
			$data['id']	= $row->f_id; // value
			$data['text']	= $row->f_id; // change display 
			array_push($DataJson, $data);
		endforeach;
		return $DataJson;
	}
}

/* End of file Mo_trx_survey.php */
/* Location: ./application/modules/Trx_survey/models/Mo_trx_survey.php */
