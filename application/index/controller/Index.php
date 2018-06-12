<?php
namespace app\index\controller;
use \think\Db;

class Index extends \think\Controller
{
    public function index()
    {
    	$cate_select=Db::table('jdshop_cate')->order('cate_sort')->select();
    	$cate_model=model('Cate');
    	$cate_list=$cate_model->getChildren($cate_select);
    	//dump($cate_list);die;
    	$this->assign('cate_list',$cate_list);
         return $this->fetch();
    }
}
