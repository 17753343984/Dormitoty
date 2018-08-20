<?php
namespace app\api\controller;
use think\Controller;
use app\common\Model;
use think\validate;
use think\Exception;
class Department extends AdminCommon
{
    private $obj;
     public function _initialize()
     {
        parent::_initialize();
        $this->obj=model('Department');
     }
    public function  lst()
    {
        $departs=$this->obj->select();
        if($departs)
        {
            return $this->return_json(200,'查询成功',$departs);
        }else{
            return $this->return_json(400,'查询失败');
        }
    }

    public function  add()
    {
        $a = $this->quanxian_check(input('uid'));
        if ($a !== 1) {
            return $this->return_json(400,'您没有权限');
        }
        if(request()->isPost()){
            //return $this->return_json(400,'添加失败');
            $data=input('post.');
            $validata=validate('Department');
            if($validata->scene('add')->check($data)){
                if($this->obj->save($data)){
                    return $this->return_json(200,'添加成功');
                }else{
                    return $this->return_json(400,'添加失败');
                }
            }else{
                return $this->return_json(400,$validata->getError());
            }
        }
    }


    public function  edit($id=''){
        $a = $this->quanxian_check(input('uid'));
        if ($a !== 1) {
            return $this->return_json(400,'您没有权限');
        }
        if(request()->isPost()){
            $data=input('post.');
            $validata=validate('Department');
            if($validata->scene('add')->check($data)){
                $id=[
                  'id'=>$data['id'],
                ];
                if($this->obj->save($data,$id)){
                    return $this->return_json(200,'修改成功');
                }else{
                    return $this->return_json(400,'修改失败');
                }
            }else{
                return $this->return_json(400,$validata->getError());
            }
        }
        $departs=$this->obj::get($id);
        if($departs){
            return $this->return_json(200,'查询成功',$departs);
        }else{
            return $this->return_json(400,'查询失败',$departs);
        }
    }

    public function del($id=''){
        $a = $this->quanxian_check(input('uid'));
        if ($a !== 1) {
            return $this->return_json(400,'您没有权限');
        }
        try{
            if($this->obj::destroy($id)){
                return $this->return_json(200,'删除成功');
            }else{
                return $this->return_json(400,'删除失败');
            }
        }catch(Exception $e){
            return $this->return_json(400,'删除失败,有子级分类');
        }
    }
}