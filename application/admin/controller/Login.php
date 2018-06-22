<?php
namespace app\admin\controller;
use \think\Db;
use \think\Request;
/**
* 登录控制器
*/
class Login extends \think\Controller
{	
	//登录页面
	public function Login(){
		if (session('?admin_name')) {
			$this->error('您已经登录，请退出后再重新登录','index/index');
		}
		return $this->fetch();
	}
	//登录验证
	public function checklogin(){
		$post=request()->post();
		if (empty($post)) {
			$this->redirect('login/login');
		}
		$admin_find=Db::table('jdshop_admin')->where('admin_name',$post['admin_name'])->find();
		if (empty($admin_find)) {
			$this->error('该管理员不存在，请重新登录','login/login');
		}else{
			$admin_password=$admin_find['admin_password'];
			if (md5($post['admin_password'])==$admin_password) {
				if(!captcha_check($post['admin_code'])){
					$this->error('验证码错误！','login/login');
				};
				session('admin_id',$admin_find['admin_id']);
				session('admin_name',$admin_find['admin_name']);
				$this->success('登陆成功','index/index');
			}else{
				$this->error('管理员密码错误，请重新登录','login/login');
			}
		}
	}
	//退出登录
	public function loginout(){
		session('admin_id',null);
		session('admin_name',null);
		$this->redirect('login/login');
	}

}
?>