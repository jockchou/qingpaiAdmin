<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notify_model extends CI_Model {

	public $db;
	
	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function save($receiverID, $resID, $resType, $resContent, $reason='') {
		$tmp = array(
			"receiverID" => $receiverID,
			"resID" => $resID,
			"resType" => $resType,
			"resContent" => $resContent,
			"reason" => $reason,
			"pubTime" => date('Y-m-d H:i:s')
		);
		return $this->db->insert('system_notify', $tmp, TRUE);
	}
	
	public function save_batch($messageArray) {
		return $this->db->insert_batch('system_notify', $messageArray, TRUE);
	}
	
	
}

/* End of file notify_model.php */
/* Location: ./application/models/notify_model.php */