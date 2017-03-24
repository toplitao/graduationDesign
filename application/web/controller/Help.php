<?php
namespace app\Web\Controller;

use app\base\CommonBase;

class Help extends CommonBase{

    private $userinfo;
    public function __construct(){
        parent::__construct();
        if($this->_OnInit()) {
            $this->userinfo = $this->_OnInit();
        }
    }

    public function question() {
        $data['code'] = 4;
        $data['userInfo'] = $this->userinfo;
        return $this->view->fetch('question',$data);
    }
    public function baoyang() {
        $data['code'] = 4;
        $data['userInfo'] = $this->userinfo;
        return $this->view->fetch('baoyang',$data);
    }
    public function about() {
        $data['code'] = 4;
        $data['userInfo'] = $this->userinfo;
        return $this->view->fetch('about',$data);
    }

}
