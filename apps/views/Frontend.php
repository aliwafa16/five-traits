<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Frontend extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // $this->load->model('mo_home');
		// $config = array('module' => 'Home','roleid'=> $this->session->userdata('sRoleId'));
		// $this->load->library('rolemodule',$config);
		if(date('Y-m-d H:i:s') > '2020-07-30 06:00:00' && date('Y-m-d H:i:s') < '2020-07-30 12:00:40' ){
			redirect('maintenance');
		}
    }

	public function index()
    {
		// $this->rolemodule->view_page();

        $data['profile'] = $this->db->select('*')->from('t_profile')->where('f_email', $this->session->userdata('email'))->get()->row_array();
        $data['list_course'] = $this->db->select('*')->from('t_package')->where('f_paket_active', 1)->where('f_paket_type', 'single')->order_by('f_created_date', 'asc')->get()->result_array();

		$data['course'] = 
		$this->db->select('*')
		->from('t_package')
        ->where('f_paket_type', 'single')
        ->where('f_paket_active', 1)
        ->order_by('f_created_date', 'asc')
		->get()->result_array();

        $afiliasi = $this->load->database('afiliasi',true);

        $data['afiliasi'] = $afiliasi->select('*')->from('t_users')->where('email', $this->session->userdata('email'))->get()->row_array();

        $data['faq'] = $this->db->select('*')->from('t_faq')->get()->row_array();


        foreach ($data['course'] as $key => $value) {
            $data['course'][$key]['check'] =
            $this->db->select('*')
            ->from('t_video_membership')
            ->where('f_paket_id', $value['f_paket_id'])
            ->where('f_user_id', $this->session->userdata('id'))
            ->get()->result_array();

            $data['course'][$key]['total_video'] = 
            $this->db->select('count(f_paket_detail_id) total')
            ->from('t_package_detail')
            ->where('f_paket_id', $value['f_paket_id'])
            ->where('f_paket_kategori_id', 1)
            ->get()->row_array();
        }
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        $data['content']	= 'vw_home';

        $check = $this->db->select('*')->from('t_user')->where('f_user_id', $this->session->userdata('id'))->get()->row_array();

        if($this->session->userdata('last_login') != $check['last_login']){
            redirect('login/logout');
        }else{
            $this->load->view('user/main', $data);
        }
    }
	
	public function test(){
	
		echo date('Y-m-d H:i:s');	
	}
    
}
