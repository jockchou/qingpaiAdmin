<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analytics extends JY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('analytics_model', 'analytics');
	}
	
	public function topic() {

		$month = $this->input->get('month', TRUE);
		
		$month = $month ? $month : date('Y-m');
		
		$data['crumbs'] = $this->createCrumbs(array('analytics/topic' => '文章统计'));
		
		//获取当前月份
		$topicAnalytics = $this->analytics->getTopicAnalyticsMonth($month);

		$data['topicAnalytics'] = $topicAnalytics;
		$data['month'] = $month;

		$this->load->view('analyticsTopic', $data);
	}
	
	public function water() {
		$month = $this->input->get('month', TRUE);
		
		$month = $month ? $month : date('Y-m');
		
		$data['crumbs'] = $this->createCrumbs(array('analytics/water' => '水贴统计'));
		
		//获取当前月份
		$topicAnalytics = $this->analytics->getWaterAnalyticsMonth($month);
		
		$data['topicAnalytics'] = $topicAnalytics;
		$data['month'] = $month;

		$this->load->view('analyticsWater', $data);
	}
	
	public function exportTopicExcel() {
		$month = $this->input->get('month', TRUE);
		$month = $month ? $month : date('Y-m');
		$this->load->library('excel');
		$this->excel->filename = 'TopicExcel_' . $month;
		 	 	
		$topicAnalytics = $this->analytics->getTopicAnalyticsMonth($month);
		$this->excel->make_from_array(array(
			"ID", "总瓶子数", "Android累计", "IOS总瓶子数", "未审核", "通过", "不通过", "删除", "Android未审核", "Android通过", "Android不通过", "Android删除", "IOS未审核", "IOS通过", "IOS不通过", "IOS删除", "收到漂流瓶的数量", "阅读漂流瓶的数量", "回复漂流瓶的数量", "机器人总数", "优质贴", "日期", "发瓶子数", "Android总数", "IOS总数"
		), $topicAnalytics);
	}
	
	public function report() {
		$month = $this->input->get('month', TRUE);
		
		$month = $month ? $month : date('Y-m');
		
		$data['crumbs'] = $this->createCrumbs(array('analytics/report' => '举报统计'));
		
		//获取当前月份
		$reportAnalytics = $this->analytics->getReportAnalyticsMonth($month);
		
		$data['reportAnalytics'] = $reportAnalytics;
		$data['month'] = $month;

		$this->load->view('analyticsReport', $data);
	}
	
	public function subject() {
		$month = $this->input->get('month', TRUE);
		
		$month = $month ? $month : date('Y-m');
		
		$data['crumbs'] = $this->createCrumbs(array('analytics/subject' => '专题统计'));
		
		//获取当前月份
		$subjectAnalytics = $this->analytics->getSubjectAnalyticsMonth($month);
		
		$data['subjectAnalytics'] = $subjectAnalytics;
		$data['month'] = $month;

		$this->load->view('analyticsSubject', $data);
	}
	
	public function user() {
		$month = $this->input->get('month', TRUE);
		
		$month = $month ? $month : date('Y-m');
		
		$data['crumbs'] = $this->createCrumbs(array('analytics/user' => '注册用户统计'));
		
		//获取当前月份
		$userAnalytics = $this->analytics->getUserAnalyticsMonth($month);
		
		$data['userAnalytics'] = $userAnalytics;
		$data['month'] = $month;

		$this->load->view('analyticsUser', $data);
	}
	
	public function exportWaterExcel() {
		$month = $this->input->get('month', TRUE);
		$month = $month ? $month : date('Y-m');
		$this->load->library('excel');
		$this->excel->filename = 'WaterExcel_' . $month;
		
		$analyticsData = $this->analytics->getWaterAnalyticsMonth($month);
              
		$this->excel->make_from_array(array(
			"ID", "所有文章", "评论数", "点赞数", "时间"
		), $analyticsData);
	}
	
	public function exportReportExcel() {
		$month = $this->input->get('month', TRUE);
		$month = $month ? $month : date('Y-m');
		$this->load->library('excel');
		$this->excel->filename = 'ReportExcel_' . $month;
		
		$analyticsData = $this->analytics->getReportAnalyticsMonth($month);
              
		$this->excel->make_from_array(array(
			"ID", "文章数", "评论数", "时间"
		), $analyticsData);
	}
	
	public function exportSubjectExcel() {
		$month = $this->input->get('month', TRUE);
		$month = $month ? $month : date('Y-m');
		$this->load->library('excel');
		$this->excel->filename = 'SubjectExcel_' . $month;
		
		$analyticsData = $this->analytics->getSubjectAnalyticsMonth($month);
              
		$this->excel->make_from_array(array(
			"ID", "专题ID", "文章数", "评论数", "点赞数", "时间"
		), $analyticsData);
	}
	
	public function exportUserExcel() {
		$month = $this->input->get('month', TRUE);
		$month = $month ? $month : date('Y-m');
		$this->load->library('excel');
		$this->excel->filename = 'UserExcel_' . $month;
		
		$analyticsData = $this->analytics->getUserAnalyticsMonth($month);
		$this->excel->make_from_array(array(
			"ID",
			"可用", "封号", "Android可用", "Android封号", "IOS可用", "IOS封号",
			"活跃", "Android活跃", "IOS活跃",
			"登录次数", "Android登录次数", "IOS登录次数",
			"发送漂流瓶独立数", "Android发送漂流瓶独立数", "IOS发送漂流瓶独立数",
			"收到漂流瓶独立数", "阅读漂流瓶独立数", "回复漂流瓶独立数",
			"累计注册", "Android累计注册", "IOS累计注册",
			"日期"
		), $analyticsData);
	}
	
	public function topicAndUser() {
		
		$date = $this->input->get('date' ,TRUE);
		
		$date = $date ? $date : date('Y-m-d');
		
	    $data['crumbs'] = $this->createCrumbs(array('analytics/topicanduser' => '活跃统计'));
	    
		$topicAndUserNum = $this->analytics->getNewTopicAndActiveUserNum($date);
		
		$data['topicAndUserNum'] = $topicAndUserNum;
		$data['date'] = $date;
		
		$this->load->view('analyticsActive', $data);
	}
	
}

/* End of file analytics.php */
/* Location: ./application/controllers/analytics.php */