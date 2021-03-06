<?php 
namespace Common\Pusher;

/**
 * Im客户端
 * @author fengshuang
 *
 */
class Client{
	
	private $adapter = null;
	
	private  static  $instance = null;//业务层实例 ,
	/**
	 * 短信代理器
	 * 封闭构造
	 */
	 private function __construct(){
	  
	}
	
	/**
	 * 获得适配器
	 * @param $config_tag
	 */
	public static function getAdapter($adapter_name=''){
		$config = Config::getConfig($adapter_name);
	
		if(empty($config)){
			throw new \Exception('短信通道不合法');
		}
		 
		$class_name =  __NAMESPACE__."\\Adapter\\".$config['class_name'];
		if(!class_exists($class_name)){
			throw new \Exception('短信通道不合法');
		}
		if(is_null(self::$instance)){
			self::$instance = new Client();
			self::$instance->adapter = new $class_name();
			self::$instance->adapter->setProp($config['config']);
		}

		return self::$instance;
	}
	
	public static function bacthPush($from_user_id, $to_user_id, $tpl, $params,$channels=array('1','2')){
 		foreach ($channels as $channel){
			$config = Config::getConfig($channel);
			$class_name =  __NAMESPACE__."\\Adapter\\".$config['class_name'];
			if(!class_exists($class_name)){
				continue;
			}else{
				$adapter = new $class_name();
				$adapter->setProp($config['config']);
				$respond = $adapter->push($from_user_id, $to_user_id, $tpl, $params);
				var_dump($respond);
			} 			
 		}
	}
	
	//抽象出发送方法 	缺点是参数不确定
	public function push($from_user_id, $to_user_id, $tpl, $params){
		return $this->adapter->push($from_user_id, $to_user_id, $tpl, $params);
	}
	

		
	
	
}
?>