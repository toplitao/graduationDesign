<?php
namespace app\base;

use think\Db;
use think\Session;
use think\Request;
use think\Controller;

class CommonBase extends Controller
{
    protected function _OnInit(){
        $param = $this->request->param();
        if($param == 'login'){
            return false;
        }else{
            $uid=Session::get('uid');
            $user=db('user')->where('id',$uid)->find();
        }
        $this->user=$user;
    }
    

}