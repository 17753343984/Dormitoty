<?php

namespace app\api\validate;
use think\Validate;
class Build extends validate{
	protected $rule = [
		'build_name' => 'require|max:4|unique:build',
	];

	protected $message = [
		'build_name.require' => '楼号不能为空',
		'build_name.max' => '楼号长度不能大于4',
		'build_name.unique' => '楼号已存在',
	];
}