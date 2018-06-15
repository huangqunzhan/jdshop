<?php
namespace app\admin\model;

/**
* 
*/
class Goods extends \think\Model
{	// 设置返回数据集的对象名
	//设置模型数据集返回类型
	protected $resultSetType='collection';

	public function keywords(){
		return $this->belongsToMany('Keywords','goods_keywords');
	}

	//商品与分类多对一的关系

	public function cate(){
		//关联模型名，外键名
		return $this->belongsTo('Cate','goods_pid');
	}
	//商品与商品细节图一对多的关系
	public function img(){
		return $this->hasMany('Img','goods_id');
	}

	public function goodsproperty(){
		//商品的细节图的一对多关系
		return $this->hasMany('Goodsproperty');
	}
}
?>