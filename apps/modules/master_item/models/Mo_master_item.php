<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Mo_master_item extends CI_Model {

	public $table = 't_item_pernyataan';
	
    function fnGetData()
    {
        $this->db->order_by('f_id', 'DESC');
        return $this->db->get($this->table)->result();		
	}

	function getDataId($id)
	{
		$this->db->select('a.f_id,f_item_name,a.f_variabel_id,a.f_dimensi_id,a.f_item_array,a.f_type,c.f_dimensi_name');
		$this->db->join('t_dimensi c','c.f_id=a.f_dimensi_id');
		$sql = $this->db->get_where($this->table.' a',array('a.f_id'=> $id))->row_array();
		$data = array(
			'f_id' => $sql['f_id'],
			'f_item_name' => $sql['f_item_name'],
			'f_variabel_id' => $sql['f_variabel_id'],
			'f_dimensi_id' => $sql['f_dimensi_id'],
			'f_item_array' => json_decode($sql['f_item_array'],true),
			'f_type' => $sql['f_type'],
			'f_dimensi_name' => $sql['f_dimensi_name'],
		);

		return $data;
	}

	function saveData()
	{
		$data = array(
				//'f_id' => $this->input->post('f_id'),
				'f_item_name' => $this->input->post('f_item_name'),
				'f_variabel_id' => $this->input->post('f_variabel_id'),
				'f_dimensi_id' => $this->input->post('f_dimensi_id'),
				'f_type' => $this->input->post('f_type'),
		);

		$pilihan = array();
		$value	= $this->input->post('value');
		$ket	= $this->input->post('keterangan');
		for($i=0;$i<count($value);$i++)
		{
			$pilihan[] = array(
				'value' => $value[$i],
				'keterangan' => $ket[$i],
			);
		}
		$data['f_item_array'] = json_encode($pilihan);

		$sql = $this->db->insert($this->table,$data);
		return $sql;
	}

	function updateData($id)
	{
		$data = array(
				//'f_id' => $this->input->post('f_id'),
				'f_item_name' => $this->input->post('f_item_name'),
				'f_variabel_id' => $this->input->post('f_variabel_id'),
				'f_dimensi_id' => $this->input->post('f_dimensi_id'),
				'f_type' => $this->input->post('f_type'),
		);

		$pilihan = array();
		$value	= $this->input->post('value');
		$ket	= $this->input->post('keterangan');
		for($i=0;$i<count($value);$i++)
		{
			$pilihan[] = array(
				'value' => $value[$i],
				'keterangan' => $ket[$i],
			);
		}
		$data['f_item_array'] = json_encode($pilihan);

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

/* End of file Mo_master_item.php */
/* Location: ./application/modules/Master_item/models/Mo_master_item.php */	

	


