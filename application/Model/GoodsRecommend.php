<?php
namespace Model;
use Library\Db\Model\Model;
//商品推荐 热卖  最新 特价
class GoodsRecommend extends Model{

	protected $table = 'pre_commend_goods';
	protected $primaryKey = 'id';
	
	protected $foreign = [
					["table"=>"pre_goods",
					"foreignkey"=>"goods_id",
					"key"=>"id",
					"field"=>["*"]
					]
				];
	
	function __construct(){
		parent::__construct();
	}
	
}

