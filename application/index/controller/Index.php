<?php
namespace app\index\Controller;

use app\base\CommonBase;
use think\Session;

class Index extends CommonBase{
    private $userinfo;
    public function __construct(){
        parent::__construct();
        if($this->_OnInit()) {
            $this->userinfo = $this->_OnInit();
        }
    }
    public function index(){
        $data['userInfo'] = $this->userinfo;
        $data['code'] = 1;
        return $this->view->fetch('web@home/home',$data);
    }
    public function login(){
        if($this->request->param()){
            $data = $this->request->param();
            $data['password'] = md5($data['password']);
            //普通用户
            if($data['userType'] == 1){
                $user=DB('user_info')->where('name',$data['username'])->where('password',$data['password'])->find();
            }
            //维修人员
            if($data['userType'] == 2){
                $user=DB('user')->where('username',$data['username'])->where('password',$data['password'])->find();
            }
            if(!empty($user)){
                $user['userType'] = $data['userType'];
                Session::set('userinfo',$user);
                if($user['userType'] == 1){ //普通用户
                    $url = '/index/index/index';
                }
                if($user['userType'] == 2){//维修人员
                    $url = '/admin/index/index';
                }
                return dr_show_return('200','登录成功',array('url'=>$url));
            }else{
                return dr_show_return('300','用户名或密码错误！');
            }
        }else{
            return $this->view->fetch('index@index/login');
        }

    }
    public function loginout(){
        Session::clear();
        $data['code'] = 1;
        return $this->view->fetch('web@home/home',$data);
    }
    /*
     * 注册新用户操作
     */
    public function register(){
    	if($this->request->param()){
    	    //普通用户
    	    if($this->request->param('level') == 1){
                $res = DB('user_info')->where('name',$this->request->param('username'))->find();
                if($res){
                    return dr_show_return(300, '该用户名已被注册！');
                }
            }
            //维修人员
            if($this->request->param('level') == 2){
                $res = DB('user')->where('username',$this->request->param('username'))->find();
                if($res){
                    return dr_show_return(300, '该用户名已被注册！');
                }
            }
			if(md5($this->request->param('password')) != md5($this->request->param('repassword'))){
				return dr_show_return(300, '两次输入密码不一致！');
			}
			//维修人员
			if($this->request->param('level') == 2){
				$data = array(
				                'username' => $this->request->param('username'),
				                'password' => md5($this->request->param('password')),
				                'level'    => 1,
				                'repair_address' =>$this->request->param('address'),
				                'iphone'   => $this->request->param('phone'),
				                'status' => 1,
                                'sid' => $this->request->param('sid'),
                                'created_at' => date('Y-m-d H:i:s',time()),
                                'img' =>  $this->request->param('img'),
							);
                $result=DB('user')->insertGetId($data);
			}
			//普通用户
			if($this->request->param('level') == 1){
				$data = array(
								  'name' => $this->request->param('username'),
		  		                  'password' => md5($this->request->param('password')),
					              'address' =>$this->request->param('address'),
			         	          'phone'   => $this->request->param('phone'),
                                  'email'   => $this->request->param('email'),
                                  'created_at' => date('Y-m-d H:i:s',time())
							 );
                $result=DB('user_info')->insertGetId($data);
			}
			if($result){
				$url = "/index/index/login";
				return dr_show_return(200, '注册成功，请登录！',array('url'=>$url));
			}
			return dr_show_return(300, '注册失败！');
    	}
        $data['list'] = Db('station')->select();
        return $this->view->fetch('index@index/register',$data);
    } 
    /*
     * 忘记密码找回操作
     */
//    public function forgetPassword(){
//        $code = '';
//    	if($this->request->param()){
//    		/*生成随即的4位随机码*/
//			for($i=1;$i<=4;$i++){
//				$code.= rand(0,9);
//			}
//			setcookie('code',$code,120);//验证码两分钟内有效
//    	}
//        return $this->view->fetch('forget_password');
//    }
    /*
     * ajax异步验证用户名是否被注册
     */
//    public function ajaxCheckUsername(){
//         $data=$this->request->param();
//         $res = db("user")->where('username',$data['username'])->select();
//         if($res){
//             dr_show_return(2,'该用户名已被注册');
//         }else{
//             dr_show_return(1,'该用户可以注册');
//         }
//    }
    /*
     * ajax异步验证登录密码
     */
//    public function ajaxCheckPassword(){
//         $data=$this->request->param();
//         $rule = '/^[a-zA-Z0-9]{6,12}$/';
//         $res = preg_match($rule,$data['password']);
//         if($res){
//             return dr_show_return(1,'密码有效');
//         }else{
//             return dr_show_return(2,'密码格式不正确，请输入6-12位数字或字母');
//         }
//    }
	/**
	 * ajax异步上传图片
	 */
	public function ajaxUploadImg(){
            define("UPLOAD_ROOT", $_SERVER['DOCUMENT_ROOT'].'/media/img/');
            if (!file_exists (UPLOAD_ROOT)) {
                mkdir ( UPLOAD_ROOT, 0777, true );
            }
			//	获取表单上传文件
            $file = request()->file('image');
            $info = $file->move(UPLOAD_ROOT);
            if($info){
                $imgpath =  $info->getSaveName();
                return dr_show_return('200','上传成功',array('imgpath'=>$imgpath));
            }else{
                return dr_show_return('300','上传失败，'.$file->getError());
            }
	}

}
