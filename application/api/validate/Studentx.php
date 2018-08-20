<?php
namespace app\api\validate;
use think\Validate;
class Studentx extends validate{
	protected $rule = [
		'xxstudent_phone' => 'require|max:11',
		'xxstudent_place' => 'require|max:10',
		'xxstudent_addres' => 'require|max:20',
		'xxstudent_major' => 'require|max:10',
		'xxstudent_job' => 'require|max:10',
		'xxstudent_fphone' => 'max:11',
		'xxstudent_mphone' => 'max:11',
		'xxdepartment_id' => 'require',
		'student_id' => 'require|unique:studentx',
		'fd_id' => 'require',
		'class_id' => 'require',
	];

	protected $message = [
		'xxstudent_phone.require' => '联系方式不能为空',
		'xxstudent_phone.max' => '联系方式长度不能大于11位',
		'xxstudent_place.require' => '籍贯不能为空',
		'xxstudent_place.max' => '籍贯长度不能大于11位',
		'xxstudent_addres.require' => '地址不能为空',
		'xxstudent_addres.max' => '地址长度不能大于11位',
		'xxstudent_major.require' => '专业不能为空',
		'xxstudent_major.max' => '专业长度不能大于11位',
		'xxstudent_job.require' => '职位不能为空',
		'xxstudent_job.max' => '职位长度不能大于11位',
		'xxstudent_fphone.max' => '父亲联系方式长度不能大于11位',
		'xxstudent_mphone.max' => '母亲亲联系方式长度不能大于11位',
		'xxdepartment_id.require' => '系不能为空',
		'student_id.require' => '学生不能为空',
		'student_id.unique' => '您已经添加信息',
		'fd_id.require' => '辅导员不能为空',
		'class_id.require' => '班级不能为空',

	];

	// protected $scene = [
	// 	'add' => ['student_id','student_name','student_cardid','student_sex'],
	// 	'login' => ['student_id'=>'require|max:10','student_cardid'=>'require|max:18'],
	// ];
}