<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Mo_position5 extends CI_Model {

	public $table = 'table_level_position5';
	
    function fnGetData()
    {
        $this->db->order_by('f_id', 'DESC');
        return $this->db->get($this->table)->result();		
	}

	function getDataId($id)
	{
		$this->db->select('a.f_id,a.f_id4,b.f_position_desc f_desc4,a.f_position_desc,a.f_total,a.f_total_min,a.f_aktif');
		$this->db->join('table_level_position4 b','b.f_id=a.f_id4');
		$sql = $this->db->get_where($this->table.' a',array('a.f_id'=> $id))->row_array();
		return $sql;
	}

	function saveData()
	{
		$data = array(
				'f_account_id' => $this->session->userdata('f_account_id'),
				'f_id4' => $this->input->post('f_id4'),
				'f_position_desc' => $this->input->post('f_position_desc'),
				'f_total' => $this->input->post('f_total'),
				'f_total_min' => $this->input->post('f_total_min'),
				'f_aktif' => 1,
		);
		$sql = $this->db->insert($this->table,$data);
		return $sql;
	}

	function updateData($id)
	{
		$data = array(
				'f_id4' => $this->input->post('f_id4'),
				'f_position_desc' => $this->input->post('f_position_desc'),
				'f_total' => $this->input->post('f_total'),
				'f_total_min' => $this->input->post('f_total_min'),
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
		$this->db->where('f_account_id', $this->session->userdata('f_account_id'));
		$this->db->where('f_aktif',1);
		$result = $this->db->get($this->table)->result();
		$DataJson = array();
		foreach($result as $row):
			$data['id']	= $row->f_id; // value
			$data['text']	= $row->f_position_desc; // change display 
			array_push($DataJson,$data);
		endforeach;
		return $DataJson;
	}
}

/* End of file Mo_position5.php */
/* Location: ./application/modules/Position5/models/Mo_position5.php */	

	


