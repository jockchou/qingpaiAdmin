<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoginAuth {
	private $url_module;		//所访问的模块，如：music
    private $CI;
    
	function __construct() {
		$this->CI = & get_instance();
		$this->CI->load->library('session');
        $this->CI->load->helper('url');
        
        if (!session_id()) {
        	session_start();
        }

        $this->url_module = $this->CI->uri->uri_string();
	}
	
	public function checkLogin() {
		$username = $this->CI->session->userdata('username');
		
		if (strpos($this->url_module, "login") !== 0) {
			if (!$username && empty($username)) {
				redirect(JY_BASE_URL . '/login/index', 'location', 301);
			}
		}
	}
	
	public function checkAdmin() {
		if (strpos($this->url_module, "user") === 0) { //账号模块
			$username = $this->CI->session->userdata('username');
			$this->CI->load->model('admin_model');
			$user = $this->CI->admin_model->get_admin_by_username($username);

			if ($user->isAdmin != 1) { //不是管理员
				redirect(JY_BASE_URL, 'location', 301);
			}
		}
	}

}
/* End of file LoginAuth.php */
/* Location: ./application/hooks/LoginAuth.php */