<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sticker extends JY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('sticker_model');
	}

	public function stickerList() {
		
		$categoryID = (int)$this->input->get('categoryID', TRUE);
		$pageNo = (int)$this->input->get('pageNo', TRUE);
		
		
		$pageSize = 10;
		$pageNo = $pageNo <= 0 ? 1: $pageNo;
		$queryData = null;

		$queryData = $this->sticker_model->getStickerList($pageNo, $pageSize,$categoryID);

		$tagsList = $queryData['tagsList'];
		$totalPages = $queryData['totalPages'];

		//设置数据
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['tagsList'] = $tagsList;
		$data['totalPages'] = $totalPages;
		
		$pathURL = "/sticker/stickerList";
		$data['crumbs'] = $this->createCrumbs(array($pathURL => '贴纸列表'));
		if($categoryID>0){
			$data['pageUrl'] = $pathURL . "?categoryID=".$categoryID;
		}else{
			$data['pageUrl'] = $pathURL."?";
		}
		$data['pathURL'] = $pathURL;

		$this->load->view('stickerList', $data);

	}

	public function stickerClass(){
		
		$pageNo = (int)$this->input->get('pageNo', TRUE);

		$pageSize = 10;
		$pageNo = $pageNo <= 0 ? 1: $pageNo;
		$queryData = null;

		$queryData = $this->sticker_model->getStickerClassList($pageNo, $pageSize);

		$tagsList = $queryData['stickerClassList'];
		$totalPages = $queryData['totalPages'];

		//设置数据
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['stickerClassList'] = $tagsList;
		$data['totalPages'] = $totalPages;
		
		$pathURL = "/sticker/stickerClass";
		$data['crumbs'] = $this->createCrumbs(array($pathURL => '贴纸分类'));

		$data['pageUrl'] = $pathURL . "?";
		$data['pathURL'] = $pathURL;
		
		$this->load->view('stickerClassList', $data);
	}
	public function stickerAdd() {
		$categoryIDList = $this->sticker_model->getAllCategoryID();
		$data['categoryIDList'] = $categoryIDList;
		$data['crumbs'] = $this->createCrumbs(array('sticker/stickerList' => '贴纸列表', 'sticker/stickerAdd' => '添加贴纸'));
		$this->load->view('stickerAdd', $data);
	}
	public function stickerClassAdd(){
		
		$data['crumbs'] = $this->createCrumbs(array('sticker/stickerList' => '贴纸分类', 'sticker/stickerAdd' => '添加贴纸分类'));
		$this->load->view('stickerClassAdd', $data);
	}
	
	public function stickerActivity() {
		$stickerID = $this->input->get("stickerID", true);
		$data['crumbs'] = $this->createCrumbs(array('sticker/stickerList' => '贴纸列表'));
		$data['stickerID'] = $stickerID;
		
		$activityInfo = $this->sticker_model->getActivityByStickerID($stickerID);
		
		$data['actiInfo'] = $activityInfo;
		$this->load->view('stickerActivity', $data);
	}
	
	public function stickerActivitySave() {
		$activityID = $this->input->post("activityID", true);
		$title = $this->input->post("title", true);
		$content = $this->input->post("content", true);
		$stickerID = $this->input->post('stickerID', true);
		
		$iconConfig ['upload_path'] = JY_UPLOAD_IMG_PATH;
		$iconConfig ['allowed_types'] = 'png|jpg';
		$iconConfig ['max_size'] = 256;
		$iconConfig ['encrypt_name'] = TRUE;
		$iconConfig ['bucket']  = 'pingodata';
		
		$iconPath = '';
		$iconError = NULL;
		$errorMessage = array();
		
		if (isset($_FILES['imageFile']) AND $_FILES['imageFile']['error'] !== 4) {
			$this->load->library ('upload', $iconConfig, 'imageFile');
			//处理上传的图标
			if (! $this->imageFile->do_upload("imageFile", TRUE)) {
				$iconError = '图上传失败: ' . $this->imageFile->display_errors('', '');
			} else {
				$iconFileInfo = $this->imageFile->data();
				$iconPath = $iconFileInfo['qiniu_ret']['key'];
			}
		}
		
		if ($iconError) {
			array_push($errorMessage, array('messageText' => $iconError));
		}
		
		if (empty($activityID) && empty($iconPath)) {
			array_push($errorMessage, array('messageText' => "未选择上传图片"));
		}
		
		if (!empty($errorMessage)) {
			$data['message'] = array('error' => $errorMessage);
			$this->load->view('message', $data);
		} else {
			$now = date("Y-m-d H:i:s");
			
			$tmpObj = array(
				"stickerID" => $stickerID,
				"title" => $title,
				"content" => $content,
				"updateTime" => $now
			);
			if (!empty($iconPath)) {
				$tmpObj['posterUrl'] = JY_PINGO_DATA_URL . $iconPath;
			}
			if (!empty($activityID)) {
				$result = $this->sticker_model->updateStickerActivity($activityID, $tmpObj);
			} else {
				$tmpObj['addTime'] = $now;
				$result = $this->sticker_model->saveStickerActivity($tmpObj);
			}
			
			if ($result) {
				array_push($errorMessage, array('messageText' => '保存成功!'));
				$data['message'] = array('success' => $errorMessage);
			} else {
				array_push($errorMessage, array('messageText' => '提交失败!'));
				$data['message'] = array('error' => $errorMessage);
			}
			
			$this->load->view('message', $data);
		}
	}
	
	public function stickerClassSave(){
		
		$stickerID = (int)$this->input->post("stickerID", TRUE);
		$title = $this->input->post("title", TRUE);
		$orderVal = (int)$this->input->post("orderVal", TRUE);
		//$onlineTime = (string)$this->input->post("onlineTime");
		$resUrl = "";
		
		$iconConfig ['upload_path'] = JY_UPLOAD_IMG_PATH;
		$iconConfig ['allowed_types'] = 'png|jpg';
		$iconConfig ['max_size'] = 1024;
		$iconConfig ['encrypt_name'] = TRUE;
		$iconConfig ['bucket']  = 'qpsticker';
		
		$iconPath = '';
		$iconError = NULL;
		$errorMessage = array();
		
		if (isset($_FILES['imageFile']) AND $_FILES['imageFile']['error'] !== 4) {
			$this->load->library ('upload', $iconConfig, 'imageFile');
			//处理上传的图标
			if (! $this->imageFile->do_upload("imageFile", TRUE)) {
				$iconError = '背景图上传失败: ' . $this->imageFile->display_errors('', '');
			} else {
				$iconFileInfo = $this->imageFile->data();
				$iconPath = $iconFileInfo['qiniu_ret']['key'];
			}
		}
		
		if ($iconError) {
			array_push($errorMessage, array('messageText' => $iconError));
		}
		
		if (empty($iconPath) && $stickerID == 0) {
			array_push($errorMessage, array('messageText' => "未选择贴纸图片"));
		}
		
		if (!empty($errorMessage)) {
			$data['message'] = array('error' => $errorMessage);
			$this->load->view('message', $data);
		} else {
			$timeNow = date("Y-m-d H:i:s");
			
			$msgTmp = array(
				"title" => $title,
				"orderVal" => $orderVal,
				"updateTime" => $timeNow
			);
			
			if($stickerID <= 0){
				$msgTmp['addTime'] = $msgTmp['updateTime'];
			}
			
			if (!empty($iconPath)) {
				$resUrl = JY_PINGO_STICKER_URL . $iconPath;
				$msgTmp['iconUrl'] = $resUrl;
			}
			
			if ($stickerID > 0) {
				$result = $this->sticker_model->updateStickerClass($stickerID, $msgTmp);
			} else {
				$result = $this->sticker_model->saveStickerClass($msgTmp);
			}
			
			if ($result) {
				array_push($errorMessage, array('messageText' => '保存成功!'));
				$data['message'] = array('success' => $errorMessage);
			} else {
				array_push($errorMessage, array('messageText' => '提交失败!'));
				$data['message'] = array('error' => $errorMessage);
			}
		}
			$this->load->view('message', $data);
	}
	
	public function stickerSave() {
		$stickerID = (int)$this->input->post("stickerID", TRUE);
		$name = (string)$this->input->post("stickerName", TRUE);
		$orderVal = (int)$this->input->post("orderVal", TRUE);
		$startTime = (string)$this->input->post("startTime");
		$endTime = (string)$this->input->post("endTime");
		$onlineTime = (string)$this->input->post("onlineTime");
		$categoryID = (string)$this->input->post("categoryId");
		$tag = (string) $this->input->post("tag", TRUE);
		$subjectTitle = (string) $this->input->post("subjectTitle", TRUE);
		$isHot = (int)$this->input->post("hotTopic");
		$isFullScreen = (int)$this->input->post("isFullScreen", TRUE);
				
		$resUrl = "";
		
		$iconConfig ['upload_path'] = JY_UPLOAD_IMG_PATH;
		$iconConfig ['allowed_types'] = 'png|jpg';
		$iconConfig ['max_size'] = 1024;
		$iconConfig ['encrypt_name'] = TRUE;
		$iconConfig ['bucket']  = 'qpsticker';
		
		$iconPath = '';
		$iconError = NULL;
		$errorMessage = array();
		
		if (isset($_FILES['imageFile']) AND $_FILES['imageFile']['error'] !== 4) {
			$this->load->library ('upload', $iconConfig, 'imageFile');
			//处理上传的图标
			if (! $this->imageFile->do_upload("imageFile", TRUE)) {
				$iconError = '背景图上传失败: ' . $this->imageFile->display_errors('', '');
			} else {
				$iconFileInfo = $this->imageFile->data();
				$iconPath = $iconFileInfo['qiniu_ret']['key'];
			}
		}
		
		if ($iconError) {
			array_push($errorMessage, array('messageText' => $iconError));
		}
		
		if (empty($iconPath) && $stickerID == 0) {
			array_push($errorMessage, array('messageText' => "未选择贴纸图片"));
		}
		
		if ($tag != "0" && (empty($startTime) || empty($endTime))) {
			array_push($errorMessage, array('messageText' => "未选择标签有效日期"));
		}
			
		if (!empty($errorMessage)) {
			$data['message'] = array('error' => $errorMessage);
			$this->load->view('message', $data);
		} else {
			
			$timeNow = date("Y-m-d H:i:s");
			
			$msgTmp = array(
				"tag" => $tag,
				"name" => $name,
				"orderVal" => $orderVal,
				"tagStartTime" => $startTime,
				"tagEndTime" => $endTime,
				"onlineTime" => $onlineTime,
				"categoryID" => $categoryID,
				"isFullScreen" => $isFullScreen
			);
			
			if("" != trim($subjectTitle)){
				$result = $this->sticker_model->getSubjectIdByTitle(md5($subjectTitle));
				if(!$result){
					//不存在，创建话题
					$result = $this->sticker_model->saveSubjectTitle($subjectTitle);
					if($result){
						$subjectID = $this->db->insert_id();
						$msgTmp['subjectID'] = $subjectID;
					}
				}else{
					$msgTmp['subjectID'] = $result['id'];
				}
				$msgTmp['subjectTitle'] = $subjectTitle;
			}
			
			
			if($isHot == 1){
				$msgTmp['isHot'] = 1;
			}else{
				$msgTmp['isHot'] = 0;
			}
			
			if ($stickerID > 0) {
				$msgTmp['updateTime'] = $timeNow;
			} else {
				$msgTmp['addTime'] = $timeNow;
				$msgTmp['updateTime'] = $timeNow;
			}
			
			if (!empty($iconPath)) {
				$resUrl = JY_PINGO_STICKER_URL . $iconPath;
				$msgTmp['imageUrl'] = $resUrl;
			}
			
			if ($stickerID > 0) {
				$result = $this->sticker_model->updateSticker($stickerID, $msgTmp);
			} else {
				$result = $this->sticker_model->saveSticker($msgTmp);
			}
			
			if ($result) {
				array_push($errorMessage, array('messageText' => '保存成功!'));
				$data['message'] = array('success' => $errorMessage);
			} else {
				array_push($errorMessage, array('messageText' => '提交失败!'));
				$data['message'] = array('error' => $errorMessage);
			}
			
			$this->load->view('message', $data);
		}
	}
	
	public function stickerDelete() {
		$id = $this->input->get('id', true);
		$op = $this->input->get('op', true);
		echo $this->sticker_model->updateOnlineState($id, $op);
	}
	
	public function stickerEdit() {
		$stickerID = $this->input->get('stickerID', true);
		$sticker = $this->sticker_model->getStickerById($stickerID);
		$data['sticker'] = $sticker;
		$categoryIDList = $this->sticker_model->getAllCategoryID();
		$data['categoryIDList'] = $categoryIDList;
		$data['crumbs'] = $this->createCrumbs(array('sticker/stickerList' => '贴纸列表', 'sticker/stickerAdd' => '添加贴纸'));
		$this->load->view('stickerAdd', $data);
	}
	
	public function stickerClassEdit(){
		$id = $this->input->get('id', true);
		$sticker = $this->sticker_model->getStickerClassById($id);
		$data['sticker'] = $sticker;
		$data['crumbs'] = $this->createCrumbs(array('sticker/stickerList' => '贴纸列表', 'sticker/stickerAdd' => '更改分类贴纸'));
		$this->load->view('stickerClassAdd', $data);
	}
	
	public function stickerClassDelete(){
		$id = $this->input->get('id', true);
		echo $this->sticker_model->removeClass($id);
	}
	
	public function addCrond() {
		$stickerID = $this->input->get('stickerID', true);
		
		$data['crumbs'] = $this->createCrumbs(array('sticker/stickerList' => '贴纸列表', 'sticker/addCrond' => '添加黄历'));
		$sticker = $this->sticker_model->getStickerById($stickerID);
		
		$data['stickerID'] = $stickerID;
		$data['sticker'] = $sticker;
		
		$this->load->view('addCrond', $data);
	}
	
	public function removeCrond() {
		$id = $this->input->get('id', true);
		
		echo $this->sticker_model->removeCrond($id);
	}
	
	public function listCrond() {
		$stickerID = (int)$this->input->get("stickerID", TRUE);
		$pageNo = (int)$this->input->get("pageNo", TRUE);
		
		$pageNo = $pageNo <= 0 ? 1 : $pageNo;
		$pageSize = 10;
		
		
		$data['crumbs'] = $this->createCrumbs(array('sticker/stickerList' => '贴纸列表', 'sticker/listCrond' => '黄历列表'));
		
		$crondData = $this->sticker_model->getCrondList($stickerID, $pageNo, $pageSize);
		$totalPages = $crondData['totalPages'];
		$crondList = $crondData['crondList'];
		
		//设置数据
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['crondList'] = $crondList;
		$data['totalPages'] = $totalPages;
		
		$pathURL = "/sticker/listCrond";
		$data['crumbs'] = $this->createCrumbs(array($pathURL => '黄历列表'));
		if($stickerID > 0){
			$data['pageUrl'] = $pathURL . "?stickerID=".$stickerID;
		}else{
			$data['pageUrl'] = $pathURL."?";
		}
		
		$data['pathURL'] = $pathURL;

		$this->load->view('crondList', $data);
	}
	
	
	public function saveCrond() {
		$stickerID = (int)$this->input->post("stickerID", TRUE);
		$actionTime = (string)$this->input->post("actionTime");
		$resUrl = "";
		
		$iconConfig ['upload_path'] = JY_UPLOAD_IMG_PATH;
		$iconConfig ['allowed_types'] = 'png|jpg';
		$iconConfig ['max_size'] = 256;
		$iconConfig ['encrypt_name'] = TRUE;
		$iconConfig ['bucket']  = 'qpsticker';
		
		$iconPath = '';
		$iconError = NULL;
		$errorMessage = array();
		
		if (isset($_FILES['imageFile']) AND $_FILES['imageFile']['error'] !== 4) {
			$this->load->library ('upload', $iconConfig, 'imageFile');
			//处理上传的图标
			if (! $this->imageFile->do_upload("imageFile", TRUE)) {
				$iconError = '背景图上传失败: ' . $this->imageFile->display_errors('', '');
			} else {
				$iconFileInfo = $this->imageFile->data();
				$iconPath = $iconFileInfo['qiniu_ret']['key'];
			}
		}
		
		if ($iconError) {
			array_push($errorMessage, array('messageText' => $iconError));
		}
		
		if (empty($iconPath)) {
			array_push($errorMessage, array('messageText' => "未选择贴纸图片"));
		}
		$timeNow = date("Y-m-d H:i:s");
		
		if ($actionTime <= $timeNow) {
			array_push($errorMessage, array('messageText' => "替换时间必须是一个未来时间"));
		}
		
		if (!empty($errorMessage)) {
			$data['message'] = array('error' => $errorMessage);
			$this->load->view('message', $data);
		} else {
			$crondData = array(
				"stickerID" => $stickerID,
				"actionTime" => $actionTime,
				"addTime" => $timeNow
			);
			
			if (!empty($iconPath)) {
				$resUrl = JY_PINGO_STICKER_URL . $iconPath;
				$crondData['imageUrl'] = $resUrl;
			}
			
			$result = $this->sticker_model->saveCrond($crondData);
			
			if ($result) {
				array_push($errorMessage, array('messageText' => '保存成功!'));
				$data['message'] = array('success' => $errorMessage);
			} else {
				array_push($errorMessage, array('messageText' => '提交失败!'));
				$data['message'] = array('error' => $errorMessage);
			}
			$this->load->view('message', $data);
		}
	}
}

/* End of file sticker.php */
/* Location: ./application/controllers/sticker.php */