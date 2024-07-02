<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Mo_work extends CI_Model {

	public $table = 'table_level_work';
	
    function fnGetData()
    {
        $this->db->order_by('f_id', 'DESC');
        return $this->db->get($this->table)->result();		
	}

	function getDataId($id)
	{
		$sql = $this->db->get_where($this->table,array('f_id'=> $id))->row_array();
		return $sql;
	}

	function saveData()
	{
		$data = array(
				'f_account_id' => $this->session->userdata('f_account_id'),
				'f_levelwork_desc' => $this->input->post('f_levelwork_desc'),
				'f_aktif' => 1,
		);
		$sql = $this->db->insert($this->table,$data);
		return $sql;
	}

	function updateData($id)
	{
		$data = array(
				'f_levelwork_desc' => $this->input->post('f_levelwork_desc'),
		);

		$this->db->where('f_id',$id);
		$this->db->where('f_account_id', $this->session->userdata('f_account_id'));
		$sql = $this->db->update($this->table,$data);
		return $sql;		
	}

	function switchData()
	{
		$f_value_active = ($this->input->get_post('f_active') == 0) ? 1:0;
		$this->db->where('f_id',$this->input->get_post('id'));
		$this->db->where('f_account_id',$this->session->userdata('f_account_id'));
		$sql = $this->db->update($this->table,array('f_aktif' => $f_value_active ));
		return $sql;		
	}

	function deleteData($id)
	{
		$this->db->where('f_id',$id);
		$this->db->where('f_account_id', $this->session->userdata('f_account_id'));
		$sql = $this->db->delete($this->table);
		return $sql;		
	}
	
	function comboData()
	{
		$sql = $this->db->get($this->table);
		if($sql)
		{
			foreach($sql->result() as $r):
				$list[$r->f_id] = $r->f_id;
			endforeach;
		}
		return $list;
	}

	function remoteComboData()
	{
		if($this->input->get('term')) $this->db->like('f_id',$this->input->get('term')); // pencarian name
		if($this->input->get('id')) $this->db->where('f_id',$this->input->get('id')); // saat pencarian update
		
		$this->db->limit('10');
		$result = $this->db->get($this->table)->result();
		$DataJson = array();
		foreach($result as $row):
			$data['id']	= $row->f_id; // value
			$data['text']	= $row->f_id; // change display 
			array_push($DataJson,$data);
		endforeach;
		return $DataJson;
	}
}

/* End of file Mo_work.php */
/* Location: ./application/modules/Work/models/Mo_work.php */	

	


