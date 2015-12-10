<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class Subjectactivity extends JY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('subjectactivity_model');
	}

	public function subjectactivityList() {
		
		$pageNo =  (int)$this->input->get('pageNo', TRUE);
		$subjectTitle =  (string)$this->input->get('subjectTitle', TRUE);

		$pageNo = $pageNo <= 0 ? 1 : $pageNo;
		$pageSize = 10;
		
		if($subjectTitle != ""){
			$queryData = $this->subjectactivity_model->getActivityList($pageNo, $pageSize, $subjectTitle);
		}else{
			$queryData = $this->subjectactivity_model->getActivityList($pageNo, $pageSize);
		}

		$activityList = $queryData['activityList'];
		$totalPages = $queryData['totalPages'];

		//设置数据
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['totalPages'] = $totalPages;
		$data['activityList'] = $activityList;
		
		//$data['pageList'] = $this->pageList;
		
		$data['crumbs'] = $this->createCrumbs(array('subjectactivity/subjectactivityList' => '活动列表'));
		
		$data['pageUrl'] = "/subjectactivity/subjectactivityList?";
		
		$this->load->view('subjectactivityList', $data);
	}
	
	public function subjectactivityAdd() {
		
		$data['crumbs'] = $this->createCrumbs(array('/subjectactivity/subjectactivityList' => '活动列表', '/activity/activityAdd' => '添加活动'));
		
		//$data['pageList'] = $this->pageList;

		$this->load->view('subjectactivityAdd', $data);
	}
	
	public function subjectactivityUpdate() {
		

		$id =  (int)$this->input->get("id", true);
		
		$subject = $this->subjectactivity_model->getSubjectById($id);
		
		$subject_hotsearch = $this->subjectactivity_model->getHotSearchBySubject($id);
		
		$subject['crumbs'] = $this->createCrumbs(array('/subjectactivity/subjectactivityList' => '活动列表', '/activity/activityAdd' => '添加活动'));
		
		$subject['isSearchSubject'] = empty($subject_hotsearch) ? 0 : 1;
		
		$this->load->view('subjectactivityAdd', $subject);
	}
	
	public function activitySave() {
		
		$id 			=  $this->input->get_post("id", true);
		$title 			=  $this->input->get_post("title", true);
		$content 		=  $this->input->get_post("content", true);
		$imageUrl 		=  $this->input->get_post("imageUrl", true);
		$imageUrl2 		=  $this->input->get_post("imageUrl2", true);
		$posterUrl 		=  $this->input->get_post("posterUrl", true);
		$activityUrlType = (int)$this->input->get_post("activityUrlType", true);
		$activityTitle 	=  $this->input->get_post("activityTitle", true);
		$activityUrl 	=  $this->input->get_post("activityUrl", true);
		$prizeUrl 		=  $this->input->get_post("prizeUrl", true);
		$orderVal       =  $this->input->get_post("order",true);
		$onlineTime 	=  $this->input->get_post("onlineTime", true);
		$recommend		=  $this->input->get_post("recommend", true);
		
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
		
		if ($activityUrlType == 1 && empty($prizeUrl)) {
			array_push($errorMessage, array('messageText' => '未填写获奖H5页面URL地址!'));
		}
		
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
				$iconError = '图上传失败: ' . $this->iconUpload->display_errors('', '');
			} else {
				$iconFileInfo = $this->iconUpload->data();
				$iconPath2 = $iconFileInfo['qiniu_ret']['key'];
			}
		}
		
		if ($iconError) {
			array_push($errorMessage, array('messageText' => $iconError));
		}
		
		//===========处理图片上传===========
		$iconPath3 = '';
		
		if (isset($_FILES['iconFile3']) AND $_FILES['iconFile3']['error'] !== 4) {
			$this->load->library ('upload', $iconConfig, 'iconUpload');
					
			//处理上传的图标
			if (! $this->iconUpload->do_upload("iconFile3", TRUE)) {
				$iconError = '图上传失败: ' . $this->iconUpload->display_errors('', '');
			} else {
				$iconFileInfo = $this->iconUpload->data();
				$iconPath3 = $iconFileInfo['qiniu_ret']['key'];
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
			}
			if (!empty($iconPath2)) {
				$posterUrl = JY_PINGO_DATA_URL . $iconPath2;
			}
			if (!empty($iconPath3)) {
				$imageUrl2 = JY_PINGO_DATA_URL . $iconPath3;
			}
			
			//===========处理图片上传===========End
			
 			$activityData = array(
				"title" => trim($title),
				"content" => $content,
				"imageUrl" => $imageUrl,
				"imageUrl2" => $imageUrl2,
				"posterUrl" => $posterUrl,
				"activityUrlType" => $activityUrlType,
				"activityTitle" => $activityTitle,
				"activityUrl" => $activityUrl,
				"prizeUrl" => $prizeUrl,
 				"isActivity" => (empty($activityUrl) && empty($prizeUrl))? 0 : 1,
				"onlineTime" => $onlineTime,
 				"orderVal" => $orderVal
 			);
 			
 			if (!empty($recommend) && in_array("hot", $recommend)) {
 				$activityData['isHot'] = 1;
 			}else{
 				$activityData['isHot'] = 0;
 			}
 			
 			$timeNow = date('Y-m-d H:i:s');
 			$subjectID = 0;
 			
 			if($id <= 0){
 				$activityData['addTime'] = $timeNow;
 				$activityData['updateTime'] = $timeNow;
 				$activityData['readCnt'] = rand(1000, 2000);
 				$activityResult = $this->subjectactivity_model->saveActivity($activityData);
 				$subjectID = $this->subjectactivity_model->db->insert_id();
 			} else {
 				$subjectID = $id;
 				$activityData['updateTime'] = $timeNow;
 				$activityResult = $this->subjectactivity_model->updateActivity($activityData, $id);
 			}
 			if ($activityResult) {
				$this->clearRedisCache('cache', 'listHotSubject:*');
				
 				if (!empty($recommend) && in_array("search", $recommend) && $subjectID > 0) {
 					$this->subjectactivity_model->saveHotSearch($subjectID);
 				}else{
 					$this->subjectactivity_model->delHotSearchBySubject($subjectID);
 				}
 				//判断是否推荐了
 				array_push($errorMessage, array('messageText' => '保存活动成功!'));
 			} else {
 				array_push($errorMessage, array('messageText' => '保存活动失败!'));
 			}

			$data['message'] = array('success' => $errorMessage);

			$this->load->view('message', $data);
		}
	}
	
	public function activityOff() {
		$id = $this->input->get('id', TRUE);
		$op = $this->input->get('op', TRUE);
		if ($op == 'on') {
			$onlineStatus = 1;
		} else {
			$onlineStatus = 0;
		}
		$result = $this->subjectactivity_model->offActivity($id, $onlineStatus);
		echo $result;
	}
	
	//搜索推荐
	public function searchHotList() {
		$pageNo = (int)$this->input->get('pageNo', TRUE);

		$pageSize = 10;
		$pageNo = $pageNo <= 0 ? 1: $pageNo;
		$queryData = null;

		$queryData = $this->subjectactivity_model->geSubjectHotsearchList($pageNo, $pageSize);

		$subjectList = $queryData['subjectList'];
		$totalPages = $queryData['totalPages'];

		//设置数据
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['subjectList'] = $subjectList;
		$data['totalPages'] = $totalPages;
		$pathURL = "/subjectactivity/searchHotList";
		$data['crumbs'] = $this->createCrumbs(array($pathURL => '搜索推荐列表'));

		$data['pageUrl'] = $pathURL . "?";
		$data['pathURL'] = $pathURL;

		$this->load->view('searchHotList', $data);
		
	}
	
	public function deSearchHost() {
		$sid = $this->input->get("sid", true);
		
		$result = $this->subjectactivity_model->deSearchHostByID($sid);
		
		echo (string) $result;
	}
}
/* End of file embed.php */
/* Location: ./application/controllers/embed.php */