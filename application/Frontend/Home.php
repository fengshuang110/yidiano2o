<?php 
namespace Frontend;

use Service\UserService;
use Service\SmsService;
use Luracast\Restler\Format\HtmlFormat;
use Service\AuthService;
use Service\WorkService;
/**
 *  网站首页
 * @author fengshuang
 */

class Home extends Base{
	
	public function index(){
		return array();
	}
}

?>