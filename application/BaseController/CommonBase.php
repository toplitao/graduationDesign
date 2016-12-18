<?php
namespace app\BaseController;

use app\BaseController\Base\Base;
use think\Db;
use think\Session;

class CommonBase extends Base
{
    protected function _OnInit(){
        if(empty($user_id=Session::get('uid'))){
            $this->error('未登录','/');
        }
        if(empty($user=db('user')->where('id',$user_id)->find())){
            $this->error('用户不存在','/');
        }
        if($user['level']<1){
            $this->error('用户权限不足','/');
        }
    }
    

}