<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Mo_setting_account extends CI_Model
{

	public $table = 't_account';
	public $table1 = 'survey_setting';

	function fnGetData()
	{
		$this->db->order_by('f_account_id', 'DESC');
		return $this->db->get($this->table1)->result();
	}

	function getDataId($id)
	{
		$sql = $this->db->get_where($this->table1, array('f_account_id' => $id))->row_array();
		return $sql;
	}

	function getDataAccountId($id)
	{
		$this->db->select('a.*,b.username');
		$this->db->join('users b', 'b.f_account_id=a.f_account_id');
		$sql = $this->db->get_where('t_account a', array('a.f_account_id' => $id))->row_array();
		return $sql;
	}

	function getDataListDemo($id)
	{
		$this->db->select('f_account_id, f_gender, f_age, f_masakerja, f_region, f_level_of_work, f_level1, f_level2, f_level3, f_level4, f_level5, f_level6, f_level7, f_custom1, f_custom2, f_custom3, f_custom4, f_custom5, f_custom6, f_custom7, f_custom8, f_custom9, f_custom10, f_pendidikan');
		$sql = $this->db->get_where('t_list_demo', array('f_account_id' => $id))->row_array();
		return $sql;
	}

	//function getDataListLaun($id)
	//{
	//$this->db->select('f_account_id, f_ochi, f_engage, f_saticfs');
	//$sql = $this->db->get_where('t_list_launcher',array('f_account_id'=> $id))->row_array();
	//return $sql;		
	//}

	function cekUrl($id)
	{
		$this->db->where('f_account_id !=', $id);
		$this->db->where('url', $this->input->get_post('alias_url'));
		$sql = $this->db->get('survey_setting');
		if ($sql->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function saveData()
	{
		$data = array(
			'f_account_id' => $this->input->post('f_account_id'),
			'f_account_name' => $this->input->post('f_account_name'),
			'f_account_contact' => $this->input->post('f_account_contact'),
			'f_account_phone' => $this->input->post('f_account_phone'),
			'f_account_email' => $this->input->post('f_account_email'),
			'f_account_logo' => $this->input->post('f_account_logo'),
			'f_account_status' => $this->input->post('f_account_status'),
		);
		$sql = $this->db->insert($this->table, $data);
		return $sql;
	}

	function updateData($id)
	{
		$foto_logo			= $_FILES["f_account_logo"];
		$data = array(
			//'f_account_id' => $this->input->post('f_account_id'),
			'f_account_name' => $this->input->post('f_account_name'),
			'f_account_contact' => $this->input->post('f_account_contact'),
			'f_account_phone' => $this->input->post('f_account_phone'),
			'f_account_email' => $this->input->post('f_account_email'),
			//'f_account_logo' => $this->input->post('f_account_logo'),
			'f_account_updated_on' => date('Y-m-d H:i:s'),
			'f_account_updated_by' => sUsername,
		);

		$data['f_account_logo'] = false;
		$path_upload = 'uploads/' . $id;
		$fModule = FCPATH . $path_upload;
		//echo $fModule;
		if (!is_dir($fModule)) {
			mkdir($fModule, '0777');
			chmod($fModule, 0777);
			//echo "create";
		}

		if ($this->input->post('f_logo_account') != $data['f_account_logo']) {
			unlink('./uploads/' . $id . '/' . $this->input->post('f_logo_account'));
		}

		$config['upload_path']		= "./" . $path_upload;
		$config['allowed_types']	= 'jpg|png|jpeg';	//tipe file yang diperbolehkan
		$config['overwrite']		= TRUE;
		$config['max_size']			= '2000';
		$this->load->library('upload', $config);

		if ($foto_logo['name'] != '') {
			if ($this->upload->do_upload('f_account_logo')) {
				$tp			= $this->upload->data();
				$permisi 	= $tp['full_path'];
				$file 		= $tp['file_name'];
				//Permission Configuration
				chmod($permisi, 0777);

				// Resize Image
				$this->load->library('image_lib');
				//small image
				$config['image_library'] = 'gd2';
				$config['source_image'] = './' . $path_upload . '/' . $file;
				$config['new_image']	= './' . $path_upload . '/' . $file;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 300;
				$config['height'] = 250;
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();

				$data['f_account_logo'] = $file;
			} else {
				$this->session->set_userdata('ERRMSG', 'Terjadi kesalahan saat meng-upload data : ' . $this->upload->display_errors());
			}
		}

		$this->db->trans_start();
		if ($this->input->post('new_password')) {
			$params = ['cost' => 10];
			$password = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT, $params);
			$pass = array(
				'password' => $password,
			);
		}

		$pass['username'] = $this->input->post('f_account_name');
		$pass['email'] = $this->input->post('f_account_email');
		$pass['phone'] = $this->input->post('f_account_phone');
		$pass['updated_on'] = time();
		$this->db->where('f_account_id', $id);
		$this->db->update('users', $pass);

		$this->db->where('f_account_id', $id);
		$this->db->update('survey_setting', array('f_language' => $this->input->post('bahasa')));

		$this->db->where('f_account_id', $id);
		$this->db->update('t_account', $data);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	function updateDataUrl($id)
	{
		$data['url'] = $this->input->post('alias_url');
		$data['sesi'] = ($this->input->post('sesi')) ?	1 : 0;
		$this->db->where('f_account_id', $id);
		$sql = $this->db->update($this->table1, $data);
		return $sql;
	}


	function deleteData($id)
	{
		$this->db->where('f_account_id', $id);
		$sql = $this->db->delete($this->table);
		return $sql;
	}

	function comboData()
	{
		$sql = $this->db->get($this->table);
		if ($sql) {
			foreach ($sql->result() as $r) :
				$list[$r->f_account_id] = $r->f_account_id;
			endforeach;
		}
		return $list;
	}

	function remoteComboData()
	{
		if ($this->input->get('term')) $this->db->like('f_account_id', $this->input->get('term')); // pencarian name
		if ($this->input->get('id')) $this->db->where('f_account_id', $this->input->get('id')); // saat pencarian update

		$this->db->limit('10');
		$result = $this->db->get($this->table)->result();
		$DataJson = array();
		foreach ($result as $row) :
			$data['id']	= $row->f_account_id; // value
			$data['text']	= $row->f_account_id; // change display 
			array_push($DataJson, $data);
		endforeach;
		return $DataJson;
	}
}

/* End of file Mo_setting_account.php */
/* Location: ./application/modules/Setting_account/models/Mo_setting_account.php */
