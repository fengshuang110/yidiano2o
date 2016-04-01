<?php 
namespace Api;
use Service\UserService;
use Service\SmsService;
use Service\CartService;
use Service\ApplicationConfigService;

/**
 *  购物车接口类
 * @author fengshuang
 *
 */
class Cart extends Authorization{
	/**
	 * @url GET /lists
	 * 用户购物车列表
	 */
	public function carts(){
		$carts = CartService::getInstance()->getCarts();
		$min_cost = ApplicationConfigService::getInstance()->getMinCost();
		$result =  array("code"=>0,
				"data"=>array(
					"carts"=>$carts,
					'min_cost'=>$min_cost
				)
			);
		return $result;
	}
	
	/**
	 * @url POST /add
	 * 添加购物车
	 */
	public function cartAdd($goods_id,$quantity){
		return CartService::getInstance()->addCart($goods_id, $quantity);
	}
	
	/**
	 * 删除购物车
	 */
	public function cartDel($id){
		$affectedCount =  CartService::getInstance()->delCart($id);
		if($affectedCount){
			return array('code'=>0,"message"=>"删除成功");
		}
		return array('code'=>1,"message"=>"删除失败");
	}
	
}

?>