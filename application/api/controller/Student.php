<?php
namespace app\api\controller;
use app\common\model;
use think\validate;
use think\Exception;
use think\Paginator;
use think\Db;
class Student extends AdminCommon{

	private $student;
	public function _initialize(){
		$this->student = model('student');
        $this->studentx = model('studentx');
        $this->department = model('department');
	}


	public function lst(){
		$studentres = $this->student->Paginate(15);
		if ($studentres) {
			return $this->return_json(200,'查询成功',$studentres);
		}else if(empty($studentres)){
			return $this->return_json(200,'没有值');
		}else{
			return $this->return_json(400,'查询失败');
		}
	}

	public function Exceladd(){
        $a = $this->quanxian_check(input('uid'));
        if ($a !== 1) {
            return $this->return_json(400,'您没有权限');
        }
		if (request()->isPost()) {
    		Vendor('PHPExcel.PHPExcel');
    		Vendor('PHPExcel.PHPExcel.IOFactory');
    		$file = request()->file('excel');
    		if ($file) {
    			$file_types = explode(".", $_FILES ['excel'] ['name']); // ["name"] => string(25) "excel文件名.xls"
                $file_type = $file_types [count($file_types) - 1];//xls后缀
                $file_name = $file_types [count($file_types) - 2];//xls去后缀的文件名
                /*判别是不是.xls文件，判别是不是excel文件*/
                if (strtolower($file_type) != "xls" && strtolower($file_type) != "xlsx"){
                    echo '不是Excel文件，重新上传';
                    die;
                }
                $info = $file->move(ROOT_PATH . 'public' . DS . 'excel');//上传位置
                $path = ROOT_PATH . 'public' . DS . 'excel' . DS;
                $file_path = $path . $info->getSaveName();//上传后的EXCEL路径
                //echo $file_path;//文件路径
                //$objReader = \PHPExcel_IOFactory::createReader('Excel5');
                $objPHPExcel = \PHPExcel_IOFactory::load($file_path);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow(); // 取得总行数 
                $highestColumn = $sheet->getHighestColumn(); // 取得总列数
                $str = array();
                for($j=2;$j<=$highestRow;$j++){ 
                    for($k='A';$k<=$highestColumn;$k++){ 
                        $str[]= iconv("utf-8","utf-8",$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue());//读取单元格
                    }
                    $sql = "INSERT INTO ts_student (student_id,student_name,student_sex,student_cardid) VALUES('".$str[0]."','".$str[1]."','".$str[2]."','".$str[3]."')";
                    echo $sql.'<br/>';
                    Db::query($sql);
                    $str = array();
                }
    		}
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
            $validate = validate('student');
            $a = $validate->scene('add')->check($data);
            if($validate->scene('add')->check($data)){  
                if($this->student->save($data)){
                    return $this->return_json(200,'添加成功',$data);
                }else{
                    return $this->return_json(400,'添加失败');
                }
            }else{
                return $this->return_json(400,$validate->getError());
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
            $validata=validate('Student');
            if($validata->scene('add')->check($data)){
                $id=[
                    'id'=>$data['id'],
                ];
                if($this->student->save($data,$id)){
                    return $this->return_json(200,'修改成功');
                }else{
                    return $this->return_json(400,'修改失败');
                }
            }else{
                return $this->return_json(400,$validata->getError());
            }
        }
        $student=$this->student::get($id);
        // $students=$this->student->field('id,student_id,student_cardid,student_name')->select();
        // $lastdata['student']=$student;
        // $lastdata['departname']=$students;
        if($student){
            return $this->return_json(200,'查询成功',$student);
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
            if($this->student::destroy($id)){
                    return $this->return_json(200,'删除成功');
            }else{
                return $this->return_json(400,'删除失败');
            }
        }catch(Exception $e){
            return $this->return_json(400,'该学生有床位，请先删除床位');
        }
        
    }

    public function studentxx(){
        if(request()->isPost()){
            $data=input('post.');
            $validate = validate('Studentx');
            if($validate->check($data)){
                $id = [
                    'id'=>input('id'),
                ];
                if($this->studentx->save($data,$id)){
                    return $this->return_json(200,'修改成功');
                }else{
                    return $this->return_json(400,'修改失败');
                }
            }else{
                return $this->return_json(400,$validate->getError());
            }
        }
        $students = $this->student->findlsts();
        $departmentres = $this->department->field('id,department_name')->select();
        $lastdata['students'] = $students;
        $lastdata['departmentres'] = $departmentres;
        if ($students) {
            return $this->return_json(200,'查询成功',$lastdata);
        }else{
            return $this->return_json(200,'没有该学生信息',$lastdata);
        } 
    }
}