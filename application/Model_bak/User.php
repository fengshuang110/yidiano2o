<?php
namespace Model;
use Library\Db\Model\Model;
class User extends Model{

	protected $table = 'sys_user';
	protected $alias = 'sys_user';
	protected $primaryKey = 'user_id';
	
	function __construct($adapter= null){
		parent::__construct();
	}
	
	public function getAll($params,$is_count = true){
		 return $this->select($params);
		 
	}
	
	public function getOneByUsername($username){
		$sql = "select * from sys_user where username=:username";
		$data[':username'] = $username;
		return $this->conn()
					->preparedSql($sql, $data)
					->fetchOne();
	}

	
}

