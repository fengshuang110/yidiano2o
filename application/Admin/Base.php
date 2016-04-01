<?php 

namespace Admin;

use Luracast\Restler\Format\HtmlFormat;
/**
 *  app应用信息
 * @author fengshuang
 *
 */
class Base extends Rest{
	protected $models = array();
	protected $namespace = 'Model';
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
	
	public function getModel($name,$namespace = ""){
		foreach ($this->models as $model){
			$class_name = basename(str_replace('\\', '/', get_class($model)));
			if($name == $class_name){
				return $model;
			}
		}
		$class_name = '\\'.$this->namespace.'\\'.$name;
		if(class_exists($class_name)){
			$class  = new $class_name;
			$this->models[$name] = $class;
			return  $class;
		}else{
			throw new \Exception($name."class is not exist");
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