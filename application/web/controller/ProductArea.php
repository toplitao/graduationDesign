<?php
/**
 * Created by PhpStorm.
 * User: ssl
 * Date: 2017/3/23
 * Time: 22:25
 */

namespace app\Web\Controller;

use app\base\CommonBase;

class ProductArea extends CommonBase{

    private $userinfo;
    public function __construct(){
        parent::__construct();
        if($this->_OnInit()) {
            $this->userinfo = $this->_OnInit();
        }
    }

    public function index() {
        $data['code'] = 6;
        $data['userInfo'] = $this->userinfo;
        return $this->view->fetch('index',$data);
    }
    public function description() {
        $data['code'] = 6;
        $data['userInfo'] = $this->userinfo;
        return $this->view->fetch('description',$data);
    }

}
