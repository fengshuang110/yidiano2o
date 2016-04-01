<?php
namespace Model;
use Library\Db\Model\Model;
class User extends Model{

	protected $table = 'pre_user';
	protected $primaryKey = 'user_id';
	function __construct(){
		parent::__construct();
	}
	//登录名获取
	public function getUserByLoginName($name){
		$sql = "select * from pre_user where username=:username or phone=:phone";
		$data = array(
				":username"=>$name,
				":phone"=>$name
			);
		return $this->conn()->preparedSql($sql, $data)->fetchOne();
	}
	
	
}

