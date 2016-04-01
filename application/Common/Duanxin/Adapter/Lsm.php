<?php 
namespace Common\Duanxin\Adapter;

use Common\Duanxin\Base\BaseAbstract;

/**
 * 螺丝帽短信通道
 * @author fengshuang
 *
 */
class Lsm extends BaseAbstract{
	
	/**
	 * 发送短信验证码
	 * @param unknown $phone
	 * @param unknown $code
	 * @return boolean
	 */
	public function sendCode($phone,$code){
		$msg=['mobile'=>$phone,'message'=>"您的验证码是:".$code." 【云族佳】"];
		return  $this->curl_post($this->config['url'], $msg);
	}
	
	public function curl_post($url,$param){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		
		curl_setopt($ch, CURLOPT_HTTPAUTH , CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD  , $this->config['api_key']);
		
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		
		$res = curl_exec( $ch );
		$data = json_decode($res);
		$i=0;
		while($data->error!=0&&$i<3){
			sleep(1);
			$res = curl_exec( $ch );
			$data = json_decode($res);
			$i++;
		}
		curl_close( $ch );
		if($i>3||$data->error!=0){
			return false;
		}else{
			return true;
		}
	}
	public static function  sendMsg($msg){
		
	}
	
}

?>