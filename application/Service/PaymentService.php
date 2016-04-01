<?php 
namespace Service;
use Common\Config;
/**
 * 支付方式服务
 * @author fengshuang
 *
 */
class PaymentService extends  Service{
	private  static  $instance = null;//业务层实例
	protected $user;
	private function __construct(){
		$this->user = AuthService::verifyLogin();
	}
	public static function getInstance(){
		
		if(self::$instance == null){
			self::$instance = new PaymentService();
		}
		return self::$instance;
	}
	public function getPayments(){
		return  $this->getModel('Payment')
					 ->where(['field'=>'type','op'=>'=','value'=>2])
					 ->all();
	}
	
	//检查支付方式
	public function checkPayment($payment_id){
		return  $this->getModel('Payment')
						->where(['field'=>'type','op'=>'=','value'=>2])
						->where(['field'=>'id','op'=>'=','value'=>$payment_id])
						->getOne();
	}
	
	
}
?>