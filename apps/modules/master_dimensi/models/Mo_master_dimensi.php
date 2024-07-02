<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Mo_master_dimensi extends CI_Model {

	public $table = 't_dimensi';
	
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
				//'f_id' => $this->input->post('f_id'),
				'f_dimensi_name' => $this->input->post('f_dimensi_name'),
				'f_variabel_id' => $this->input->post('f_variabel_id'),
		);
		$sql = $this->db->insert($this->table,$data);
		return $sql;
	}

	function updateData($id)
	{
		$data = array(
				//'f_id' => $this->input->post('f_id'),
				'f_dimensi_name' => $this->input->post('f_dimensi_name'),
				'f_variabel_id' => $this->input->post('f_variabel_id'),
		);

		$this->db->where('f_id',$id);
		$sql = $this->db->update($this->table,$data);
		return $sql;		
	}

	function deleteData($id)
	{
		//$this->db->where('f_id',$id);
		$sql = false;//$this->db->delete($this->table);
		return $sql;		
	}
	
	function comboData()
	{
		$sql = $this->db->get($this->table);
		if($sql)
		{
			foreach($sql->result() as $r):
				$list[$r->f_id] = $r->f_dimensi_name;
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
			$data['text']	= $row->f_dimensi_name; // change display 
			array_push($DataJson,$data);
		endforeach;
		return $DataJson;
	}
}

/* End of file Mo_master_dimensi.php */
/* Location: ./application/modules/Master_dimensi/models/Mo_master_dimensi.php */	

	


