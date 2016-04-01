<?php 
namespace Admin;
use Luracast\Restler\Format\HtmlFormat;
use Admin\Base;

class Permission extends Member{
	
	/**
	 * @view permission/lists
	 * @return multitype:
	 */
	public function lists($pn=1,$limit=10){
		$param['start'] = ($pn-1)*$limit;
		$param['limit'] = $limit;
		$permissions_list = $this->getModel("Menu")->select($param);
		HtmlFormat::$data['page']=$permissions_list['_meta']['currentPage'];
		HtmlFormat::$data['lists']=$permissions_list['items'];
		HtmlFormat::$data['totalPage']=$$permissions_list['_meta']['pageCount'];
		return array();
	}
	
	/**
	 * @view permission/add
	 * @url GET /add
	 * @url POST /add
	 * @return multitype:
	 */
	public function add(){
		$request = $this->getRequest();
		if($request->isPost()){
			$post = $request->getPost();
			$parent_menus =$this->getModel("Menu")->save($post);
			$this->redirect("/permission/lists");
		}
		$parent_menus = $this->getModel("Menu")->getParent();
		HtmlFormat::$data['parent_menus'] = $parent_menus;
		return array();
		
	}
	
	/**
	 * 编辑资源
	 * @view permission/edit
	 * @url GET /edit
	 * @return multitype:
	 */
	public function edit($id=0){
		$menu = $this->getModel("Menu")->get($id);
		if(empty($menu)){
			$this->redirect("/permission/lists");
		}
		$parent_menus = $this->getModel("Menu")
							 ->where(array('field'=>"parent_id",'op'=>'=','value'=>0))
							 ->all();
		HtmlFormat::$data['parent_menus'] = $parent_menus;
		HtmlFormat::$data['menu'] = $menu;
		return array();
	}
	
	/**
	 * 编辑资源
	 * @url GET /del
	 * @return multitype:
	 */
	public function del($id = 0){
		//删除权限
		$this->getModel("Menu")->del($id);
		$this->redirect("/permission/lists");
	}
	
}
?>