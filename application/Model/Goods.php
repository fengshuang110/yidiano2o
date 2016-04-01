<?php
namespace Model;
use Library\Db\Model\Model;

class Goods extends Model{

	protected $table = 'pre_goods';
	protected $primaryKey = 'id';
	
	function __construct(){
		parent::__construct();
	}
	
	public function detail($goods_id){
		$goods = $this->get($goods_id);
		$goodsPhotoModel = new GoodsPhoto();
		$goods['photos'] = $goodsPhotoModel->where(["field"=>'goods_id','op'=>'=','value'=>$goods_id])->all();
		return $goods;
	}
	
	public function search($keyword,$params){
		$sql = "select * from pre_goods where 
				name like :name ";
		$data = array(':name'=>"%".$keyword."%");
		return $this->conn()->preparedSql($sql, $data)->fetchAll();
	}
	
}

