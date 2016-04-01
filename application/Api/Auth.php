<?php 
namespace Api;

use Service\UserService;
use Service\SmsService;
use Service\AuthService;
/**
 * 一点O2O
 * @author fengshuang
 */
class Auth{
	/**
	 * 登录
	 * @url POST /login
	 * @param string $username
	 * @param string $password
	 */
	public function login($username,$password){
		$user = UserService::getInstance()->getUserByLoginName($username);
		if(empty($user) || md5($password) != $user['password']){
			return array("code"=>1,"message"=>"用户或者密码错误");
		}
		session_start();
		$access_token = session_id();
		$result = array(
				"access_token" => $access_token,
				"username"=>$user['username'],
				"email"=>$user['email'],
				"phone"=>$user['phone'],
				'user_id'=>$user['id']
			);
		UserService::getInstance()->saveLogin($access_token,$result);
		return  array("code"=>0,'message'=>"登录成功",'data'=>$result);
	}
	
	/**
	 * 移动端注册账号接口
	 * @url POST /register
	 * @param string $user_name 电话号码   value {@pattern /^1[3578]{1}[0-9]{1}[0-9]{8}$/} 
	 * @param string $password 密码 value {@min 6} {@max 16} 
	 * @param string $vcode  {@min 4} {@max 6}
	 * @return multitype:number string |multitype:number boolean Ambigous <\Service\multitype:NULL, multitype:NULL Ambigous <\yii\db\mixed, NULL, multitype:, multitype:Ambigous <NULL, multitype:> > >
	 */
	public function register($user_name, $password,$vcode,$type="register"){
		$user = array("phone"=>$user_name,"password"=>$password,"username"=>$user_name);
		
// 		if(!SmsService::getInstance()->verifycode($user_name, $type, $vcode)){
// 			return array(
// 				"code"=>1,
// 				"message"=>"验证码错误",
// 			);
// 		}
		$data = UserService::getInstance()->register($user);
		return $data;
	}
	
	public function verify(){
		$data = AuthService::verifyLogin();
		if($data){
			return array("code"=>0);
		}
		return array("code"=>403);
	}
}

?>