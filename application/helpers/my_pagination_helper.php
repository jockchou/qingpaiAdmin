<?php
if ( ! function_exists('create_pagination')){
	function create_pagination($config){
		$pagination = &load_class("Pagination");
		//全页
		$html['full_tag_open'] = "<ul>";
		$html['full_tag_close'] = "</ul>";
		//数字页面
		$html['num_tag_open'] = "<li>";
		$html['num_tag_close'] = "</li>";
		//第一页
		$html['first_link']   = "第一页";
		$html['first_tag_open'] = "<li>";
		$html['first_tag_close'] = "</li>";
		//最后一页
		$html['last_link']    = "最后一页";
		$html['last_tag_open'] = "<li>";
		$html['last_tag_close'] = "</li>";
		//前一页
		$html['prev_tag_open']   ="<li>";
		$html['prev_tag_close']   ="</li>";
		//后一页
		$html['next_tag_open']   ="<li>";
		$html['next_tag_close']   ="</li>";
		//当前页
		$html['cur_tag_open'] = "<li  class=\"active\"><a href=\"javascript:void(0)\">";
		$html['cur_tag_close'] = "</li></a>";
		$html['use_page_numbers'] = TRUE;
		$config = array_merge($html,$config);
		$pagination->initialize($config);
		return $pagination->create_links();
	}
}
/* End of file MY_pagination_helper.php */
/* Location: ./application/helpers/MY_pagination_helper.php */