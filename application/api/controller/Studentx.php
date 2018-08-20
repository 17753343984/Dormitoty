<?php
namespace app\api\controller;
use think\Controller;
use think\model;
// 指定允许其他域名访问  
header('Access-Control-Allow-Origin:*');  
// 响应类型  
header('Access-Control-Allow-Methods:*');  
// 响应头设置  
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class Studentx extends Controller{
	public function __construct(){
		parent::__construct();
		$this->studentObj = model('student');
		$this->build = model('build');
		$this->dorm = model('dorm');
		$this->bed = model('bed');
		$this->department = model('department');
		$this->fd = model('fd');
		$this->grade = model('grade');
		$this->studentx = model('studentx');
		$arr = [
			'sid' => input('sid'),
		];
		if (!($this->check_id($arr))) {
			$data = [
				'code' => 400,
				'msg' => '未登录',
			];
			echo json_encode($data);
			exit;
		}
	}

	public function bedadd(){
		if (request()->isPost()) {
			$data = input('post.');
			$validate = validate('bed');
			/*验证*/
			if($validate->check($data)){
				if($this->bed->save($data)){
					return $this->return_json(200,'添加成功');
				}else{
					return $this->return_json(400,'添加失败');
				}
			}else{
				return $this->return_json(400,$validate->getError());
			}
		}
		$buildres = $this->build->order('id asc')->field('id,build_name')->select();
		if ($buildres) {
			return $this->return_json(200,'查询成功',$buildres);
		}else if(empty($buildres)){
			return $this->return_json(200,'没有值');
		}else{
			return $this->return_json(200,'没有值');
		}
	}


	public function xxstudentadd()
    {
        if(request()->isPost()){
            $data=input('post.');
            $validate = validate('Studentx');
            if($validate->check($data)){ 
                if($this->studentx->save($data)){
                    return $this->return_json(200,'添加成功');
                }else{
                    return $this->return_json(400,'添加失败');
                }
            }else{
                return $this->return_json(400,$validate->getError());
            }
        }
        $students = $this->studentObj->where('id',input('sid'))->find();
        $departmentres = $this->department->field('id,department_name')->select();
        $lastdata['students'] = $students;
        $lastdata['departmentres'] = $departmentres;
        return $this->return_json(200,'查询成功',$lastdata);
    }



	public function BuildChildres($id=''){
		$lcres =  $this->dorm->where('build_id',$id)->order('dorm_name desc')->select();
		if ($lcres){
			return $this->return_json(200,'查询成功',$lcres);
		}else if (empty($dump)){
			return $this->return_json(200,'没有值');
		}else{
			return $this->return_json(400,'查询失败');
		}
	}


	public function DeChildres($id='')
    {
        $fds=$this->fd->field('id,fd_name')->where('department_id',$id)->select();
        if($fds)
        {
            return $this->return_json(200,'查询成功',$fds);
        }else if(empty($fds)){
        	return $this->return_json(200,'没有值',$fds);
        }else{
            return $this->return_json(400,'查询失败');
        }
    }

    public function Fdchildres($id='')
    {
        $fds=$this->grade->field('id,class_name')->where('fd_id',$id)->select();
        if($fds)
        {
            return $this->return_json(200,'查询成功',$fds);
        }else{
            return $this->return_json(400,'查询失败');
        }
    }

    public function Grchildres($id='')
    {
        $grades=$this->grade->field('id,class_name')->where('fd_id',$id)->select();
        if($grades)
        {
            return $this->return_json(200,'查询成功',$grades);
            
        }else{
            return $this->return_json(400,'查询失败');
        }
    }

    public function sxchildres($buildid='',$lcid=''){
		$lcres =  $this->dorm->where('build_id',$buildid)->where('lc_name',$lcid)->order('dorm_name asc')->select();
		if ($lcres){
			return $this->return_json(200,'查询成功',$lcres);
		}else if (empty($dump)){
			return $this->return_json(200,'没有值');
		}else{
			return $this->return_json(400,'查询失败');
		}
	}

    public function check_id($arr){
		if (!isset($arr['sid'])||empty($arr['sid'])) {
			return false;
		}
		if ($this->studentObj->where('id',$arr['sid'])->find()) {
			return true;
		}else{
			return false;
		}
	}

	public function return_json($code,$msg='',$data=[]){
		$return_data['code'] = $code;
		$return_data['msg'] = $msg;
		$return_data['data'] = $data;
		return json($return_data);
	}
}