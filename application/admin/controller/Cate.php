<?php
namespace app\admin\controller;
use \think\Db;
use \think\Request;

/**
* 分类管理控制器
*/
class Cate extends Common
{
	//商品分类
	public function catelist(){
		//商品列表的方法
		$cate_select=Db::table('jdshop_cate')->order('cate_sort')->select();
		$cate_model=model('Cate');
		$cate_list=$cate_model->getChildrenId($cate_select);
		$this->assign('cate_list',$cate_list);
		return $this->fetch();
	}
	//添加分类表单
	public function add(){
		//获取下拉列表内容
		$cate_select=Db::table('jdshop_cate')->select();
		$cate_model=model('Cate');
		$cate_list=$cate_model->getChildrenId($cate_select);
		$this->assign('cate_list',$cate_list);
		return $this->fetch();
	}

	//添加商品分类处理
	public function addhandle(){
		if (request()->isPost()) {
			$data=input('post.');
			if($data['cate_name'] !=''){
			//获取提交的$cate_id
				$cate_id=input('post.cate_pid');
				//有$cate_id检索出等级
				$cate_level=Db::table('jdshop_cate')->where('cate_id',$cate_id)->value('cate_level');
				
				switch ($cate_level) {
					case '1':
						$data['cate_level']=2;
						break;
					case '2':
						$data['cate_level']=3;
						break;
					case '3':
						$data['cate_level']=4;
						break;
					case '4':
						$data['cate_level']=5;
						break;
					case '5':
						$data['cate_level']=6;
						break;
					case '6':
						$data['cate_level']=7;
						break;	
					default:
						$data['cate_level']=0;
						break;
				}
				$add_data=Db::table('jdshop_cate')->insert($data);
				if ($add_data) {
					$this->success("添加成功",'cate/catelist');
				}
				}else{
					$this->error("添加失败",'cate/add');
				}
			}else{
				$this->error("添加失败",'cate/add');
			}
		}

	//删除商品分类
	public function catedelete($cate_id=''){
		if($cate_id==''){
			$this->redirect('catelist');
		}
		$cate_id_data=Db::table('jdshop_cate')->where('cate_id',$cate_id)->find();		
		if($cate_id_data==null){
			$this->redirect('catelist');
		}else{	
			//连同子类一起删除			
			$cate_select=Db::table('jdshop_cate')->select();
			$cate_model=model('Cate');
			$cate_list=$cate_model->getChildrenId($cate_select,$cate_id,$cate_id_data['cate_level']+1);
			//var_dump($cate_list);
			//exit();
			foreach ($cate_list as $key => $value) {
				$cate_delete_child=Db::table('jdshop_cate')->where('cate_id',$value['cate_id'])->delete();						
			}		
			$cate_delete=Db::table('jdshop_cate')->where('cate_id',$cate_id)->delete();
			if ($cate_delete && $cate_delete_child) {
				$this->success('删除成功','catelist');
			}else{
				$this->error('删除失败','catelist');
			}
		}
	}

	//编辑商品分类
	public function cateupdate($cate_id=''){
		if ($cate_id=='') {
			$this->redirect('catelist');
		}
		$cate_id_data=Db::table('jdshop_cate')->where('cate_id',$cate_id)->find();
		if ($cate_id_data==null) {
			$this->redirect('catelist');
		}else{
			$this->assign('cate_id_data',$cate_id_data);
			$cate_select=Db::table('jdshop_cate')->select();
			$cate_model=model('Cate');
			$cate_list=$cate_model->getChildrenId($cate_select);
			$this->assign('cate_list',$cate_list);
			return $this->fetch();
		}
	}

	//编辑商品分类处理
	public function updatehandle($cate_id=''){
		if ($cate_id=='') {
			$this->redirect('catelist');
		}
		$cate_id_data=	Db::table('jdshop_cate')->where('cate_id',$cate_id)->find();
		if ($cate_id_data==null) {
			$this->redirect('catelist');
		}else{
			$data_post=request()->post();
			$cate_update=Db::table('jdshop_cate')->where('cate_id',$cate_id)->update($data_post);
			if ($cate_update !== false) {
				$this->success('修改成功','catelist');
			}else{
				$this->error('修改失败','catelist');
			}
		}
	}

	//商品分类排序
	public function catesort(){
		$post_data=request()->post();
		foreach ($post_data as $key => $value) {
			Db::table('jdshop_cate')->where('cate_id',$key)
				->update([
				'cate_sort' => $value
				]);
		}
		$this->redirect('cate/catelist');
	}

}
?>