<?php 

namespace Frontend;

use Luracast\Restler\Format\HtmlFormat;
/**
 *  app应用信息
 * @author fengshuang
 *
 */
class Base extends Rest{
	
	public function __construct(){
		$parse_url = parse_url($_SERVER['REQUEST_URI']);
		$page_query = "";
		if(isset($parse_url['query'])){
			parse_str($parse_url['query'],$query);
			
			unset($query['page']);
			foreach ($query as $key=>$value){
				$page_query = '$'.$key."=".$value;
			}
		}
		HtmlFormat::$data['page_query'] = $page_query;
		if(!empty($_SESSION['user'])){
			HtmlFormat::$data['session_user'] = $_SESSION['user'];
		}
	}
	/**
	 * @view $template
	 * (non-PHPdoc)
	 * @see \Frontend\Rest::render()
	 */
	public function render($data,$template=""){
		HtmlFormat::$data = array_merge(HtmlFormat::$data,$data);
		return HtmlFormat::$data;
	}
}

?>