<?php
namespace Model;
use Library\Db\Model\Model;

class GoodsPhoto extends Model{

	protected $table = 'pre_goods_photo_relation';
	protected $primaryKey = 'id';
	protected $foreign = [
						["table"=>"pre_goods_photo",
							"foreignkey"=>"photo_id",
							"key"=>"id",
							"field"=>["img as photo"]
						]
				];
	function __construct(){
		parent::__construct();
	}
}

