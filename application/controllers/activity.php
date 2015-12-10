<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class Activity extends JY_Controller {
	
	private $pageList = array(
		"homepage" => "首页",
		"discover" => "发现",
		"nearby" => "附近"
	);

	function __construct() {
		parent::__construct();
		$this->load->model('activity_model');
	}

	public function activityList() {
		
		$pageNo =  (int)$this->input->get('pageNo', TRUE);

		$pageNo = $pageNo <= 0 ? 1 : $pageNo;
		$pageSize = 10;
		
		$queryData = $this->activity_model->getActivityList($pageNo, $pageSize);

		$activityList = $queryData['activityList'];
		$totalPages = $queryData['totalPages'];

		//设置数据
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['totalPages'] = $totalPages;
		$data['activityList'] = $activityList;
		
		$data['pageList'] = $this->pageList;
		
		$data['crumbs'] = $this->createCrumbs(array('activity/activityList' => '活动列表'));
		
		$data['pageUrl'] = "/activity/activityList?";
		
		$this->load->view('activityList', $data);
	}
	
	public function activityAdd() {
		
		$data['crumbs'] = $this->createCrumbs(array('/activity/activityList' => '活动列表', '/activity/activityAdd' => '添加活动'));
		
		$data['pageList'] = $this->pageList;

		$this->load->view('activityAdd', $data);
	}
	
	public function activitySave() {
		
		$title 			=  $this->input->get_post("title", true);
		$description 	=  $this->input->get_post("description", true);
		$os 			=  $this->input->get_post("os", true);
		$versionCode 	=  $this->input->get_post("versionCode", true);
		$channelID 		=  $this->input->get_post("channelID", true);
		$operaUrl 		=  $this->input->get_post("operaUrl", true);
		$beginTime 		=  $this->input->get_post("beginTime", true);
		$dueTime 		=  $this->input->get_post("dueTime", true);
		
		$iconConfig ['upload_path'] = JY_UPLOAD_IMG_PATH;
		$iconConfig ['allowed_types'] = 'gif|jpg|png';
		$iconConfig ['max_size'] = 1024;
		$config['max_width']  = '800';
 		$config['max_height']  = '600';
		$iconConfig ['encrypt_name'] = TRUE;
		
		//===========处理图片上传===========
		$iconPath = '';
		$iconError = NULL;
		$errorMessage = array();
		
		if (isset($_FILES['iconFile']) AND $_FILES['iconFile']['error'] !== 4) {
			$this->load->library ('upload', $iconConfig, 'iconUpload');
					
			//处理上传的图标
			if (! $this->iconUpload->do_upload("iconFile", TRUE)) {
				$iconError = '背景图上传失败: ' . $this->iconUpload->display_errors('', '');
			} else {
				$iconFileInfo = $this->iconUpload->data();
				$iconPath = $iconFileInfo['qiniu_ret']['key'];
			}
		}
		
		if ($iconError) {
			array_push($errorMessage, array('messageText' => $iconError));
		}
		
		//===========处理图片上传===========
		$iconPath2 = '';
		
		if (isset($_FILES['iconFile2']) AND $_FILES['iconFile2']['error'] !== 4) {
			$this->load->library ('upload', $iconConfig, 'iconUpload');
					
			//处理上传的图标
			if (! $this->iconUpload->do_upload("iconFile2", TRUE)) {
				$iconError = 'Banner图上传失败: ' . $this->iconUpload->display_errors('', '');
			} else {
				$iconFileInfo = $this->iconUpload->data();
				$iconPath2 = $iconFileInfo['qiniu_ret']['key'];
			}
		}
		
		if ($iconError) {
			array_push($errorMessage, array('messageText' => $iconError));
		}
		
		if (!empty($errorMessage)) {
			$data['message'] = array('error' => $errorMessage);
			$this->load->view('message', $data);
		} else {
			
 			if (!empty($iconPath)) {
				$imageUrl = JY_PINGO_DATA_URL . $iconPath;
			} else {
				$imageUrl = '';
			}
			
			if (!empty($iconPath2)) {
				$bannerUrl = JY_PINGO_DATA_URL . $iconPath2;
			} else {
				$bannerUrl = '';
			}
			//===========处理图片上传===========End

 			$activityData = array(
				"title" => $title,
				"description" => $description,
				"os" => $os,
				"versionCode" => $versionCode,
				"channelID" => $channelID,
				"imageUrl" => $imageUrl,
				"bannerUrl" => $bannerUrl,
				"operaUrl" => $operaUrl,
				"beginTime" => $beginTime,
				"dueTime" => $dueTime,
 			);

 			// 保存运营表
 			$this->load->model('activity_model');

 			$activityResult = $this->activity_model->saveActivity($activityData);

 			if ($activityResult) {
 				array_push($errorMessage, array('messageText' => '保存活动成功!'));
 			} else {
 				array_push($errorMessage, array('messageText' => '保存活动失败!'));
 			}

			$data['message'] = array('success' => $errorMessage);

			$this->load->view('message', $data);
		}
	}
	
	public function activityDelete() {
		$id = $this->input->get('id', TRUE);
		$result = $this->activity_model->deleteActivity($id);
		echo $result;
	}

	public function activityOff() {
		$id = $this->input->get('id', TRUE);
		$op = $this->input->get('op', TRUE);
		if ($op == 'on') {
			$onlineStatus = 1;
		} else {
			$onlineStatus = 0;
		}
		$result = $this->activity_model->offActivity($id, $onlineStatus);
		echo $result;
	}
}

/* End of file embed.php */
/* Location: ./application/controllers/embed.php */