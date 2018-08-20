<?php
namespace app\api\validate;
use think\Validate;
class Dorm extends validate{
	protected $rule = [
		'dorm_name' => 'require|max:4|unique:dorm',
		'lc_name' => 'require|max:2',
		'build_id' => 'require',
	];

	protected $message = [
		'dorm_name.require' => '宿舍号不能为空',
		'dorm_name.max' => '宿舍号度不能大于2',
		'dorm_name.unique' => '宿舍号已存在',
		'lc_name.require' => '楼层不能为空',
		'build_id.require' => '所属楼号不能为空',
	];
}