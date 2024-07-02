<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Mo_reg_account extends CI_Model
{

	public $table = 'users';

	function fnGetData()
	{
		$this->db->order_by('id', 'DESC');
		return $this->db->get($this->table)->result();
	}

	function getDataId($id)
	{
		$this->db->select('a.id, ip_address, username, password, email, active, first_name, last_name, company, phone,b.group_id,a.f_account_id', false);
		$this->db->join('users_groups b', 'b.user_id=a.id');
		//$this->db->join('t_account c','c.f_account_id=a.f_account_id');
		$sql = $this->db->get_where($this->table . ' a', array('a.id' => $id))->row_array();
		return $sql;
	}

	function getDataAccountId($id)
	{
		$this->db->select('a.id, ip_address, username, password, email, active, first_name, last_name, company, phone, b.group_id, a.f_account_id, c.f_account_contact', false);
		$this->db->join('users_groups b', 'b.user_id=a.id');
		$this->db->join('t_account c', 'c.f_account_id=a.f_account_id');
		$sql = $this->db->get_where($this->table . ' a', array('a.f_account_id' => $id))->row_array();
		return $sql;
	}

	function saveData()
	{
		//$this->load->model('auth/ion_auth_model','iam');
		$this->db->trans_start();
		$group_id = ($this->input->post('group_id')) ? $this->input->post('group_id') : 2;
		$params = ['cost' => ($group_id == 1) ? 12 : 10,];

		$password = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $params);

		$data_account = array(
			//'f_account_id' => $this->input->post('f_account_id'),
			'f_account_name' => $this->input->post('f_account_name'),
			'f_account_contact' => $this->input->post('f_account_contact'),
			'f_account_phone' => $this->input->post('phone'),
			'f_account_email' => strtolower($this->input->post('email')),
			'f_account_noacc' => 'CX-' . generateCode(10),
			'f_account_status' => 1,
			'f_account_created_on' => date('Y-m-d H:i:s'),
			'f_account_created_by' => $this->session->userdata('username'),
		);
		$this->db->insert('t_account', $data_account);


		$account_id = $this->db->insert_id();

		// INSER ITEM
		// $this->db->query("INSERT INTO t_item_account(f_item_name, f_variabel_id, f_dimensi_id, f_active, f_account_id, f_updated_by) SELECT f_item_name, f_variabel_id, f_dimensi_id,1,$account_id,'admin' FROM t_item_pernyataan");

		$data = array(
			'ip_address' => $this->input->ip_address(),
			'username' => $this->input->post('f_account_name'),
			'password' => $password,
			'email' => strtolower($this->input->post('email')),
			'created_on' => time(),
			'active' => 1,
			'phone' => $this->input->post('phone'),
			'f_account_id' => $account_id,
		);

		//die();
		$this->db->insert($this->table, $data);
		$user_id = $this->db->insert_id();
		//echo $this->db->last_query().br();

		$group_user = array(
			'user_id' => $user_id,
			'group_id' => $group_id
		);
		$this->db->insert('users_groups', $group_user);
		//echo $this->db->last_query().br();


		// setting survey page
		$page_welcome = array(
			'title' => 'Selamat Datang',
			'content' => '<h1>Work Enganged</h1><p>Organization Culture Health Index<br></p>'
		);
		$page_howto	  = array(
			'title' => 'Petunjuk Survey',
			'content' => '<p>&nbsp;</p>
<p>Harap isi pilih pernyataan berikut dengan persepsi/pendapat Bapak/Ibu/Saudara terkait tentang perasaan anda dalam pekerjaan anda.<br />Harap setiap pernyataan tersebut dibaca dengan seksama dan putuskan jawaban anda mengenai bagaimana perasaan anda terhadap pekerjaan anda.<br />Jika anda tidak pernah memiliki perasaan tersebut maka pilih jawaban &ldquo;1&rdquo; (satu) dalam kolom jawaban.<br />Jika anda pernah memiliki perasaan tersebut, indikasikan seberapa sering anda merasakan perasaan tersebut dengan memilih angka (1 sampai 6) yang benar-benar menggambarkan kondisi anda.</p>'
		);
		$page_thanks  = array(
			'title' => 'Terima kasih',
			'content' => '<h3>Survey complete if Your Submit. Thank you for you time.</h3>'
		);

		$level1 = array('indonesian' => 'Level 1', 'english' => 'Level 1', 'malaysia' => 'Level 1');
		$level2 = array('indonesian' => 'Level 2', 'english' => 'Level 2', 'malaysia' => 'Level 2');
		$level3 = array('indonesian' => 'Level 3', 'english' => 'Level 3', 'malaysia' => 'Level 3');
		$level4 = array('indonesian' => 'Level 4', 'english' => 'Level 4', 'malaysia' => 'Level 4');
		$level5 = array('indonesian' => 'Level 5', 'english' => 'Level 5', 'malaysia' => 'Level 5');
		$level6 = array('indonesian' => 'Level 6', 'english' => 'Level 6', 'malaysia' => 'Level 6');
		$level7 = array('indonesian' => 'Level 7', 'english' => 'Level 7', 'malaysia' => 'Level 7');

		$data = array(
			'f_account_id' => $account_id,
			'f_page_welcome' => json_encode($page_welcome),
			'f_page_howto' => json_encode($page_howto),
			'f_page_thanks' => json_encode($page_thanks),
			'f_label_level1' => json_encode($level1),
			'f_label_level2' => json_encode($level2),
			'f_label_level3' => json_encode($level3),
			'f_label_level4' => json_encode($level4),
			'f_label_level5' => json_encode($level5),
			'f_label_level6' => json_encode($level6),
			'f_label_level7' => json_encode($level7),
			'url' => $account_id . generateCode(5) . $account_id,
			'f_page_created_on' => date('Y-m-d H:i:s'),
			'f_page_created_by' => $this->session->userdata('username'),
		);

		//$page_welcome_ochi =array('title'=> 'Selamat Datang','content'=> '<h1>Work Enganged</h1><p>Organization Culture Health Index<br></p>');
		//$page_howto_ochi	  =array('title'=> 'Petunjuk Survey','content'=> '<p>Harap isi pilih pernyataan berikut dengan persepsi/pendapat Bapak/Ibu/Saudara terkait tentang perasaan anda dalam pekerjaan anda.<br/>Harap setiap pernyataan tersebut dibaca dengan seksama dan putuskan jawaban anda mengenai bagaimana perasaan anda terhadap pekerjaan anda.<br/>Jika anda tidak pernah memiliki perasaan tersebut maka pilih jawaban &ldquo;1&rdquo; (satu) dalam kolom jawaban.<br/>Jika anda pernah memiliki perasaan tersebut, indikasikan seberapa sering anda merasakan perasaan tersebut dengan memilih angka (1 sampai 6) yang benar-benar menggambarkan kondisi anda.</p>');
		//$page_thanks_ochi  =array('title'=> 'Terima kasih','content'=> '<h3>Survey complete if Your Submit. Thank you for you time.</h3>');

		//$ochi = array(
		//'f_page_welcome' => array(
		//$page_welcome_ochi,
		//'indonesian' => $page_welcome_ochi,
		//'english' => $page_welcome_ochi,
		//'malaysia' => $page_welcome_ochi,
		//),
		//'f_page_howto' => array(
		//$page_howto_ochi,
		//'indonesian' => $page_howto_ochi,
		//'english' => $page_howto_ochi,
		//'malaysia' => $page_howto_ochi,
		//),
		//'f_page_thanks' =>  array(
		//$page_thanks_ochi,
		//'indonesian' => $page_thanks_ochi,
		//'english' => $page_thanks_ochi,
		//'malaysia' => $page_thanks_ochi,
		//),			
		//);
		//$bahasa_ochi = array(
		//'indonesian' => $ochi,
		//'english' => $ochi,
		//'malaysia' => $ochi,
		//);		
		//$data['f_ochi'] = json_encode($bahasa_ochi);
		//$data['f_setting'] = json_encode($ochi);
		$data['f_setting'] = '{"f_page_welcome":{"title":null,"content":null,"indonesian":{"title":null,"content":"<h1><span style=\"font-family:Arial,Helvetica,sans-serif\"><span style=\"font-size:medium\"><strong>Selamat Datang di Customer Experience<em>&nbsp;<\/em>Survey<\/strong><\/span><\/span><\/h1>\r\n\r\n<p><span style=\"font-size:14px\"><span style=\"font-family:Arial,Helvetica,sans-serif\">Customer Experience Survey adalah sebuah survei yang ditujukan kepada pelanggan, dimana survei ini untuk melihat persepsi pelanggan dan perasaan terkait yang disebabkan oleh efek kumulatif dan salah satu dari interaksi dengan karyawan, sistem, saluran, atau produk pemasok.<\/span><\/span><\/p>\r\n\r\n<p><span style=\"font-size:14px\"><span style=\"font-family:Arial,Helvetica,sans-serif\">Karena jumlah pelanggan yang berinteraksi dengan perusahaan terus meningkat, maka perlu dilakukan pengamatan mengenai&nbsp;kebutuhan pelanggan, menjaga keterpaduan, dan menyediakan komunikasi yang sangat personal untuk dapat membentuk pengalaman dan berkontribusi untuk meningkatkan kepuasan dan loyalitas pelanggan.<\/span><\/span><\/p>\r\n\r\n<p><span style=\"font-size:14px\"><span style=\"font-family:Arial,Helvetica,sans-serif\">Dalam survei ini, tidak ada jawaban benar atau salah. Anda hanya diminta untuk memberikan respon dengan jujur dan objektif berkaitan dengan kondisi yang Anda rasakan saat ini.<br \/>\r\n<br \/>\r\nTerima kasih telah berpartisipasi dalam survei ini. <\/span><\/span><\/p>\r\n"}},"f_page_howto":{"title":null,"content":null,"indonesian":{"title":null,"content":""}},"f_page_thanks":{"title":null,"content":null,"indonesian":{"title":null,"content":"<h1>Terima kasih<\/h1>\r\n\r\n<h3>Survey complete if Your Submit. Thank you for you time.<\/h3>\r\n"}}}';

		$data['f_page_personal'] = '{"judul":{"indonesian":"<h1>Work &amp; Cultural Experience<\/h1>\r\n"},"indonesian":"<p>Dibawah ini Merupakan Pernyataan yang Mencerminkan Lingkungan dan Budaya Kerja Anda. Untuk Setiap Pernyataan, Pilih Jawaban yang Menurut Anda Paling Dirasa Sesuai<\/p>\r\n"}';
		$data['f_page_leaderc'] = '{"judul":{"indonesian":"<h1>Physical &amp; Technological Experience<\/h1>\r\n"},"indonesian":"<p>Dibawah Ini Merupakan Pernyataan yang Mencerminkan Sistem, Sarana dan Prasana yang Terdapat pada Perusahaan Anda. Untuk Setiap Pernyataan, Pilihlah Jawaban yang Menurut Anda Paling Dirasa Sesuai<\/p>\r\n"}';
		$data['f_page_leaderd'] = '{"judul":{"indonesian":"<h1>Leadership Experience<\/h1>\r\n"},"indonesian":"<p>Dibawah Ini Merupakan Pernyataan yang Mencerminkan Pimpinan, Tujuan, Makna Bekerja, Management Organisasi Dan Kepercayaan Terhadap Organisasi Anda Saat Ini. Untuk Setiap Pernyataan, Pilih Jawaban yang Menurut Anda Paling Dirasa Sesuai<\/p>\r\n"}';

		$others = array(
			'leaders' => array(
				'indonesian' => 'Pimpinan',
				'english' => 'Leader',
				'malaysia' => 'Ketua',
			),
			'gender' => array(
				'indonesian' => 'Jenis Kelamin',
				'english' => 'Gender',
				'malaysia' => 'Jantina',
			),
			'age' => array(
				'indonesian' => 'Usia',
				'english' => 'Age',
				'malaysia' => 'Umur',
			),
			'mk' => array(
				'indonesian' => 'Masa Kerja',
				'english' => 'Length of Service',
				'malaysia' => 'Tahun berkhidmat',
			),
			'region' => array(
				'indonesian' => 'Wilayah',
				'english' => 'Region',
				'malaysia' => 'Wilayah',
			),
			'work' => array(
				'indonesian' => 'Jabatan',
				'english' => 'Work',
				'malaysia' => 'Kedudukan',
			),
			'education' => array(
				'indonesian' => 'Pendidikan',
				'english' => 'Education',
				'malaysia' => 'Pendidikan',
			),
		);
		$data['f_label_others'] = json_encode($others);
		$data['sesi'] = 1;

		$this->db->insert('survey_setting', $data);

		$list_demo = array(
			'f_account_id' 		=> $account_id,
			'f_gender' 			=> 1,
			'f_age'				=> 1,
			'f_masakerja' 		=> 1,
			'f_region'  		=> 1,
			'f_level_of_work' 	=> 1,
			'f_level1'  		=> 1,
			'f_level2'  		=> 1,
			'f_level3'  		=> 1,
			'f_level4'  		=> 1,
			'f_level5'  		=> 1,
			'f_level6'  		=> 1,
			'f_level7'  		=> 1,
			'f_custom1' 		=> 1,
			'f_custom2' 		=> 1,
			'f_custom3' 		=> 1,
			'f_custom4' 		=> 1,
			'f_custom5' 		=> 1,
			'f_custom6' 		=> 1,
			'f_custom7' 		=> 1,
			'f_custom8' 		=> 1,
			'f_custom9' 		=> 1,
			'f_custom10' 		=> 1,
			'f_pendidikan' 		=> 1
		);
		$this->db->insert('t_list_demo', $list_demo);

		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	function updateData($id)
	{
		$this->db->trans_start();
		$data = array(
			'ip_address' => $this->input->ip_address(),
			'username' => $this->input->post('f_account_name'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
		);

		if ($this->input->post('password')) {
			$group_id = ($this->input->post('group_id')) ? $this->input->post('group_id') : 2;
			$params = ['cost' => ($group_id == 1) ? 12 : 10,];

			$password = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $params);
			$data['password'] = $password;
		}

		$this->db->where('f_account_id', $id);
		$this->db->update($this->table, $data);

		$data = array(
			'f_account_contact' => $this->input->post('f_account_contact'),
			'f_account_phone' => $this->input->post('phone'),
			'f_account_email' => $this->input->post('email'),
			'f_account_updated_on' => date('Y-m-d H:i:s'),
			'f_account_updated_by' => $this->session->userdata('username'),
		);

		$this->db->where('f_account_id', $id);
		$this->db->update('t_account', $data);

		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	function deleteData($id)
	{
		$this->db->where('id', $id);
		$sql = $this->db->delete($this->table);

		return $sql;
	}

	function comboData()
	{
		$sql = $this->db->get($this->table);
		if ($sql) {
			foreach ($sql->result() as $r) :
				$list[$r->id] = $r->id;
			endforeach;
		}
		return $list;
	}

	function remoteComboData()
	{
		if ($this->input->get('term')) $this->db->like('id', $this->input->get('username')); // pencarian name
		if ($this->input->get('id')) $this->db->where('id', $this->input->get('id')); // saat pencarian update

		$this->db->select('a.id,a.username,a.email,a.f_account_id', false);
		//$this->db->where('active',1);
		//$this->db->where('b.group_id',2);
		//$this->db->join('users_groups b','b.user_id=a.id');
		$this->db->where('f_account_id >', 0);
		$this->db->limit('10');
		$result = $this->db->get($this->table . ' a')->result();
		$DataJson = array();
		foreach ($result as $row) :
			$data['id']	= $row->f_account_id; // value
			$data['text']	= $row->username; // change display 
			array_push($DataJson, $data);
		endforeach;
		return $DataJson;
	}
}

/* End of file Mo_reg_account.php */
/* Location: ./application/modules/Reg_account/models/Mo_reg_account.php */
