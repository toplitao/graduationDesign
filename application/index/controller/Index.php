<?php
namespace app\index\Controller;
use app\base\CommonBase;
use think\View;
use think\DB;
use think\Url;
use think\Session;
use think\Request;

class Index extends CommonBase{
    private $userinfo;
    public function __construct(){
        parent::__construct();
        if(!$this->_OnInit()){
            echo "<script>请先进行登录</script>";
            return false;
        }else{
            $this->userinfo = $this->_OnInit();
        }

    }
    public function index(){
        $data['userInfo'] = $this->userinfo;
        $data['code'] = 1;
        return $this->view->fetch('web@home/home',$data);
    }
    public function login(){
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
    		$username =$this->request->param('username');
			//验证用户名时候已注册
			$res =DB('user')->where('username',$username)->find();
			if($res){
				return dr_show_return(2, '该用户名已被注册！');
			}
			if(md5($this->request->param('password')) != md5($this->request->param('repassword'))){
				return dr_show_return(2, '两次输入密码不一致！');
			}
			if($this->request->param('level') == 2){
				$data = array(
				                'username' => $this->request->param('username'),
				                'password' => md5($this->request->param('password')),
				                'level'    => $this->request->param('level'),
				                'repairAddress' =>$this->request->param('address'),
				                'iphone'   => $this->request->param('iphone'),
				                'img'      => $this->request->param('img'),
				                'status' => 1
							);
			}
			if($this->request->param('level') == 1){
				$data = array(
								  'username' => $this->request->param('username'),
		  		                  'password' => md5($this->request->param('password')),
				                  'level'    => $this->request->param('level'),
					              'repairAddress' =>$this->request->param('address'),
			        	          'iphone'   => $this->request->param('iphone'),
			            	      'status' => 1						                     
							 );
			}			
			$result=DB('user')->insertGetId($data);
			if($result){
				$url = "/index/index/index";
				return dr_show_return(1, '注册成功！',$url);
			}
			return dr_show_return(2, '注册失败！');
    	}
		return $this->view->fetch('register');
    } 
    /*
     * 忘记密码找回操作
     */
    public function forgetPassword(){
        $code = '';
    	if($this->request->param()){
    		/*生成随即的4位随机码*/
			for($i=1;$i<=4;$i++){
				$code.= rand(0,9);
			}
			setcookie('code',$code,120);//验证码两分钟内有效
    	}
        return $this->view->fetch('forget_password');
    } 
    /*
     * ajax异步验证用户名是否被注册
     */
    public function ajaxCheckUsername(){
         $data=$this->request->param();
         $res = db("user")->where('username',$data['username'])->select();
         if($res){
             dr_show_return(2,'该用户名已被注册');
         }else{
             dr_show_return(1,'该用户可以注册');
         }
    } 
    /*
     * ajax异步验证登录密码
     */
    public function ajaxCheckPassword(){
         $data=$this->request->param();
         $rule = '/^[a-zA-Z0-9]{6,12}$/';
         $res = preg_match($rule,$data['password']);
         if($res){
             return dr_show_return(1,'密码有效');
         }else{
             return dr_show_return(2,'密码格式不正确，请输入6-12位数字或字母');
         }
    } 
    
	/**
	 * ajax异步上传图片
	 */
	public function ajaxUploadImg(){
			define("UPLOAD_ROOT", dirname(dirname(dirname(dirname(__FILE__)))));
			//	获取表单上传文件			
			$files	=	request()->file('img');	
			foreach($files	as	$file){
				$info	=	$file->move(UPLOAD_ROOT.'/public/media/img/');									
				if($info){
					//	成功上传后	获取上传信息								
					return dr_show_return(1,'上传成功','',$info->getSaveName());					
				}else{
					//	上传失败获取错误信息	
					return dr_show_return(2,'上传失败','',$file->getError());								
				}								
			} 
	} 
}
