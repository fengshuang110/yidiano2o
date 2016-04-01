<?php 
namespace Service;
use Library\Cache\CacheAdapter;
use Common\Duanxin\Main;
use Common\Duanxin\Adapter\Lsm;
/**
 * 通知服务
 * @author fengshuang
 *
 */
class SmsService{
	private $adapter = null;
	private $cache = null;
	private  static  $instance = null;//业务层实例
	public  $config = array(
				"expire"=>"600",//短信验证码10分钟有效
				//发送短信类别
				"type" => array(
					"register",
					"modifypassword",
					"withdraw")
			) ;
	
	private function __construct(){
		$cacheFactory = new CacheAdapter('redis');
		$this->cache = $cacheFactory->getCacheAdapter();
		
	}
	public static function getInstance(){
		
		if(self::$instance == null){
			self::$instance = new SmsService();
		}
		return self::$instance;
	}
	
	public function getAdapter($channle){
		$this->adapter =  Main::getAdapter($channle);
		return $this;
	}
	
	/**
	 * 发送验证码
	 * @param unknown $tel
	 * @param unknown $type
	 */
	public function sendCode($tel,$type){
		if(!in_array($type, $this->config['type'])){
			return array("code"=>1,"message"=>"非法的短信发送请求");
		}
		if($this->adapter instanceof Lsm){
			$key = 'CODE_'.$tel.$type ; //短信验证码缓存的key
			$code = $this->cache->get($key);//获取验证码
			if(empty($code)){
				$code = $this->getRandomCode();
			}
// 			$code = "888888";
			$result = $this->adapter->sendCode($tel,$code);
			if($result){
				$this->cache->set($key, $code,$this->config['expire']);
				return array("code"=>0,"message"=>"发送成功","expire"=>$this->config['expire']);
			}
			return array("code"=>1,"message"=>"发送失败");
			
		}else{
			throw new \Exception("非法通道");
		}
		 
	}
	/**
	 * 短信验证码验证
	 * @param unknown $tel
	 * @param unknown $type
	 * @param unknown $code
	 * @return multitype:number string |boolean
	 */
	public function verifycode($tel,$type,$code){
		if(!in_array($type, $this->config['type'])){
			return false;
		}
		
		$key = 'CODE_'.$tel.$type ; //短信验证码缓存的key
		$cache_code = $this->cache->get($key);//获取验证码
		
		if($code == $cache_code){
			$this->cache->delete($key);
			return true;
		}
		return false;
	}
	
	/**
	 * 随机4位验证码
	 * @param number $str
	 * @return string
	 */
	protected function  getRandomCode($length=4){
	
		$chars = "0123456789";
		$str = "";
		for($i = 0; $i < $length; $i++){
			$str .= $chars[mt_rand(0, strlen($chars) - 1)];
		}
		return $str;
	}
	
	
}
?>