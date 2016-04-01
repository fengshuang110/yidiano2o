<?php
/**
 * 注册Library
 * @author fengshuang
 * UTF-8
 */
// echo 1;die;

include __DIR__ . '/Loader/AutoloaderFactory.php';
        Library\Loader\AutoloaderFactory::factory(array(
            'Library\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true
           )
        ));
