<?php 

class Pushboard extends JY_Controller{
	
		function __construct() {
			
			parent::__construct();
			$this->load->model('pushboard_model','push');
		
		}
		
		public function pushList(){
				
			$data['crumbs'] = $this->createCrumbs(array('pushboard/pushEdit' => 'PUSH列表'));
			
			$pageSize = (int)$this->input->get('pageSize', TRUE);
			$pageNo =  (int)$this->input->get('pageNo', TRUE);
			$isSend =  (string)$this->input->get('isSend', TRUE);
			
			$pageNo = $pageNo <= 0 ? 1 : $pageNo;
			$pageSize = ($pageSize > 0 && $pageSize <= 50) ? $pageSize : 10;
			
			$pageInfo = $this->push->getPushList($isSend, $pageSize, $pageNo);
			
			$pushList = $pageInfo['pushList'];
			$totalPages = $pageInfo['totalPages'];
		
			$data['pageNo'] = $pageNo;
			$data['pageSize'] = $pageSize;
			$data['pushList'] = $pushList;
			$data['totalPages'] = $totalPages;
			$data['isSend'] = $isSend;
		
			$query_config = array(
				'isSend' => $isSend
			);
		
			$pathURL = "/pushboard/pushList";
		
			$data['pageUrl'] = $pathURL . "?" . http_build_query($query_config);
			$data['pathURL'] = $pathURL;
		
			$this->load->view('pushList',$data);
		}
		
		public function pushEdit(){
		
			$data['crumbs'] = $this->createCrumbs(array('pushboard/pushEdit' => '编辑PUSH'));
			$this->load->view('pushEdit', $data);	
		}
		
		public function pushSave(){
			
			$os = (string)$this->input->post("os", TRUE);
			$title = (string)$this->input->post("title", TRUE);
			$content = (string)$this->input->post("content", TRUE);
			$pushTime = $this->input->post("pushTime", TRUE);
			$version = (string)$this->input->post("version", TRUE);
			$loginDays = $this->input->post("loginDays", TRUE);
			$unLoginDays = $this->input->post("unLoginDays", TRUE);
			$type = (int)$this->input->post('type', TRUE);
			$jump = $this->input->post('jump', TRUE);
			
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
				
				$resUrl = "";
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
				}

				if (!empty($errorMessage)) {
					$data['message'] = array('error' => $errorMessage);
					$this->load->view('message', $data);
				} else {
					
					if (!empty($iconPath)) {
						$resUrl = JY_PINGO_DATA_URL . $iconPath;
					}

					$msgTmp = array(
						"os" => $os,
						"type" => $type,
						"title" => $title,
						"content" => $content,
						"addTime" => date("Y-m-d H:i:s"),
						"pushTime" => $pushTime,
						"version" => $version,
						"loginDays" => $loginDays,
						"unLoginDays" => $unLoginDays,
						"msgIcon" => $resUrl,
						"jumpUrl" => $this->getJumpStrByType($type, $jump)
					);
				
					$result = $this->push->savePush($msgTmp);
					if ($result) {
						array_push($errorMessage, array('messageText' => '保存成功!'));
						$data['message'] = array('success' => $errorMessage);
					} else {
						array_push($errorMessage, array('messageText' => '提交失败!'));
						$data['message'] = array('error' => $errorMessage);
					}
				}
			}
			$this->load->view('message', $data);	
		}
		
		public function pushDel(){
			
			$id = $this->input->get('id', TRUE);
		
			$result = $this->push->delPush($id);
		
			echo $result ? "1" : "0";
		}
}