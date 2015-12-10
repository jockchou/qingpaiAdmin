<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends JY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model( 'admin_model' );
	}
	
	public function index() {
		$this->session->set_userdata('username', '');
		$this->load->view('login');
	}
	
	public function doLogin() {
		
		$username = $this->input->post('username', TRUE);
		$password = $this->input->post('password', TRUE);
		
		$password = md5($password);
		
		$admin = $this->admin_model->get_admin_by_username($username);
		
		$data = array();
		
		if ($admin && !empty($admin)) {
			if ($admin->password === $password) { //登录成功
				$data['code'] = 1;
				$data['msg'] = "登录成功";
				$this->session->set_userdata('username', $username);
				$this->session->set_userdata('isAdmin', $admin->isAdmin);
			} else { //密码错误
				$data['code'] = 0;
				$data['msg'] = "密码错误";
			}
		} else { //用户不存在
				$data['code'] = -1;
				$data['msg'] = "用户不存在";
		}
		
		$this->renderJSON(json_encode($data));
	}
	
	public function logout() {
		$this->session->set_userdata('username', '');
		$this->renderJSON("ok");
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */