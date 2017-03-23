<?php
namespace app\Web\Controller;

use think\Request;
use think\View;
use think\Db;
use app\base\CommonBase;

class Help extends CommonBase
{
    protected $view;
    protected $request;
    public function __construct(){
        $this->view=new View;
        $this->request=Request::instance();
        if(!$this->_OnInit()){
//            header('location:/index/index/login');
        }else{
            $this->user = $this->_OnInit();
        }
    }
    public function question() {
        return $this->view->fetch('question');
    }
    public function baoyang() {
        $data['code'] = 4;
        $data['userInfo'] = $this->user;
        return $this->view->fetch('baoyang',$data);
    }

}
