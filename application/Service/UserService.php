<?php 
namespace Service;
use Library\Cache\CacheAdapter;
/**
 * 用户服务
 * @author fengshuang
 *
 */
class UserService extends  Service{
	private  static  $instance = null;//业务层实例
	
	private function __construct(){
		$cacheFactory = new CacheAdapter('redis');
		$this->cache = $cacheFactory->getCacheAdapter();
	}
	public static function getInstance(){
		
		if(self::$instance == null){
			self::$instance = new UserService();
		}
		return self::$instance;
	}
	
	public function getUserByLoginName($name){
		if(empty($name)){
			return false;
		}
		$user = $this->getModel('User')->getUserByLoginName($name);
		return $user;		
	}
	
	/**
	 * 保存登录信息
	 */
	public function saveLogin($access_token,$result){
		$this->cache->set($access_token, $result);
	}
	
	/**
	 * 注册用户
	 * @param array $user 注册信息
	 * @return multitype:NULL Ambigous <\yii\db\mixed, NULL, multitype:, multitype:Ambigous <NULL, multitype:> >
	 */
	public function register($user){
		$userModel = $this->getModel('User');
		$item = $userModel->getUserByLoginName($user['username']);
		if($item){
			return array("code"=>1,"message"=>"已存在用户");
		}
		$user['password'] = md5($user['password']);
		$user['phone'] = $user['username'];
		$id = $userModel->save($user);
		if($id){
			session_start();
			$access_token = session_id();
			$result = array(
					"access_token" => $access_token,
					"user_id"=>$id,
					"username"=>$user['username'],
					"phone"=>$user['phone'],
			);
			$this->cache->set($access_token, $result);
			return array("code"=>0,"message"=>"注册成功","data"=>$result);
		}else {
			return array("code"=>1,"message"=>"注册失败");
		}
	}
	public function getAddress(){
		$user = AuthService::verifyLogin();
		$addresses = $this->getModel('Address')
						  ->where(['field'=>'user_id','op'=>'=','value'=>$user['user_id']])
						  ->all();
		return $addresses;
	}
	
	public function getAddrById($addr_id){
		$user = AuthService::verifyLogin();
		$address = $this->getModel('Address')->get($addr_id);
		if($user['user_id'] != $address['user_id']){
			return false;
		}
		return $address;
	}
	
	public function saveAddress($address){
		$user = AuthService::verifyLogin();
		$address['user_id'] = $user['user_id'];
		return $this->getModel('Address')->save($address);
	}
}
?>