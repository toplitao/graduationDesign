<?php
namespace app\Web\Controller;

use think\Request;
use think\View;
use think\Db;

class Help 
{
    protected $view;
    protected $request;
    public function __construct(){
        $this->view=new View;
        $this->request=Request::instance();
    }
    public function question() {
        return $this->view->fetch('question');
    }
    public function baoyang() {
        return $this->view->fetch('baoyang');
    }

}
