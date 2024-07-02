<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
	}

	function index()
	{
		$data = array(
			'app_title' => 'Dashboard',
			'app_desc' => ''
		);

		if ($this->ion_auth->is_admin()) {
			$data['regAccount']	= $this->getCountRegAccount();
			$data['countEvent']	= $this->getCountEvent();
		} else {
			//$data['content']	= 'vw_dashboard';
		}
		$data['content']	= 'vw_admin';
		$data['side_main']	= 'dashboard';
		$this->load->view('admin/main', $data);
	}

	function logEvent()
	{
		$is_admin	= $this->ion_auth->is_admin();
		$this->load->library('dtable');
		//$this->dtable->select('a.f_event_id,f_account_name,f_event_start,f_event_end,f_account_contact,f_event_click,f_step_1,f_step_2,f_step_3,f_step_4,f_step_5');
		$this->dtable->select('a.f_event_id,f_account_name,f_event_name,f_event_start,f_event_end,f_account_contact,f_event_click,f_event_survey,c.url, a.f_event_kode');
		$this->dtable->join('t_account b', 'b.f_account_id=a.f_account_id');
		$this->dtable->join('survey_setting c', 'c.f_account_id=b.f_account_id');
		//$this->dtable->join('t_event_detail c','c.f_event_id=a.f_event_id');
		//$this->dtable->where('a.f_event_survey','ochi');		
		if (!$is_admin) $this->dtable->where('a.f_account_id', sAccount);
		$this->dtable->order_by('a.f_event_id', 'desc');
		$this->dtable->from('t_event a');

		echo $this->dtable->generate();
	}

	public function getCountRegAccount()
	{
		$sql = $this->db->count_all('t_account');
		return $sql;
	}

	public function getCountEvent()
	{
		$sql = $this->db->count_all('t_event');
		return $sql;
	}

	function viewSes()
	{
		echo "<pre>";
		echo print_r($this->session->all_userdata()) . "</pre>";
	}
}
