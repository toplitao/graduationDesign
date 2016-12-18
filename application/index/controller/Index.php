<?php
namespace app\index\Controller;
use think\View;
use think\DB;
use think\Url;
use think\Session;
use think\Request;
use think\Controller;

class Index extends Controller
{
    protected $view;
    protected $request;
    public function __construct(){
        $this->view=new View;
        $this->request=Request::instance();
    }
    public function index()
    {
        return $this->view->fetch('Login');
    }
    public function login(){
        $data=$this->request->param();
        $data['password'] = md5($data['password']);
        $user=DB('user')->where('username',$data['username'])
        ->where('password',$data['password'])
        ->find();
        if(!empty($user)){
            Session::set('uid',$user['id']);
            if($user['level'] == 1){
                $url = '/web/apply_repair/write_apply_repair';
            }else{
                $url = '/admin/system_admin/admin_index';
            }
            $this->redirect(Url::build($url,'',false));
        }else{
            $url ="'/index/index/index'";
            echo "<script>alert('用户名或账号错误！');</script>";
            echo "<script>window.location = ".$url."</script>";
        }
    }
    /*
     * 注册新用户操作
     */
    public function register(){
         return $this->view->fetch('register');
    } 
    /*
     * 忘记密码找回操作
     */
    public function forgetPassword(){
        return $this->view->fetch('forgetPassword');
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
             dr_show_return(1,'密码有效');
         }else{
             dr_show_return(2,'密码格式不正确，请输入6-12位数字或字母');
         }
    } 
}
