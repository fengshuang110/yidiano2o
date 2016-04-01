<?php 
namespace Service;
use Common\Config;
/**
 * 订单服务
 * @author fengshuang
 *
 */
class OrderService extends  Service{
	private  static  $instance = null;//业务层实例
	protected $distribution_type = array(
			"0"=>"未发货",
			"1"=>"已发货",
			"2"=>"部分发货"
		);
	private function __construct(){
		
	}
	public static function getInstance(){
		
		if(self::$instance == null){
			self::$instance = new OrderService();
		}
		return self::$instance;
	}
	
	public function getOrders($type,$params=array()){
		$user = AuthService::verifyLogin();
		$orderModel = $this->getModel('Order');
// 		
		switch ($type){
			case 'all':
				$orders = $orderModel->where(['field'=>'user_id','op'=>'=','value'=>$user['user_id']])
									 ->select($params);
				break;
			case 'wait_pay':
				$orders = $orderModel->where(['field'=>'user_id','op'=>'=','value'=>$user['user_id']])
									 ->where(['field'=>'pay_status','op'=>'=','value'=>0])
									 ->where(['field'=>'pay_type','op'=>'!=','value'=>0])
									 ->select($params);
				break;
			case 'wait_delivery':
				$orders = $orderModel->where(['field'=>'user_id','op'=>'=','value'=>$user['user_id']])
									->where(['field'=>'distribution_status','op'=>'=','value'=>0])
									->select($params);
				break;
			case 'wait_receipt':
				$orders = $orderModel->where(['field'=>'user_id','op'=>'=','value'=>$user['user_id']])
									 ->where(['field'=>'distribution_status','op'=>'=','value'=>1])
									 ->select($params);
				break;
			default:
				$orders = $orderModel->where(['field'=>'user_id','op'=>'=','value'=>$user['user_id']])
				->select($params);
				break;
		}
		$payments_res = PaymentService::getInstance()->getPayments();
		$payments = array();
		foreach ($payments_res as $payment){
			$payments[$payment['id']] = $payment['name'];
		}
		$result = array();
// 		pay_type_name distribution_name
		foreach ($orders['items'] as $order){
			$total_count = 0;
			$goods_detail = $orderModel->getOrderDetail($order['id']);
			foreach ($goods_detail as $goods){
				$goods['img'] = Config::img_url.$goods['img'];
				$total_count += $goods['goods_nums'];
				$order['goods_detail'][] = $goods;
			}
			$order['pay_type_name'] = $payments[$order['pay_type']];
			$order['distribution_name'] = $this->distribution_type[$order['distribution_status']];
			$order['total_count'] = $total_count;
			$result[] = $order;
		}
		return $result;
	}
	
	public function getOrderDetail($order_id){
		$user = AuthService::verifyLogin();
		$orderModel = $this->getModel('Order');
		$order =$orderModel->where(['field'=>'id','op'=>'=','value'=>$order_id])
					  	   ->where(['field'=>'user_id','op'=>'=','value'=>$user['user_id']])
					  	   ->getOne();
		if(empty($order)){
			return false;
		}
		
		$goods_detail = $orderModel->getOrderDetail($order['id']);
		
		$logs =  $orderModel->getOrderLog($order_id);
		
		$first_log[] = array(
					"id"=>0,
					"order_id"=>$order_id,
					"user"=>$order['accept_name'],
					"action"=>"下单",//标示
					"addtime"=>$order['create_time'],
					"result"=>"成功",
					"note"=>"订单【".$order['order_no']."】下单成功"
			);
		$logs = array_merge($first_log,$logs);
		$order['logs'] = $logs;
		$total_count = 0;
		foreach ($goods_detail as $goods){
			$goods['img'] = Config::img_url.$goods['img'];
			$goods['goods_array'] = json_decode(stripslashes($goods['goods_array']));
			$total_count += $goods['goods_nums'];
			$order['goods_detail'][] = $goods;
		}
		$payments_res = PaymentService::getInstance()->getPayments();
		$payments = array();
		foreach ($payments_res as $payment){
			$payments[$payment['id']] = $payment['name'];
		}
		
		$order['pay_type_name'] = $payments[$order['pay_type']];
		$order['distribution_name'] = $this->distribution_type[$order['distribution_status']];
		$order['total_count'] = $total_count;
		return $order;
	}
	public function createOrder($order,$carts,$address,$payment){
		$user = AuthService::verifyLogin();
		$total = 0;
		$cart_count = 0;
		$freight = 0;
		$order_goods = array();
		foreach ($carts as $cart){
			$goods['goods_id'] = $cart['goods_id'];
			$goods['img'] = str_replace(Config::img_url, '', $cart['img']);
			$goods['goods_price'] = $cart['market_price'];
			$goods['real_price'] = $cart['real_sell_price'];
			$goods['goods_nums'] = $cart['goods_number'];
			$goods['goods_weight'] = $cart['weight'];
			$goods['goods_array'] = json_encode(array(
								'name'=>$cart['goods_name'],
					            'goodsno'=>$cart['goods_no'],
					            'unit'=>$cart['unit'],
								'value'=>""));	
			$order_goods[] = $goods;
			$cart_count += $cart['goods_number'];
			$total += $cart['goods_number'] * $cart['real_sell_price'];
		}
		if($total<200){
			$freight = 20;
		}
		$order['user_id'] = $user['user_id'];
		$order['pay_type'] = $payment['id'];
		$order['accept_name'] = $address['accept_name'];
		$order['postcode'] = $address['zip'];
		$order['telphone'] = $address['telphone'];
		$order['mobile'] = $address['mobile'];
		$order['province'] = $address['province'];
		$order['area'] = $address['area'];
		$order['address'] = $address['address'];
		$order['payable_amount'] = $total;
		$order['real_amount'] = $total;
		$order['payable_freight'] = $freight;
		$order['real_freight'] = $freight;
		$order['create_time'] = date('Y-m-d H:i:s',time());
		$order['order_amount'] = $total+$freight;
		$order['order_no'] = $this->createOrderNum();
		$order_id = $this->getModel('Order')->saveOrder($order,$order_goods);
		if($order_id){
			return array(
					"order_id"=>$order_id,
					"order_amount"=>$order['order_amount'],
				);
		}else{
			return false;
		}
	}
	
	/**
	 * @brief 产生订单ID
	 * @return string 订单ID
	 */
	public function createOrderNum(){
		return date('YmdHis').rand(100000,999999);
	}
}
?>