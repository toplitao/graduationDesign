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
            echo "<script>alert('用户名或账号错误');</script>";
        }
    }
}
