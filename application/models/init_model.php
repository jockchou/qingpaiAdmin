<?php 
	class Init_model extends CI_Model{
		
		public function __construct() {
			parent::__construct();
			$this->db = $this->load->database('default', TRUE);
		}
		public function getDubiousUser(){
			
			$sql = "select id from user where isDubious = 1";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		public function setTopicState($userIDList){
			
			if(empty($userIDList)) return true;
			$userIDList = implode(",", $userIDList);
			$sql = "update topic set state = -3 where state = 0 and userID in ({$userIDList});";
			return $this->db->query($sql);
		}
	}
