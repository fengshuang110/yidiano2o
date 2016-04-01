<?php 
namespace Api;

use Service\UserService;
use Service\SmsService;
use Service\AuthService;
use Service\RegionService;
/**
 * 一点O2O
 * @author fengshuang
 */
class City{
	public function region($id=0){
		return RegionService::getInstance()->region($id);
	}
}

?>