<?php
namespace app\api\validate;
use think\Validate;
class Student extends validate{
	protected $rule = [
		'student_id' => 'require|max:10|unique:student',
		'student_name' => 'require|max:10',
		'student_cardid' => 'require|max:28|unique:student',
	];

	protected $message = [
		'student_id.require' => '学号不能为空',
		'student_id.max' => '学号长度不能大于18',
		'student_id.unique' => '学号已存在',
		'student_name.require' => '学生姓名不能为空',
		'student_name.max' => '学生姓名不能为空',
		'student_cardid.require' => '身份证号不能为空',
		'student_cardid.max' => '身份证号不能为空',
		'student_cardid.unique' => '身份证号不能为空',
	];

	protected $scene = [
		'add' => ['student_id','student_name','student_cardid','student_sex'],
		'login' => ['student_id'=>'require|max:10','student_cardid'=>'require|max:18'],
	];
}