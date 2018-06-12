<?php
namespace app\admin\model;


/**
* 商品分类模型
*/
class Cate extends \think\Model
{
	//protected $resultSetType='collection';
	
	public function getChildrenId($cate_list,$pid=0,$level=1){

		static $arr=array();

		foreach ($cate_list as $key => $value) {
			//根据子类找父类
			if ($value['cate_pid'] == $pid) {
				$value['cate_level']=$level;
				$value['str']=str_repeat('----', $value['cate_level']-1);
				$arr[]=$value;
				$this->getChildrenId($cate_list,$value['cate_id'],$value['cate_level']+1);
			}
		}
		return $arr;
	}

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

	public function getFatherId($cate_list,$id){

		static $arr=array();

		foreach ($cate_list as $key => $value) {
			if($value['cate_id']==$id){
				$value['str']=str_repeat('----',$value['cate_level']-1);
				$arr[]=$value;
				$this->getFatherId($cate_list,$value['cate_pid']);
			}
		}
		return $arr;
	}

	public function getFather($cate_list,$id){

		$arr=array();

		foreach ($cate_list as $key => $value) {
			if ($value['cate_id']==$id) {
				$value['father']=$this->getFather($cate_list,$value['cate_pid']);
				$arr[]=$value;
			}
		}
		return $arr;
	}

	//分类与商品的一对多关系
	public function goods(){
		return $this->hasMany('Cate');
	}
}
?>