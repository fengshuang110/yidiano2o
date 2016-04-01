<?php 
namespace Api;
use Service\UserService;
use Service\SmsService;

/**
 *  用户接口类
 * @author fengshuang
 *
 */
class User extends Authorization{
	
	public function addressbyid($addr_id){
		$address = UserService::getInstance()->getAddrById($addr_id);
		return array("code"=>0,"data"=>$address);
	}
	/**
	 * 用户地址列表
	 */
	public function addresses(){
		$addresses = UserService::getInstance()->getAddress();
		return array("code"=>0,"data"=>$addresses);
	}
	
	/**
	 * 编辑或者添加地址
	 * @url POST /address/save
	 * @param unknown $accept_name
	 * @param unknown $mobile
	 * @param unknown $address
	 * @param string $vcode 预留 添加地址必须手机号码验证 目前暂时不验证
	 */
	public function addressSave($accept_name,$mobile,$address,$region,$province="",$city="",$area="",$vcode="",$id=0){
		$address = array(
				"accept_name"=>$accept_name,
				"mobile"=>$mobile,
				'telphone'=>$mobile, 
				'region'=>$region,
				'address'=>$address,
		);
		if(empty($id)){
			$address['area'] = $area;
			$address['province'] =$province;
			$address['city'] = $city;
			$id = UserService::getInstance()->saveAddress($address);
			return array("code"=>0,"message"=>"添加地址成功",'data'=>array("addr_id"=>$id));
		}else{
			$res = UserService::getInstance()->getAddrById($id);
			if($res){
				return array("code"=>1,"message"=>"非法操作");
			}
			$address['id'] = $id;
			UserService::getInstance()->saveAddress($address);
			return array("code"=>0,"message"=>"修改地址",'data'=>array("addr_id"=>$id));
		}
	}
	
	/**
	 * 删除地址
	 * @param unknown $addr_id
	 */
	public function addressDel($addr_id){
		
	}
	
}

?>