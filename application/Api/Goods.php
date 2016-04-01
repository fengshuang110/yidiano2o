<?php 
namespace Api;

use Service\GoodsService;
/**
 *  商品接口类
 * @author fengshuang
 *
 */
class Goods{
	
	/**
	 * 商品分类
	 * @return multitype:number unknown
	 */
	public function category(){
		$data = GoodsService::getInstance()->category();
		return array("code"=>0,'data'=>$data);
	}
	
	/**
	 * 1最新 2特价商品 3热卖 4推荐 
	 */
	public function recommend($type = 1){
		if(!in_array($type, array(1,2,3,4))){
			$type = 1;
		}
		$goods = GoodsService::getInstance()->recommend($type);
		
		return array("code"=>1,"data"=>$goods);
	}
	
	/**
	 * 分类查询商品
	 * @url GET /lists
	 * @param unknown $category_id
	 * @return multitype:number unknown
	 */
	public function getByCategory($category_id){
		$goods = GoodsService::getInstance()->getByCategory($category_id);
		return array("code"=>0,"data"=>$goods);
	}
	
	/**
	 * 商品详情
	 * @param unknown $goods_id
	 * @return multitype:number unknown
	 */
	public function detail($goods_id){
		$goods = GoodsService::getInstance()->detail($goods_id);
		return array("code"=>0,"data"=>$goods);
	}
	
	/**
	 * 
	 * @param unknown $keyword
	 */
	public function search($keyword){
		$goods = GoodsService::getInstance()->search($keyword);
		return array("code"=>0,"data"=>$goods);
	}
}

?>