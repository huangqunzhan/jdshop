<?php 
namespace app\index\model;

/**
* 前台商品分页模型
*/
class Cate extends \think\Controller
{
	public function getChildren($cate_list,$pid=0){
		$arr=array();
		foreach ($cate_list as $key => $value) {
			if ($value['cate_pid']==$pid) {
				$value['children']=$this->getChildren($cate_list,$value['cate_id']);
				$arr[]=$value;
			}
		}
		return $arr;
	}
}
?>