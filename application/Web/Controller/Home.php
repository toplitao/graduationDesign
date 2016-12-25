<?php
namespace app\Web\Controller;

use think\Request;
use think\View;
use think\Db;

class Home 
{
    protected $view;
    protected $request;
    public function __construct(){
        $this->view=new View;
        $this->request=Request::instance();
    }
    public function home()
    {
        return $this->view->fetch('home');
    }

}
