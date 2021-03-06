<?php 

namespace Common\Pusher\Adapter;

use Common\Pusher\Base\Base;
use Common\Pusher\Base\BaseInterface;
class IM extends Base implements  BaseInterface{
	
	public function setProp($config){
		$this->config = $config;
	}
	
	public function push($from_user_id, $to_user_id, $tpl, $params)
	{
		$msg = json_encode(['type'=> $tpl, 'data'=> $params]);
		$content = ["req_id"=> $from_user_id ,
					"to_id"=> $to_user_id,
					"msg_content"=> '-!@#^%$-'.str_replace('"','\"',$msg).'!-@#^%$-',
					"token" => $this->config['im_token']
				  ];
		
		return $this->http_post($this->config['url'],$content);
	}
}

?>