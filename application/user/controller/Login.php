<?php
namespace app\user\controller;
use \think\Request;
use \think\Db;
/**
* 用户登录控制器
*/
class Login extends \think\Controller
{
	//用户登录视图
	public function login(){
		return $this->fetch();
	}
	//用户登录处理
	public function loginhandle(){
		$post=request()->post();
		$post['user_password']=md5($post['user_password']);
		$user_email_find=Db::table('jdshop_user')->where('user_email',$post['user_email'])->find();
		if (empty($user_email_find)) {
			//用户或密码错误的情况
			$this->error('用户或密码错误，请重新登录','user/login/login');
		}else if($user_email_find['user_email_active']=='0'){
			//用户邮箱没有激活的情况
			$this->error('该邮箱并未激活，请登录该邮箱进行激活',url('user/login/active',array('user_email'=>$user_email_find['user_email'])));
		}
		else{
			//用户邮箱已经激活的情况
			session('user_id',$user_email_find['user_id']);
			session('user_email',$user_email_find['user_email']);
			$this->success('登录成功！','index/index/index');
		}
	}
	//用户退出
	public function loginout(){
		session('user_email',null);
		$this->redirect('index/index/index');
	}
	public function active($user_email)
	{
		$title = 'JD商城';  //标题
		$address = url('user/login/active1',array('user_email'=>$user_email));
		$address = urldecode($address);
		$content = '请访问以下地址进行激活http://localhost'.$address; dump($content); 
		//邮件内容
		SendMail($user_email,$title,$content); //直接调用发送即可
	}

	public function active1($user_email)
	{
		$user_email_find = db('user')->where('user_email','eq',$user_email)->find();
		if ($user_email_find) {
			if ($user_email_find['user_email_active']=='1') {
				$this->error('该邮箱已经激活，请重新登录','user/login/login');
			}
			else{
				db('user')->update(['user_email_active'=>'1','user_id'=>$user_email_find['user_id']]);
				$this->success('该邮箱被成功激活，请登录','user/login/login');
			}
		}
		else{
			$this->redirect('index/index/index');
		}
	}
}
?>