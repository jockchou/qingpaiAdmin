<?php
class SysNotice extends JY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('sysnotice_model', 'sysnotice');
	}
	
	public function sysNoticList() {
		$data['crumbs'] = $this->createCrumbs(array('sysnotice/sysNoticList' => '小喇叭列表'));
		
		$type =  (string)$this->input->get('type', TRUE);
		$pageSize = (int)$this->input->get('pageSize', TRUE);
		$pageNo =  (int)$this->input->get('pageNo', TRUE);
		
		//默认值
		$pageNo = $pageNo <= 0 ? 1 : $pageNo;
		$pageSize = ($pageSize > 0 && $pageSize <= 50) ? $pageSize : 10;
		
		$pageInfo = $this->sysnotice->getSysNoticeList($type, $pageSize, $pageNo);
		
		if ($pageInfo) {
			$data['pageNo'] = $pageNo;
			$data['pageSize'] = $pageSize;
			$data['sysNoticeList'] = $pageInfo['sysNoticeList'];
			$data['totalPages'] = $pageInfo['totalPages'];
			$data['type'] = $type;
		}
		
		$query_config = array(
			'type' => $type
		);
		
		$pathURL = "/sysnotice/sysNoticList";
		
		$data['pageUrl'] = $pathURL . "?" . http_build_query($query_config);
		$data['pathURL'] = $pathURL;
		
		$this->load->view('sysNoticeList', $data);
	}
	
	public function saveSysNotice() {
		
		$title = $this->input->post('title', TRUE);
		$content = $this->input->post('content', TRUE);
		$type = (int)$this->input->post('type', TRUE);
		$os = $this->input->post('os', TRUE);
		$jump = $this->input->post('jump', TRUE);
		$pubTime = $this->input->post('pubTime', TRUE);
		
		$errorMessage = array();
		
		$check = $this->checkJumpID($type, $jump);
		if ($check !== TRUE) {
			
			array_push($errorMessage, array('messageText' => $check));
			$data['message'] = array('error' => $errorMessage);
			
		} else {
			
			$iconConfig ['upload_path'] = JY_UPLOAD_IMG_PATH;
			$iconConfig ['allowed_types'] = 'gif|jpg|png';
			$iconConfig ['max_size'] = 256;
			$config['max_width']  = '800';
			$config['max_height']  = '600';
			$iconConfig ['encrypt_name'] = TRUE;
			
			$imageUrl = '';
			$iconPath = '';
			$iconError = NULL;
			
			
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
				$data['message'] = array('warning' => $errorMessage);
				
			}
			
			if (!empty($iconPath)) { 
				$imageUrl = JY_PINGO_DATA_URL . $iconPath;
			}
			
			$data['title'] = $title;
			$data['content'] = $content;
			$data['type'] = $type;
			$data['os'] = $os;
			$data['imageUrl'] = $imageUrl;
			$data['jumpUrl'] = $this->getJumpStrByType($type, $jump);
			$data['pubTime'] = $pubTime;
			$data['addTime'] = date('Y-m-d H:i:s');
			
			$result= $this->sysnotice->saveSysNotice($data);
			
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
	
	public function deleteSysNotice() {
		
		$id = $this->input->get('id', TRUE);
		$result = $this->sysnotice->deleteSysNotice($id);
		if ($result) {
			echo "0";
		} else {
			echo "999";
		}
		
	}
	
	public function editSystNotice() {
		$data['crumbs'] = $this->createCrumbs(array('message/msgEdit' => '编辑消息'));
		$this->load->view('sysNoticeEdit', $data);
	}
	
}