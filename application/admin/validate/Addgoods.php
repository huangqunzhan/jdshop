<?php
namespace app\admin\validate;

use think\Validate;

/**
* 
*/
class Addgoods extends Validate
{
	
	protected $rule = [
		'goods_name' => 'require|max:90',
		'goods_thumb' => 'require',
		'goods_price' => 'require|egt:1|float',
		'goods_after_price' => 'egt:0|float',
		'goods_sales' => 'require|egt:1|integer',
		'goods_inventory' => 'require|egt:1|integer',
		'goods_pid' => 'require'
	];
	protected $message = [
		'goods_name.require' => '名称必须'
	];


}
?>