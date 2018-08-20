<?php

namespace app\api\validate;
use think\Validate;
class Admin extends validate{
	protected $rule = [
		'admin_username' => 'require|max:18|unique:admin',
		'admin_password' => 'require',
	];

	protected $message = [
		'admin_username.require' => '用户名不能为空',
		'admin_username.max' => '用户名长度不能大于18',
		'admin_username.unique' => '用户名已存在',
		'admin_password.require' => '密码不能为空',
	];

	protected $scene = [
		'login' => ['admin_username'=>'require|max:18','admin_password'],
		'add' => ['admin_username','admin_password'],
	];
}