<?php 
namespace Library\Config;
class Config{
	
	
	public static function getDbConfig(){
		$file = __DIR__.'/../../Application/config/db.php';
		if(!file_exists($file)){
			$file = __DIR__.'/../../application/config/db.php';
		}
		return require $file;
	} 
	
	public static function getCacheConfig(){
		$cache_config_file = __DIR__.'/../../Application/config/cache.php';
		if(!file_exists($cache_config_file)){
			$cache_config_file = __DIR__.'/../../application/config/cache.php';
		}
		return require $cache_config_file;
	}
}


?>