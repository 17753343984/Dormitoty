<?php
namespace app\api\validate;
use think\Validate;
class Fd extends validate{
    protected $rule=[
        'fd_name'=>'require',
        'department_id'=>'require',
        'fd_phone'=>'require|max:11|unique:Fd',
    ];
    protected $message=[
        'fd_name.require'=>'辅导员姓名不能为空',
        'department_id.require'=>'系别不能为空',
        'fd_phone.require'=>'手机号不能为空',
        'fd_phone.max'=>'手机号长度不能超过11位',
        'fd_phone.unique'=>'手机号已经存在',
    ];

    protected $scene=[
        'add'=>['fd_name','department_id','fd_phone'],
    ];
}