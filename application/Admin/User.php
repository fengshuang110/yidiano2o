<?php 
namespace Admin;
use Luracast\Restler\Format\HtmlFormat;
use Admin\Base;
use Application;

class User extends Member{
	
	/**
	 * 用户列表
	 * @view user/lists
	 * @return multitype:
	 */
	public function lists(){
		$page = empty($_REQUEST['pn'])?"1":$_REQUEST['pn'];
		$limit = empty($_REQUEST['limit'])?10:intval($_REQUEST['limit']);
		$param['start'] = ($page-1)*$limit;
		$param['limit'] = $limit;
		$users = $this->getModel("User")->select($param);
		HtmlFormat::$data['page']=$users['_meta']['currentPage'];
		HtmlFormat::$data['lists']=$users['items'];
		HtmlFormat::$data['totalPage']=$users['_meta']['pageCount'];
		return array();
	}
	/**
	 * 添加角色
	 * @view user/add
	 * @url GET /add
	 * @url POST /add
	 * @return multitype:
	 */
	public function add(){
		
		$request = $this->getRequest();
		if($request->isPost()){
			$user = $request->getPost("user");
			$this->getModel("User")->save($user);
			$this->redirect("/user/lists");
			
		}
		$roles = $this->getModel("User")->getAll();
		HtmlFormat::$data["roles"]=$roles;
		return array();
	}

	/**
	 * 编辑用户
	 * @view user/edit
	 * @url GET /edit
	 */
	public function edit($id){
		$user = $this->getModel("User")->getOne($id);
		$roles = $this->getModel("Role")->getAll();
		if(empty($user) || empty($roles)){
			$this->redirect("/user/lists");
		}
		HtmlFormat::$data["user"]=$user;
		HtmlFormat::$data["roles"]=$roles;
		return array();		
	}
	//删除角色
	public function del($id){
		$user = $this->getModel("User")->del($id);
		$this->redirect("/user/lists");		
	}
}
?>