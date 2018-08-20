<?php
namespace app\api\validate;
use think\Validate;
class Grade extends validate{
    protected $rule=[
        'department_id '=>'require',
        'class_name'=>'require|unique:Grade',
        'fd_id'=>'require',
    ];
    protected $message=[
        'department_id.require'=>'所属系别不能为空',
        'class_name.require'=>'班级名称不能为空',
        'class_name.unique'=>'班级名称已经存在',
    ];

    protected $scene=[
        'add'=>['department_id','class_name','fa_id'],
    ];
}