<?php
namespace app\api\controller;
use app\Common\Model;
use think\validate;
use think\Exception;
class Fd extends AdminCommon{
    private $fd;
    private $depart;
    public function _initialize()
    {
        $this->fd=model('Fd');
        $this->depart=model('department');
    }
    public function lst()
    {
        $fds=$this->fd->findlst();
        if($fds)
        {
            return $this->return_json(200,'查询成功',$fds);
        }else{
            return $this->return_json(400,'查询失败');
        }
    }
    public function childres($id='')
    {
        $fds=$this->fd->field('id,fd_name')->where('department_id',$id)->select();
        if($fds)
        {
            return $this->return_json(200,'查询成功',$fds);
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
            $validata=validate('Fd');
            if($validata->scene('add')->check($data)){
                if($this->fd->save($data)){
                    return $this->return_json(200,'添加成功');
                }else{
                    return $this->return_json(400,'添加失败');
                }
            }else{
                return $this->return_json(400,$validata->getError());
            }
        }
        $departnames=$this->depart->field('id,department_name')->select();
        if($departnames){
            return $this->return_json(200,'查询成功',$departnames);
        }else{
            return $this->return_json(400,'查询失败');
        }
    }

    public function edit($id=''){
        $a = $this->quanxian_check(input('uid'));
        if ($a !== 1) {
            return $this->return_json(400,'您没有权限');
        }
        if(request()->isPost()){
            $data=input('post.');
            $validata=validate('Fd');
            if($validata->scene('add')->check($data)){
                $id=[
                    'id'=>$data['id'],
                ];
                if($this->fd->save($data,$id)){
                    return $this->return_json(200,'修改成功');
                }else{
                    return $this->return_json(400,'修改失败');
                }
            }else{
                return $this->return_json(400,$validata->getError());
            }
        }
        $fd=$this->fd::get($id);
        $departnames=$this->depart->field('id,department_name')->select();
        $lastdata['fd']=$fd;
        $lastdata['departnames']=$departnames;
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
        try{
            if($this->fd::destroy($id)){
                return $this->return_json(200,'删除成功');
            }else{
                return $this->return_json(400,'删除失败');
            }
        }catch(Exception $e){
            return $this->return_json(400,'删除失败,有子级属性');
        }
        
    }
}