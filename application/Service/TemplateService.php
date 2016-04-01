<?php 
namespace Service;
/**
 * 商品服务
 * @author fengshuang
 *
 */
class GoodsService extends  Service{
	private  static  $instance = null;//业务层实例
	
	private function __construct(){
		
	}
	public static function getInstance(){
		
		if(self::$instance == null){
			self::$instance = new GoodsService();
		}
		return self::$instance;
	}
	public function category(){
		return $this->getModel('GoodsCategory')->where(['field'=>'parent_id',"op"=>"=","value"=>0])->all;
	}
}
?>