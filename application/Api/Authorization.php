<?php 
namespace Api;
use Service\AuthService;
/**
 * 权限校验器
 * @author fengshuang
 *
 */
class Authorization{
	protected $user;
	public function __construct(){
		$res = AuthService::verifyLogin();
		if(!$res){
			echo json_encode(array("code"=>403,"message"=>"用户未登录"));die;
		}else{
			$this->user= $res;
		}
	}
}

?>