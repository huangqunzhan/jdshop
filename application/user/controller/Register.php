<?php
namespace app\user\controller;

/**
* 用户注册控制器
*/
class Register extends \think\Controller
{
	//注册界面
	public function register(){
		return $this->fetch();
	}
	//邮箱注册处理
	public function userregisterhandle(){
		$post=request()->post();
		$post['user_password']=md5($post['user_password']);
		$user_register_result=db('user')->insert($post);
		if ($user_register_result) {
			$this->success('恭喜你注册成功','index/index/index');
		}
		else{
			$this->error('注册失败，请重新注册','register/register');
		}
	}

	//ajax检查用户名
	public function checkusername()
	{
		/*使用Ajax对用户注册时邮箱是否已经存在进行验证*/
		if (request()->isAjax()) {
			//如果是Ajax请求
			$post = request()->post();
			$user_email = $post['param'];
			$user_email_find = db('user')->where('user_email','eq',$user_email)->find();
			//查看传递过来的邮箱地址是否存在
			if ($user_email_find) {
				return ['status'=>'n','info'=>'该邮箱已经被注册'];
			}
			else {
				return ['status'=>'y','info'=>'该邮箱可以使用'];
			}
		}
	}
	//ajax检查用户名
	public function checkusername1()
	{
		/*使用Ajax对用户注册时手机是否已经存在进行验证*/
		if (request()->isAjax()) {
			//如果是Ajax请求
			$post = request()->post();
			$user_phone = $post['param'];
			$user_phone_find = db('user')->where('user_phone','eq',$user_phone)->find();
			//查看传递过来的邮箱地址是否存在
			if ($user_phone_find) {
				return ['status'=>'n','info'=>'该手机已经被注册'];
			}
			else {
				return ['status'=>'y','info'=>'该手机可以使用'];
			}
		}
	}

	//手机注册处理
	public function userregisterhandle1(){
		$post=request()->post();
		//dump($post);die;
		//$post['user_password']=md5($post['user_password1']);
		unset($post['code']);
		unset($post['user_password1']);
		$user_register_result=db('user')->insert($post);
		if ($user_register_result) {
			$this->success('恭喜你注册成功','index/index/index');
		}
		else{
			$this->error('注册失败，请重新注册','register/register');
		}
	}
}
?>