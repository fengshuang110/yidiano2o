<?php 
namespace Api;

use Service\CartService;
use Service\UserService;
use Service\PaymentService;
use Service\ApplicationConfigService;
use Service\OrderService;
/**
 *  订单接口
 * @author fengshuang
 *
 */
class Order extends Authorization{
	/**
	 * @url GET /lists
	 * @return multitype:number multitype:
	 */
	public function orders($type = "all"){
		$orders = OrderService::getInstance()->getOrders($type);
		return array("code"=>0,"data"=>$orders);
	}
	
	public function before(){
		$carts = CartService::getInstance()->getCarts();
		if(empty($carts)){
			return array("code"=>1,"message"=>"购物车没有数据");
		}
		$goods_total = 0;
		$cart_count = 0;
		$freight = 0;
		foreach ($carts as $cart){
			$cart_count += $cart['goods_number'];
			$goods_total += $cart['goods_number'] * $cart['real_sell_price'];
		}
		//计算配送费
		if($goods_total < 200){
			$freight = 20;	
		}
		
		$address = UserService::getInstance()->getAddress();
		
		$payments = PaymentService::getInstance()->getPayments();
		$min_cost = ApplicationConfigService::getInstance()->getMinCost();
		return array("code"=>0,"data"=>array(
						"carts"=>$carts,
						"goods_total"=>$goods_total,
						"min_cost"=>$min_cost,
						"cart_count"=>$cart_count,
						'freight'=>$freight,
						"address"=>$address,
						"payments"=>$payments,
				));
	}
	
	/**
	 *创建订单
	 *@url POST /create
	 */
	public function create($payment_id,$addr_id,$postscript=""){
		$carts = CartService::getInstance()->getCarts();
		if(empty($carts)){
			return array("code"=>1,"message"=>"购物车没有数据");
		}
		$address = UserService::getInstance()->getAddrById($addr_id);
		if(empty($address)){
			return array("code"=>1,"message"=>"地址错误");
		}
		
		$payment = PaymentService::getInstance()->checkPayment($payment_id);
		
		if(empty($payment)){
			return array("code"=>1,"message"=>"支付方式错误");
		}
		$order['postscript'] = $postscript;
		$result = OrderService::getInstance()->createOrder($order,$carts,$address,$payment);
		if($result){
			return array("code"=>0,'message'=>'订单生成成功','data'=>$result);
		}
		return array("code"=>1,'message'=>'订单生成失败');
		
	}
	
	/**
	 * 订单详情
	 * @param int $order_id
	 */
	public function detail($order_id){
		$order_detail = OrderService::getInstance()->getOrderDetail($order_id);
		if(empty($order_detail)){
			return array("code"=>1,"message"=>"错误的订单");
		}
		return array("code"=>0,
					 "data"=>$order_detail);
	}
	
	public function evaluation(){
		
	}
	
}

?>