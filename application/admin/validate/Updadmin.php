<?php  
namespace app\admin\validate;

use think\Validate;

class Updadmin extends Validate
{
    protected $rule = [
        'admin_name'  =>  'require|alphaNum|length:3,10',
        'admin_password' =>  'require|length:6,10|confirm:admin_repassword',
    ];
    protected $message = [
        'admin_name.require'    => '请输入管理员名称名称',
        'admin_name.alphaNum'   => '名称只能是字母和数字',
        'admin_name.length'     => '管理员名称长度介于3~10之间',
        'admin_password.require'  => '请输入管理员密码',
        'admin_password.length' =>  '管理员密码长度介于6~10之间',
        'admin_password.confirm'    =>  '两次输入的密码不一致'
    ];
    

}
?>