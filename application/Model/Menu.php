<?php
namespace Model;
use Library\Db\Model\Model;
class Menu extends Model{
	
	private static $tag = 'Model_Menu';
	protected $table = 'sys_menu';
	protected $alias = 'sys_user';
	protected $primaryKey = 'menu_id';
	
	function __construct($adapter= null){
		parent::__construct();
	}
	
	public function findAll(){
		$sql = "select * from ".$this->table ." where 1=1";
		return $this->conn()
			 		->preparedSql($sql, array())
			 		->fetchAll();;
	}
	
	public function getAll($params,$is_count = false){
		return $this->select($params,$is_count);
			
	}
	
}