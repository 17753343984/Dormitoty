<?php
namespace app\api\controller;
use app\common\model;
use think\validate;
use think\Exception;
use think\Paginator;
class Build extends AdminCommon{

	/*助手函数实例model admin*/
	private $obj;
	public function _initialize(){
		$this->obj = model('build');
	}
	public function lst(){
		$buildres =  $this->obj->select();
		//$count = $this->obj->Paginate(10);
		if ($buildres) {
			return $this->return_json(200,'查询成功',$buildres);
		}else if (empty($dump)){
			return $this->return_json(200,'没有值');
		}else{
			return $this->return_json(400,'查询失败');
		}
	}

	public function add(){
		$a = $this->quanxian_check(input('uid'));
		if ($a !== 1) {
			return $this->return_json(400,'您没有权限');
		}
		if (request()->isPost()) {
			$data = input('post.');
			$validate = validate('build');
			if ($validate->check($data)) {
				if($this->obj->save($data)){
					return $this->return_json(200,'添加成功');
				}else{
					return $this->return_json(400,'添加失败');
				}
			}else{
				return $this->return_json(400,$validate->getError());
			}
		}
	}

	public function edit($id=''){
		$a = $this->quanxian_check(input('uid'));
		if ($a !== 1) {
			return $this->return_json(400,'您没有权限');
		}
		if (request()->isPost()) {
			$data = input('post.');
			$validate = validate('build');
			if ($validate->check($data)) {
				$id = $data['id'];
				if($this->obj->save($data,$id)){
					return $this->return_json(200,'修改成功');
				}else{
					return $this->return_json(400,'修改失败');
				}
			}else{
				return $this->return_json(400,$validate->getError());
			}
		}
		$builds = $this->obj::get($id);
		if ($builds) {
			return $this->return_json(200,'查询成功',$builds);
		}else{
			return $this->return_json(400,'查询失败',$builds);
		}
	}

	public function del($id=''){
		$a = $this->quanxian_check(input('uid'));
		if ($a !== 1) {
			return $this->return_json(400,'您没有权限');
		}
		try{
			if ($this->obj::destroy($id)) {
				return $this->return_json(200,'删除成功');
			}else{
				return $this->return_json(400,'删除失败');
			}
		}catch(Exception $e){
			return $this->return_json(400,'请删除该楼层下的子分类');
		}
	}
}
