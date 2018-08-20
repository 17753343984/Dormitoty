<?php
namespace app\api\controller;
use app\Common\Model;
use think\validate;
class Grade extends AdminCommon
{
    private $grade;
    private $depart;
    private $fd;
    public function _initialize()
    {

        $this->grade=model('Grade');
        $this->department=model('Department');
        $this->fd=model('Fd');
    }

    public function lst()
    {

        $grades = $this->grade->findlst();
        if($grades)
        {
            return $this->return_json(200,'查询成功',$grades);
        }else{
            return $this->return_json(400,'查询失败');
        }
    }

    public function childres($id='')
    {
        $grades=$this->grade->field('id,class_name')->where('fd_id',$id)->select();
        if($grades)
        {
            return $this->return_json(200,'查询成功',$grades);
        }else{
            return $this->return_json(400,'查询失败');
        }
    }

    public function add()
    {
        $a = $this->quanxian_check(input('uid'));
        if ($a !== 1) {
            return $this->return_json(400,'您没有权限');
        }
        if(request()->isPost()){
            $data=input('post.');
            $validata=validate('Grade');
            if($validata->scene('add')->check($data)){   
                if($this->grade->save($data)){
                    return $this->return_json(200,'添加成功');
                }else{
                    return $this->return_json(400,'添加失败');
                }
            }else{
                return $this->return_json(400,$validata->getError());
            }
        }
        $departments=$this->department->field('id,department_name')->select();
        $lastdata['departs']=$departments;
        if($lastdata){
            return $this->return_json(200,'查询成功',$lastdata);
        }else{
            return $this->return_json(400,'查询失败');
        }
    }

    public function  edit($id=''){
        $a = $this->quanxian_check(input('uid'));
        if ($a !== 1) {
            return $this->return_json(400,'您没有权限');
        }
        if(request()->isPost()){
            $data=input('post.');
            $validata=validate('Grade');
            if($validata->scene('add')->check($data)){
                $id=[
                    'id'=>$data['id'],
                ];
                if($this->grade->save($data,$id)){
                    return $this->return_json(200,'修改成功');
                }else{
                    return $this->return_json(400,'修改失败');
                }
            }else{
                return $this->return_json(400,$validata->getError());
            }
        }
        $grades=$this->grade->findlsts();
        $departments=$this->department->field('id,department_name')->select();
        $lastdata = [
            'grades' => $grades,
            'department' => $departments,
        ];
        if($lastdata){
            return $this->return_json(200,'查询成功',$lastdata);
        }else{
            return $this->return_json(400,'查询失败');
        }
    }

    public function del($id=''){
        $a = $this->quanxian_check(input('uid'));
        if ($a !== 1) {
            return $this->return_json(400,'您没有权限');
        }
        if($this->grade::destroy($id)){
            return $this->return_json(200,'删除成功');
        }else{
            return $this->return_json(400,'删除失败');
        }
    }
}