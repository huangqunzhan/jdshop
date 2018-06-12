<?php
namespace app\index\controller;
use think\Db;

/**
* 前台商品列表展示
*/
class Goods extends \think\Controller
{
	
	public function goodslist1($goods_pid=''){
		if ($goods_pid=='') {
			$this->redirect('index/index');
		}
		$goodslist_data=Db::table('jdshop_goods')->where('goods_pid',$goods_pid)->paginate(2);
		if (empty($goodslist_data)) {
			$this->redirect('index/index');
		}
		$this->assign('goodslist_data',$goodslist_data);
		//dump($goodslist_data);die;
		return $this->fetch();
	}

	//商品列表添加关键字
	public function goodslist($goods_pid='',$goods_order=''){
		if ($goods_pid=='') {
			$this->redirect('index/index');
		}
		$goods_data_exist=Db::table('jdshop_goods')->where('goods_pid',$goods_pid)->where('goods_status','1')->select();
		if(empty($goods_data_exist)){
			$this->redirect('index/index');
		}
		$this->assign('goods_pid',$goods_pid);

		if($goods_order=='goods_sales'){
			$goods_order='goods_sales acs';
		}elseif ($goods_order=='goods_price_acs') {
			$goods_order='goods_price acs';
		}elseif ($goods_order=='goods_price_desc') {
			$goods_order='goods_price desc';
		}else{
			$goods_order='goods_id';
		}
		$goods_model=new \app\admin\model\Goods;
		//$cate_model=new \app\admin\model\Cate;
		$keywords_model=new \app\admin\model\Keywords;

	 	$goods_all=$goods_model->all(function($query) use ($goods_pid) {$query->where('goods_pid',$goods_pid)->where('goods_status','1');});
		//$goods_all=Db::table('jdshop_goods')->where('goods_pid',$goods_pid)->where('goods_status','1')->order($goods_order)->select();
		//dump($goods_all);die;
		//dump($goods_all);
		$goods_all_toArray=$goods_all->toArray();
		//dump($goods_all_toArray);die;
		$goods_info=array();
		foreach ($goods_all_toArray as $key => $value) {
			//$goods_get=$goods_model->get($value['goods_id']);
			// $goods_keywords=$goods_model->get($value['goods_id'])->keywords;
			// $goods_keywords_toArray=$goods_keywords->toArray();
			// $value['keywords']=$goods_keywords_toArray;
			// $goods_info[]=$value;
			$goods_get=$goods_model->get($value['goods_id']);
			$goods_get_toArray=$goods_get->toArray();

			$goods_keywords=$goods_get->keywords;
			$goods_keywords_toArray=$goods_keywords->toArray();
			
			$value['keywords']=$goods_keywords_toArray;
			$goods_info[]=$value;

		}
		//dump($goods_info);die;
		$this->assign('goods_info',$goods_info);
		return $this->fetch();
		//dump($goods_keywords_toArray);die;
		//dump($value['keywords']);die;
		//dump($goods_keywords);die;
		//dump($goods_get);die;

	}

	//商品详情
	public function introduction($goods_id=''){
		if (empty($goods_id)) {
			$this->redirect('index/index');
		}
		$goods_find=Db::table('jdshop_goods')->where('goods_id',$goods_id)->select();
		if (empty($goods_find)) {
			$this->redirect('index/index');
		}
		$goods_model=new \app\admin\model\Goods;
		$goods_get=$goods_model->get($goods_id);
		$goods_get_toArray=$goods_get->toArray();

		$goods_keywords=$goods_get->keywords;
		$goods_keywords_toArray=$goods_keywords->toArray();
		$goods_get_toArray['keywords']=$goods_keywords_toArray;
		//dump($goods_get_toArray);die;
		$this->assign('goods_info',$goods_get_toArray);

		$goods_pid = $goods_find[0]['goods_pid'];
		$cate_select = db('cate')->select();
		$cate_model = new \app\admin\model\Cate;
		$cate_in = $cate_model->getFatherId($cate_select,$goods_pid);
		//dump($cate_in);die;
		$this->assign('cate_in',$cate_in);

		return $this->fetch();
	}
}
?>