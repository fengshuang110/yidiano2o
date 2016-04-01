<?php 
namespace Service;
/**
 * 通知服务
 * @author fengshuang
 *
 */
class TestService extends  Service{
	private  static  $instance = null;//业务层实例
	
	private function __construct(){
		
	}
	public static function getInstance(){
		
		if(self::$instance == null){
			self::$instance = new TestService();
		}
		return self::$instance;
	}
	public function  load1(){
		$this->getModel('WorkCategory');
	}
}
?>