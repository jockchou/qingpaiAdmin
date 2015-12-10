<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends JY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model( 'admin_model' );
	}
	
	public function userList() {
		$adminList = $this->admin_model->get_admin_list();
		
		$username = $this->session->userdata('username');
		
		$user = $this->admin_model->get_admin_by_username($username);
		
		$data['adminList'] = $adminList;
		$data['user'] = $user;
		
		$data['crumbs'] = $this->createCrumbs(array('user/userList' => '账号列表'));
		
		$this->load->view('userList', $data);
	}
	
	public function userAdd() {
		$username = $this->session->userdata('username');
		$user = $this->admin_model->get_admin_by_username($username);
		
		if ($user AND $user->isAdmin == 1) {
			$data['crumbs'] = $this->createCrumbs(array('user/userList' => '账号列表', 'user/userAdd' => '添加账号'));
			$this->load->view('userAdd', $data);
		} else {
			$this->load->helper('url');
			redirect(JY_BASE_URL, 'location', 301);
		}
	}
	
	public function changePass() {
		$username = $this->session->userdata('username');
		$user = $this->admin_model->get_admin_by_username($username);
		
		$data['crumbs'] = $this->createCrumbs(array('admin/changePass' => '修改密码'));
		$data['user'] = $user;
		
		$this->load->view('change_pass', $data);
	}
	
	public function savePass() {
		$password = $this->input->post('password', TRUE);
		$password2 = $this->input->post('password2', TRUE);
		
		$username = $this->session->userdata('username');
		if (empty($password)) {
			echo "-1"; //密码为空
		} else if ($password !== $password2) {
			echo "-2"; //密码不一样
		} else {
			$udata = array('password'=>md5($password), 'opTime' => date('Y-m-d H:i:s'));
			$result = $this->admin_model->update_admin($username, $udata);
			
			if ($result == 1) {
				$this->session->set_userdata('username', '');
			}
			echo $result;
		}
	}
	
	public function userAuth() {
		$_username = $this->session->userdata('username');
		if ($_username == 'admin') {
			$username = $this->input->get('username', TRUE);
			$oper = $this->input->get('oper', TRUE);
			if ($oper == 'Y') {
				$udata = array('isAdmin'=>1, 'opTime' => date('Y-m-d H:i:s'));
			} else {
				$udata = array('isAdmin'=>0, 'opTime' => date('Y-m-d H:i:s'));
			}
			echo $this->admin_model->update_admin($username, $udata);
		} else {
			echo "-1";
		}
	}
	
	public function userDelete() {
		$username = $this->input->get('username', TRUE);
		
		$_username = $this->session->userdata('username');
		
		$_user = $this->admin_model->get_admin_by_username($_username);
		
		if ($_user AND $_user->isAdmin) { //当前用户是管理员才有删除权限
			
			$user = $this->admin_model->get_admin_by_username($username);
			
			if ($user) {
				if ($user->isAdmin == 1) { //被删除的用户是管理员
					if ($user->username == 'admin') {
						echo "-2"; //不能删除超管
					} else { //普通管理员要超管权限删除
						if ($_user->username == 'admin') {
							echo $this->admin_model->delete_admin($username);
						} else {
							echo "-4"; //不是超管，不能删除管理员
						}
					}
				} else { //不是管理员，可以直接删除
					echo $this->admin_model->delete_admin($username);
				}
			} else {
				echo "-3"; //删除的用户不存在
			}
		} else {
			echo "-1"; //没有权限
		}
	}
	
	public function userSave() {
		$username = $this->input->post('username', TRUE);
		$password = $this->input->post('password', TRUE);
		
		$errorMessage = array();
		$data['crumbs'] = $this->createCrumbs(array('user/userList' => '账号列表', 'user/userAdd' => '添加账号'));
		
		if (!empty($username) AND !empty($password)) {
			//查询用户是否存在
			$userTmp = $this->admin_model->get_admin_by_username($username);
			if ($userTmp AND $userTmp->username === $username) {
				//用户存在
				array_push($errorMessage, array('messageText' => "用户名[".$username."]已经存在"));
				$data['message'] = array('error' => $errorMessage);
				$this->load->view('message', $data);
			} else {
				$user = array(
					'username'=> $username,
					'password' => md5($password),
					'isAdmin' => 0,
					'opTime' => date('Y-m-d H:i:s')
				);
				$result = $this->admin_model->save_user($user);
				if ($result > 0) {
					array_push($errorMessage, array('messageText' => "账号[".$username."]添加成功"));
					$data['message'] = array('success' => $errorMessage);
					$this->load->view('message', $data);
				}
			}
		}
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */