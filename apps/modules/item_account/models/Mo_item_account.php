<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Mo_item_account extends CI_Model {

	public $table = 't_item_account';
	
    function fnGetData()
    {
        $this->db->order_by('f_id', 'DESC');
        return $this->db->get($this->table)->result();		
	}

	function getDataId($id)
	{
		$this->db->select('a.f_id,a.f_item_name,a.f_variabel_id,a.f_dimensi_id,c.f_dimensi_name');
		$this->db->join('t_dimensi c','c.f_id=a.f_dimensi_id');
		$sql = $this->db->get_where($this->table.' a',array('a.f_id'=> $id))->row_array();
		return $sql;
	}

	function saveData()
	{
		$data = array(
				'f_item_name' => $this->input->post('f_item_name'),
				'f_variabel_id' => $this->input->post('f_variabel_id'),
				'f_dimensi_id' => $this->input->post('f_dimensi_id'),
				'f_active' => 1,
				'f_account_id' => $this->session->userdata('f_account_id'),
		);
		$sql = $this->db->insert($this->table,$data);
		return $sql;
	}

	function updateData($id)
	{
		$data = array(
				'f_item_name' => $this->input->post('f_item_name'),
				'f_variabel_id' => $this->input->post('f_variabel_id'),
				'f_dimensi_id' => $this->input->post('f_dimensi_id'),
				'f_account_id' => $this->session->userdata('f_account_id'),
		);

		$this->db->where('f_id',$id);
		$this->db->where('f_account_id',$this->session->userdata('f_account_id'));
		$sql = $this->db->update($this->table,$data);
		return $sql;		
	}

	function deleteData($id)
	{
		$this->db->where('f_id',$id);
		$this->db->where('f_account_id',$this->session->userdata('f_account_id'));
		$sql = $this->db->delete($this->table);
		return $sql;		
	}
	
	function comboData()
	{
		$sql = $this->db->get($this->table);
		if($sql)
		{
			foreach($sql->result() as $r):
				$list[$r->f_id] = $r->f_item_name;
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
			$data['text']	= $row->f_item_name; // change display 
			array_push($DataJson,$data);
		endforeach;
		return $DataJson;
	}
}

/* End of file Mo_item_account.php */
/* Location: ./application/modules/Item_account/models/Mo_item_account.php */	

	


