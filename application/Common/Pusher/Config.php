<?php
namespace Common\Pusher;

/**
 * 
 * @author fengshuang
 * 2015/6/1
 * UTF-8
 */
class Config {
	private static $pusher_config = array (
			1 => array (
				'class_name' => 'Web',//web通知
				'config'	 => array(
					)
			),
			2 =>array(
				'class_name' => 'IM',//im通知
				'config' => array(
					'im_token'=>'YUNZUJIA661510',
					'im_url'=>'http://beta.yunzujia.com:8400/api/sendmsg'
				)
			)
	);
	
	/**
	 * 封闭构造
	 */
	private function __construct() {
	}
	
	/**
	 * 获得配置文件
	 *
	 * @param unknown $config_key        	
	 * @throws Yaf_Exception
	 */
	public static function getConfig($config_key) {
		if (! isset ( self::$pusher_config [$config_key] )) {
			return null;
		}
		return self::$pusher_config [$config_key];
	}
}
