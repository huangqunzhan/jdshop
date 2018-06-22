<?php
namespace app\admin\controller;
use think\Db;
use think\Request;

/**
* 
*/
class Keywords extends Common
{
	//关键字列表
	public function keywordslist(){
		$keywords_list=Db::table('jdshop_keywords')->paginate(5);
		if ($keywords_list) {
			$this->assign('keywords_list',$keywords_list);
			//$page=$keywords_list->render();
			//$this->assign('page',$page);
			if (request()->isAjax()) {
				return view("paginate1");
			}else{
			return $this->fetch();
		}
		}else{
			$this->redirect('index/index');
		}
		
		
	}
	//添加关键字
	public function addkeywords(){
		return $this->fetch();
	}
	//添加关键字处理

	public function addkeywordshandle(){
		$keywords_add_data=request()->post();
		$validate=validate('Keywords');
		if (!$validate->check($keywords_add_data)) {
			$this->error($validate->getError(),'keywords/keywordslist');
		}
		$keywords_add=Db::table('jdshop_keywords')->insert($keywords_add_data);
		if ($keywords_add) {
			$this->success('添加关键字成功','keywords/keywordslist');
		}else{
			$this->error('添加关键字失败','keywords/keywordslist');
		}
		
		
		
	}

}
?>
