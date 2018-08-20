<?php
namespace app\api\controller;
use app\common\model;
use think\validate;
class Admin extends AdminCommon{
	/*助手函数实例model admin*/
	private $obj;
	public function _initialize(){
		$this->obj = model('admin');
		$this->tokenObj = model('token');
	}
	/*查询*/
	public function lst(){
		$adminres = $this->obj->field('id,admin_username,manage')->select();
		if($adminres){
			return $this->return_json(200,'查询成功',$adminres);
		}else if (empty($dump)){
			return $this->return_json(200,'没有值');
		}else{
			return $this->return_json(400,'查询失败');
		}
	}

	/*添加*/
	public function add(){
		$a = $this->quanxian_check(input('uid'));
		if ($a !== 1) {
			return $this->return_json(400,'您没有权限');
		}
		if (request()->isPost()) {
			$data = input('post.');
			$validate = validate('admin');
			if ($validate->scene('add')->check($data)){
				if ($data['admin_password'] == $data['passwords_check']){
					$lastdata=[
						'admin_username' => $data['admin_username'],
						'admin_password' => md5($data['admin_password']),
						'manage'=> $data['manage']
					];
					if ($this->obj->save($lastdata)) {
						return $this->return_json(200,'添加成功');
					}else{
						return $this->return_json(400,'添加失败');
					}
				}else{
					return $this->return_json(400,'两次密码输入错误');
				}
			}else{
				return $this->return_json(400,$validate->getError());
			}
		}
	}

	/* 修改 get post*/
	public function edit($id=''){
		$a = $this->quanxian_check(input('uid'));
		if ($a !== 1) {
			return $this->return_json(400,'您没有权限');
		}
		if (request()->isPost()) {
			$data = input('post.');
			$validate = validate('admin');
			if ($validate->scene('add')->check($data)){
				if ($data['admin_password'] == $data['passwords_check']) {
					$lastdata=[
						'admin_username' => $data['admin_username'],
						'admin_password' => md5($data['admin_password']),
						'manage'=> $data['manage']
					];
					$id = [
						'id' => $data['id']
					];
					if ($this->obj->save($lastdata,$id)) {
						return $this->return_json(200,'修改成功');
					}else{
						return $this->return_json(400,'修改失败');
					}
				}else{
					return $this->return_json(400,'两次密码输入错误');
				}
			}else{
				return $this->return_json(400,$validate->getError());
			}
		}
		$admins = $this->obj->field('id,admin_username,manage')->where('id',$id)->find();
		if ($admins) {
			return $this->return_json(200,'查询成功',$admins);
		}else{
			return $this->return_json(400,'查询失败',$admins);
		}
		
	}

	/* 删除 */
	public function del($id=''){
		$a = $this->quanxian_check(input('uid'));
		if ($a !== 1) {
			return $this->return_json(400,'您没有权限');
		}
		$data = $this->obj->findlst();
		if ($data['admin_username']=='admin') {
			return $this->return_json(400,'此管理员不能被删除');
		}
		if ($data['token_id'] !== null){
			$this->tokenObj::destroy(['id'=>$data['token_id']]);
		}
		if ($this->obj::destroy(['id'=>$data['id']])){
			return $this->return_json(200,'删除成功');
		}else{
			return $this->return_json(400,'删除失败');
		}
	}


}