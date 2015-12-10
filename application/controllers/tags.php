<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends JY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('tags_model');
	}

	public function tagsList() {
		$pageNo = (int)$this->input->get('pageNo', TRUE);

		$pageSize = 10;
		$pageNo = $pageNo <= 0 ? 1: $pageNo;
		$queryData = null;

		$queryData = $this->tags_model->get_tags_list($pageNo, $pageSize);

		$tagsList = $queryData['tagsList'];
		$totalPages = $queryData['totalPages'];

		//设置数据
		$data['pageSize'] = $pageSize;
		$data['pageNo'] = $pageNo;
		$data['tagsList'] = $tagsList;
		$data['totalPages'] = $totalPages;
		$pathURL = "/tags/tagsList";
		$data['crumbs'] = $this->createCrumbs(array($pathURL => '标签列表'));

		$data['pageUrl'] = $pathURL . "?";
		$data['pathURL'] = $pathURL;


		$this->load->view('tagsList', $data);

	}

	public function tagsAdd() {
		$data['crumbs'] = $this->createCrumbs(array('tags/tagsList' => '标签列表', 'tags/tagsAdd' => '添加标签'));
		$this->load->view('tagsAdd', $data);
	}

	public function tagsSave() {
		$tagsName = $this->input->post('tagsName', TRUE);
		$sexAdapt = $this->input->post('sexAdapt', TRUE);

		$errorMessage = array();
		$data['crumbs'] = $this->createCrumbs(array('tags/tagsList' => '标签列表', 'tags/tagsAdd' => '添加标签'));

		if (mb_strlen($tagsName, 'utf8') > 7){
			//判断标签名是否超过7个字（字母和汉字都算一个字）
			array_push($errorMessage, array('messageText' => "标签[".$tagsName."]超过7个字"));
			$data['message'] = array('error' => $errorMessage);
			$this->load->view('message', $data);
		} elseif (!empty($tagsName) AND (!empty($sexAdapt) OR $sexAdapt === "0")) {
			//查询标签是否存在
			$tagsTmp = $this->tags_model->get_tags_by_tagsName($tagsName);
			if ($tagsTmp AND $tagsTmp->tagName === $tagsName) {
				//标签已经存在
				array_push($errorMessage, array('messageText' => "标签[".$tagsName."]已经存在"));
				$data['message'] = array('error' => $errorMessage);
				$this->load->view('message', $data);
			} else {
				$tags = array(
					'tagName'=> $tagsName,
					'sexAdapt' => $sexAdapt,
					'updateTime' => date('Y-m-d H:i:s')
				);
				$result = $this->tags_model->save_tags($tags);
				if ($result > 0) {
					array_push($errorMessage, array('messageText' => "标签[".$tagsName."]添加成功"));
					$data['message'] = array('success' => $errorMessage);
					$this->load->view('message', $data);
				}
			}
		}
		

	}

	public function tagsDelete() {
		$tagsName = $this->input->get('tagsName', TRUE);
		echo $this->tags_model->delete_tags($tagsName);

	}


	
}

/* End of file tags.php */
/* Location: ./application/controllers/tags.php */