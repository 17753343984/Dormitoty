<?php
namespace app\common\model;
use think\Model;
use think\Db;
use think\Session;
class Student extends Model{

	public function find(){
		$studentres = $this->select();
	}

	public function findlsts(){
		//1.设置视图查询条件
		$table1 = ['ts_student'=>'a'];//设置第1张表及表别名
  		$table2 = ['ts_studentx'=>'b'];   //设置第2张表及表别名ts_department
  		$table3 = ['ts_department'=>'c']; 
  		$table4 = ['ts_fd' => 'd'];
  		$table5 = ['ts_grade' => 'e'];
  		$field1 = ['id','student_id','student_cardid','student_sex','student_name']; //设置第1张表字段别名
  		$field2 = ['id'=>'studentx_id','xxstudent_birthday','xxstudent_phone','xxstudent_place','xxstudent_addres','xxstudent_major','xxstudent_job','xxstudent_fphone','xxstudent_mphone','xxdepartment_id','fd_id','class_id'];  //设置第2张表字段别名department_name
  		$field3 = ['department_name'];  //设置第2张表字段别名
  		$field4 = ['fd_name'];
  		$field5 = ['class_name'];
  		$on = 'a.id = b.student_id';   //设置2张表连接条件
  		$on1 = 'b.xxdepartment_id=c.id';
  		$on2 = 'b.fd_id=d.id';
  		$on3 = 'b.class_id=e.id';
  		$type = 'LEFT';    //设置连接类型为左连接
  		//2.设置查询条件（数组方式进行批量设置）  
  		$where = [];
        if (input('id')) {
        	$where['id'] = ['=',input('id')];
        }
  		// $where['age'] = ['>=',40];
  		// $where['salary'] = ['<=',8000]; 
  		//3.设置排序条件
  		//$order = ['salary'=>'desc'];

  		//4.设置输出数量



  		//1.执行多表视图查询
  		$result = Db::view($table1,$field1) //设置第1张表的表名与字段名
          	-> view($table2,$field2,$on,$type)
          	 -> view($table3,$field3,$on1,$type)
          	 -> view($table4,$field4,$on2,$type)
          	 -> view($table5,$field5,$on3,$type)  //设置第1张表的表名与字段名,连接条件和连接类型
          	-> where($where)    //设置查询条件    //设置结果排序条件
          	-> find();    //获取结果集

  		//4.输出结果
  		return $result;
	}


	public function login($data){
		$info = $this->where('student_id',$data["admin_username"])->find();
		if ($info) {
			if ($info['student_cardid']==$data['admin_password']) {
				return $info['id'];
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}