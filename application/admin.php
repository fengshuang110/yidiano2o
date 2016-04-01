<?php

//加载composer库
// error_reporting(E_ALL);
error_reporting(1);
if(empty(str_replace('/', "", $_SERVER['REQUEST_URI']))){
	header("location: http://".$_SERVER['HTTP_HOST']."/index/index");exit();
}
//加载rest composer库
if (is_readable(__DIR__ . '/vendor/autoload.php')) {
	//if composer auto loader is found use it
	$loader = require_once __DIR__ . '/vendor/autoload.php';
	$loader->setUseIncludePath(true);
	class_alias('Luracast\\Restler\\Restler', 'Restler');
}

include_once(__DIR__.'/auto_init.php');
require __DIR__.'/../Library/bootstrap.php';

Application::init(require 'config/admin.config.php')->run();

