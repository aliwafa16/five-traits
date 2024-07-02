<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mo_c extends CI_Model
{

	public function alias_url($alias)
	{
		$this->db->select('a.f_account_id, a.url, f_setting,f_page_personal_leader,f_page_desire_leader,f_page_personal,f_page_leaderc,f_page_leaderd,f_page_qopen,f_label_level1, f_label_level2, f_label_level3, f_label_level4, f_label_level5, f_label_level6, f_label_level7, f_label_others,c.f_account_name, f_language, c.f_account_logo,d.f_event_kode');
		$this->db->join('users b', 'b.f_account_id=a.f_account_id');
		$this->db->join('t_account c', 'a.f_account_id=c.f_account_id');
		$this->db->join('t_event d', 'd.f_account_id=a.f_account_id');
		$this->db->where('d.f_event_kode', $alias);
		$sql = $this->db->get('survey_setting a');
		if ($sql->num_rows() > 0) {
			$f_user = $sql->row_array();
			return $f_user;
		} else {
			return false;
		}
	}

	public function alias_id($id)
	{
		$this->db->select('a.f_account_id, a.url, f_setting,f_page_personal_leader,f_page_desire_leader,f_page_personal,f_page_leaderc,f_page_leaderd,f_page_qopen,f_label_level1, f_label_level2, f_label_level3, f_label_level4, f_label_level5, f_label_level6, f_label_level7, f_label_others,c.f_account_name, f_language, c.f_account_logo');
		$this->db->join('users b', 'b.f_account_id=a.f_account_id');
		$this->db->join('t_account c', 'a.f_account_id=c.f_account_id');
		$this->db->where('a.f_account_id', $id);
		$sql = $this->db->get('survey_setting a');
		if ($sql->num_rows() > 0) {
			$f_user = $sql->row_array();
			return $f_user;
		} else {
			return false;
		}
	}

	function checkEventAccount($id, $alias)
	{
		$this->db->where('f_event_kode', $alias);
		$this->db->where('f_account_id', $id);
		$this->db->where("concat(REPLACE(f_event_start,'-',''),REPLACE(f_event_start_time,':','')) <=", date('YmdHis'));
		$this->db->where("concat(REPLACE(f_event_end,'-',''),REPLACE(f_event_end_time,':','')) >=", date('YmdHis'));
		$data = $this->db->get('t_event')->row_array();
		if ($data) {
			return $data;
		} else {
			return FALSE;
		}
	}

	function getDataId($id)
	{
		$this->db->select('a.f_account_id,url,sesi,f_page_personal, f_page_current, f_page_desire, f_page_leaderc, f_page_leaderd, f_page_qopen, b.f_account_name, f_language, f_account_logo, f_label_level1, f_label_level2, f_label_level3, f_label_level4, f_label_level5, f_label_level6, f_label_level7, f_label_others, f_setting, f_demo_view');
		$this->db->join('t_account b', 'a.f_account_id=b.f_account_id');
		$sql = $this->db->get_where('survey_setting a', array('a.f_account_id' => $id))->row_array();
		return $sql;
	}

	function getDataLeaders($id)
	{
		$this->db->select("a.f_id, a.f_event_id, f_survey_code, f_survey_personal, f_survey_valid, f_survey_created_on, f_survey_updated_on, f_ip_address, b.f_name, concat(REPLACE(c.f_event_start,'-',''),REPLACE(c.f_event_start_time,':','')) as sd, concat(REPLACE(c.f_event_end,'-',''),REPLACE(c.f_event_end_time,':','')) as ed, c.f_event_name, c.f_account_id", false);
		$this->db->join('table_leaders b', 'b.f_id=a.f_id');
		$this->db->join('t_event c', 'c.f_event_id=a.f_event_id');
		$sql = $this->db->get_where('trn_survey_leader a', array('a.f_survey_code' => $id));
		if ($sql->num_rows() > 0) {
			$f_user = $sql->row_array();
			return $f_user;
		} else {
			return false;
		}
	}

	function comboDataLeaders($id)
	{
		$this->db->where('f_account_id', $id); // saat pencarian update
		$sql = $this->db->get('table_leaders')->result();
		$list = array();
		foreach ($sql as $s) :
			$list[$s->f_id] = $s->f_name; //$s->f_gender_name;
		endforeach;

		return $list;
	}

	function comboDataGender($id)
	{
		$this->db->where('f_account_id', $id); // saat pencarian update
		$sql = $this->db->get('table_gender')->result();
		$list = array();
		foreach ($sql as $s) :
			$list[$s->f_gender_id] = $s->f_gender_name; //$s->f_gender_name;
		endforeach;

		return $list;
	}

	function comboDataEducation($id)
	{
		$this->db->where('f_account_id', $id); // saat pencarian update
		$this->db->where('f_aktif', 1); // saat pencarian update
		$sql = $this->db->get('table_pendidikan')->result();
		$list = array();
		foreach ($sql as $s) :
			$list[$s->f_id] = $s->f_name; //$s->f_gender_name;
		endforeach;

		return $list;
	}

	function comboDataPosition1($id)
	{
		$params = array(
			'f_account_id' => $id,
			'f_aktif' => 1
		);
		$this->db->where($params);
		$this->db->order_by('f_position_desc', 'asc');
		$sql = $this->db->get('table_level_position1')->result();
		foreach ($sql as $s) :
			$list[$s->f_id] = $s->f_position_desc;
		endforeach;

		return $list;
	}

	function pendidikan($id)
	{
		$params = array(
			'f_account_id' => $id,
			'f_aktif' => 1
		);
		$this->db->where($params);
		$this->db->order_by('f_id', 'asc');
		$sql = $this->db->get('tabel_pendidikan')->result();
		foreach ($sql as $s) :
			$list[$s->f_kode] = $s->f_name;
		endforeach;

		return $list;
	}

	function countRegion($id)
	{
		$this->db->where('f_account_id', $id);
		return $this->db->get('table_region')->num_rows();
	}

	function countWork($id)
	{
		$this->db->where('f_account_id', $id);
		return $this->db->get('table_level_work')->num_rows();
	}

	function countposition2($id)
	{
		$this->db->where('f_account_id', $id);
		return $this->db->get('table_level_position2')->num_rows();
	}

	function countposition($table, $id)
	{
		$this->db->where('f_account_id', $id);
		return $this->db->get('table_level_position' . $table)->num_rows();
	}

	function fnGetDataLabel($id)
	{
		$this->db->where('f_account_id', $id);
		$this->db->where('f_aktif', 1);
		$this->db->order_by('f_id', 'asc');
		return $this->db->get('table_custom_label')->result();
	}

	function fnGetDataOption($id)
	{
		$this->db->where('f_account_id', $id);
		$this->db->where('f_aktif', 1);
		$this->db->order_by('f_id', 'asc');
		return $this->db->get('table_custom_demograph')->result();
	}

	function listDemo($id)
	{
		$this->db->select('f_gender, f_age, f_masakerja, f_region, f_level_of_work, f_level1, f_level2, f_level3, f_level4, f_level5, f_level6, f_level7, f_custom1, f_custom2, f_custom3, f_custom4, f_custom5, f_custom6, f_custom7, f_custom8, f_custom9, f_custom10, f_pendidikan');
		$sql = $this->db->get_where('t_list_demo', array('f_account_id' => $id))->row_array();
		return $sql;
	}

	function listLaunc($id)
	{
		$this->db->select('f_account_id, f_ochi, f_engage, f_saticfs');
		$sql = $this->db->get_where('t_list_launcher', array('f_account_id' => $id))->row_array();
		return $sql;
	}

	function comboDataAge($id)
	{
		$this->db->where('f_account_id', $id); // saat pencarian update
		//$this->db->order_by('f_age_desc','asc');
		$this->db->where('f_age_aktif', 1); // Aktif
		$this->db->order_by('f_id', 'asc');
		$result = $this->db->get('table_age')->result();
		$DataJson = array();
		foreach ($result as $row) :
			$DataJson[$row->f_id]	= $row->f_age_desc; // change display 
		endforeach;
		return $DataJson;
	}

	function comboDataLengthofservice($id)
	{
		$this->db->where('f_account_id', $id); // saat pencarian update
		//$this->db->order_by('f_service_desc','asc');
		$this->db->where('f_service_aktif', 1); // Aktif
		$this->db->order_by('f_id', 'asc');
		$result = $this->db->get('table_length_of_service')->result();
		$data = array();
		foreach ($result as $row) :
			$data[$row->f_id]	= $row->f_service_desc; // change display 
		endforeach;
		return $data;
	}

	function comboDataRegion($id)
	{
		$this->db->where('f_account_id', $id); // saat pencarian update
		$this->db->where('f_region_aktif', 1); // saat pencarian update
		$this->db->order_by('f_id', 'asc');
		$result = $this->db->get('table_region')->result();
		$DataJson = array();
		foreach ($result as $row) :
			$DataJson[$row->f_id]	= $row->f_region_name; // change display 
		endforeach;
		return $DataJson;
	}

	function comboDataLevelofposition1($id)
	{
		$this->db->where('f_account_id', $id); // pencarian Account
		$this->db->where('f_aktif', 1); // Aktif
		//$this->db->order_by('f_position_desc','asc');
		$this->db->order_by('f_id', 'asc');
		$result = $this->db->get('table_level_position1')->result();
		$data = array();
		foreach ($result as $row) :
			$data[$row->f_id]	= $row->f_position_desc; // change display 
		endforeach;
		return $data;
	}

	function remoteComboDataPosition2($id)
	{
		if ($this->input->get('term')) $this->db->like('f_position_desc', $this->input->get('term')); // pencarian name
		if ($this->input->get('f_id1')) $this->db->where('f_id1', $this->input->get('f_id1')); // saat pencarian update
		if ($this->input->get('id')) $this->db->where('f_id', $this->input->get('id')); // saat pencarian update
		$this->db->where('f_account_id', $id); // pencarian Account
		$this->db->where('f_aktif', 1); // Aktif

		//$this->db->limit('10');
		$this->db->order_by('f_id', 'asc');
		$result = $this->db->get('table_level_position2')->result();
		$DataJson = array();
		foreach ($result as $row) :
			$data['id']	= $row->f_id; // value
			$data['text']	= $row->f_position_desc; // change display 
			array_push($DataJson, $data);
		endforeach;
		return $DataJson;
	}

	function remoteComboDataPosition3($id)
	{
		if ($this->input->get('term')) $this->db->like('f_position_desc', $this->input->get('term')); // pencarian name
		if ($this->input->get('id')) $this->db->where('f_id', $this->input->get('id')); // saat pencarian update
		if ($this->input->get('f_id2')) $this->db->where('f_id2', $this->input->get('f_id2')); // saat pencarian update
		$this->db->where('f_account_id', $id); // pencarian Account
		$this->db->where('f_aktif', 1); // Aktif

		//$this->db->limit('10');
		$this->db->order_by('f_id', 'asc');
		$result = $this->db->get('table_level_position3')->result();
		//echo $this->db->last_query().br();
		//echo print_r($result);
		$DataJson = array();
		foreach ($result as $row) :
			$data['id']	= $row->f_id; // value
			$data['text']	= $row->f_position_desc; // change display 
			array_push($DataJson, $data);
		endforeach;
		return $DataJson;
	}

	function remoteComboDataPosition4($id)
	{
		if ($this->input->get('term')) $this->db->like('f_position_desc', $this->input->get('term')); // pencarian name
		if ($this->input->get('id')) $this->db->where('f_id', $this->input->get('id')); // saat pencarian update
		if ($this->input->get('f_id3')) $this->db->where('f_id3', $this->input->get('f_id3')); // saat pencarian update
		$this->db->where('f_account_id', $id); // pencarian Account
		$this->db->where('f_aktif', 1); // Aktif

		//$this->db->limit('10');
		$this->db->order_by('f_id', 'asc');
		$result = $this->db->get('table_level_position4')->result();
		$DataJson = array();
		foreach ($result as $row) :
			$data['id']	= $row->f_id; // value
			$data['text']	= $row->f_position_desc; // change display 
			array_push($DataJson, $data);
		endforeach;
		return $DataJson;
	}

	function remoteComboDataPosition5($id)
	{
		if ($this->input->get('term')) $this->db->like('f_position_desc', $this->input->get('term')); // pencarian name
		if ($this->input->get('id')) $this->db->where('f_id', $this->input->get('id')); // saat pencarian update
		if ($this->input->get('f_id4')) $this->db->where('f_id4', $this->input->get('f_id4')); // saat pencarian update
		$this->db->where('f_account_id', $id); // pencarian Account
		$this->db->where('f_aktif', 1); // Aktif

		//$this->db->limit('10');
		$this->db->order_by('f_id', 'asc');
		$result = $this->db->get('table_level_position5')->result();
		$DataJson = array();
		foreach ($result as $row) :
			$data['id']	= $row->f_id; // value
			$data['text']	= $row->f_position_desc; // change display 
			array_push($DataJson, $data);
		endforeach;
		return $DataJson;
	}

	function remoteComboDataPosition6($id)
	{
		if ($this->input->get('term')) $this->db->like('f_position_desc', $this->input->get('term')); // pencarian name
		if ($this->input->get('id')) $this->db->where('f_id', $this->input->get('id')); // saat pencarian update
		if ($this->input->get('f_id5')) $this->db->where('f_id5', $this->input->get('f_id5')); // saat pencarian update
		$this->db->where('f_account_id', $id); // pencarian Account
		$this->db->where('f_aktif', 1); // Aktif

		//$this->db->limit('10');
		$this->db->order_by('f_id', 'asc');
		$result = $this->db->get('table_level_position6')->result();
		$DataJson = array();
		foreach ($result as $row) :
			$data['id']	= $row->f_id; // value
			$data['text']	= $row->f_position_desc; // change display 
			array_push($DataJson, $data);
		endforeach;
		return $DataJson;
	}

	function remoteComboDataPosition7($id)
	{
		if ($this->input->get('term')) $this->db->like('f_position_desc', $this->input->get('term')); // pencarian name
		if ($this->input->get('id')) $this->db->where('f_id', $this->input->get('id')); // saat pencarian update
		if ($this->input->get('f_id6')) $this->db->where('f_id6', $this->input->get('f_id6')); // saat pencarian update
		$this->db->where('f_account_id', $id); // pencarian Account
		$this->db->where('f_aktif', 1); // Aktif

		//$this->db->limit('10');
		$this->db->order_by('f_id', 'asc');
		$result = $this->db->get('table_level_position7')->result();
		$DataJson = array();
		foreach ($result as $row) :
			$data['id']	= $row->f_id; // value
			$data['text']	= $row->f_position_desc; // change display 
			array_push($DataJson, $data);
		endforeach;
		return $DataJson;
	}

	function comboDataLevelofwork($id)
	{
		$this->db->where('f_account_id', $id); // pencarian Account
		$this->db->where('f_aktif', 1); // Aktif
		$this->db->order_by('f_id', 'asc');
		$result = $this->db->get('table_level_work')->result();
		$data = array();
		foreach ($result as $row) :
			$data[$row->f_id]	= $row->f_levelwork_desc; // change display 
		endforeach;
		return $data;
	}

	function cek_pegawai($id, $cek_password = false)
	{
		$this->db->where('nip', $this->input->post('f_nik'));
		if ($cek_password) $this->db->where('tanggal_lahir', $this->input->post('f_tgl'));
		$sql = $this->db->get('master_pegawai_' . $id);
		//echo $this->db->last_query();
		if ($sql->num_rows() > 0) {
			return $sql->row_array();
		} else {
			return FALSE;
		}
	}
}

/* End of file Mo_c.php */
/* Location: ./application/models/Mo_c.php */
