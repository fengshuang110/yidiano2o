<?php
namespace Model;
use Library\Db\Model\Model;
class GoodsCategory extends Model{

	protected $table = 'pre_category';
	protected $primaryKey = 'id';
	
	function __construct(){
		parent::__construct();
	}
	
	public function getByCategory($category_id,$params){
		$this->table= "pre_category_extend";

		$this->foreign = [["table"=>"pre_goods",
					"foreignkey"=>"goods_id",
					"key"=>"id",
					"field"=>["*"]]
					];
		return $this->where(['field'=>'category_id','op'=>'=','value'=>$category_id])
					->select($params);
	}
	
}

