<?php
namespace app\admin\controller;

/**
* 公共方法，用于是否登录
*/
class Common extends \think\Controller
{
	public function _initialize(){
		if (!session('?admin_name')) {
			$this->error('您还没有登录','login/login');
		}
	}
}
?>