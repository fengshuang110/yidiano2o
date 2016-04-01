<?php 

namespace Api;

use Common\Third\TaskApi;
/**
 *  task任务api
 * @author fengshuang
 *
 */
class Task{
	/**
	 * 注册用户
	 * @param unknown $username
	 * @param unknown $password
	 * @param unknown $email
	 * @param unknown $full_name
	 * @return Ambigous <string, mixed>
	 */
	public function register($username, $password, $email, $full_name){
		return TaskApi::getInstance()->register($username, $password, $email, $full_name);
	}
	/**
	 * 登录
	 * @param unknown $username
	 * @param unknown $password
	 * @return Ambigous <string, mixed>
	 */
	public function login($username, $password){
		return TaskApi::getInstance()->login($username, $password);
	}
	/**
	 * 创建项目
	 * @param unknown $name
	 * @param unknown $description
	 */
	public function createproject($name,$description){
		return TaskApi::getInstance()->createproject($name, $description);
	}
	
	/**
	 * 修改项目
	 * @param unknown $id 项目id
	 * @return Ambigous <string, mixed>
	 */
	public function projectModify($id){
		$params = $_POST;
		return TaskApi::getInstance()->projectById($id,$params);
	}
	/**
	 * 删除项目
	 * @param unknown $id
	 * @return Ambigous <string, mixed>
	 */
	public function projectDel($id){
		return TaskApi::getInstance()->projectDel($id);
	}
	/**
	 * id获取项目
	 * @param unknown $id
	 * @return Ambigous <string, mixed>
	 */
	public function projectById($id){
		return TaskApi::getInstance()->projectById($id);
	}
	/**
	 * 通过用户名-项目名称查询
	 * @param unknown $name
	 * @return Ambigous <string, mixed>
	 */
	public function projectBySlug($name){
		return TaskApi::getInstance()->projectBySlug($name);
	}
	/**
	 * 项目列表
	 * @return Ambigous <string, mixed>
	 */
	public function projects(){
		return TaskApi::getInstance()->projects();
	}
	
	
	
}

?>