<?php
namespace Common\Duanxin;


use Common\Duanxin\Config;
/**
 * 
 * @author fengshuang
 * 2015/6/1
 * UTF-8
 */
class Main{
	
    
    /**
     * 获得适配器
     * @param $config_tag 
     */
    public static function getAdapter($config_tag=''){
        $config = Config::getConfig($config_tag);
    
        if(empty($config)){
            throw new \Exception('短信通道不合法');
        }
   
        $class_name =  __NAMESPACE__."\\Adapter\\".$config['class_name']; 
        if(!class_exists($class_name)){
        	throw new \Exception('短信通道不合法');
        }
        $tmpAdapter = new $class_name();
        $tmpAdapter->setProp($config['config']);
        return  $tmpAdapter;
    }
   
}