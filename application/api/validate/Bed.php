<?php
namespace app\api\validate;
use think\Validate;
class Bed extends validate{
	protected $rule = [
		'bed_name' => 'require|max:2',
		'build_id' => 'require',
		'dorm_id' => 'require',
		'student_id' => 'require|unique:bed',
	];

	protected $message = [
		'cwid.require' => '床位不能为空',
		'cwid.max' => '床位长度不能大于2',
		'build_id.require' => '所属楼号不能为空',
		'dorm_id.require' => '所属楼号不能为空',
		'student_id.unique' => '你已经有床位',
	];
}