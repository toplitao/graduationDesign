<?php
namespace app\base;

use think\Session;
use think\Controller;
use think\Request;
use think\View;

class CommonBase extends Controller{
    protected $view;
    protected $request;
    public function __construct(){
        parent::__construct();
        $this->view=new View;
        $this->request=Request::instance();
    }

    protected function _OnInit(){
        $userinfo = Session::get('userinfo');
        return $userinfo;
    }
    

}