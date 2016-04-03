<?php



//加载composer库
error_reporting(E_ALL);
define('ISAPI', true);//定义api
//加载rest composer库
if (is_readable(__DIR__ . '/vendor/autoload.php')) {
	//if composer auto loader is found use it

	$loader = require_once __DIR__ . '/vendor/autoload.php';
	$loader->setUseIncludePath(true);
	class_alias('Luracast\\Restler\\Restler', 'Restler');
}
//require_once __DIR__.'/../vendor/restler.php';

include_once(__DIR__.'/auto_init.php');
include __DIR__ . '/../Library/Loader/AutoloaderFactory.php';
Library\Loader\AutoloaderFactory::factory(array(
'Library\Loader\StandardAutoloader' => array(
'autoregister_zf' => true,
	"namespaces"=>array(
	
		)
	)	
));

Application::init(require 'config/api.config.php')->run();

