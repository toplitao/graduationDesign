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
        $user=DB('user')->where('username',$data['username'])
        ->where('password',$data['password'])
        ->find();
        if(!empty($user)){
            Session::set('uid',$user['id']);
            $this->redirect(Url::build('/web/apply_repair/write_apply_repair','',false));
        }
    }
}
