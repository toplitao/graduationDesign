<?php
namespace app\Web\Controller;

use app\base\CommonBase;

class Help extends CommonBase{

    private $userinfo;
    private $nav;
    public function __construct(){
        parent::__construct();
        if($this->_OnInit()) {
            $this->userinfo = $this->_OnInit();
        }
        $this->nav = $this->getAllNews();
    }

    public function news() {
        $data['code'] = 4;
        $data['userInfo'] = $this->userinfo;
        $data['list'] = db('news')->where(['id'=>$this->request->param('id')])->find();
        $data['nav'] = $this->nav;
        $data['news_id'] = $this->request->param('id');
        return $this->view->fetch('question',$data);
    }

}
