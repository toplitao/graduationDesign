<?php
namespace app\index\Controller;
use think\View;
use think\DB;
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
        print_r($user);
        if(!empty($user)){
            Session::set('user_id',$user['id']);
            $this->redirect($this->request->domain.'/web/apply_repair/write_apply_repair');
        }
    }
}
