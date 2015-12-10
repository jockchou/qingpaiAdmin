<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Imglibs extends JY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('imglibs_model');
		$this->load->model('jjuser_model', 'jjuser');
		$this->load->model('subjectactivity_model', 'subject');
	}
	
	public function blackList() {
		$pageNo = (int)$this->input->get('pageNo', TRUE);
		
		$pageSize = 50;
		$pageNo = $pageNo <= 0 ? 1: $pageNo;

		$queryData = $this->imglibs_model->getBlackImageList($pageSize, $pageNo);

		$imageList = $queryData['imageList'];
		$totalPages = $queryData['totalPages'];

		//设置数据
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		
		$data['imageList'] = $imageList;
		$data['totalPages'] = $totalPages;
		$pathURL = "/imglibs/blackList";
		$data['crumbs'] = $this->createCrumbs(array($pathURL => '黑图'));
		
		$data['pageUrl'] = $pathURL . "?keyword=";
		$data['pathURL'] = $pathURL;
		
		$this->load->view('blackList', $data);
	}
	public function imageList() {
		$pageNo = (int)$this->input->get('pageNo', TRUE);
		$keyword = $this->input->get('keyword', TRUE);
		
		$pageSize = 50;
		$pageNo = $pageNo <= 0 ? 1: $pageNo;

		$queryData = $this->imglibs_model->getImageList($keyword, $pageSize, $pageNo);

		$imageList = $queryData['imageList'];
		$totalPages = $queryData['totalPages'];

		//设置数据
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['keyword'] = $keyword;
		
		$data['imageList'] = $imageList;
		$data['totalPages'] = $totalPages;
		$pathURL = "/imglibs/imageList";
		$data['crumbs'] = $this->createCrumbs(array($pathURL => '照片库'));
		
		$data['pageUrl'] = $pathURL . "?keyword=" . $keyword;
		$data['pathURL'] = $pathURL;
		$this->load->view('imageList', $data);
	}
	
	public function addRobotTask() {
		$imgID = $this->input->get('imgID', TRUE);
		$robotList = $this->jjuser->getAllRobot();
		$image = $this->imglibs_model->getImageById($imgID);
		$subjectList = $this->subject->getAllSubjectList();
		
		$data['subjectList'] = $subjectList;
		$data['robotList'] = $robotList;
		$data['image'] = $image;
		$data['crumbs'] = $this->createCrumbs(array("/imageList/addRobotTask" => '机器人任务'));
		$this->load->view('addRobotTask', $data);
	}
	
	public function saveRobotTask() {
		$imgID = (int)$this->input->post('imgID', TRUE);
		$robotId = $this->input->post('robotId', TRUE);
		$subjectId = $this->input->post('subjectId', TRUE);
		$subjectTitle = $this->input->post('subjectTitle', TRUE);
		$content = (string)$this->input->post('content', TRUE);
		$pushTime = (string)$this->input->post('pushTime', TRUE);
		$result = false;
		
		if ($imgID <= 0) { //自己上传照片
			$resUrl = "";
		
			$iconConfig ['upload_path'] = JY_UPLOAD_IMG_PATH;
			$iconConfig ['allowed_types'] = 'png|jpg';
			$iconConfig ['max_size'] = 512;
			$iconConfig ['encrypt_name'] = TRUE;
			$iconConfig ['bucket']  = JY_QN_bucket_piclibs;
			
			$iconPath = '';
			$iconError = NULL;
			$errorMessage = array();
			
			if (isset($_FILES['imageFile']) AND $_FILES['imageFile']['error'] !== 4) {
				$this->load->library ('upload', $iconConfig, 'imageFile');
				//处理上传的图标
				if (! $this->imageFile->do_upload("imageFile", TRUE)) {
					$iconError = '图片上传失败: ' . $this->imageFile->display_errors('', '');
				} else {
					$iconFileInfo = $this->imageFile->data();
					$iconPath = $iconFileInfo['qiniu_ret']['key'];
				}
			}
			
			if ($iconError) {
				array_push($errorMessage, array('messageText' => $iconError));
			}
			
			if (empty($iconPath)) {
				array_push($errorMessage, array('messageText' => "未上传图片"));
			}
			
			if (!empty($errorMessage)) {
				$data['message'] = array('error' => $errorMessage);
				$this->load->view('message', $data);
			} else {
				$dataSave = array(
					"subjectID" => $subjectId,
					"subjectTitle" => $subjectTitle,
					"userID" => $robotId,
					"resUrl" => JY_QN_piclibs_url . $iconPath,
					"content" => $content,
					"pushTime" => $pushTime,
					"addTime" => date('Y-m-d H:i:s'),
					"updateTime" => date('Y-m-d H:i:s')
				);
				
				$result = $this->imglibs_model->saveRobotTask($dataSave);
			}
		} else {
			$image = $this->imglibs_model->getImageById($imgID);
			if (!empty($image)) {
				$dataSave = array(
					"subjectID" => $subjectId,
					"subjectTitle" => $subjectTitle,
					"userID" => $robotId,
					"resUrl" => JY_QN_piclibs_url . $image['picName'],
					"content" => $content,
					"pushTime" => $pushTime,
					"addTime" => date('Y-m-d H:i:s'),
					"updateTime" => date('Y-m-d H:i:s')
				);
				
				$result = $this->imglibs_model->saveRobotTask($dataSave);
				if ($result) {
					$this->imglibs_model->updateImageState($imgID);
				}
			}
		}
		
		if ($result) {
			$messageList = array();
			array_push($messageList, array('messageText' => "添加成功"));
			$data['message'] = array('success' => $messageList);
			$this->load->view('message', $data);
		}
	}
	
	public function robotTaskList() {
		$pageNo = (int)$this->input->get('pageNo', TRUE);
		$robotID = (int)$this->input->get('robotID', TRUE);
		$isPushed = $this->input->get('isPushed', TRUE);
		$pageSize = 10;
		$pageNo = $pageNo <= 0 ? 1: $pageNo;
		
		$queryData = $this->imglibs_model->getRobotImageList($robotID, $isPushed, $pageSize, $pageNo);
		
		$user = $this->jjuser->get_user_by_id($robotID);
		$robotList = $this->jjuser->getAllRobot();
		
		$imageList = $queryData['imageList'];
		$totalPages = $queryData['totalPages'];

		//设置数据
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['isPushed'] = $isPushed;
		$data['robotID'] = $robotID;
		$data['user'] = $user;
		$data['robotList'] = $robotList;
		
		$data['imageList'] = $imageList;
		$data['totalPages'] = $totalPages;
		$pathURL = "/imglibs/robotTaskList";
		
		$data['crumbs'] = $this->createCrumbs(array($pathURL => '机器人任务列表'));
		
		$query_config = array(
			'robotID' => $robotID <= 0 ? '' : $robotID,
			'isPushed' => $isPushed === false ? '' : $isPushed
		);
		
		$data['pageUrl'] = $pathURL . "?" . http_build_query($query_config);
		$data['pathURL'] = $pathURL;

		$this->load->view('robotTaskList', $data);
	}
	
	public function delRobotTask() {
		$id = $this->input->get('id', TRUE);
		
		$result = $this->imglibs_model->removeById($id);
		
		echo $result ? "1" : "0";
	}
	
	public function deleteImage() {
		$id = $this->input->get('imgID', TRUE);
		
		$result = $this->imglibs_model->removeImageByID($id);
		
		echo $result ? "1" : "0";
	}
}

/* End of file imglibs.php */
/* Location: ./application/controllers/imglibs.php */