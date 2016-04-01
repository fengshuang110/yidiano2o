<?php
namespace Common\Third;
//-----------------------------------------------------------------
/**
 * 任务管理api
 * @author    fengshuang
 */
class TaskApi {

	private static $obj = null;
	private $url = "http://192.168.1.8:7000/api/v1/";
	
	private function __construct($options = array()){
	
	}
	public static function getInstance(){
		if(is_null(self::$obj)){
			self::$obj = new TaskApi();
		}
		return self::$obj;
	}
	
	public function projectDel($id){
		$url = $this->url."projects/$id";
		return $this->requestExecute($url,"DELETE",array(),true);
	}
	//修改项目
	public function projectModify($id,$params){
		$url = $this->url."projects/$id";
		return $this->requestExecute($url,"PATCH",$params,true);
	}
	
	public function projectBySlug($name){
		$url = $this->url."projects/by_slug?slug=$name";
		return $this->requestExecute($url,"GET",array(),true);
	}
	public function projectById($id){
		$url = $this->url."projects/$id";
		return $this->requestExecute($url,"GET",array(),true);
	}
	
	//项目列表
	public function projects(){
		$params = array();
		$url = $this->url."projects";
		return $this->requestExecute($url,"GET",$params,true);
	}
	
	
	//创建项目
	public function createproject($name,$description){
		$params = array(
			"name"=>$name,
			"description"=>$description,
		);
		$url = $this->url."projects";
		return $this->requestExecute($url,"POST",$params,true);
	}
	
	//登录
	public function login($username,$password,$type="normal"){
		$params = array(
				'type'=>$type,
				"username"=>$username,
				"password"=>$password,
		);
		$url = $this->url."auth";
		return $this->requestExecute($url,"POST",$params);
	}
	
	//注册用户
	public function register($username,$password,$email,$full_name){
		$params = array(
				'type'=>"public",
				"username"=>$username,
				"password"=>$password,
				"email"=>$email,
				"full_name"=>$full_name,
		);
		$url = $this->url."auth/register";
		return $this->requestExecute($url,"POST",$params);
	}
	
	public function requestExecute($url,$type = "post",$param =array(),$auth=false){
	    $param=json_encode($param);
	    $header = array();
	    if($auth == true){
	    	$header = array($this->_get_token());
	    }
	    $type = strtolower($type);
	    $res = $this->_curl_request($url,$param,$header,$type);
	    return $res;
	}
	
	
	//先获取app管理员token POST /{org_name}/{app_name}/token
	public function _get_token()
	{
		$access_token = "eyJ1c2VyX2F1dGhlbnRpY2F0aW9uX2lkIjoxOH0:1a0nv0:W-Bidk3xnAO5TXu4GY1413KRMGk";
		return "Authorization: Bearer ". $access_token;
	}
	public function _curl_request($url, $body, $header = array(), $method = "POST")
	{
		
		array_push($header, 'Accept:application/json');
		array_push($header, 'Content-Type:application/json');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($ch, $method, 1);
		$method = strtolower($method);
		switch ($method){
			case "get" :
				curl_setopt($ch, CURLOPT_HTTPGET, true);
				break;
			case "post":
				curl_setopt($ch, CURLOPT_POST,true);
				break;
			case "put" :
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				break;
			case "patch" :
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
				break;
			case "delete":
				curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
				break;
		}
	
		curl_setopt($ch, CURLOPT_USERAGENT, 'SSTS Browser/1.0');
		curl_setopt($ch, CURLOPT_ENCODING,'gzip');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		if (isset($body{3}) > 0) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		}
		if (count($header) > 0) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
		$ret = curl_exec($ch);
		$err = curl_error($ch);
		curl_close($ch);
		//clear_object($ch);
		//clear_object($body);
		//clear_object($header);
		if ($err) {
			return $err;
		}
		return $ret;
	}
}