<?php 
namespace Service;
use Common\Config;
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
	
	public function search($keyword,$params=array()){
		$goodses =  $this->getModel('Goods')->search($keyword,$params);
		foreach ($goodses as $key=>$item){
			$goodses[$key]['img'] = Config::img_url.$item['img'];
		}
		return $goodses;
	}
	
	public function detail($goods_id){
		return $this->getModel('Goods')->detail($goods_id);
	}
	
	public function  getByCategory($category_id,$params = array()){
		$goods = $this->getModel('GoodsCategory')
					->getByCategory($category_id,$params);
		foreach ($goods['items'] as $key=>$item){
			$goods['items'][$key]['img'] = Config::img_url.$item['img'];
		}
		return $goods;
	}
	
	public function category($parent_id = 0){
		return $this->getModel('GoodsCategory')
					->where(['field'=>'parent_id',"op"=>"=","value"=>$parent_id])
					->orderby(['field'=>'sort','sort'=>'asc'])
					->all();
	}
	public function recommend($type,$params = array()){
		$goods = $this->getModel('GoodsRecommend')
					->where(['field'=>'commend_id','op'=>'=','value'=>$type])
					->select($params);
		foreach ($goods['items'] as $key=>$item){
			$goods['items'][$key]['img'] = Config::img_url.$item['img'];
		}
		return $goods;
		
	}
}
?>
