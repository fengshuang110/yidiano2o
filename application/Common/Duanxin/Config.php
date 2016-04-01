<?php
namespace Common\Duanxin;

/**
 * 
 * @author fengshuang
 * 2015/6/1
 * UTF-8
 */
class Config {
	private static $duanxin_config = array (
			1 => array (
				'class_name' => 'Lsm',//螺丝帽短信通道
				'config' => array (
					'url' => 'http://sms-api.luosimao.com/v1/send.json',
					'api_key' => 'api:key-fdeb235c519d7b1f10f1c869e60391a8',
					'code_expire' => 600, // 验证码失效时间
				),
			),
			//更多的通道W
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
		if (! isset ( self::$duanxin_config [$config_key] )) {
			return null;
		}
		return self::$duanxin_config [$config_key];
	}
}
