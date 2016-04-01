<?php 
namespace Api;
use Service\UserService;
use Service\SmsService;

/**
 *  短信发送接口类
 * @author fengshuang
 *
 */
class Sms{
	/**
	 * 验证码发送接口
	 * @url POST /sendcode
	 * @param string $phone 电话号码
	 * @param string $type 验证支持的类 注册register modifypassword 
	 * @return number
	 */
	public function sendcode($phone,$type){
		$user = UserService::getInstance()->getUserByLoginName($phone);
		switch ($type){
			case 'register':
				if($user){
					return array("code"=>1,"message"=>"电话号码已经注册");
				}
			break;
		}
		return SmsService::getInstance()
					->getAdapter(1)
					->sendCode($phone, $type);
	}
}

?>