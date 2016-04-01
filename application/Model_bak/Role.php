<?php
namespace Model;
use Library\Db\Model\Model;
class Role extends Model{

	private static $tag = 'Model_Role';
	protected $table = 'sys_role';
	protected $alias = 'sys_role';
	protected $primaryKey = 'role_id';
	function __construct($adapter= null){
		parent::__construct();
	}
}