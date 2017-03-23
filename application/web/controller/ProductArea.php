<?php
/**
 * Created by PhpStorm.
 * User: ssl
 * Date: 2017/3/23
 * Time: 22:25
 */

namespace app\Web\Controller;

use think\Request;
use think\View;
use think\Db;
use app\base\CommonBase;

class ProductArea extends CommonBase{

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

    public function index() {
        $data['code'] = 6;
        return $this->view->fetch('index',$data);
    }

}
