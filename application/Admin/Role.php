<?php 
namespace Admin;
use Luracast\Restler\Format\HtmlFormat;
use Admin\Base;

class Role extends Member{
	
	/**
	 * @view role/lists
	 * @return multitype:
	 */
	public function lists(){
		
		$page = empty($_REQUEST['pn'])?"1":$_REQUEST['pn'];
		$limit = empty($_REQUEST['limit'])?10:intval($_REQUEST['limit']);
		$param['start'] = ($page-1)*$limit;
		$param['limit'] = $limit;
		$roles = $this->getModel("Role")->select($param);
		
		HtmlFormat::$data['page']=$roles['_meta']['currentPage'];
		HtmlFormat::$data['lists']=$roles['items'];
		HtmlFormat::$data['totalPage']=$roles['_meta']['pageCount'];
		return array();
	}
	/**
	 * 添加角色
	 * @view admin/role/add
	 * @url GET /add
	 * @url POST /add
	 * @return multitype:
	 */
	public function add(){
		$request = $this->getRequest();
		if($request->isPost()){
			$role = $request->getPost();
			$this->getModel("Role")->save($role);
			$this->redirect("/role/lists");
		}else{
			return array();
		}
	}
	
	/**
	 * 编辑角色
	 * @view admin/role/edit
	 * @url GET /edit
	 * @url POST /edit
	 * @return multitype:
	 */
	public function edit($id){
		//删除权限
		$role = $this->getModel("Role")->get($id);
		HtmlFormat::$data['role']=$role;
		return array();
	}
	//删除角色
	public function del($id){
		//删除权限
		$this->getModel("Role")->del($id);
		$this->redirect("/role/lists");		
		 
	}
}
?>