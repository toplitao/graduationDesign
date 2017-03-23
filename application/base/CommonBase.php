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
        if(isset($param['type']) && $param['type'] == 'login'){
            return false;
        }else{
            $userinfo = Session::get('userinfo');
//            //普通用户
//            if($userinfo['userType'] == 1){
//                $user = db('user_info')->where('id',$userinfo['id'])->find();
//            }
//            //维修人员
//            if($userinfo['userType'] == 2){
//                $user = db('user')->where('id',$userinfo['id'])->find();
//            }
            return $userinfo;
        }
    }
    

}