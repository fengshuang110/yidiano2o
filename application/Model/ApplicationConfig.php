<?php
namespace Model;
use Library\Db\Model\Model;
class ApplicationConfig extends Model{

	
	protected $table = 'pre_application_config';
	protected $primaryKey = 'id';
	
	function __construct(){
		parent::__construct();
	}
	public function getItem($key){
		return  $this->where(['field'=>'key','op'=>'=','value'=>$key])
			 		 ->getOne();
	}
	
}

