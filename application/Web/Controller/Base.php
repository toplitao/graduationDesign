<?php
namespace app\Web\Controller;

use think\Controller;
use think\Request;
use think\View;

class Base extends Controller
{
    protected $view;
    protected $request;
    public function __construct(){
        // $this->beforeActionList();
        $this->view=new View;
        $this->request=Request::instance();
    }
}