<?php
namespace app\BaseController;

use app\BaseController\Base\Base;
use think\Db;
use think\Session;

class CommonBase extends Base
{
    protected function _OnInit(){
        $url=$this->request->url();
        if(empty($uid=Session::get('uid'))){
            $this->error('未登录','/');
        }
        if(empty($user=db('user')->where('id',$uid)->find())){
            $this->error('用户不存在','/');
        }
        if(stripos($url,'web/')){
            if($user['level']<1){
                $this->error('用户权限不足','/');
            }
        }
        if(stripos($url,'admin/')){
            if($user['level']<2){
                $this->error('用户权限不足','/');
            }
        }
        $this->uid=$uid;
    }
    

}