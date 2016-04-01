<?php
namespace Model;
use Library\Db\Model\Model;
class Order extends Model{

	protected $table = 'pre_order';
	protected $primaryKey = 'id';
	function __construct(){
		parent::__construct();
	}
	public function getOrderDetail($order_id){
		$sql = "select * from pre_order_goods where
				order_id = :order_id";
		$data = array(
				":order_id"=>$order_id
		);
		return $this->conn()
					->preparedSql($sql, $data)
					->fetchAll();
	}
	public function getOrderLog($order_id){
		$sql = "select * from pre_order_log where
				order_id = :order_id";
		$data = array(
				":order_id"=>$order_id
		);
		return $this->conn()
					->preparedSql($sql, $data)
					->fetchAll();
	}
	
	//生成订单
	public function  saveOrder($order,$order_goods){
		$this->conn()->beginTransaction();
		$order_id = $this->save($order);
		if(empty($order_id)){
			$this->rollback();
			return false;
		}
		foreach ($order_goods as $goods){
			$goods['order_id'] = $order_id;
			$this->table = 'pre_order_goods';
			$lastInsertId = $this->save($goods);
			if(empty($lastInsertId)){
				$this->rollback();
				return false;
			}
		}
		$sql = "delete from pre_cart where user_id=:user_id";
		$data = array(":user_id"=>$order['user_id']);
		$affectedCount = $this->preparedSql($sql, $data)->affectedCount();
		if(empty($affectedCount)){
			$this->rollback();
			return false;
		}
		$this->commit();
		return $order_id;
	}
}

