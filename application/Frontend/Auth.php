<?php 

namespace Frontend;

use Luracast\Restler\Format\HtmlFormat;
/**
 *  app应用信息
 * @author fengshuang
 *
 */
class Auth extends Base{
	protected $user;
	public function __construct(){
		$this->user = $this->getSessionUser();
		if(empty($this->user)){
			session_unset();
			session_destroy();
			header("location: /home/login");
			exit();
		}
		 HtmlFormat::$data['session_user'] = $this->user;
	} 
	
	public function getSessionUser(){
		if(!empty( $_SESSION['user'])){
			return $_SESSION['user'];
		}else{
			return false;
		}
	}
	
}

?>