<?php 
namespace Common\Tools;
class StringSn{
	
	/**
	 * 订单号创建
	 * @return string
	 */
	public static function getOrderSerialNumber() {
		$year_code = array('A','B','C','D','E','F','G','H','I','J');
		$order_sn = $year_code[intval(date('Y'))-2014].
		strtoupper(dechex(date('m'))).date('d').
		substr(time(),-5).substr(microtime(),2,5).sprintf('%02d',rand(0,99));
		return $order_sn;
	}
	
	public static function getCustodianSerialNumber() {
		$year_code = array('A','B','C','D','E','F','G','H','I','J');
		$order_sn = $year_code[intval(date('Y'))-2014].
		strtoupper(dechex(date('m'))).date('d').
		substr(time(),-5).substr(microtime(),2,5).sprintf('%02d',rand(0,99));
		return $order_sn;
	}
	
	public static function getTransferSerialNumber() {
		$year_code = array('A','B','C','D','E','F','G','H','I','J');
		$order_sn = $year_code[intval(date('Y'))-2014].
		strtoupper(dechex(date('m'))).date('d').
		substr(time(),-5).substr(microtime(),2,5).sprintf('%02d',rand(0,99));
		return $order_sn;
	}
}

?>