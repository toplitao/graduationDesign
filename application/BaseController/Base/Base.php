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
    public function __construct(){
        $this->_OnInit();
        $this->view=new View;
        $this->request=Request::instance();
    }

}