<?php
namespace app\common\model;
use think\Model;
use think\Db;
use think\Paginator;
class Grade extends Model
{
	public function findlst(){
		//1.设置视图查询条件
		  $table1 = ['ts_grade'=>'a'];//设置第1张表及表别名
  		$table2 = ['ts_department'=>'b'];   //设置第2张表及表别名ts_department
  		$table3 = ['ts_fd'=>'c'];    //设置第3张表及表别名
  		$field1 = ['id','class_name']; //设置第1张表字段别名
  		$field2 = ['id'=>'department_id','department_name'];  //设置第2张表字段别名department_name
  		$field3 = ['id'=>'fd_id','fd_name'];  //设置第2张表字段别名
  		$on = 'a.department_id = b.id';   //设置2张表连接条件
  		$on1 = 'a.fd_id=c.id';
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
  		//$num = 100;


  		//1.执行多表视图查询
  		$result = Db::view($table1,$field1) //设置第1张表的表名与字段名
          	-> view($table2,$field2,$on,$type)
          	-> view($table3,$field3,$on1,$type)  //设置第1张表的表名与字段名,连接条件和连接类型
          	-> where($where)    //设置查询条件    //设置结果排序条件
            //-> limit($num)   // 设置输出记录数量
          	-> paginate(15);    //获取结果集

  		//4.输出结果
  		return $result;
	}

  public function findlsts(){
    //1.设置视图查询条件
      $table1 = ['ts_grade'=>'a'];//设置第1张表及表别名
      $table2 = ['ts_department'=>'b'];   //设置第2张表及表别名ts_department
      $table3 = ['ts_fd'=>'c'];    //设置第3张表及表别名
      $field1 = ['id','class_name']; //设置第1张表字段别名
      $field2 = ['id'=>'department_id','department_name'];  //设置第2张表字段别名department_name
      $field3 = ['id'=>'fd_id','fd_name'];  //设置第2张表字段别名
      $on = 'a.department_id = b.id';   //设置2张表连接条件
      $on1 = 'a.fd_id=c.id';
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
      //$num = 100;


      //1.执行多表视图查询
      $result = Db::view($table1,$field1) //设置第1张表的表名与字段名
            -> view($table2,$field2,$on,$type)
            -> view($table3,$field3,$on1,$type)  //设置第1张表的表名与字段名,连接条件和连接类型
            -> where($where)    //设置查询条件    //设置结果排序条件
            //-> limit($num)   // 设置输出记录数量
            -> find();    //获取结果集

      //4.输出结果
      return $result;
  }
}