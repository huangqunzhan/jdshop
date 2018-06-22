<?php
namespace  app\admin\controller;
use think\Db;
use think\Request;
/**
* 管理员控制器
*/
class Admin extends Common
{
	//管理员列表
	public function adminlist(){
		$admin_list=Db::table('jdshop_admin')->paginate(3);
		//var_dump($admin_list);die;
		$this->assign('admin_list',$admin_list);
		return $this->fetch();
	}
	//管理员添加的方法
	public function addadmin(){
		return $this->fetch();
	}
	//管理员添加的·处理
	public function addadminhandle(){
		$post = request()->post();
		$validate=validate('Admin');
		if (!$validate->check($post)) {
			$this->error($validate->getError(),'admin/addadmin');
		}else{
			$post['admin_password']=md5($post['admin_password']);
			unset($post['admin_repassword']);
			$add_admin_data=Db::table('jdshop_admin')->insert($post);
			if ($add_admin_data) {
				$this->success('添加管理员成功','admin/adminlist');
			}else{
				$this->error('添加管理员失败','admin/adminlist');
			}
		}		
	} 
	//ajax验证用户名是否存在
	public function checkadminname(){
		if (request()->isAjax()) {
			$post=request()->post();
			//$admin['admin_id'] = $post['name'];
			//$admin_name['admin_name'] = $post['param'];
			$admin_name=$post['admin_name'];
			if ($admin_name=='') {
				return array('status'=>'0','info'=>'请输入管理员名称');
			}else{
				$admin_name_find=Db::table('jdshop_admin')->where('admin_name',$admin_name)->find();
				if ($admin_name_find) {
					return array('status'=>'-1','info'=>'管理员名称存在');
				}else{
					$admin_name_length=strlen($admin_name);
					if ($admin_name_length<3 || $admin_name_length>10) {
						return array('status'=>'-2','info'=>'管理员名称长度介于3~10之间');
					}else{
						return array('status'=>'1','info'=>'该管理员名称可用');
					}
					
				}
			}
			// $validate = validate('admin');
			// if ($validate->scene('admin_name')->check($admin_name)) {
			// 	return array('status'=>'y','info'=>'管理员名称可以使用');
			// }
			// else{
			// 	return array('status'=>'n','info'=>$validate->getError());
			// }
		}
	}
	//ajax验证密码是否正确
	public function checkpassword(){
		if (request()->isAjax()) {
			$post=request()->post();
			$admin_password=$post['admin_password'];
			if ($admin_password=='') {
				return array('status'=>'-1','info'=>'请输入密码');
			}else if($admin_password!=''){
				$admin_password_length=strlen($admin_password);
				//dump($admin_password_length);
				if ($admin_password_length<6 || $admin_password_length>10) {
					return array('status'=>'-2','info'=>'管理员密码长度介于6~10之间');
				}else{
					return array('status'=>'1','info'=>'管理员密码可用');
				}
			}
			
		}
	}
	//ajax验证二次密码
	public function checkrepassword(){
		if (request()->isAjax()) {
			$post=request()->post();
			$admin_password=$post['admin_password'];
			$admin_repassword=$post['admin_repassword'];
			if ($admin_password!=''&&$admin_repassword=='') {
				return array('status'=>'-1','info'=>'请再次输入密码');
			}
			if ($admin_repassword!='') {
				if ($admin_password!=$admin_repassword) {
					return array('status'=>'-2','info'=>'两次密码不一致');
				}else{
					return array('status'=>'1','info'=>'两次密码一致');
				}
				
			}
		}
	}
	//更新管理员
	public function updateadmin($admin_id=''){
		if ($admin_id=='') {
			$this->redirect('admin/adminlist');
		}
		$admin_id_find=Db::table('jdshop_admin')->where('admin_id',$admin_id)->find();
		if (empty($admin_id_find)) {
			$this->redirect('admin/adminlist');
		}
		$this->assign('admin_data',$admin_id_find);
		return $this->fetch();
	}
	//删除管理员
	public function deleteadmin($admin_id=''){
		if ($admin_id=='') {
			$this->redirect('admin/adminlist');
		}
		$admin_id_find=Db::table('jdshop_admin')->where('admin_id',$admin_id)->find();
		if (empty($admin_id_find)) {
			$this->redirect('admin/adminlist');
		}
		$admin_id_delete=Db::table('jdshop_admin')->where('admin_id',$admin_id)->delete();
		if ($admin_id_delete) {
			$this->success('删除管理员成功','admin/adminlist');
		}else{
			$this->error('删除管理员失败','admin/adminlist');
		}
	}

	/*public function checkupdadminname(){
		if (request()->isAjax()) {
			$post=request()->post();
			//$admin['admin_id'] = $post['name'];
			//$admin_name['admin_name'] = $post['param'];
			$admin_name=$post['admin_name'];
			if ($admin_name=='') {
				return array('status'=>'0','info'=>'请输入管理员名称');
			}else{
				$admin_name_find=Db::table('jdshop_admin')->where('admin_name',$admin_name)->find();
				if ($admin_name_find) {
					return array('status'=>'-1','info'=>'管理员名称存在');
				}else{
					$admin_name_length=strlen($admin_name);
					if ($admin_name_length<3 || $admin_name_length>10) {
						return array('status'=>'-2','info'=>'管理员名称长度介于3~10之间');
					}else{
						return array('status'=>'1','info'=>'该管理员名称可用');
					}
					
				}
			}
			// $validate = validate('admin');
			// if ($validate->scene('admin_name')->check($admin_name)) {
			// 	return array('status'=>'y','info'=>'管理员名称可以使用');
			// }
			// else{
			// 	return array('status'=>'n','info'=>$validate->getError());
			// }
		}
	}*/
	//修改管理员密码处理
	public function updateadminhandle($admin_id=''){
		$post=request()->post();
		$validate=validate('updadmin');
		$updatepassword=md5($post['admin_password']);
		if (!$validate->check($post)) {
			$this->error($validate->getError(),'admin/adminlist');
		}else{
			$admin_password_update=Db::table('jdshop_admin')->where('admin_id',$admin_id)->setField('admin_password',$updatepassword);
			if ($admin_password_update!==false) {
				$this->success('修改成功','admin/adminlist');
			}else{
				$this->error('修改失败','admin/adminlist');
			}
			
		}
	}
	
}
?>