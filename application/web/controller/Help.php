<?php
namespace app\Web\Controller;

use think\Request;
use think\View;
use think\Db;
use app\base\CommonBase;

class Help extends CommonBase{
    private $userinfo;
    public function __construct(){
        parent::__construct();
        if(!$this->_OnInit()){
            echo "<script>请先进行登录</script>";
            return false;
        }else{
            $this->userinfo = $this->_OnInit();
        }

    }
    public function question() {
        return $this->view->fetch('question');
    }
    public function baoyang() {
        $data['code'] = 4;
        $data['userInfo'] = $this->userinfo;
        return $this->view->fetch('baoyang',$data);
    }

}
