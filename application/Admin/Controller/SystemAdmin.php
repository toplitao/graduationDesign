<?php
namespace app\Admin\Controller;

use think\Request;
use think\View;
use think\Db;
use think\Session;
use app\BaseController\CommonBase;

class SystemAdmin extends CommonBase
{
    //后台首页
    public function admin_index() {
        
        $list = db('applyrepair')->where(['status'=>0])->select();
        return $this->view->fetch('SystemIndex',['list'=>$list]);
       
    }
}