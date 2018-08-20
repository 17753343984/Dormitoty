<?php
namespace app\api\controller;
use app\common\model;
use think\validate;
use think\Paginator;
use think\Exception;
use think\Db;
class Dorm extends AdminCommon{

	/*助手函数实例model admin*/
	private $build;
	private $dorm;
	public function _initialize(){
		$this->build = model('build');
		$this->dorm = model('dorm');
	}

	public function lst(){
		$dormres = $this->dorm->findlst();
		if ($dormres) {
			return $this->return_json(200,'查询成功',$dormres);
		}else if (empty($dump)){
			return $this->return_json(200,'没有值');
		}else{
			return $this->return_json(400,'查询失败');
		}
	}

	public function childres($id=''){
		$lcres =  $this->dorm->where('build_id',$id)->order('dorm_name desc')->select();
		if ($lcres){
			return $this->return_json(200,'查询成功',$lcres);
		}else if (empty($dump)){
			return $this->return_json(200,'没有值');
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


	public function add(){
		$a = $this->quanxian_check(input('uid'));
		if ($a !== 1) {
			return $this->return_json(400,'您没有权限');
		}
		if (request()->isPost()) {
			$data = input('post.');
			$validate = validate('dorm');
			if($validate->check($data)){
				if($this->dorm->save($data)){
					return $this->return_json(200,'添加成功');
				}else{
					return $this->return_json(400,'添加失败');
				}
			}else{
				return $this->return_json(400,$validate->getError());
			}
		}
		$buildres = $this->build->field('id,build_name')->select();
		if ($buildres) {
			return $this->return_json(200,'查询成功',$buildres);
		}else if(empty($buildres)){
			return $this->return_json(200,'没有值');
		}else{
			return $this->return_json(200,'没有值');
		}
	}

	public function edit($id=''){
		$a = $this->quanxian_check(input('uid'));
		if ($a !== 1) {
			return $this->return_json(400,'您没有权限');
		}
		if (request()->isPost()) {
			$data = input('post.');
			$validate = validate('dorm');
			/*验证*/
			if($validate->check($data)){
				$id = $data['id'];
				if($this->dorm->save($data,$id)){
					return $this->return_json(200,'修改成功');
				}else{
					return $this->return_json(400,'修改失败');
				}
			}else{
				return $this->return_json(400,$validate->getError());
			}
		}
		$dorms = $this->dorm->findlsts();
		$buildres = $this->build->field('id,build_name')->select();
		$lastdata['dorms'] = $dorms;
		$lastdata['buildres'] = $buildres;
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
		try{
			if ($this->dorm::destroy($id)) {
				return $this->return_json(200,'删除成功');
			}else{
				return $this->return_json(400,'删除失败');
			}
		}catch(Exception $e){
			return $this->return_json(400,'删除失败,有子级属性');
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
                    $sql = "INSERT INTO ts_dorm (dorm_name,lc_name,build_id) VALUES('".$str[0]."','".$str[1]."','".$str[2]."')";
                    echo $sql.'<br/>';
                    Db::query($sql);
                    $str = array();
                }
    		}
    	}
	}
	
}