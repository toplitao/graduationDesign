<?php
/**
 * Created by PhpStorm.
 * User: ssl
 * Date: 2017/3/23
 * Time: 21:35
 */
namespace app\Web\Controller;

use think\Request;
use think\View;
use think\Db;
use app\base\CommonBase;

class StagnationPoint extends CommonBase{

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
        $data['code'] = 5;
        return $this->view->fetch('index',$data);
    }

}
