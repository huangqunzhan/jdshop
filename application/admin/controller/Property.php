<?php
namespace app\admin\controller;
use think\Db;
use think\Request;

/**
* 商品属性控制器
*/
class Property extends \think\Controller
{
	//属性列表
	public function propertylist($property_pid=''){
		// $property_select=Db::table('jdshop_property')->alias(['jdshop_property'=>'a','jdshop_cate'=>'b'])
		// 		->join('jdshop_cate','a.property_pid=b.cate_id')
		// 		->paginate(5);
		if ($property_pid=='') {
			$property_select=Db::table('jdshop_property')->select();
			//dump($keywords_list);die;		
		}else{
			$property_select=Db::table('jdshop_property')->where('property_pid',$property_pid)->select();
			if (empty($property_select)) {
				$this->redirect('property/propertylist');
			}
			
		}
		$cate_model=model('Cate');
		$cate_select=Db::table('jdshop_cate')->select();
		$property_select_fatherid=array();
		foreach ($property_select as $key => $value) {
			$property_pid=$value['property_pid'];
			// $value['fatherid']=$cate_model->getFather($cate_select,$property_pid);
			// $property_select_fatherid[]=$value;
			$father=$cate_model->getFather($cate_select,$property_pid);
			$value['father'][]=$father['0']['father']['0']['father']['0']['cate_name'];
			$value['father'][]=$father['0']['father']['0']['cate_name'];
			$value['father'][]=$father['0']['cate_name'];
			$property_select_fatherid[]=$value;
		}
		//dump($property_select_fatherid);die;
		$cate_model=model('Cate');
		$cate_list1=$cate_model->getChildren($cate_select);
		//dump($cate_list1);die;
		$this->assign('cate_list1',$cate_list1);
		$this->assign('property_select_fatherid',$property_select_fatherid);	
		return $this->fetch();
	}
	//添加商品属性
	public function addproperty(){
		$cate_model=model('Cate');
		$cate_select=Db::table('jdshop_cate')->select();
		$cate_list1=$cate_model->getChildren($cate_select);
		$this->assign('cate_list1',$cate_list1);
		return $this->fetch();
	}
	//添加商品属性处理
	public function addhandle(){
		$post=request()->post();
		$validate=validate('Property');
		if (!$validate->check($post)) {
			$this->error($validate->getError(),'property/addproperty');
		}else{
			$property_add=Db::table('jdshop_property')->insert($post);
			if ($property_add) {
				$this->success('添加商品属性成功','property/propertylist');
			}else{
				$this->error('添加商品属性成功','property/propertylist');
			}
		}
	}
	//商品属性修改
	public function updateproperty($property_id=''){
		if ($property_id=='') {
			$this->redirect('property/propertylist');
		}
		//select()输出二维数组，find()输出一维数组
		$property_id_data=Db::table('jdshop_property')->where('property_id',$property_id)->find();
		if (empty($property_id_data)) {
			$this->redirect('property/propertylist');
		}
		$cate_select=Db::table('jdshop_cate')->order('cate_sort')->select();
		$cate_model=model('Cate');
		$cate_list1=$cate_model->getChildren($cate_select);
		//dump($cate_list1);die;
		$cate_list2=$cate_model->getFatherId($cate_select,$property_id_data['property_pid']);
		//dump($cate_list2);die;
		//$cate_list3=$cate_model->getFather($cate_select,$goods_id_data['goods_pid']);
		$cate_list2_data=array();
		$cate_list2_data['one']=$cate_list2['0'];
		$cate_list2_data['two']=$cate_list2['1'];
		$cate_list2_data['three']=$cate_list2['2'];
		//dump($cate_list2_data);
		//dump($cate_list1);die;
		$this->assign('cate_list1',$cate_list1);
		$this->assign('cate_list2_data',$cate_list2_data);
		$this->assign('property_id_data',$property_id_data);
		return $this->fetch();
	}
	//商品属性修改处理
	public function updatepropertyhandle($property_id=''){
		$post=request()->post();
		if ($post['property_name']=='') {
			$this->error('属性分类名称不能为空','property/updateproperty');
		}
		$update_goods_property=Db::table('jdshop_property')->where('property_id',$property_id)->update($post);
		//   0不恒等于false
		if ($update_goods_property!==false) {
			$this->success('修改商品信息成功','property/propertylist');
		}else{
			$this->error('修改商品信息成功','property/propertylist');
		}

	}
	//商品属性的删除
	public function deleteproperty($property_id=''){
		
	}
}
?>