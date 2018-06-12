<?php
namespace app\admin\model;

/**
* 商品细节图模型
*/
class Img extends \think\Model
{
	protected $resultSetType='collection';
	public function goods(){
		return $this->belongsTo('Goods');
	}
}
?>