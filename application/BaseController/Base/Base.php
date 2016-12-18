<?php
namespace app\BaseController\Base;

use think\Request;
use think\View;
use think\Db;
use think\Controller;

class Base extends Controller
{
    protected $view;
    protected $request;
    protected $user;
    public function __construct(){
        $this->view=new View;
        $this->request=Request::instance();
        $this->_OnInit();
    }

}