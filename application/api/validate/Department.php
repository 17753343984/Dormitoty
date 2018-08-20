<?php
namespace app\api\validate;
use think\Validate;
class Department extends validate{
    protected $rule=[
        'department_name'=>'require|max:10|unique:Department',
    ];
    protected $message=[
        'department_name.require'=>'系名不能为空',
        'department_name.max'=>'系名长度不能大于10',
        'department_name.unique'=>'系名已存在',
    ];

    protected $scene=[
        'add'=>['department_name'],
    ];
}