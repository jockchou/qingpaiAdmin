<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analytics_model extends CI_Model {
	
	public $db = null;
	
	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('pingo_analysis', TRUE);
	}
	
	public function getTopicAnalyticsMonth($month) {
		//  $today_android_total = $item['android_0_pub_topic'] + $item['android_1_pub_topic'] + $item['android_-1_pub_topic'] + $item['android_-2_pub_topic'];

        //  $today_ios_total = $item['ios_0_pub_topic'] + $item['ios_1_pub_topic'] + $item['ios_-1_pub_topic'] + $item['ios_-2_pub_topic'];

		$sql = "SELECT *,
			(`all_0_pub_topic`+`all_1_pub_topic`+`all_-1_pub_topic`+`all_-2_pub_topic`) AS all_pub_topic,
			(`android_0_pub_topic`+`android_1_pub_topic`+`android_-1_pub_topic`+`android_-2_pub_topic`) AS android_total,
			(`ios_0_pub_topic`+`ios_1_pub_topic`+`ios_-1_pub_topic`+`ios_-2_pub_topic`) AS ios_total FROM day_topic WHERE pubTime > ? AND pubTime <= ? ORDER BY pubTime ASC";

		$startDay = $month . "-00";
		$endDay = $month . "-31";
		
		$query = $this->db->query($sql, array($startDay, $endDay));
		
		return $query->result_array();
	}
	
	public function getWaterAnalyticsMonth($month) {
		$sql = "SELECT * FROM day_topic_water WHERE pubTime > ? AND pubTime <= ? ORDER BY pubTime ASC";
		$startDay = $month . "-00";
		$endDay = $month . "-31";
		
		$query = $this->db->query($sql, array($startDay, $endDay));
		
		return $query->result_array();
	}
	
	public function getReportAnalyticsMonth($month) {
		$sql = "SELECT * FROM day_report WHERE pubTime > ? AND pubTime <= ? ORDER BY pubTime ASC";
		$startDay = $month . "-00";
		$endDay = $month . "-31";
		
		$query = $this->db->query($sql, array($startDay, $endDay));
		return $query->result_array();
	}
	
	public function getSubjectAnalyticsMonth($month) {
		$sql = "SELECT * FROM day_topic_subject WHERE pubTime > ? AND pubTime <= ? ORDER BY pubTime ASC, subjectId ASC";
		$startDay = $month . "-00";
		$endDay = $month . "-31";
		
		$query = $this->db->query($sql, array($startDay, $endDay));
		return $query->result_array();
	}
	
	public function getUserAnalyticsMonth($month) {
		$sql = "SELECT * FROM day_user WHERE pubTime > ? AND pubTime <= ? ORDER BY pubTime ASC";
		$startDay = $month . "-00";
		$endDay = $month . "-31";
		
		$query = $this->db->query($sql, array($startDay, $endDay));
		return $query->result_array();
	}
	
	public function getNewTopicAndActiveUserNum($date){
		$sql = "SELECT * FROM topic_user_num WHERE addTime >= ? AND addTime < ? ORDER BY addTime ASC";
		$startTime = date('Y-m-d', strtotime($date)) . " 00:00:00";
		$endTime = $date . " 23:59:59";
		
		$query =  $this->db->query($sql, array($startTime, $endTime));
		return $query->result_array();
	}
	
}
 
/* End of file analytics_model.php */
/* Location: ./application/models/analytics_model.php */