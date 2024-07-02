<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth {

	protected $ci;
	
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->library('session');
		$this->ci->load->helper('cookie');
		define('sRole',$this->ci->session->userdata("sRole"));
		define('sUsername',$this->ci->session->userdata("sUsername"));
		define('sAccount',$this->ci->session->userdata("sAccount"));
		define('sOchi',$this->ci->session->userdata("sOchi"));
		define('sAchi',$this->ci->session->userdata("sAchi"));
		define('sEng',$this->ci->session->userdata("sEng"));
		define('sFaction',$this->ci->session->userdata("sFaction"));
		define('apis','http://'.$_SERVER['SERVER_NAME'].'/apis/index.php');
		//define('apis1','http://survey.actconsulting.co/apis/index.php');
		define('apis1','http://'.$_SERVER['SERVER_NAME'].'/apis/index.php');
		define('tokenAdd',md5('TAMBAH'));
		define('tokenEdit',md5('UBAH'));
		define('tokenDel',md5('HAPUS'));
		$trn_account = $this->ci->db->select('f_language')->get_where('trn_account',array('f_account_id'=> sAccount));
		if($trn_account->num_rows() > 0 ) { $setting = $trn_account->row(); $language = $setting->f_language; }
		else { $language = $this->ci->config->item('language'); }
		
		if(get_cookie('act_language')) {
			if(file_exists('apps/language/'.get_cookie('act_language').'/act_lang.php') && is_dir('apps/language/'.get_cookie('act_language'))) {
			$this->ci->lang->load('act', get_cookie('act_language'));
			define("LANGUAGE", get_cookie('act_language'));
			}
		} else {
			$this->ci->lang->load('act', $language);
			define("LANGUAGE", $language);
		}
	}
	
	public function check_isvalidated($required_role = sRole)
	{
		if( !$this->ci->session->userdata("validated") || $required_role != $this->ci->session->userdata("sRole") ) 
		{
			redirect( 'md_login/role/'.$this->ci->session->userdata("sRole") );
		} 
    }

	public function check_survey_ochi($status = sOchi)
	{
		if( !$this->ci->session->userdata("validated") || $status != $this->ci->session->userdata("sOchi") ) 
		{
			redirect( 'md_login/role/'.$this->ci->session->userdata("sRole") );
		} 
    }

	public function check_survey_achi($status = sAchi)
	{
		if( !$this->ci->session->userdata("validated") || $status != $this->ci->session->userdata("sAchi") ) 
		{
			redirect( 'md_login/role/'.$this->ci->session->userdata("sRole") );
		} 
    }

	public function check_survey_eng($status = sEng)
	{
		if( !$this->ci->session->userdata("validated") || $status != $this->ci->session->userdata("sEng") ) 
		{
			redirect( 'md_login/role/'.$this->ci->session->userdata("sRole") );
		} 
    }

	public function check_survey_sfaction($status = sFaction)
	{
		if( !$this->ci->session->userdata("validated") || $status != $this->ci->session->userdata("sFaction") ) 
		{
			redirect( 'md_login/role/'.$this->ci->session->userdata("sRole") );
		} 
    }
    
    
}
