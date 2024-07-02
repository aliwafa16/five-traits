<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Mo_events extends CI_Model
{

	public $table = 't_event';

	function fnGetData()
	{
		$this->db->order_by('f_event_id', 'DESC');
		return $this->db->get($this->table)->result();
	}

	function getDataId($id)
	{
		$this->db->select('a.*,b.f_account_name');
		$this->db->join('t_account b', 'b.f_account_id=a.f_account_id');
		$this->db->from('t_event a');
		$this->db->where('a.f_event_id', $id);
		$sql = $this->db->get()->row_array();
		return $sql;
	}

	function saveData()
	{
		$data = array(
			'f_event_name' => $this->input->post('f_event_name'),
			'f_event_survey' => 1, //$this->input->post('f_event_survey'),
			'f_event_start' => $this->input->post('f_event_start'),
			'f_event_start_time' => $this->input->post('f_event_start_time'),
			'f_event_end' => $this->input->post('f_event_end'),
			'f_event_end_time' => $this->input->post('f_event_end_time'),
			'f_event_status' => 1,
			'f_account_id' => $this->input->post('f_account_id'),
			//'f_account_id' => sAccount,
			'f_event_kode' => generateCode(5),
			'f_event_type' => 1,
			'f_event_min_respon' => $this->input->post('f_event_min_respon'),
			'f_event_created_on' => date('Y-m-d H:i:s'),
			'f_event_created_by' => $this->session->userdata('username'),
		);
		$sql = $this->db->insert($this->table, $data);
		return $sql;
	}

	function updateData($id)
	{
		$data = array(
			'f_event_name' => $this->input->post('f_event_name'),
			//'f_event_survey' => $this->input->post('f_event_survey'),
			'f_event_start' => $this->input->post('f_event_start'),
			'f_event_start_time' => $this->input->post('f_event_start_time'),
			'f_event_end' => $this->input->post('f_event_end'),
			'f_event_end_time' => $this->input->post('f_event_end_time'),
			'f_account_id' => $this->input->post('f_account_id'),
			'f_event_kode' => $this->input->post('f_event_kode'),
			'f_event_type' => $this->input->post('f_event_type'),
			'f_event_min_respon' => $this->input->post('f_event_min_respon'),
			'f_event_updated_on' => date('Y-m-d H:i:s'),
			'f_event_updated_by' => $this->session->userdata('username'),

		);

		// $this->db->where('f_account_id', sAccount);
		$this->db->where('f_event_id', $id);
		$sql = $this->db->update($this->table, $data);
		return $sql;
	}

	function deleteData($id)
	{
		if (sAccount != 0) {
			$this->db->where('f_account_id', sAccount);
		}
		$this->db->where('f_event_id', $id);
		$sql = $this->db->delete($this->table);
		return $sql;
	}

	function comboData()
	{
		$sql = $this->db->get($this->table);
		if ($sql) {
			foreach ($sql->result() as $r) :
				$list[$r->f_event_id] = $r->f_event_id;
			endforeach;
		}
		return $list;
	}

	function comboDataLeaders()
	{
		$this->db->where('f_account_id', sAccount); // saat pencarian update
		$sql = $this->db->get('table_leaders')->result();
		$list = array('' => '-- Pilih --');
		foreach ($sql as $s) :
			$list[$s->f_id] = $s->f_name; //$s->f_gender_name;
		endforeach;

		return $list;
	}

	function remoteComboData()
	{
		if ($this->input->get('term')) $this->db->like('f_event_id', $this->input->get('term')); // pencarian name
		if ($this->input->get('id')) $this->db->where('f_event_id', $this->input->get('id')); // saat pencarian update

		$this->db->limit('10');
		$this->db->where('f_account_id', sAccount);
		$result = $this->db->get($this->table)->result();
		$DataJson = array();
		foreach ($result as $row) :
			$data['id']	= $row->f_event_id; // value
			$data['text']	= $row->f_event_id; // change display 
			array_push($DataJson, $data);
		endforeach;
		return $DataJson;
	}

	function getDataTemplate($id)
	{
		$this->db->select('f_subject, f_header, f_header_color, f_body, f_button, f_button_color, f_update_on');
		$sql = $this->db->get_where($this->table . '_template a', array('a.f_event_id' => $id))->row_array();
		return $sql;
	}

	function getDataTemplateLeader($id)
	{
		$this->db->select('f_subject, f_header, f_header_color, f_body, f_button, f_button_color, f_update_on');
		$sql = $this->db->get_where($this->table . '_template_leader a', array('a.f_event_id' => $id))->row_array();
		return $sql;
	}

	function getDataEmail($id)
	{
		$this->db->select('f_event_id, f_email, f_code');
		$this->db->order_by('f_event_id', 'asc');
		$sql = $this->db->get_where($this->table . '_email a', array('a.f_event_id' => $id));
		if ($sql->num_rows() > 0) {
			return $sql->result_array();
		} else {
			return FALSE;
		}
	}
}

/* End of file Mo_events.php */
/* Location: ./application/modules/Events/models/Mo_events.php */
