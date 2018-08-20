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

class AdminCommon extends Controller{
	private $quanxian;
	public function __construct(){
		parent::__construct();
		$this->tokenObj = model('token');
		$arr = [
			'uid' => input('uid'),
			'token' => input('token'),
		];
		if (!($this->check_token($arr))) {
			$data = [
				'code' => 400,
				'msg' => '未登录',
			];
			echo json_encode($data);
			exit;
		}
	}

	
	public function return_json($code,$msg='',$data=[]){
		$return_data['code'] = $code;
		$return_data['msg'] = $msg;
		$return_data['data'] = $data;
		return json($return_data);
	}

	public function set_token($data){
		$token = md5('api_'.md5($data['admin_username'])
			.md5($data['admin_password']).time().'_api');
		return $token;
	}

	public function check_token($arr){
		if (!isset($arr['token'])||empty($arr['token'])) {
			return false;
		}
		$tokens = $this->tokenObj->where('uid',$arr['uid'])->find();
		if ($arr['token']==$tokens['token']){
			return true;
		}else{
			return false;
		}
	}

	public function quanxian_check($uid){
		$this->adminObj = model('admin');
		$data = $this->adminObj->where('admin_username',$uid)->find();
		return $data['manage'];
	}

}