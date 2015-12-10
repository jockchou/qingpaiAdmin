<?php
class Album_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database('default');
	}
	
	public function getAlbumListByUserID($userID) {
		$sql = "SELECT * FROM user_album WHERE userID = ? AND state = 0 ORDER BY indexNum ASC LIMIT 6";
		$query = $this->db->query($sql, array("userID" => $userID));
		return $query->result_array();
	}
}