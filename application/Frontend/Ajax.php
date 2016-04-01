<?php 
namespace Frontend;

use Service\ResumeService;
use Service\WorkService;
use Service\CategoryService;
use Service\CompanyService;
/**
 *  app应用信息
 * @author fengshuang
 *
 */
class Ajax extends Rest{
	/**
	 * 检查用户是否可以发布项目
	 * @url POST /checkuser
	 * @return multitype:number string |multitype:number
	 */
	public function checkuser(){
		$request = $this->getRequest() ;
		if($request->isPost() && $request->isXmlHttpRequest()){
			if(empty($_SESSION['user'])){
				return array('code'=>403,"message"=>"请登录");
			}
			$authentication = CompanyService::getInstance()->getAuthentication();
			$company_info = CompanyService::getInstance()->getProfile();
			
			if(empty($company_info)){
				return array('code'=>1,"message"=>"需求者的档案信息不完善，请完善档案信息");
			}
			
			if(empty($authentication) || $authentication['status'] != 1){
				return array('code'=>2,"message"=>"认证信息不完善，或者在审核中......");
			}
			
			return array('code'=>0);
		}
	}
	
	/**
	 * 检查用户是否可以报名项目
	 * @url POST /checkapply
	 * @return multitype:number string |multitype:number
	 */
	public function checkapply(){
		$request = $this->getRequest() ;
		if($request->isPost() && $request->isXmlHttpRequest()){
			if(empty($_SESSION['user'])){
				return array('code'=>403,"message"=>"请登录");
			}
			
			if(ResumeService::getInstance()->getCvcomplete($_SESSION['user']['userid'])<70){
				return array('code'=>1004,"message"=>"简历不完善请完善简历");
			}
			return array('code'=>0);
		}
	}
	
	//我是开发者通过分类查询项目
	public function works(){
		$request = $this->getRequest();
		$category_id = $request->getQuery('category_id');
		if($category_id === false){
			return array("code"=>1,"message"=>"参数数据错误");
		}
		$params = $this->page(5);
		$works = WorkService::getInstance()->getByCateId($params,$category_id);
		return array("code"=>0,"data"=>$works);
		
	}
	
	/**
	 * @url POST /getCategory
	 * @param number $cate_id
	 */
	public function getCategory($cate_id = 0){
		return CategoryService::getInstance()->getCategories($cate_id);
	}
	
}

?>