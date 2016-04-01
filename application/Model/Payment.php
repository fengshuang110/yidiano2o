<?php
namespace Model;
use Library\Db\Model\Model;
class Payment extends Model{

	protected $table = 'pre_payment';
	protected $primaryKey = 'id';
	function __construct(){
		parent::__construct();
	}
	
}

