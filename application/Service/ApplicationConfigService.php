<?php 
namespace Service;
/**
 * 全局配置服务
 * @author fengshuang
 *
 */
class ApplicationConfigService extends  Service{
	private  static  $instance = null;//业务层实例
	const  MIN_COST = 'min_cost';
	private function __construct(){
		
	}
	public static function getInstance(){
		
		if(self::$instance == null){
			self::$instance = new ApplicationConfigService();
		}
		return self::$instance;
	}
	
	public function getMinCost(){
		$item = $this->getModel('ApplicationConfig')->getItem(self::MIN_COST);
		return number_format((float)$item['value'], 2);
	}
	
}
?>