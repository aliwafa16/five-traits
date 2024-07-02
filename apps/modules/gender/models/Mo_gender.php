<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Mo_gender extends CI_Model {

	public $table = 'table_gender';
	
    function fnGetData()
    {
        $this->db->order_by('f_gender_id', 'DESC');
        return $this->db->get($this->table)->result();		
	}

	function getDataId($id)
	{
		$sql = $this->db->get_where($this->table,array('f_gender_id'=> $id))->row_array();
		return $sql;
	}

	function saveData()
	{
		$data = array(
				'f_gender_name' => $this->input->post('f_gender_name'),
				'f_account_id' => $this->session->userdata('f_account_id'),
				'f_create_date' => date('Y-m-d H:i:s'),
				'f_create_by' => $this->session->userdata('f_account_id'),
		);
		$sql = $this->db->insert($this->table,$data);
		return $sql;
	}

	function updateData($id)
	{
		$data = array(
				'f_gender_name' => $this->input->post('f_gender_name'),
				'f_update_by' => $this->session->userdata('f_account_id'),
		);

		$this->db->where('f_account_id',$this->session->userdata('f_account_id'));
		$this->db->where('f_gender_id',$id);
		$sql = $this->db->update($this->table,$data);
		return $sql;		
	}

	function deleteData($id)
	{
		$this->db->where('f_account_id',$this->session->userdata('f_account_id'));
		$this->db->where('f_gender_id',$id);
		$sql = $this->db->delete($this->table);
		return $sql;		
	}
	
	function comboData()
	{
		$sql = $this->db->get($this->table);
		if($sql)
		{
			foreach($sql->result() as $r):
				$list[$r->f_gender_id] = $r->f_gender_id;
			endforeach;
		}
		return $list;
	}

	function remoteComboData()
	{
		if($this->input->get('term')) $this->db->like('f_gender_id',$this->input->get('term')); // pencarian name
		if($this->input->get('id')) $this->db->where('f_gender_id',$this->input->get('id')); // saat pencarian update
		
		$this->db->limit('10');
		$result = $this->db->get($this->table)->result();
		$DataJson = array();
		foreach($result as $row):
			$data['id']	= $row->f_gender_id; // value
			$data['text']	= $row->f_gender_id; // change display 
			array_push($DataJson,$data);
		endforeach;
		return $DataJson;
	}
}

/* End of file Mo_gender.php */
/* Location: ./application/modules/Gender/models/Mo_gender.php */	

	


