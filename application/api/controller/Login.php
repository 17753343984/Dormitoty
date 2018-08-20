<?php
namespace app\api\controller;
use app\common\model;
use think\validate;
use think\Controller;
// 指定允许其他域名访问  
header('Access-Control-Allow-Origin:*');  
// 响应类型  
header('Access-Control-Allow-Methods:*');  
// 响应头设置  
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class Login extends Controller{

	private $admin;
    private $student;
    private $token;
	public function _initialize(){
		$this->admin = model('admin');
        $this->student = model('student');
        $this->token = model('token');
	}

    public function login(){
        if (request()->isPost()) {
            $data = input('post.');
            if ($data['position'] == 1) {
                $validate = validate('admin');
                if ($validate->scene('login')->check($data)) {
                    if ($this->admin->login($data)) {
                        $tokens = $this->token->where('uid',$data['admin_username'])->find();
                        if (empty($tokens)) {
                            $token = [
                                'uid' => $data['admin_username'],
                                'token' => $this->set_token($data),
                            ];
                            if ($this->token->save($token)) {
                                return $this->return_json(200,'登陆成功',$token);
                            }else{
                                return $this->return_json(400,'登陆失败',$token);
                            }
                        }else{
                            $token = [
                                'uid' => $data['admin_username'],
                                'token' => $this->set_token($data),
                            ];
                            $id =[
                                'id' => $tokens['id'],
                            ]; 
                            if ($this->token->save($token,$id)) {
                                return $this->return_json(200,'登陆成功',$token);
                            }else{
                                return $this->return_json(400,'登陆失败',$token);
                            }
                        } 
                    }else{
                        return $this->return_json(400,'用户名或密码不正确');
                    }
                }else{
                    return $this->return_json(400,$validate->getError());
                }
            }else{
                $validate = validate('admin');
                if ($validate->scene('login')->check($data)) {
                    $id = $this->student->login($data);
                    if ($id){
                        return $this->return_json(200,'登陆成功',$id);
                    }else{
                        return $this->return_json(400,'登陆失败');
                    }
                }else{
                    return $this->return_json(400,$validate->getError());
                }

            }

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
}