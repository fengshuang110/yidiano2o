<?php
namespace Model;
use Library\Db\Model\Model;
class Region extends Model{

	protected $table = 'pre_areas';
	protected $primaryKey = 'id';
	function __construct(){
		parent::__construct();
	}
}

