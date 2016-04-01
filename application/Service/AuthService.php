<?php 
namespace Service;
use Model\User;
use Library\Cache\CacheAdapter;
/**
 * 搜索记录服务
 * @author fengshuang
 *
 */
class AuthService extends Service{
	private  static  $instance = null;//业务层实例
	private function __construct(){
		$cacheFactory = new CacheAdapter('redis');
		$this->cache = $cacheFactory->getCacheAdapter();
	}
	public static function getInstance(){
		
		if(self::$instance == null){
			self::$instance = new AuthService();
		}
		return self::$instance;
	}
	protected $user=null;
	
	/**
	 * 校验登录
	 * @access protected
	 * @return object
	 */
	public  static function verifyLogin(){
   		$cacheFactory = new CacheAdapter('redis');
   		$cache = $cacheFactory->getCacheAdapter();
   		$token = self::getAccesstoken();
   		if(empty($token)){
   			return false;
   		}
   		$res =  $cache->get($token);
   		if(empty($res)){
   			return false;
   		}
   		return $res;
	}
	
	/**
	 * 获取请求的access_token值
	 * @return unknown|Ambigous <multitype:, number, multitype:unknown , boolean>|multitype:
	 */
	protected static function getAccesstoken(){
	
		if(!empty($_REQUEST['access_token'])){
			return $_REQUEST['access_token'];
		}
	
		if(!empty(\Application::$r->getRequestData()['access_token'])){
			return \Application::$r->getRequestData()['access_token'];
		}
	
		if(preg_match('/[\?\&]access_token=(\w+)/', $_SERVER['REQUEST_URI'], $matches)){
			return $matches[1];
		}
	
		if(!empty($_SERVER['HTTP_AUTHORIZATION'])){
			return explode(" ", $_SERVER['HTTP_AUTHORIZATION'])[1];
		}
	
	}
	
}
?>