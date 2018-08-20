<?php
namespace app\api\controller;
use app\common\model;
use think\validate;
class Bed extends AdminCommon{

	/*助手函数实例model admin*/
	private $build;
	private $dorm;
	private $bed;
	public function _initialize(){
		$this->build = model('build');
		$this->dorm = model('dorm');
		$this->bed=model('bed');
		$this->student = model('student');
	}

	public function lst(){
		$bedres = $this->bed->findlst();
		if ($bedres) {
			return $this->return_json(200,'查询成功',$bedres);
		}else if (empty($dump)){
			return $this->return_json(200,'没有值');
		}else{
			return $this->return_json(400,'查询失败');
		}
	}
	public function childres($id=''){
		$lcres =  $this->bed->where('dorm_id',$id)->select();
		if ($lcres) {
			return $this->return_json(200,'查询成功',$lcres);
		}else if (empty($dump)){
			return $this->return_json(200,'没有值');
		}else{
			return $this->return_json(400,'查询失败');
		}
	}

	// public function add(){
	// 	$a = $this->quanxian_check(input('uid'));
	// 	if ($a !== 1) {
	// 		return $this->return_json(400,'您没有权限');
	// 	}
	// 	if (request()->isPost()) {
	// 		$data = input('post.');
	// 		$validate = validate('cw');
	// 		/*验证*/
	// 		if($validate->check($data)){
	// 			if($this->bed->save($data)){
	// 				return $this->return_json(200,'添加成功');
	// 			}else{
	// 				return $this->return_json(400,'添加失败');
	// 			}
	// 		}else{
	// 			return $this->return_json(400,$validate->getError());
	// 		}
	// 	}
	// 	$buildres = $this->build->field('id,build')->select();
	// 	if ($buildres) {
	// 		return $this->return_json(200,'查询成功',$buildres);
	// 	}else if(empty($buildres)){
	// 		return $this->return_json(200,'没有值');
	// 	}else{
	// 		return $this->return_json(200,'没有值');
	// 	}
	// }

	public function edit($id=''){
		$a = $this->quanxian_check(input('uid'));
		if ($a !== 1) {
			return $this->return_json(400,'您没有权限');
		}
			if (request()->isPost()) {
			$data = input('post.');
			$validate = validate('bed');
			/*验证*/
			if($validate->check($data)){
				$id = $data['id'];
				if($this->bed->save($data,$id)){
					return $this->return_json(200,'修改成功');
				}else{
					return $this->return_json(400,'修改失败');
				}
			}else{
				return $this->return_json(400,$validate->getError());
			}
		}
		$beds = $this->bed->findlsts();
		$buildres = $this->build->select();
		$students = $this->student->select();
		$lastdata['beds'] = $beds;
		$lastdata['buildres'] = $buildres;
		$lastdata['students'] = $students;
		if ($lastdata) {
			return $this->return_json(200,'查询成功',$lastdata);
		}else if(empty($lastdata)){
			return $this->return_json(200,'没有值');
		}else{
			return $this->return_json(200,'没有值');
		}
	}

	public function del($id=''){
		$a = $this->quanxian_check(input('uid'));
		if ($a !== 1) {
			return $this->return_json(400,'您没有权限');
		}
		if ($this->bed::destroy($id)) {
			return $this->return_json(200,'删除成功');
		}else{
			return $this->return_json(400,'删除失败');
		}
	}
}