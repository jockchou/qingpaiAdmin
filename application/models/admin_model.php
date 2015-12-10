<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database('joyo_admin');
	}
	
	function get_admin_by_username($username) {
		$sql = "SELECT id, username, password, opTime, isAdmin FROM admin WHERE username = ? LIMIT 1";
		
		$query = $this->db->query($sql, array($username));
		
		$data =  $query->result_object();
		
		if (empty($data)) {
			return NULL;
		} else {
			return $data[0];
		}
	}
	
	public function get_admin_list() {
		$sql = "SELECT id, username, password, opTime, isAdmin FROM admin WHERE username != 'admin'";
		$query = $this->db->query($sql);
		return $query->result_object();
	}
	
	public function save_user($data) {
		return $this->db->insert('admin', $data);
	}
	
	public function delete_admin($username) {
		$this->db->where('username', $username);
		return $this->db->delete('admin');
	}
	
	public function update_admin($username, $data) {
		$this->db->where('username', $username);
		return $this->db->update('admin', $data); 
	}
}
/* End of file admin_model.php */
/* Location: ./application/models/admin_model.php */