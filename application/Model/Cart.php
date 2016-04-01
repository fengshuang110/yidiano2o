<?php
namespace Model;
use Library\Db\Model\Model;
class Cart extends Model{

	protected $table = 'pre_cart';
	protected $primaryKey = 'id';
	function __construct(){
		parent::__construct();
	}
	//获取购物车列表
	public function getCarts($user_id){
		$sql = "select a.*,b.img,b.weight,b.unit,b.sell_price as real_sell_price from pre_cart as a,pre_goods as b 
				where a.goods_id=b.id 
				and a.user_id=:user_id";
		
		$data = array(":user_id"=>$user_id);
		
		return $this->conn()->preparedSql($sql, $data)->fetchAll();
	}
	
}

