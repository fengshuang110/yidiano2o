<?php 

namespace Common\Pusher\Adapter;
use Common\Pusher\Base\Base;
use Common\Pusher\Base\BaseInterface;
use Model\Notification;
class Web extends Base implements  BaseInterface{
	public function setProp($config){
		$this->config = $config;
	}
	
	public function __construct(){
		$this->notification = new Notification();
	}
	
	public function push($from_user_id, $to_user_id, $tpl, $params){
		
		$model = new Notification();
		$record = [
				'from_user_id' => $from_user_id,
				'user_id' => $to_user_id,
				'params' => json_encode($params),
				'type' => $tpl,
				];
		return $model->save($record);
	
	}
}

?>