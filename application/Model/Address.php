<?php
namespace Model;
use Library\Db\Model\Model;
class Address extends Model{

	protected $table = 'pre_address';
	protected $primaryKey = 'id';
	function __construct(){
		parent::__construct();
	}
	
}

