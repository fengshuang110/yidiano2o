<?php 

namespace Api;

/**
 *  app应用信息
 * @author fengshuang
 *
 */
class App{
	/**
	 * 获取app版本号
	 * @return multitype:number string multitype:string number
	 */
	public function version(){
		$result = array(
				'version'=>'2.0.1.v20150905',
            	'forceUpdate'=>0
		);
		return array(
			"code"=>0,
			"message"=>"获取版本信息",
			"result"=>$result	
		);
	}
	
	
}

?>