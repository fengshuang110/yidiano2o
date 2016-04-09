<?php 
namespace Service;
use Common\Config;
/**
 * 购物车服务
 * @author fengshuang
 *
 */
class CartService extends  Service{
	private  static  $instance = null;//业务层实例
	protected $user;
	private function __construct(){
		$this->user = AuthService::verifyLogin();
	}
	public static function getInstance(){
		
		if(self::$instance == null){
			self::$instance = new CartService();
		}
		return self::$instance;
	}
	
	public function getCarts(){
		$user_id = $this->user['user_id'];
		$carts = $this->getModel('Cart')->getCarts($user_id);
		foreach ($carts as $key => $cart){
			$carts[$key]['img'] = Config::img_url.$cart['img'];
		}
		return $carts;
	}
	
	public function addCart($goods_id,$quantity){
		$cartModel = $this->getModel('Cart');
		$goods = $this->getModel('Goods')->get($goods_id);
		
		if(empty($goods)){
			return array("code"=>1,"message"=>"商品已经下架");
		}
		if($goods['store_nums']<$quantity){
			return array("code"=>1,"message"=>"商品库存不足");
		}
		$cart = $cartModel->where(['field'=>'goods_id','op'=>'=','value'=>$goods_id])
						  ->where(['field'=>'user_id','op'=>'=','value'=>$this->user['user_id']])
						  ->getOne();
		if(!empty($cart)){
			if($quantity<1){
				$cartModel->del($cart['id']);
				return array("code"=>0,"message"=>"删除商品成功");
			}
			$cart['goods_number'] = $quantity;
			$cart['sell_price'] = $goods['sell_price'];;
			$cart['market_price'] = $goods['market_price'];
		}else{
			$cart['user_id'] = $this->user['user_id'];
			$cart['goods_id'] = $goods['id'];
			$cart['goods_no'] = $goods['goods_no'];
			$cart['goods_name'] = $goods['name'];
			$cart['goods_number'] = $quantity;
			$cart['sell_price'] = $goods['sell_price'];
			$cart['market_price'] = $goods['market_price'];
			$lastInsertId = $cartModel->save($cart);
			if($lastInsertId){
				return array("code"=>0,"message"=>"添加成功");
			}
		
			return array("code"=>1,"message"=>"添加失败");
		}
	}
	
	/**
	 * 删除购物车
	 * @param unknown $id
	 * @return boolean
	 */
	public function delCart($id){
		$cartModel = $this->getModel('Cart');
		$cart = $cartModel->get($id);
		if($cart['user_id'] != $this->user['user_id']){
			return false;
		}
		return $cartModel->del($id);
	}
}
?>