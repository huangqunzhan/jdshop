<?php
namespace app\admin\validate;

/**
* 商品属性验证器
*/
class Property extends \think\Validate
{
	protected $rule = [
		'property_name' => 'require|max:90|unique:property,property_name',
		'property_pid' => 'require|gt:0',
	];

	protected $message = [
		'keywords_name.require' => '请输入属性名称',
		'keywords_name.unique' => '属性是否唯一',
		'property_pid.gt' => '请选择所属分类',
	];
	
}
?>